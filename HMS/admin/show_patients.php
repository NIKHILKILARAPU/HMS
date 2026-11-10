<?php
session_start();
include '../config.php';

$sql = "SELECT pid, patientname,age , phone, email, patient_address FROM patients";
$result = mysqli_query($conn, $sql);

$patients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $patients[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['patients' => $patients]);
?>