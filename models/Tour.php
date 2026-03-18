<?php
class Tour
{
    private $conn;
    private $table = "tours";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả tour
    public function getTours()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'active' ORDER BY created_by DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Lấy chi tiết tour theo ID
    public function getTourById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE tour_id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lọc tour đa tiêu chí (NÂNG CẤP)
    public function getToursByFilter($filters = [])
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = 'active'";
        $params = [];

        // Giá từ
        if (!empty($filters['min_price'])) {
            $query .= " AND price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }

        // Giá đến
        if (!empty($filters['max_price'])) {
            $query .= " AND price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }

        // Location (LIKE - gần đúng giống Travel app)
        if (!empty($filters['location'])) {
            $query .= " AND location LIKE :location";
            $params[':location'] = "%" . $filters['location'] . "%";
        }

        // Ngày khởi hành
        if (!empty($filters['departure_date'])) {
            $query .= " AND departure_date = :departure_date";
            $params[':departure_date'] = $filters['departure_date'];
        }

        // Sắp xếp (tuỳ chọn)
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
}
?>