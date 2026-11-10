<?php
session_start();
include '../config.php';
$sql="SELECT id, patient_name, session_date, session_time, notes, meeting_link FROM telemedicine_sessions WHERE doctor_name = '" . $_SESSION['username'] . "'  ";
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