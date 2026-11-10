<?php
session_start();
include '../config.php';
header('Content-Type: application/json');

function getCount($conn, $query){
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("Query Failed: " . mysqli_error($conn));
    }
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

$main_data = [];

$main_data['username'] = $_SESSION['username'] ?? '';

$main_data['total_patients'] = getCount($conn,"SELECT COUNT(*) as total FROM patients");
$main_data['total_appointments'] = getCount($conn,"SELECT COUNT(*) as total FROM appointments");
$main_data['total_prescriptions'] = getCount($conn,"SELECT COUNT(*) as total FROM prescriptions");
$main_data['total_doctors'] = getCount($conn,"SELECT COUNT(*) as total FROM doctors");
$main_data['total_earnings'] = getCount($conn,"SELECT IFNULL(SUM(total),0) as total FROM billing");

echo json_encode(['main_data' => $main_data]);
exit;
?>