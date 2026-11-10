<?php
session_start();
include '../config.php';
$pname= $_POST['new_name'];
$doctor_name = $_POST['new_doctor_name'];
$date = $_POST['new_date'];
$time = $_POST['new_time'];
$note = $_POST['new_treatment'];
$sql="CREATE TABLE IF NOT EXISTS appointments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    appointment_id VARCHAR(10),
    patient_name VARCHAR(30) NOT NULL,
    doctor_name VARCHAR(30) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    notes TEXT)";
if ($conn->query($sql) === TRUE) {
    $insert_sql = "INSERT INTO appointments (patient_name, doctor_name, appointment_date, appointment_time, notes) VALUES ('$pname', '$doctor_name', '$date', '$time', '$note')";
    if ($conn->query($insert_sql) === TRUE) {
        $sql = "SELECT MAX(id) as max_id FROM appointments";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $max_id = (int) $row['max_id'];
        $appointment_id = 'A' . str_pad($max_id, 5, '0', STR_PAD_LEFT);
        $update_sql = "UPDATE appointments SET appointment_id='$appointment_id' WHERE id=$max_id";
       if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Appointment added successfully with Appointment ID: $appointment_id'); window.location.href='../admin/index.html';</script>";
        } else {
            echo "<script>alert('Error updating appointment ID: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
        }       
    } else {
        echo "<script>alert('Error adding appointment: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }
}
    else {
        echo "<script>alert('Error creating appointments table: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }



?>