<?php
session_start();
include '../config.php';
$sql="SELECT doctor_name, prescription_date, medication, dosage, frequency, notes FROM prescriptions WHERE patient_name = '" . $_SESSION['username'] . "' ";
$result = mysqli_query($conn, $sql);
$prescriptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $prescriptions[] = $row;
}
header('Content-Type: application/json');
echo json_encode([
    "prescriptions" => $prescriptions
]);



?>