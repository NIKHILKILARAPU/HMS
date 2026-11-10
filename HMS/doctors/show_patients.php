<?php
session_start();
include '../config.php';
$sql="SELECT DISTINCT p.pid, p.patientname, p.age, p.phone, p.email, p.patient_address 
FROM patients p
INNER JOIN appointments a ON p.patientname = a.patient_name
WHERE a.doctor_name = '".$_SESSION['username']."'";
$result = mysqli_query($conn, $sql);
$patients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $patients[] = $row;
}
header('Content-Type: application/json');
echo json_encode([
    "patients" => $patients
]);


?>