<?php
class Tour
{
    private $conn;
    private $table = "tours";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // =========================
    // 📌 USER - LẤY TOUR ACTIVE
    // =========================
    public function getTours()
    {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE status = 'active' 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // =========================
    // 📌 MANAGER - LẤY TẤT CẢ TOUR
    // =========================
    public function getAllTours()
    {
        $query = "SELECT * FROM " . $this->table . " 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // =========================
    // 📌 LẤY CHI TIẾT TOUR
    // =========================
    public function getTourById($id)
    {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE tour_id = :id 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // =========================
    // 📌 FILTER TOUR (NÂNG CAO)
    // =========================
    public function getToursByFilter($filters = [])
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'active'";
        $params = [];

        if (!empty($filters['min_price'])) {
            $query .= " AND price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }

        if (!empty($filters['max_price'])) {
            $query .= " AND price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }

        if (!empty($filters['location'])) {
            $query .= " AND destination LIKE :location";
            $params[':location'] = "%" . $filters['location'] . "%";
        }

        if (!empty($filters['departure_date'])) {
            $query .= " AND departure_date = :departure_date";
            $params[':departure_date'] = $filters['departure_date'];
        }

        // SORT
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_asc':
                    $query .= " ORDER BY price ASC";
                    break;
                case 'price_desc':
                    $query .= " ORDER BY price DESC";
                    break;
                default:
                    $query .= " ORDER BY created_at DESC";
            }
        } else {
            $query .= " ORDER BY created_at DESC";
        }

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return $stmt;
    }

    // =========================
    // 📌 CREATE TOUR
    // =========================
    public function createTour($data)
    {
        $query = "INSERT INTO " . $this->table . " 
            (tour_name, destination, price, duration, status, created_at) 
            VALUES (:name, :destination, :price, :duration, 'active', NOW())";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name' => $data['tour_name'],
            ':destination' => $data['destination'],
            ':price' => $data['price'],
            ':duration' => $data['duration']
        ]);
    }

    // =========================
    // 📌 UPDATE TOUR
    // =========================
    public function updateTour($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
            SET tour_name = :name,
                destination = :destination,
                price = :price,
                duration = :duration
            WHERE tour_id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':name' => $data['tour_name'],
            ':destination' => $data['destination'],
            ':price' => $data['price'],
            ':duration' => $data['duration'],
            ':id' => $id
        ]);
    }

    // =========================
    // 📌 SOFT DELETE (KHUYÊN DÙNG)
    // =========================
    public function deleteTour($id)
    {
        $query = "UPDATE " . $this->table . " 
                  SET status = 'inactive' 
                  WHERE tour_id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    // =========================
    // 📌 HARD DELETE (OPTIONAL)
    // =========================
    public function forceDeleteTour($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE tour_id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':id' => $id]);
    }

    // =========================
    // 📌 TOGGLE STATUS
    // =========================
    public function toggleStatus($id, $status)
    {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status 
                  WHERE tour_id = :id";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }

    // =========================
    // 📌 THỐNG KÊ
    // =========================
    public function countTours()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        return $this->conn->query($query)->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>