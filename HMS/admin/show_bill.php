<?php
session_start();
include '../config.php';
$sql="SELECT bill_id, patient_name, bill_date, amount, tax, total, bill_description FROM billing";
$result=mysqli_query($conn,$sql);
$bills=[];
while($row=mysqli_fetch_assoc($result)){
$bills[]=$row;
}
header('Content-Type: application/json');
echo json_encode(['bills' => $bills]);
?>
