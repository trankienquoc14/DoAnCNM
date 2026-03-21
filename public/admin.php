<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    die("Không có quyền truy cập");
}

require_once "../controllers/AdminController.php";

$controller = new AdminController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'toggle':
        $controller->toggle();
        break;
    case 'reset':
        $controller->reset();
        break;
    default:
        $controller->index();
}