<?php
require_once __DIR__ . '/../config/database.php';
class Notification
{
    private $conn;
    private $table = "notifications";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getByUser($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO notifications (user_id, booking_id, message) VALUES (:user_id, :booking_id, :message)");
        $stmt->bindParam(":user_id", $data['user_id']);
        $stmt->bindParam(":booking_id", $data['booking_id']);
        $stmt->bindParam(":message", $data['message']);
        return $stmt->execute();
    }
    public function markRead($notification_id)
    {
        $stmt = $this->conn->prepare("UPDATE notifications SET is_read=1 WHERE notification_id=:id");
        $stmt->bindParam(":id", $notification_id);
        return $stmt->execute();
    }
}
