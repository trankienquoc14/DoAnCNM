<?php
require_once __DIR__ . '/../config/database.php';

class Booking {

    private $conn;
    private $table = "bookings";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function createBooking($user_id, $tour_id, $quantity) {

        $query = "INSERT INTO $this->table (user_id, tour_id, quantity, status)
                  VALUES (:user_id, :tour_id, :quantity, 'pending')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->bindParam(":quantity", $quantity);

        return $stmt->execute();
    }
}