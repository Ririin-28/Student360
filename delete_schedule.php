<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student360";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM schedule WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    http_response_code(500);
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>