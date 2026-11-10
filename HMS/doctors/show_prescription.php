<?php
session_start();
include '../config.php';
$sql="SELECT id, patient_name,  prescription_date, medication, dosage, frequency, notes FROM prescriptions WHERE doctor_name = '".$_SESSION['username']."' ORDER BY prescription_date DESC";
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