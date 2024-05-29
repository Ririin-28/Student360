<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['student_id']) ? $conn->real_escape_string($_GET['student_id']) : '';

if (!empty($id)) {
    $sql = "SELECT students.*, personal_info.*,
                   CONCAT(personal_info.surname, ', ', personal_info.first_name, ' ', personal_info.middle_name) AS student_name
            FROM students
            INNER JOIN personal_info ON students.student_id = personal_info.pstudent_id
            WHERE students.student_id = '$id'";
    
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found.']);
    }
} else {
    echo json_encode(['error' => 'Student ID not provided.']);
}

$conn->close();
?>

<script>
$(document).ready(function() {
    // View student details
    $('.viewBtn').click(function() {
        var studentId = $(this).closest('tr').data('id');
        $.ajax({
            url: 'get_student.php',
            type: 'GET',
            data: { student_id: studentId },
            success: function(response) {
                var data = JSON.parse(response);
                if (!data.error) {
                    $('#viewContent').html(`
                        <p>Student ID: ${data.student_id}</p>
                        <p>Student Name: ${data.student_name}</p>
                        <p>Course: ${data.course}</p>
                        <p>Section: ${data.section}</p>
                        <p>Age: ${data.age}</p>
                        <p>Gender: ${data.gender}</p>
                        <p>Birthdate: ${data.birthdate}</p>
                        <p>Address: ${data.address}</p>
                        <p>Email: ${data.email}</p>
                        <p>Contact Number: ${data.contact_number}</p>
                    `);
                    $('#viewModal').show();
                } else {
                    alert(data.error);
                }
            }
        });
    });

    // Edit student details
    $('.editBtn').click(function() {
        var studentId = $(this).closest('tr').data('id');
        $.ajax({
            url: 'get_student.php',
            type: 'GET',
            data: { student_id: studentId },
            success: function(response) {
                var data = JSON.parse(response);
                if (!data.error) {
                    $('#editStudentId').val(data.student_id);
                    $('#editStudentName').val(data.student_name);
                    $('#editCourse').val(data.course);
                    $('#editSection').val(data.section);
                    $('#editAge').val(data.age);
                    $('#editGender').val(data.gender);
                    $('#editBirthdate').val(data.birthdate);
                    $('#editAddress').val(data.address);
                    $('#editEmail').val(data.email);
                    $('#editContactNumber').val(data.contact_number);
                    $('#editModal').show();
                } else {
                    alert(data.error);
                }
            }
        });
    });

    // Close modals
    $('.close').click(function() {
        $(this).closest('.modal').hide();
    });
});
</script>

