<?php
session_start();
include '../config.php';
$sql="SELECT id,item_name, quantity, priority, date, notes FROM inventory_requests WHERE doctor_name = '".$_SESSION['username']."' ORDER BY date DESC";
$result = mysqli_query($conn, $sql);
$requests = []; 
while ($row = mysqli_fetch_assoc($result)) {
    $requests[] = $row;
}
header('Content-Type: application/json');
echo json_encode([
    "requests" => $requests
]);


?>