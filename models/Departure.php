<?php
require_once __DIR__ . '/../config/database.php';

class Departure
{
    private $conn;
    private $table = "departures";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM departures");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM departures WHERE departure_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO departures (tour_id, start_date, end_date, max_seats, available_seats) VALUES (:tour_id, :start, :end, :max, :avail)");
        $stmt->bindParam(":tour_id", $data['tour_id']);
        $stmt->bindParam(":start", $data['start_date']);
        $stmt->bindParam(":end", $data['end_date']);
        $stmt->bindParam(":max", $data['max_seats']);
        $stmt->bindParam(":avail", $data['available_seats']);
        return $stmt->execute();
    }
    public function update($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE departures SET tour_id=:tour_id, start_date=:start, end_date=:end, max_seats=:max, available_seats=:avail WHERE departure_id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":tour_id", $data['tour_id']);
        $stmt->bindParam(":start", $data['start_date']);
        $stmt->bindParam(":end", $data['end_date']);
        $stmt->bindParam(":max", $data['max_seats']);
        $stmt->bindParam(":avail", $data['available_seats']);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM departures WHERE departure_id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    public function getByTourId($tour_id)
    {
        $stmt = $this->conn->prepare("
        SELECT departure_id, start_date, available_seats 
        FROM departures 
        WHERE tour_id = :tour_id 
        AND start_date >= CURDATE()
        ORDER BY start_date ASC
    ");

        $stmt->bindParam(':tour_id', $tour_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
