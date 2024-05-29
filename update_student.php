<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "student360";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE students_list SET surname=?, first_name=?, middle_name=?, course=?, section=?, birthdate=?, gender=?, email=?, phone=?, address=?, contact_number=? WHERE student_id=?");
    $stmt->bind_param("sssssssssssi", $surname, $first_name, $middle_name, $course, $section, $birthdate, $gender, $email, $phone, $address, $contact, $id);

    $id = $_POST['id'];
    $surname = $_POST['surname'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $course = $_POST['course'];
    $section = $_POST['section'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Student details updated successfully";
        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['error'] = "Failed to update student details";
        echo json_encode($response);
    }

    $stmt->close();
    $conn->close();
} else {
    $response['success'] = false;
    $response['error'] = "Invalid request method";
    echo json_encode($response);
}
?>
