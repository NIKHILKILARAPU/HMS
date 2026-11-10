<?php
session_start();
include '../config.php';
$lab_name = $_POST['lab_name'];
$lab_location = $_POST['lab_location'];
$lab_head = $_POST['lab_head'];
$lab_tests = $_POST['lab_tests'];
$sql = "CREATE TABLE IF NOT EXISTS laboratories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    lab_id VARCHAR(10),
    lab_name VARCHAR(50) NOT NULL,
    lab_location VARCHAR(100) DEFAULT NULL,
    head VARCHAR(50) DEFAULT NULL,
    tests_available TEXT)";

if ($conn->query($sql) === TRUE) {
    $insert_sql = "INSERT INTO laboratories (lab_name, lab_location, head, tests_available) VALUES ('$lab_name', '$lab_location', '$lab_head', '$lab_tests')";
    if ($conn->query($insert_sql) === TRUE) {
        $sql = "SELECT MAX(id) as max_id FROM laboratories";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $max_id = (int) $row['max_id'];
        $lab_id = 'L' . str_pad($max_id, 5, '0', STR_PAD_LEFT);
        $update_sql = "UPDATE laboratories SET lab_id='$lab_id' WHERE id=$max_id";
       if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Laboratory added successfully with Lab ID: $lab_id'); window.location.href='../admin/index.html';</script>";
        } else {
            echo "<script>alert('Error updating lab ID: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
        }       
    } else {
        echo "<script>alert('Error adding laboratory: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }
}
    else {
        echo "<script>alert('Error creating laboratories table: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }
?>