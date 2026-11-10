<?php
session_start();
include '../config.php';

$main_data['username'] = $_SESSION['username'] ?? '';
header('Content-Type: application/json');
echo json_encode(['main_data' => $main_data]);

?>