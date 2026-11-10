<?php
session_start();
include '../config.php';
$sql="SELECT did, Doctorname, specialty, email, phone FROM doctors";
$result=mysqli_query($conn,$sql);
$doctors=[];
while($row=mysqli_fetch_assoc($result)){
$doctors[]=$row;
}
header('Content-Type: application/json');
echo json_encode(['doctors' => $doctors]);
?>
