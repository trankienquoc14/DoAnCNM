<?php
require_once __DIR__ . '/../config/database.php';

class CheckinController {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function checkin($booking_id) {

        $query = "UPDATE bookings SET status='checked_in'
                  WHERE id=:booking_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":booking_id",$booking_id);

        return $stmt->execute();
    }
}