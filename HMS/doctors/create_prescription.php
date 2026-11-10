<?php
session_start();
include '../config.php';
$pname = $_POST['patient_name'];
$date= $_POST['prescription_date'];
$medication = $_POST['medicine'];
$dosage = $_POST['dosage'];
$doctor_name = $_SESSION['username'];
$frequency = $_POST['frequency'];
$notes = $_POST['notes'];
$sql="CREATE TABLE IF NOT EXISTS prescriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(255) NOT NULL,
    doctor_name VARCHAR(255) NOT NULL,
    prescription_date DATE NOT NULL,
    medication VARCHAR(255) NOT NULL,
    dosage VARCHAR(255) NOT NULL,
    frequency VARCHAR(255) NOT NULL,
    notes TEXT
)";
if (mysqli_query($conn, $sql)) {
    $query = "INSERT INTO prescriptions (patient_name, doctor_name, prescription_date, medication, dosage, frequency, notes) VALUES ('$pname', '$doctor_name', '$date', '$medication', '$dosage', '$frequency', '$notes')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Prescription created successfully'); window.location.href='../doctors/index.html';</script>"  ;    
    } else {
        echo "<script>alert('Error creating prescription: " . mysqli_error($conn) . "');</script>"  ;
    }
} else {
    echo "<script>alert('Error creating table: " . mysqli_error($conn) . "');</script>"  ;
}

?>