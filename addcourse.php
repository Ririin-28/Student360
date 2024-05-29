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
    echo json_encode(["status" => "error", "message" => "Connection failed. Please try again: " . $conn->connect_error]);
    exit;
}

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $course = $_POST["course"];
        $course_description = $_POST["course_description"];
        $year_sec = $_POST["year_sec"];

        if (empty($course) || empty($course_description) || empty($year_sec)) {
            echo json_encode(["status" => "error", "message" => "All fields are required"]);
            exit;
        }

        $sql = "INSERT INTO courses (course, course_description, year_sec) VALUES ('$course', '$course_description', '$year_sec')";
        $result = $conn->query($sql);

        if (!$result) {
            echo json_encode(["status" => "error", "message" => "Invalid query: " . $conn->error]);
            exit;
        }

        echo json_encode(["status" => "success", "message" => "Course added successfully!"]);
        exit;
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
    <title>Add Course</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">

    <!-- ========================= Styles ========================= -->
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>


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

</style>

<body>
    <!-- ========================= Navigation ========================= -->
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
                    <a href="dashboard.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/gdashboard.png" alt="">
                        </span>    
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="addcourse.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/gaddcourse.png" alt="">
                        </span>    
                        <span class="title">Add Course</span>
                    </a>
                </li>


                <li>
                    <a href="addstudent.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/gaddstudent.png" alt="">
                        </span>    
                        <span class="title">Add Student</span>
                    </a>
                </li>

                <li>
                    <a href="addgrade.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/gaddgrades.png" alt="">
                        </span>    
                        <span class="title">Add Grades</span>
                    </a>
                </li>

                <li>
                    <a href="courselist.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/gcourselist.png" alt="">
                        </span>    
                        <span class="title">Course List</span>
                    </a>
                </li>

                <li>
                    <a href="studentlist.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/gstudentlist.png" alt="">
                        </span>    
                        <span class="title">Student List</span>
                    </a>
                </li>

                <li>
                    <a href="logout.php" class="nav-link">
                        <span class="icon">
                            <img src="assets/imgs/glogout.png" alt="">
                        </span>    
                        <span class="title">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ========================= -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <img src="assets/imgs/dgmenubar.png" alt="">
                </div>

            <div class="search">
            </div>

                <div class="user">
                </div>
            </div>

            <!-- ========================= Header ========================= -->
            <div class="header">Add Course</div>

            <!-- ========================= Display (List and Create ) ========================= -->
            <div class="addcoursedetails">
                <div class="addcoursecontainer">
                    <div class="cardHeader">
                        <h2>New Course Details</h2>
                    </div>

                    <form id="addCourseForm">


<div class="addcoursebox">
    <p>Select Course:</p>
    <select id="course" name="course" required>
        <option value="" disabled selected>Select Course Code</option>
        <option value="BSIS">BSIS</option>
        <option value="BSCS">BSCS</option>
        <option value="BSIT">BSIT</option>
        <option value="BSEMC">BSEMC</option>
    </select>
</div>
                        <div class="coursecodebox">
                            <p>Course Description:</p>
                            <input type="text" id="course_description" name="course_description" placeholder="Course Description" readonly>
                        </div>

                        <div class="coursedescriptionbox">
                            <p>Year and Section:</p>
                            <input type="text" id="year_sec" name="year_sec" placeholder="Add Year and Section" pattern="^[1-4]-[A-Z]$" title="Format should be number (1-4) followed by a hyphen and an uppercase letter (e.g., 2-A)" required>
                        </div>
                        <input type="hidden" name="action" value="">
                        <button type="submit" class="coursesubmitbtn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================= Scripts =========================  -->
    <script src="assets/js/main.js"></script>

    <script>
    $(document).ready(function(){
    $('#addCourseForm').submit(function(e){
        e.preventDefault();

        var formData = $(this).serialize();

        var yearSecPattern = /^[1-4]-[A-Z]$/;
        var yearSecInput = $('#year_sec').val();

        if (!yearSecPattern.test(yearSecInput)) {
            alert('Invalid format for Year and Section. Please use the format: number (1-4) followed by a hyphen and an uppercase letter (e.g., 2-A).');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: formData,
            dataType: 'json',
            success: function(response){
                if(response.status === "success") {
                    alert(response.message);
                    $('#addCourseForm')[0].reset();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText); 
                alert('Error occurred, please try again.');
            }
        });
    });

    $('.nav-link').on('click', function(){
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
    });

    var currentURL = window.location.href;
    $('.nav-link').each(function(){
        if (this.href === currentURL) {
            $(this).addClass('active');
        }
    });
});

$(document).ready(function(){
    $('#course').change(function(){
        var selectedCourse = $(this).val();
        if(selectedCourse === 'BSIS') {
            $('#course_description').val('Bachelor of Science in Information System');
        } else if(selectedCourse === 'BSCS') {
            $('#course_description').val('Bachelor of Science in Computer Science');
        } else if(selectedCourse === 'BSIT') {
            $('#course_description').val('Bachelor of Science in Information Technology');
        } else if(selectedCourse === 'BSEMC') {
            $('#course_description').val('Bachelor of Science in Bachelor of Science in Entertainment and Media Computing');
        }
        
    });
});

</script>

</body>

</html>
