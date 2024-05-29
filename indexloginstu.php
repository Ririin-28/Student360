<?php
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lstudent_id = $_POST['lstudent_id'];
$password = $_POST['password'];

$lstudent_id = $conn->real_escape_string($lstudent_id);
$password = $conn->real_escape_string($password);

$password = (int)$password;

$sql = "SELECT * FROM students_login WHERE lstudent_id = '$lstudent_id' AND id = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['lstudent_id'] = $lstudent_id;
    header("Location: studentinterface.php");
    exit();
} else {
    header('Location: LoginStu.php?error=1');
    exit;
}

?>

 
 