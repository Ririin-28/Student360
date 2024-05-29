<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["student_id"])) {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "student360";
    
    $conn = new mysqli($servername, $db_username, $db_password, $dbname); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$id = isset($_POST['student_id']) ? $conn->real_escape_string($_POST['student_id']) : '';

if (!empty($id)) {
    $sql_personal_info = "DELETE FROM student_grades WHERE gstudent_id='$id';";
        if ($conn->query($sql_personal_info) === TRUE) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting personal_info record: " . $conn->error;
        }
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Student ID not provided.";
}

$conn->close();

?>