<?php
require_once __DIR__ . '/../config/database.php';
class TourGuide
{
    private $conn;
    private $table = "tour_guides";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getByDeparture($departure_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_guides WHERE departure_id = :departure_id");
        $stmt->bindParam(":departure_id", $departure_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function assign($departure_id, $staff_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_guides (departure_id, staff_id) VALUES (:departure_id, :staff_id)");
        $stmt->bindParam(":departure_id", $departure_id);
        $stmt->bindParam(":staff_id", $staff_id);
        return $stmt->execute();
    }
}
