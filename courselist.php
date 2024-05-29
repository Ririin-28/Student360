<?php
session_start();
if(!isset($_SESSION['username'])) {
    header('Location: UserSelection.php');
    session_destroy();
    exit;
}
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css">
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
        .navigation ul li:nth-child(5), .navigation ul li:nth-child(6), .navigation ul li:nth-child(7) {
            margin-bottom: 1px;
        }
        .navigation ul li:nth-child(7) {
            margin-bottom: 120px;
        }
        #courseTable th, #courseTable td {
            text-align: center;
        }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1000; 
            left: 0; 
            top: 0; 
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0, 0, 0, 0.4); 
        }
        .modal-content {
            background-color: var(--white);
            margin: 15% auto; 
            padding: 20px; 
            border: 1px solid #888;
            width: 80%; 
            max-width: 600px; 
            border-radius: 20px;
            box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
        }
        .close {
            color: var(--black2);
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover, .close:focus {
            color: var(--green);
            text-decoration: none;
        }
        .editBtn, .deleteBtn {
            background: var(--green);
            color: var(--white);
            border: none;
            border-radius: 20px;
            padding: 10px 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 400;
        }
        .editBtn:hover, .deleteBtn:hover {
            background: #394626;
            color: var(--white);
        }
        #editForm .coursebox, #editForm .coursedescriptionbox {
            margin: 10px 0;
        }
        #editForm input {
            width: 100%;
            height: 40px;
            border: 2px solid var(--green);
            border-radius: 20px;
            margin-top: 5px;
            padding: 0 10px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s;
        }
        #editForm input:focus {
            border: 2px solid var(--lgreen);
        }
        #editForm button {
            display: block;
            width: 100%;
            margin-top: 20px;
            background: var(--green);
            color: var(--white);
            border: none;
            border-radius: 20px;
            padding: 10px 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
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
                <div class="toggle">
                    <img src="assets/imgs/dgmenubar.png" alt="">
                </div>
                <div class="search">
                    <label>
                        <img src="assets/imgs/dgsearch.png" alt="">
                        <input type="text" id="searchInput" placeholder="Search">
                    </label>
                </div>
                <div class="user"></div>
            </div>

            <div class="header">Course List</div>
            <div class="details">
                <div class="stdntlist">
                    <div class="cardHeader">
                        <h2>Course List</h2>
                        <a href="addcourse.php" class="addcoursebtn" id="addcoursebtn">
                            <img src="assets/imgs/wadd.png" alt="">
                            Add Course
                        </a>
                    </div>
                    <table id="courseTable">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Course Name</td>
                                <td>Course Description</td>
                                <td>Year & Sec</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $servername = "localhost";
                                $db_username = "root";
                                $db_password = "";
                                $dbname = "student360";
                                $conn = new mysqli($servername, $db_username, $db_password, $dbname); 

                                if ($conn->connect_error) {
                                    die("Connection failed. Please try again: " . $conn->connect_error);
                                }

                                $sql = "SELECT * FROM courses";
                                $result = $conn->query($sql);

                                if (!$result){
                                    die("Invalid query: " . $conn->error);
                                }

                                while ($row = $result->fetch_assoc()){
                                    echo "
                                    <tr data-id='$row[id]'>
                                        <td>$row[id]</td>
                                        <td>$row[course]</td>
                                        <td>$row[course_description]</td>
                                        <td>$row[year_sec]</td>
                                        <td>
                                            <button class='editBtn'>Edit</button>
                                            <button class='deleteBtn'>Delete</button>
                                        </td>
                                    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeEdit">&times;</span>
                    <h2>Edit Course</h2>
                    <form id="editForm">
                        <input type="hidden" id="editId">
                        <label for="editCourseName">Course Name:</label>
                        <input type="text" id="editCourseName" required>
                        <label for="editCourseDescription">Course Description:</label>
                        <input type="text" id="editCourseDescription" required>
                        <label for="editYearSec">Year & Sec:</label>
                        <input type="text" id="editYearSec" required>
                        <button type="submit">Save Changes</button>
                    </form>
                </div>
            </div>

            <script src="assets/js/main.js"></script>

            <script>
var editModal = document.getElementById("editModal");
var closeEdit = document.getElementById("closeEdit");
var editForm = document.getElementById("editForm");

document.querySelectorAll(".editBtn").forEach(button => {
    button.addEventListener("click", function() {
        var row = this.closest("tr");
        var id = row.getAttribute("data-id");

        var xhr = new XMLHttpRequest();
        xhr.open("GET", "get_course.php?id=" + id, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var courseDetails = JSON.parse(xhr.responseText);
                document.getElementById("editId").value = courseDetails.id;
                document.getElementById("editCourseName").value = courseDetails.course;
                document.getElementById("editCourseDescription").value = courseDetails.course_description;
                document.getElementById("editYearSec").value = courseDetails.year_sec;
                editModal.style.display = "block";
            }
        };
        xhr.send();
    });
});

closeEdit.onclick = function() {
    editModal.style.display = "none";
}

document.getElementById("editForm").onsubmit = function(event) {
    event.preventDefault();
    var id = document.getElementById("editId").value;
    var courseName = document.getElementById("editCourseName").value;
    var courseDescription = document.getElementById("editCourseDescription").value;
    var yearSec = document.getElementById("editYearSec").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_course.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert("Failed to update course: " + response.error);
            }
        }
    };
    var params = `id=${id}&course=${courseName}&course_description=${courseDescription}&year_sec=${yearSec}`;
    xhr.send(params);
};

document.querySelectorAll(".deleteBtn").forEach(button => {
    button.addEventListener("click", function() {
        if (confirm("Are you sure you want to delete this course?")) {
            var row = this.closest("tr");
            var id = row.getAttribute("data-id");

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_course.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert("Course deleted successfully.");
                    location.reload();
                }
            };
            xhr.send("id=" + id);
        }
    });
});

document.getElementById("searchInput").addEventListener("keyup", function() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("courseTable");
    tr = table.getElementsByTagName("tr");

    for (i = 1; i < tr.length; i++) {
        tr[i].style.display = "none";
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                }
            }
        }
    }
});
            </script>
</body>
</html>

