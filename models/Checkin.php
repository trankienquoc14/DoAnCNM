<?php
require_once __DIR__ . '/../config/database.php';
class Checkin
{
    private $conn;
    private $table = "checkins";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getByBooking($booking_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM checkins WHERE booking_id = :booking_id");
        $stmt->bindParam(":booking_id", $booking_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO checkins (booking_id, staff_id) VALUES (:booking_id, :staff_id)");
        $stmt->bindParam(":booking_id", $data['booking_id']);
        $stmt->bindParam(":staff_id", $data['staff_id']);
        return $stmt->execute();
    }
}
