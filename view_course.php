<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed. Please try again: " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM courses WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "<p>ID: " . $row['id'] . "</p>";
    echo "<p>Course Name: " . $row['course'] . "</p>";
    echo "<p>Course Description: " . $row['course_description'] . "</p>";
    echo "<p>Year & Sec: " . $row['year_sec'] . "</p>";
    echo "<p>Student Count: " . $row['student_count'] . "</p>";
} else {
    echo "No data found.";
}

$conn->close();
?>
