<?php
session_start();
include '../config.php';

if(isset($_POST['patient_name'], $_POST['appointment_date'], $_POST['appointment_time'], $_POST['treatment_notes'])){

    $pname = $_POST['patient_name'];
    $doctor_name = $_SESSION['username'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    $note = $_POST['treatment_notes'];

    // Use Prepared Statement
  $stmt = $conn->prepare("INSERT INTO appointments 
(patient_name, doctor_name, appointment_date, appointment_time, notes) 
VALUES (?, ?, ?, ?, ?)");

if(!$stmt){
    die("Prepare failed: " . $conn->error);
}

    $stmt->bind_param("sssss", $pname, $doctor_name, $date, $time, $note);

    if($stmt->execute()){

        // Get last inserted ID safely
        $last_id = $conn->insert_id;

        $appointment_id = 'A' . str_pad($last_id, 4, '0', STR_PAD_LEFT);

        // Update appointment_id
        $update_stmt = $conn->prepare("UPDATE appointments SET appointment_id = ? WHERE id = ?");
        $update_stmt->bind_param("si", $appointment_id, $last_id);
        $update_stmt->execute();

        echo "<script>alert('Appointment added successfully with Appointment ID: $appointment_id'); window.location.href='../doctors/index.html';</script>";

    } else {
        echo "Error creating appointment: " . $stmt->error;
    }

}
?>