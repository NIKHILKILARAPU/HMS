<?php
session_start();
include '../config.php';
$sql = "SELECT * FROM telemedicine_sessions WHERE patient_name = '" . $_SESSION['username'] . "'";
$result = mysqli_query($conn, $sql);
$sessions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $sessions[] = $row;
}
header('Content-Type: application/json');
echo json_encode([
    "sessions" => $sessions
]);


?>