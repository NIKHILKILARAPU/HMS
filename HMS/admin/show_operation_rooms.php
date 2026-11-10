<?php
session_start();
include '../config.php';
$sql="SELECT room_number, room_name, capacity, equipment FROM operation_rooms";
$result = mysqli_query($conn, $sql);
$rooms = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rooms[] = $row;
}
header('Content-Type: application/json');
echo json_encode(['rooms' => $rooms]);

?>