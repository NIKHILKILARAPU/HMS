<?php 
session_start();
include '../config.php';

$doc_name  = $_POST['doc_name'];
$specialty = $_POST['doc_specialty'];
$mail      = $_POST['doc_email'];
$phone     = $_POST['doc_phone'];

if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

if (!preg_match("/^[0-9]{10}$/", $phone)) {
    die("Invalid phone number format");
}

$sql = "CREATE TABLE IF NOT EXISTS doctors (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    did VARCHAR(10) UNIQUE,
    Doctorname VARCHAR(100) NOT NULL,
    doc_password VARCHAR(255) NOT NULL,
    specialty VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL
)";

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}

$default_password = 'password123';
$did = 'D' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

$insert_sql = "INSERT INTO doctors 
(did, Doctorname, doc_password, specialty, email, phone) 
VALUES 
('$did', '$doc_name', '$default_password', '$specialty', '$mail', '$phone')";

if ($conn->query($insert_sql)) {
    echo "<script>alert('Doctor added successfully with default password: password123'); window.location.href='../admin/index.html';</script>";
} else {
    echo "<script>alert('Error adding doctor: " . $conn->error . "'); window.location.href='../admin/index.html';</script>";
}
?>
