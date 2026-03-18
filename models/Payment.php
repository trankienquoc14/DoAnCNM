<?php
require_once __DIR__ . '/../config/database.php';
class Payment
{
    private $conn;
    private $table = "payments";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getByBooking($booking_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE booking_id = :booking_id");
        $stmt->bindParam(":booking_id", $booking_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO payments (booking_id, amount, payment_method, payment_status, transaction_code, payment_date) VALUES (:booking_id, :amount, :method, :status, :code, :date)");
        $stmt->bindParam(":booking_id", $data['booking_id']);
        $stmt->bindParam(":amount", $data['amount']);
        $stmt->bindParam(":method", $data['payment_method']);
        $stmt->bindParam(":status", $data['payment_status']);
        $stmt->bindParam(":code", $data['transaction_code']);
        $stmt->bindParam(":date", $data['payment_date']);
        return $stmt->execute();
    }
}
