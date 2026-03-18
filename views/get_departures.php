<?php
require_once '../config/database.php';
require_once '../models/Departure.php';

$db = (new Database())->connect();

$tour_id = $_GET['tour_id'] ?? 0;

$departureModel = new Departure($db);
$data = $departureModel->getByTourId($tour_id);

header('Content-Type: application/json');
echo json_encode($data);