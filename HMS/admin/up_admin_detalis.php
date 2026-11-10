<?php
session_start();
include '../config.php';

$cp = $_POST['current_password'];
$np = $_POST['new_password'];

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT password FROM admin WHERE admin_id='$admin_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    // Direct comparison (no hashing)
    if ($cp === $row['password']) {

        $update_sql = "UPDATE admin SET password='$np' WHERE admin_id='$admin_id'";

        if ($conn->query($update_sql)) {
            echo "<script>alert('Password updated successfully'); window.location.href='../admin/index.html';</script>";
        } else {
            echo "<script>alert('Error updating password');</script>";
        }

    } else {
        echo "<script>alert('Current password is incorrect'); window.location.href='../admin/index.html';</script>";
    }

} else {
    echo "<script>alert('Admin not found');</script>";
}
?>
