<?php

session_start();
if (!isset($_SESSION['username'])) {
    header('Location: UserSelection.php');
    session_destroy();
    exit;
}

$username = $_SESSION['username'];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed. Please try again: " . $conn->connect_error);
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST["action"];
        
        if ($action == "add_student") {
            $student_id = $_POST["student_id"];
            $surname = $_POST["surname"];
            $first_name = $_POST["first_name"];
            $middle_name = $_POST["middle_name"];
            $course = $_POST["course"];
            $section = $_POST["section"];
            $age = $_POST["age"];
            $gender = $_POST["gender"];
            $birthdate = $_POST["birthdate"];
            $address = $_POST["address"];
            $email = $_POST["email"];
            $contact_number = $_POST["contact_number"];
            
            $check_sql = "SELECT * FROM students_list WHERE student_id = '$student_id'";
            $check_result = $conn->query($check_sql);
            if ($check_result->num_rows > 0) {
                echo "Student ID already exists. Please choose a different one.";
                exit;
            }
            
            $sql = "INSERT INTO students_list (student_id, surname, first_name, middle_name, course, section, age, gender, birthdate, address, email, contact_number) 
                    VALUES ('$student_id', '$surname', '$first_name', '$middle_name', '$course', '$section', '$age', '$gender', '$birthdate', '$address', '$email', '$contact_number')";
            $result = $conn->query($sql);
            
            if (!$result) {
                echo "Invalid query: " . $conn->error;
                exit;
            }
            
            echo "Student details added successfully!";
            exit;
        }
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        .navigation ul li:nth-child(1) {
            margin-top: 20px;
            margin-bottom: 50px;
            pointer-events: none;
        }

        .navigation ul li:nth-child(1) .title {
            margin-top: 5px;
            font-weight: 500;
            font-size: 1.5rem;
            color: #C9D99E;
        }

        .navigation ul li:nth-child(5){
            margin-bottom: 1px;
        }

        .navigation ul li:nth-child(6){
            margin-bottom: 1px;
        }

        .navigation ul li:nth-child(7){
            margin-bottom: 120px;
        }

        .addcoursedetails {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .addcoursecontainer {
            width: 80%;
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .cardHeader {
            margin-bottom: 20px;
        }

        .cardHeader h2 {
            margin: 0;
        }
        .form-row .student_id{
            width: 100%;
            height: 50px;
            margin: 0px 0;
        }
        .student_id{
            width: 50%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid var(--green);
            border-radius: 40px;
            font-weight: 600;
            color: var(--green);
            padding: 0px 0px 0px 15px;
        }


        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
            margin-right: 10px;
        }

        .form-group:last-child {
            margin-right: 0;
        }

        .form-group p {
            margin: 0;
            font-weight: bold;
            font-size: 15px;
            color: var(--green);
        }

        .form-group input, .form-group select {
            width: 100%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid var(--green);
            border-radius: 45px;
            font-weight: 600;
            color: var(--green);
            padding: 0 15px;
        }

        .form-group input::placeholder {
            color: var(--green);
        }

        .form-group input:focus, .form-group select:focus {
            background-color: var(--white);
            color: #6B8149;
            border: 4px solid #394626;
        }

        .form-group select option {
            background: #6B8149;
            color: #fff;
            font-weight: bold;
            padding: 10px 15px;
        }

        .addcoursecontainer .coursesubmitbtn{
            width: 30%;
            height: 45px;
            background: var(--green);
            color: var(--white);
            border: 3px solid var(--lgreen);
            border-radius: 45px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin: 0px 360px 20px
        }

        .coursesubmitbtn:hover{
            background-color: #394626;
            border: 8px solid #394626;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#" class="userLink">
                        <span class="userprofile">
                            <img src="assets/imgs/Student360 Logo.png" alt="">
                        </span>    
                        <span class="title"><?php echo htmlspecialchars($username); ?></span>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">
                        <span class="icon">
                            <img src="assets/imgs/gdashboard.png" alt="">
                        </span>    
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="addcourse.php">
                        <span class="icon">
                            <img src="assets/imgs/gaddcourse.png" alt="">
                        </span>    
                        <span class="title">Add Course</span>
                    </a>
                </li>
                <li>
                    <a href="addstudent.php">
                        <span class="icon">
                            <img src="assets/imgs/gaddstudent.png" alt="">
                        </span>    
                        <span class="title">Add Student</span>
                    </a>
                </li>
                <li>
                    <a href="addgrade.php">
                        <span class="icon">
                            <img src="assets/imgs/gaddgrades.png" alt="">
                        </span>    
                        <span class="title">Add Grades</span>
                    </a>
                </li>
                <li>
                    <a href="courselist.php">
                        <span class="icon">
                            <img src="assets/imgs/gcourselist.png" alt="">
                        </span>    
                        <span class="title">Course List</span>
                    </a>
                </li>
                <li>
                    <a href="studentlist.php">
                        <span class="icon">
                            <img src="assets/imgs/gstudentlist.png" alt="">
                        </span>    
                        <span class="title">Student List</span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <span class="icon">
                            <img src="assets/imgs/glogout.png" alt="">
                        </span>    
                        <span class="title">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="topbar">
                <div class="toggle"><img src="assets/imgs/dgmenubar.png" alt=""></div>
                <div class="search"></div>
                <div class="user"></div>
            </div>
            <div class="header">Add Student</div>
            <div class="addcoursedetails">
                <div class="addcoursecontainer">
                    <div class="cardHeader"><h2>New Student Details</h2></div>
                    <form id="addStudentForm">
                        <div class="form-row">
                            <div class="form-group">
                                <p>Student ID</p>
                                <input type="text" id="student_id" name="student_id" class="student_id" placeholder="Student ID" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <p>Surname</p>
                                <input type="text" id="surname" name="surname" placeholder="Surname" required>
                            </div>
                            <div class="form-group">
                                <p>First Name</p>
                                <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <p>Middle Name</p>
                                <input type="text" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <p>Course</p>
                                <select id="course" name="course" required>
                                    <option value="" disabled selected>Select Course</option>
                                    <option value="BSIS">Bachelor of Science in Information Systems</option>
                                    <option value="BSCS">Bachelor of Science in Computer Science</option>
                                    <option value="BSIT">Bachelor of Science in Information Technology</option>
                                    <option value="BSEMC">Bachelor of Science in Entertainment and Multimedia Computing </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <p>Section</p>
                                <select id="section" name="section" required>
                                    <option value="" disabled selected>Select Section</option>
                                    <option value="1-A">1-A</option>
                                    <option value="1-B">1-B</option>
                                    <option value="2-A">2-A</option>
                                    <option value="2-B">2-B</option>
                                    <option value="3-A">3-A</option>
                                    <option value="3-B">3-B</option>
                                    <option value="4-A">4-A</option>
                                    <option value="4-B">4-B</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <p>Age</p>
                                <input type="text" id="age" name="age" placeholder="Age" required>
                            </div>
                            <div class="form-group">
                                <p>Gender</p>
                                <select id="gender" name="gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <p>Birthdate</p>
                                <input type="date" id="birthdate" name="birthdate" placeholder="Birthdate" required>
                            </div>
                            <div class="form-group">
                                <p>Address</p>
                                <input type="text" id="address" name="address" placeholder="Address" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <p>Email</p>
                                <input type="email" id="email" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <p>Contact Number</p>
                                <input type="text" id="contact_number" name="contact_number" placeholder="Contact Number" required>
                            </div>
                        </div>
                        <input type="hidden" name="action" value="add_student">
                        <button type="submit" class="coursesubmitbtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            $('#addStudentForm').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                var studentID = $('#student_id').val();
                var surname = $('#surname').val();
                var first_name = $('#first_name').val();
                var middle_name = $('#middle_name').val();
                var student_Name = surname + ', ' + first_name + ' ' + middle_name;
                var age = $('#age').val();
                var gender = $('#gender').val();
                var birthdate = $('#birthdate').val();
                var email = $('#email').val();
                var contactNumber = $('#contact_number').val();
                var course = $('#course').val();
                var section = $('#section').val();

                var valid = true;
                var messages = [];

                var studentIDPattern = /^\d{8}-[NS]$/;
                if (!studentIDPattern.test(studentID)) {
                    valid = false;
                    messages.push("Student ID must be in the format 20220636-N or 20220636-S");
                }

                var agePattern = /^\d{1,2}$/;
                if (!agePattern.test(age)) {
                    valid = false;
                    messages.push("Age must be a number with a maximum of two digits");
                }

                if (gender !== "Female" && gender !== "Male") {
                    valid = false;
                    messages.push("Gender must be either 'Female' or 'Male'");
                }

                var birthdatePattern = /^\d{4}-\d{2}-\d{2}$/;
                if (!birthdatePattern.test(birthdate)) {
                    valid = false;
                    messages.push("Birthdate must be in the format YYYY-MM-DD");
                }

                var emailPattern = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
                if (!emailPattern.test(email)) {
                    valid = false;
                    messages.push("Email must end with @gmail.com");
                }

                var contactNumberPattern = /^\d{11}$/;
                if (!contactNumberPattern.test(contactNumber)) {
                    valid = false;
                    messages.push("Contact Number must be exactly 11 digits");
                }

                var sectionPattern = /^\d+-[A-Z]$/;
                if (!sectionPattern.test(section)) {
                    valid = false;
                    messages.push("Section must be in the format 2-A");
                }

                if (!valid) {
                    alert(messages.join('\n'));
                    return false;
                }

                $.ajax({
                    type: 'POST',
                    url: '',
                    data: formData,
                    success: function(response) {
                        alert(response);
                        $('#addStudentForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error occurred, please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>