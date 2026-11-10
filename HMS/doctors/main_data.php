<?php
session_start();
include '../config.php';

function getCount($conn, $sql) {
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    }
    return 0;
}

$main_data = [];

$username = $_SESSION['username'] ?? '';

$main_data['docname'] = $username;

// Total patients (distinct patients for that doctor)
$main_data['total_patients'] = getCount(
    $conn,
    "SELECT COUNT(DISTINCT patient_name) as total 
     FROM appointments 
     WHERE doctor_name = '$username'"
);

// Total appointments
$main_data['total_appointments'] = getCount(
    $conn,
    "SELECT COUNT(*) as total 
     FROM appointments 
     WHERE doctor_name = '$username'"
);
$main_data['total_prescriptions']= getCount(
    $conn,
    "SELECT COUNT(*) as total 
     FROM prescriptions 
     WHERE doctor_name = '$username'"
);

// Return JSON
header('Content-Type: application/json');
echo json_encode($main_data);
?>