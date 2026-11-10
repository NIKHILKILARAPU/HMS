<?php
// 1. Start the session and enable error reporting for debugging
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Include your database connection
include 'config.php';

// 3. Collect form data
$role = $_POST['role'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// --- ADMIN BLOCK ---
if ($role === 'Admin') {
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_name = ? AND password = ?");
    if (!$stmt) { die("Prepare failed (Admin): " . $conn->error); }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: admin/index.html");
        exit();
    } else {
        echo "<script>alert('Invalid admin credentials'); window.location.href='login.html';</script>";
    }
    $stmt->close();
}

// --- PATIENT BLOCK ---
elseif ($role === 'patient') {
    $stmt = $conn->prepare("SELECT * FROM patients WHERE patientname = ? AND patient_password = ?");
    if (!$stmt) { die("Prepare failed (Patient): " . $conn->error); }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: patient/index.html");
        exit();
    } else {
        echo "<script>alert('Invalid patient credentials'); window.location.href='login.html';</script>";
    }
    $stmt->close();
}

// --- DOCTOR BLOCK ---
elseif ($role === 'Doctor') {
    // Using your specific column names: Doctorname and doc_password
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE Doctorname = ? AND doc_password = ?");
    if (!$stmt) { die("Prepare failed (Doctor): " . $conn->error); }

    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: doctors/index.html");
        exit();
    } else {
        // Changed redirect from index.html to login.html for consistency
        echo "<script>alert('Invalid doctor credentials'); window.location.href='login.html';</script>";
    }
    $stmt->close();
}

// --- INVALID ROLE ---
else {
    echo "<script>alert('Invalid role selected'); window.location.href='login.html';</script>";
}

$conn->close();
?>