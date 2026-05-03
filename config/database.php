<?php
// Set múi giờ cho PHP
date_default_timezone_set('Asia/Ho_Chi_Minh');

class Database
{
    private $host = "sql100.infinityfree.com";
    private $db_name = "if0_41728842_tour";
    private $username = "if0_41728842";
    private $password = "EoBN0fvjrfQSV"; // ⚠️ Nhớ đổi mật khẩu này sau nhé Quốc!

    public function connect()
    {
        $conn = null;

        try {
            $conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Set font chữ tiếng Việt
            $conn->exec("set names utf8mb4");

            // Set múi giờ Việt Nam cho MySQL (Sửa $this->conn thành $conn)
            $conn->exec("SET time_zone = '+07:00'");

        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $conn;
    }
}
?>