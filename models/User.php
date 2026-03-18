<?php
class User {

    private $conn;
    private $table = "users";

    public function __construct($db){
        $this->conn = $db;
    }

    // ================= REGISTER =================
    public function register($name, $email, $password){

        // 🔥 1. Check email tồn tại
        $check = $this->conn->prepare("SELECT user_id FROM users WHERE email = :email");
        $check->bindParam(":email", $email);
        $check->execute();

        if ($check->rowCount() > 0) {
            return false; // email đã tồn tại
        }

        // 🔥 2. Hash password
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // 🔥 3. Insert
        $query = "INSERT INTO users(full_name, email, password, role)
                  VALUES(:name, :email, :password, 'customer')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hash);

        return $stmt->execute();
    }

    // ================= LOGIN =================
    public function login($email){

        $query = "SELECT user_id, full_name, email, password, role 
                  FROM users 
                  WHERE email = :email";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 🔥 Chuẩn hóa lại key để controller dùng dễ hơn
        if ($user) {
            return [
                'user_id' => $user['user_id'],
                'name' => $user['full_name'], // map lại
                'email' => $user['email'],
                'password' => $user['password'],
                'role' => $user['role']
            ];
        }

        return false;
    }
}
?>