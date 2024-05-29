<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed. Please try again: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM courses WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    $conn->query("ALTER TABLE courses AUTO_INCREMENT = 1");
    
    $result = $conn->query("SELECT id FROM courses ORDER BY id ASC");
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $conn->query("UPDATE courses SET id = $counter WHERE id = " . $row['id']);
        $counter++;
    }
    
    echo "Record deleted successfully and AUTO_INCREMENT reset.";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
