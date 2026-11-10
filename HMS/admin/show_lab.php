<?php
session_start();
include '../config.php';
$sql="SELECT lab_id, lab_name, lab_location, head, tests_available FROM laboratories";
$result=mysqli_query($conn,$sql);
$labs=[];
while($row=mysqli_fetch_assoc($result)){
$labs[]=$row;
}
header('Content-Type: application/json');
echo json_encode(['labs' => $labs]);
?>
