<?php
session_start();
include '../config.php';
$pname = $_POST['patient_name'];
$docname = $_SESSION['username'];
$date = $_POST['session_date'];
$time = $_POST['session_time'];
$notes = $_POST['notes'];
$meeting_link = $_POST['meeting_link'];
$sql="CREATE TABLE IF NOT EXISTS telemedicine_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(255) NOT NULL,
    doctor_name VARCHAR(255) NOT NULL,
    session_date DATE NOT NULL,
    session_time TIME NOT NULL,
    notes VARCHAR(255),
    meeting_link VARCHAR(255)
)";
if (mysqli_query($conn, $sql)) {
    $query = "INSERT INTO telemedicine_sessions (patient_name, doctor_name, session_date, session_time, notes, meeting_link) VALUES ('$pname', '$docname', '$date', '$time', '$notes', '$meeting_link')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Telemedicine session created successfully!'); window.location.href = 'index.html';</script>"  ;
    } else {
        echo "<script>alert('Error creating telemedicine session: " . mysqli_error($conn) . "');</script>"  ;
    }
} else {
    echo "<script>alert('Error creating table: " . mysqli_error($conn) . "');</script>"  ;
}


?>