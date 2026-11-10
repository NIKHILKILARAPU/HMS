 <?php
 session_start();
 include '../config.php';
    $room_number = $_POST['room_number'];
    $room_name = $_POST['room_name'];
    $room_capacity = $_POST['room_capacity'];
    $room_equipment = $_POST['room_equipment'];
    $sql = "CREATE TABLE IF NOT EXISTS operation_rooms (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        room_number VARCHAR(10) NOT NULL,
        room_name VARCHAR(50) NOT NULL,
        capacity INT NOT NULL,
        equipment TEXT)";
    if ($conn->query($sql) === TRUE) {
        $insert_sql = "INSERT INTO operation_rooms (room_number, room_name, capacity, equipment) VALUES ('$room_number', '$room_name', $room_capacity, '$room_equipment')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Operation room added successfully'); window.location.href='../admin/index.html';</script>";
        } else {
            echo "<script>alert('Error adding operation room: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
        }
    } else {
        echo "<script>alert('Error creating operation_rooms table: " . mysqli_error($conn) . "'); window.location.href='../admin/index.html';</script>";
    }
?>
    