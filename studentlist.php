<?php
session_start();
if(!isset($_SESSION['username']))
{
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
    <title>Student List</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <!-- ========================= Styles ========================= -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

   <!-- ========================= Styles ========================= -->
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

.navigation ul li:nth-child(5){
    margin-bottom: 1px;
}

.navigation ul li:nth-child(6){
    margin-bottom: 1px;
}

.navigation ul li:nth-child(7){
    margin-bottom: 120px;
}

#studentTable th, #studentTable td{
    text-align: center;
}

.nameColumn {
    width: 30%;
}
.courseColumn {
    width: 10%;
}
.sectionColumn {
    width: 10%;
}

 /*========================= Modals =========================*/
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

.modal-content{
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

.close:hover,
.close:focus {
    color: var(--green);
    text-decoration: none;
}

.viewBtn, .editBtn, .deleteBtn, .viewrecBtn, .deleterecBtn {
    background: var(--green);
    color: var(--white);
    border: none;
    border-radius: 20px;
    padding: 10px 10px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 400;

}

.viewBtn:hover, .editBtn:hover, .deleteBtn:hover, .viewrecBtn:hover, .deleterecBtn:hover {
    background: #394626;
    color: var(--white);
}


 /*========================= Edit Form Modal =========================*/
#editForm .coursebox, #editForm .coursedescriptionbox {
    margin: 10px 0;
}

#editForm input {
    color: var(--black1);
    font-size: 14px;
    font-weight: 400;

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

 /*========================= View Modal =========================*/

    #viewModal .modal-content {
        background-color: var(--white);
        margin: 15% auto;
        padding: 20px; 
        border: 1px solid #888;
        width: 80%; 
        max-width: 600px; 
        border-radius: 20px;
        box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
    }

    #viewModal .close {
        color: var(--black2);
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    #viewModal .close:hover,
    #viewModal .close:focus {
        color: var(--green);
        text-decoration: none;
    }

    #viewModal .modal-content p {
        font-size: 16px;
        color: var(--black1);
        margin: 10px 0;
    }

    #viewModal .modal-content p span {
        color: var(--green);
    }


    /*========================= ViewGrades Modal =========================*/
#viewRecModal .modal-content {
    background-color: var(--white);
    margin: 15% auto;
    padding: 20px; 
    border: 1px solid #888;
    width: 80%; 
    max-width: 600px; 
    border-radius: 20px;
    box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
}

#viewRecModal .close {
    color: var(--black2);
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

#viewRecModal .close:hover,
#viewRecModal .close:focus {
    color: var(--green);
    text-decoration: none;
}

#viewRecModal .modal-content p {
    font-size: 16px;
    color: var(--black1);
    margin: 10px 0;
}

#viewRecModal .modal-content p span {
    color: var(--green);
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

        <!-- ========================= Main ========================= -->
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

                <div class="user">
                </div>
            </div>
            <!-- ========================= Header ========================= -->
            <div class="header">Student List</div>

            <!-- ========================= Display (List and Create ) ========================= -->
    <div class="details">
        <div class="stdntlist">
            <div class="cardHeader">
                <h2>Student List</h2>
                <a href="addstudent.php" class="addstudentbtn" id="addstudentbtn">
                    <img src="assets/imgs/wadd.png" alt="">
                    Add Student
                </a>
            </div>

            <table id="studentTable">
                <thead>
                    <tr>
                        <td>Student ID</td>
                        <td class="nameColumn">Name</td>
                        <td class="coursesColumn">Course</td>
                        <td class="sectionColumn">Section</td>
                        <td>Action</td>
                        <td>Grades</td>
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

$sql = "SELECT student_id, CONCAT(surname, ', ', first_name, ' ', middle_name) AS student_name, course, section FROM students_list";
$result = $conn->query($sql);

