<?php
require_once "../config/database.php";

$db=(new Database())->connect();

$query="INSERT INTO bookings(user_id,departure_id,number_of_people,total_price)
        VALUES(:user,:departure,:people,:price)";

$stmt=$db->prepare($query);

$stmt->bindParam(":user",$_POST['user_id']);
$stmt->bindParam(":departure",$_POST['departure_id']);
$stmt->bindParam(":people",$_POST['people']);
$stmt->bindParam(":price",$_POST['price']);

$stmt->execute();

echo "Đặt tour thành công";
?>