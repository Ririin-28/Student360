<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    $sql = "SELECT * FROM students_list WHERE student_id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        echo json_encode($student);
    } else {
        echo json_encode(["error" => "Student not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}

$conn->close();
?>