if (!$result) {
    die("Invalid query: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    echo "
    <tr data-id='{$row['student_id']}'>
        <td>{$row['student_id']}</td>
        <td>{$row['student_name']}</td>
        <td>{$row['course']}</td>
        <td>{$row['section']}</td>
        <td>
            <button class='viewBtn'>View</button>
            <button class='editBtn'>Edit</button>
            <button class='deleteBtn'>Delete</button>
        </td>
        <td>
            <button class='viewrecBtn'>View Grades</button>
            <button class='deleterecBtn'>Delete Grades</button>
        </td>
    </tr>";
}

$conn->close();
?>

                        </tbody>
                    </table>
                </div>
            </div>

<!-- View Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeView">&times;</span>
        <h2>Student Details</h2>
        <div class="details">
            <p><strong>ID:</strong> <span id="studentId"></span></p>
            <p><strong>Name:</strong> <span id="studentName"></span></p>
            <p><strong>Course:</strong> <span id="studentCourse"></span></p>
            <p><strong>Section:</strong> <span id="studentSection"></span></p>
            <p><strong>Birth Date:</strong> <span id="studentBirthdate"></span></p>
            <p><strong>Gender:</strong> <span id="studentGender"></span></p>
            <p><strong>Email:</strong> <span id="studentEmail"></span></p>
            <p><strong>Phone:</strong> <span id="studentPhone"></span></p>
            <p><strong>Address:</strong> <span id="studentAddress"></span></p>
            <p><strong>Contact Number:</strong> <span id="studentContact"></span></p>
        </div>
    </div>
</div>


            <!-- View Grades Modal -->
            <div id="viewRecModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeViewRec">&times;</span>
                    <h2>Student Grades</h2>
                    <div id="viewRecContent"></div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" id="closeEdit">&times;</span>
                    <h2>Edit Student</h2>
                    <form id="editForm">
                        <div class="coursebox">
                            <label for="editStudentId">Student ID</label>
                            <input type="text" id="editStudentId" name="student_id" readonly>
                        </div>
                        <div class="coursebox">
                            <label for="editSurname">Surname</label>
                            <input type="text" id="editSurname" name="surname" required>
                        </div>
                        <div class="coursebox">
                            <label for="editFirstName">First Name</label>
                            <input type="text" id="editFirstName" name="first_name" required>
                        </div>
                        <div class="coursebox">
                            <label for="editMiddleName">Middle Name</label>
                            <input type="text" id="editMiddleName" name="middle_name" required>
                        </div>
                        <div class="coursebox">
                            <label for="editCourse">Course</label>
                            <input type="text" id="editCourse" name="course" required>
                        </div>
                        <div class="coursebox">
                            <label for="editSection">Section</label>
                            <input type="text" id="editSection" name="section" required>
                        </div>
                        <div class="coursebox">
                            <label for="editAge">Age</label>
                            <input type="text" id="editAge" name="age" required>
                        </div>
                        <div class="coursebox">
                            <label for="editGender">Gender</label>
                            <input type="text" id="editGender" name="gender" required>
                        </div>
                        <div class="coursebox">
                            <label for="editBirthdate">Birthdate</label>
                            <input type="text" id="editBirthdate" name="birthdate" required>
                        </div>
                        <div class="coursebox">
                            <label for="editAddress">Address</label>
                            <input type="text" id="editAddress" name="address" required>
                        </div>
                        <div class="coursebox">
                            <label for="editEmail">Email</label>
                            <input type="email" id="editEmail" name="email" required>
                        </div>
                        <div class="coursebox">
                            <label for="editContact">Contact</label>
                            <input type="text" id="editContact" name="contact_number" required>
                        </div>
                        <button type="submit">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================= Scripts =========================  -->
    <script src="assets/js/main.js"></script>
    
    <script>
var editModal = document.getElementById("editModal");
var closeEdit = document.getElementById("closeEdit");
var editForm = document.getElementById("editForm");

document.addEventListener("DOMContentLoaded", function() {
    // Function to show the modal
    function showModal(data) {
        document.getElementById("studentId").innerText = data.student_id;
        document.getElementById("studentName").innerText = data.surname + ', ' + data.first_name + ' ' + data.middle_name;
        document.getElementById("studentCourse").innerText = data.course;
        document.getElementById("studentSection").innerText = data.section;
        document.getElementById("studentBirthdate").innerText = data.birthdate;
        document.getElementById("studentGender").innerText = data.gender;
        document.getElementById("studentEmail").innerText = data.email;
        document.getElementById("studentPhone").innerText = data.phone;
        document.getElementById("studentAddress").innerText = data.address;
        document.getElementById("studentContact").innerText = data.contact_number;
        document.getElementById("viewModal").style.display = "block";
    }

    // Event listener for View buttons
    document.querySelectorAll(".viewBtn").forEach(button => {
        button.addEventListener("click", function() {
            var row = this.closest("tr");
            var id = row.getAttribute("data-id");

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_student.php?id=" + id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    showModal(data);
                }
            };
            xhr.send();
        });
    });

    // Close the modal
    document.getElementById("closeView").onclick = function() {
        document.getElementById("viewModal").style.display = "none";
    };

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target == document.getElementById("viewModal")) {
            document.getElementById("viewModal").style.display = "none";
        }
    };
});


    document.addEventListener("DOMContentLoaded", function() {
    // View Student Details
    document.querySelectorAll(".viewBtn").forEach(button => {
        button.addEventListener("click", function() {
            var row = this.closest("tr");
            var id = row.getAttribute("data-id");

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_student.php?id=" + id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("viewContent").innerHTML = xhr.responseText;
                    document.getElementById("viewModal").style.display = "block";
                }
            };
            xhr.send();
        });
    });

    // View Student Grades
    document.querySelectorAll(".viewrecBtn").forEach(button => {
        button.addEventListener("click", function() {
            var row = this.closest("tr");
            var id = row.getAttribute("data-id");

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_student_grades.php?id=" + id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("viewRecContent").innerHTML = xhr.responseText;
                    document.getElementById("viewRecModal").style.display = "block";
                }
            };
            xhr.send();
        });
    });

    // Close View Grades Modal
        document.getElementById("closeViewRec").onclick = function() {
        document.getElementById("viewRecModal").style.display = "none";
    };


    // Edit Student Details
    document.querySelectorAll(".editBtn").forEach(button => {
        button.addEventListener("click", function() {
            var row = this.closest("tr");
            var id = row.getAttribute("data-id");

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_student.php?id=" + id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var studentDetails = JSON.parse(xhr.responseText);
                    document.getElementById("editStudentId").value = studentDetails.student_id;
                    document.getElementById("editSurname").value = studentDetails.surname;
                    document.getElementById("editFirstName").value = studentDetails.first_name;
                    document.getElementById("editMiddleName").value = studentDetails.middle_name;
                    document.getElementById("editCourse").value = studentDetails.course;
                    document.getElementById("editSection").value = studentDetails.section;
                    document.getElementById("editAge").value = studentDetails.age;
                    document.getElementById("editGender").value = studentDetails.gender;
                    document.getElementById("editBirthdate").value = studentDetails.birthdate;
                    document.getElementById("editEmail").value = studentDetails.email;
                    document.getElementById("editAddress").value = studentDetails.address;
                    document.getElementById("editContact").value = studentDetails.contact_number;
                    document.getElementById("editModal").style.display = "block";
                }
            };
            xhr.send();
        });
    });

    // Close Edit Modal
    document.getElementById("closeEdit").onclick = function() {
        document.getElementById("editModal").style.display = "none";
    };

    document.getElementById("editStudentForm").onsubmit = function(event) {
    event.preventDefault();
    var id = document.getElementById("editStudentId").value;
    var surname = document.getElementById("editSurname").value;
    var firstName = document.getElementById("editFirstName").value;
    var middleName = document.getElementById("editMiddleName").value;
    var course = document.getElementById("editCourse").value;
    var section = document.getElementById("editSection").value;
    var birthdate = document.getElementById("editBirthdate").value;
    var gender = document.getElementById("editGender").value;
    var email = document.getElementById("editEmail").value;
    var phone = document.getElementById("editPhone").value;
    var address = document.getElementById("editAddress").value;
    var contact = document.getElementById("editContact").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_student.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert("Failed to update student: " + response.error);
            }
        }
    };
    var params = `id=${id}&surname=${surname}&first_name=${firstName}&middle_name=${middleName}&course=${course}&section=${section}&birthdate=${birthdate}&gender=${gender}&email=${email}&phone=${phone}&address=${address}&contact=${contact}`;
    xhr.send(params);
};


    // Delete Student
    document.querySelectorAll(".deleteBtn").forEach(button => {
        button.addEventListener("click", function() {
            if (confirm("Are you sure you want to delete this student?")) {
                var row = this.closest("tr");
                var id = row.getAttribute("data-id");

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert("Student deleted successfully.");
                        location.reload();
                    }
                };
                xhr.send("student_id=" + id);
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
    // Delete Student
    document.querySelectorAll(".deleteBtn").forEach(button => {
        button.addEventListener("click", function() {
            if (confirm("Are you sure you want to delete this student?")) {
                var row = this.closest("tr");
                var id = row.getAttribute("data-id");

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert("Student deleted successfully.");
                        location.reload();
                    }
                };
                xhr.send("student_id=" + id);
            }
        });
    });

    // Delete Student Grades
    document.querySelectorAll(".deleterecBtn").forEach(button => {
        button.addEventListener("click", function() {
            if (confirm("Are you sure you want to delete grades for this student?")) {
                var row = this.closest("tr");
                var id = row.getAttribute("data-id");

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_student_grades.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert("Grades deleted successfully.");
                        location.reload();
                    }
                };
                xhr.send("student_id=" + id);
            }
        });
    });
});


    // Close View Modal
    document.getElementById("closeView").onclick = function() {
        document.getElementById("viewModal").style.display = "none";
    };


    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = "none";
        }
    };
});

document.getElementById("searchInput").addEventListener("keyup", function() {
    var input, filter, table, tr, td, i, j, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toLowerCase();
    table = document.getElementById("studentTable");
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