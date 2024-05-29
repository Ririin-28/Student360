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
    $student_id = $_GET['id'];

    $sql = "SELECT * FROM student_grades WHERE gstudent_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $grades = array();

        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }

        echo json_encode($grades);
    } else {
        echo json_encode(["error" => "No grades found for this student."]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "No student ID provided."]);
}

$conn->close();
?>
