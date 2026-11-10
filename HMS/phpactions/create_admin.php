<?php
session_start();
include '../config.php';

$admin_name = $_POST['admin_name'];
$mail       = $_POST['admin_email'];
$phone      = $_POST['admin_phone'];
$password   = $_POST['admin_password'];

// Email validation
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format");
}

// Phone validation (10 digits)
if (!preg_match("/^[0-9]{10}$/", $phone)) {
    die("Invalid phone number format");
}

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_id VARCHAR(10) UNIQUE,
    admin_name VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL
)";

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}

// Generate admin ID
$admin_id = 'A' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

// Use prepared statement (safe from SQL injection)
$stmt = $conn->prepare("INSERT INTO admin (admin_id, admin_name, password, email, phone) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $admin_id, $admin_name, $password, $mail, $phone);

if ($stmt->execute()) {
    $_SESSION['admin_id'] = $admin_id;
    $_SESSION['admin_name'] = $admin_name;

    header("Location: ../admin/index.html");
    exit();
} else {
    die("Error adding admin: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
