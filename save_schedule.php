<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$day = $_POST['day'];
$time = $_POST['time'];
$course = $_POST['course'];
$year_section = $_POST['year_section'];
$subject = $_POST['subject'];
$room = $_POST['room'];

if (empty($id)) {
    $stmt = $conn->prepare("INSERT INTO schedule (day, time, course, year_section, subject, room) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $day, $time, $course, $year_section, $subject, $room);
    $stmt->execute();
    echo $stmt->insert_id;
    $stmt->close();
} else {
    $stmt = $conn->prepare("UPDATE schedule SET day=?, time=?, course=?, year_section=?, subject=?, room=? WHERE id=?");
    $stmt->bind_param("ssssssi", $day, $time, $course, $year_section, $subject, $room, $id);
    $stmt->execute();
    echo $id;
    $stmt->close();
}

$conn->close();
?>