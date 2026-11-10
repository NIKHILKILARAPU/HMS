<?php
session_start();
include '../config.php';
$item_name = $_POST['item_name'];
$quantity = $_POST['quantity'];
$priority = $_POST['priority'];
$date = date('Y-m-d');
$notes = $_POST['notes'];
$doctor_name = $_SESSION['username'];
$sql="CREATE TABLE IF NOT EXISTS inventory_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    priority VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    notes TEXT,
    doctor_name VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    $query = "INSERT INTO inventory_requests (item_name, quantity, priority, date, notes, doctor_name) VALUES ('$item_name', '$quantity', '$priority', '$date', '$notes', '$doctor_name')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Inventory request created successfully'); window.location.href='../doctors/index.html';</script>";
    } else {
        echo "<script>alert('Error creating inventory request: " . mysqli_error($conn) . "');</script>"  ;
    }
} else {
    echo "<script>alert('Error creating table: " . mysqli_error($conn) . "');</script>"  ;
}
?>