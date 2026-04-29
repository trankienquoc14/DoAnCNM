<?php
class User
{

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // ================= CHECK EMAIL =================
    public function emailExists($email, $excludeId = null)
    {
        $sql = "SELECT user_id FROM users WHERE email = ?";
        $params = [$email];

        if ($excludeId) {
            $sql .= " AND user_id != ?";
            $params[] = $excludeId;
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    // ================= REGISTER =================
    public function register($name, $email, $password, $phone)
    {

        if ($this->emailExists($email)) {
            return false;
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("
            INSERT INTO users(full_name,email,phone,password,role,status)
            VALUES(?,?,?,?, 'customer','active')
        ");

        return $stmt->execute([$name, $email, $phone, $hash]);
    }

    // ================= LOGIN =================
    public function login($email)
    {

        $stmt = $this->conn->prepare("
            SELECT user_id, full_name, email, password, role, status 
            FROM users WHERE email = ?
        ");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if ($user['status'] != 'active')
                return 'locked';
            return $user;
        }

        return false;
    }

    // ================= GET ALL USERS =================
    public function getAllUsers()
    {
        return $this->conn->query("SELECT * FROM users ORDER BY created_at DESC")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================= GET USER BY ID =================
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================= CREATE USER (ADMIN) =================
    public function createUser($data)
    {

        if ($this->emailExists($data['email'])) {
            return false;
        }

        $hash = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $this->conn->prepare("
            INSERT INTO users(full_name,email,phone,password,role,status)
            VALUES(?,?,?,?,?, 'active')
        ");

        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $hash,
            $data['role']
        ]);
    }

    // ================= UPDATE USER =================
    public function updateUser($id, $data)
    {

        if ($this->emailExists($data['email'], $id)) {
            return false;
        }

        $stmt = $this->conn->prepare("
            UPDATE users 
            SET full_name=?, email=?, phone=?, role=? 
            WHERE user_id=?
        ");

        return $stmt->execute([
            $data['full_name'],
            $data['email'],
            $data['phone'],
            $data['role'],
            $id
        ]);
    }

    // ================= DELETE USER =================
    public function deleteUser($id)
    {

        $user = $this->getUserById($id);

        // ❗ Không cho xóa admin cuối cùng
        if ($user['role'] == 'admin') {
            $stmt = $this->conn->prepare("
                SELECT COUNT(*) as total FROM users WHERE role = 'admin'
            ");
            $stmt->execute();
            $count = $stmt->fetch()['total'];

            if ($count <= 1) {
                return false;
            }
        }

        return $this->conn->prepare("DELETE FROM users WHERE user_id=?")
            ->execute([$id]);
    }

    // ================= TOGGLE STATUS =================
    public function toggleStatus($id)
    {
        // 1. Lấy trạng thái hiện tại của user (SỬ DỤNG $this->conn MỚI ĐÚNG)
        $stmt = $this->conn->prepare("SELECT status FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $currentStatus = $stmt->fetchColumn();

        // 2. Nếu rỗng hoặc null, coi như nó đang 'active'
        if (empty($currentStatus)) {
            $currentStatus = 'active';
        }

        // 3. Đảo ngược trạng thái
        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';

        // 4. Cập nhật vào Database
        $updateStmt = $this->conn->prepare("UPDATE users SET status = ? WHERE user_id = ?");
        return $updateStmt->execute([$newStatus, $id]);
    }

    // ================= RESET PASSWORD =================
    public function resetPassword($id)
    {
        $hash = password_hash("123456", PASSWORD_BCRYPT);

        return $this->conn->prepare("
            UPDATE users SET password=? WHERE user_id=?
        ")->execute([$hash, $id]);
    }
}
?>