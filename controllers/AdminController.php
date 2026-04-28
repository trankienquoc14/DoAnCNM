<?php
require_once "../config/database.php";
require_once "../models/User.php";

class AdminController
{

    private $user;

    public function __construct()
    {
        $db = (new Database())->connect();
        $this->user = new User($db);
    }

    public function index()
    {
        $users = $this->user->getAllUsers();
        include "../views/admin/users.php";
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->createUser($_POST);
            header("Location: admin.php");
            exit();
        }
        include "../views/admin/create_user.php";
    }

    public function edit()
    {
        $id = $_GET['id'];
        $user = $this->user->getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->updateUser($id, $_POST);
            header("Location: admin.php");
            exit();
        }

        include "../views/admin/edit_user.php";
    }

    public function delete()
    {
        if ($_SESSION['user']['id'] == $_GET['id']) {
            die("Không thể xóa chính mình");
        }

        $this->user->deleteUser($_GET['id']);
        header("Location: admin.php");
    }

    public function toggle()
    {
        $this->user->toggleStatus($_GET['id']);
        header("Location: admin.php");
    }

    public function reset()
    {
        $this->user->resetPassword($_GET['id']);
        header("Location: admin.php");
    }
    public function chat()
    {
        // Khai báo biến này để Sidebar biết đang ở mục nào mà sáng lên
        $activeMenu = 'chat';
        // Trỏ thẳng về file giao diện quản lý chat mà mình đã tạo
        require_once __DIR__ . '/../views/admin/chat_manage.php';
    }
}
?>