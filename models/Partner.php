<?php
require_once __DIR__ . '/../config/database.php';
class Partner
{
    private $conn;
    private $table = "partners";
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }
    public function getAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM partners");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM partners WHERE partner_id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO partners (partner_name, contact_person, phone, email, address) VALUES (:name, :contact, :phone, :email, :address)");
        $stmt->bindParam(":name", $data['partner_name']);
        $stmt->bindParam(":contact", $data['contact_person']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":address", $data['address']);
        return $stmt->execute();
    }
    public function update($id, $data)
    {
        $stmt = $this->conn->prepare("UPDATE partners SET partner_name=:name, contact_person=:contact, phone=:phone, email=:email, address=:address WHERE partner_id=:id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $data['partner_name']);
        $stmt->bindParam(":contact", $data['contact_person']);
        $stmt->bindParam(":phone", $data['phone']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":address", $data['address']);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM partners WHERE partner_id = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
