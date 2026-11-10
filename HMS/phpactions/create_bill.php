<?php
session_start();
include '../config.php';
$pname = $_POST['patient_name'];
$amount = $_POST['amount'];
$tax = $_POST['tax'];
$description = $_POST['description'];
$toal= $amount + ($amount * $tax / 100);
$sql = "CREATE TABLE IF NOT EXISTS billing (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    bill_id VARCHAR(10),
    patient_name VARCHAR(30) NOT NULL,
    bill_date DATE DEFAULT CURRENT_DATE,
    amount DECIMAL(10, 2) NOT NULL,
    tax DECIMAL(5, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    bill_description TEXT)"; 
if ($conn->query($sql) === TRUE) {
    $insert_sql = "INSERT INTO billing (patient_name, amount, tax, total, bill_description) VALUES ('$pname', $amount, $tax, $toal, '$description')";
    if ($conn->query($insert_sql) === TRUE) {
        $sql = "SELECT MAX(id) as max_id FROM billing";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $max_id = (int) $row['max_id'];
        $bill_id = 'B' . str_pad($max_id, 5, '0', STR_PAD_LEFT);
        $update_sql = "UPDATE billing SET bill_id='$bill_id' WHERE id=$max_id";
       if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Invoice created successfully with Bill ID: $bill_id'); window.location.href='../admin/index.html';</script>";
        } else {
            echo "<script>alert('Error updating bill ID: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
        }       
    } else {
        echo "<script>alert('Error creating invoice: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }
}
    else {
        echo "<script>alert('Error creating billing table: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }
?>