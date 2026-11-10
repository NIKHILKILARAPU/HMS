<?php
session_start();
include '../config.php';
$doc_name=$_POST['doctor_name'];
$date=$_POST['date'];
$time=$_POST['time'];
$reason=$_POST['reason'];
$sql="INSERT INTO appointments (patient_name,doctor_name, appointment_date, appointment_time, treatment_notes) VALUES ($_SESSION['username'],'$doc_name', '$date', '$time', '$reason')";
if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Appointment created successfully.');</script>";
} else {
    echo "<script>alert('Error creating appointment');</script>";
}

?>