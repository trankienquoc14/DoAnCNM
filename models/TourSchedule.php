<?php
require_once __DIR__ . '/../config/database.php';
class TourSchedule
{
    private $conn;
    private $table = "tour_schedules";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getByTour($tour_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_schedules WHERE tour_id = :tour_id ORDER BY day_number ASC");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_schedules (tour_id, day_number, location, activity) VALUES (:tour_id, :day, :location, :activity)");
        $stmt->bindParam(":tour_id", $data['tour_id']);
        $stmt->bindParam(":day", $data['day_number']);
        $stmt->bindParam(":location", $data['location']);
        $stmt->bindParam(":activity", $data['activity']);
        return $stmt->execute();
    }
}
