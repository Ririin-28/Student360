<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $course = $conn->real_escape_string($_POST['course']);
    $course_description = $conn->real_escape_string($_POST['course_description']);
    $year_sec = $conn->real_escape_string($_POST['year_sec']);

    $sql = "UPDATE courses SET course='$course', course_description='$course_description', year_sec='$year_sec' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Record updated successfully"]);
    } else {
        echo json_encode(["success" => false, "error" => "Error updating record: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request method"]);
}

$conn->close();
?>
