<?php
include '../config.php';

$sql = "SELECT appointment_id, patient_name, doctor_name, appointment_date, appointment_time, notes 
        FROM appointments
        ORDER BY appointment_date ASC, appointment_time ASC";

$result = mysqli_query($conn, $sql);

$appointments = [];

while ($row = mysqli_fetch_assoc($result)) {
    $appointments[] = $row;
}

header('Content-Type: application/json');
echo json_encode([
    "appointments" => $appointments
]);
?>
