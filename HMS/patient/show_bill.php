<?php
session_start();
include '../config.php';
$sql="SELECT bill_id,bill_date, amount, tax, total, bill_description FROM billing WHERE patient_name = '" . $_SESSION['username'] . "' ";
$result=mysqli_query($conn,$sql);
$bills=[];
while($row=mysqli_fetch_assoc($result)){
$bills[]=$row;
}
header('Content-Type: application/json');
echo json_encode(['bills' => $bills]);

?>