<?php
require_once __DIR__ . '/../config/database.php';
class Review
{
    private $conn;
    private $table = "reviews";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByTour($tour_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE tour_id = :tour_id");
        $stmt->bindParam(":tour_id", $tour_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO reviews (user_id, tour_id, rating, comment) VALUES (:user_id, :tour_id, :rating, :comment)");
        $stmt->bindParam(":user_id", $data['user_id']);
        $stmt->bindParam(":tour_id", $data['tour_id']);
        $stmt->bindParam(":rating", $data['rating']);
        $stmt->bindParam(":comment", $data['comment']);
        return $stmt->execute();
    }
}
