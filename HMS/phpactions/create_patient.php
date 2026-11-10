<?php
session_start();
include '../config.php';

$pname    = $_POST['pat_name'];
$page     = $_POST['pat_age'];
$pphone   = $_POST['pat_phone'];
$pemail   = $_POST['pat_email'];
$paddress = $_POST['pat_address'];

$sql = "CREATE TABLE IF NOT EXISTS patients (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pid VARCHAR(10) UNIQUE,
    patientname VARCHAR(100) NOT NULL,
    patient_password VARCHAR(255) DEFAULT 'patient123',
    age INT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    patient_address VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {

    $insert_sql = "INSERT INTO patients (patientname, age, phone, email, patient_address)
                   VALUES ('$pname', '$page', '$pphone', '$pemail', '$paddress')";

    if ($conn->query($insert_sql) === TRUE) {

        $last_id = $conn->insert_id;
        $patient_id = 'P' . str_pad($last_id, 5, '0', STR_PAD_LEFT);

        $update_sql = "UPDATE patients SET pid='$patient_id' WHERE id=$last_id";
        $conn->query($update_sql);

        header("Location: ../admin/index.html");
        exit();

    } else {
        echo "Insert Error: " . $conn->error;
    }
} else {
    echo "Table Error: " . $conn->error;
}
?>
