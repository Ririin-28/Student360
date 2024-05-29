<?php
session_start();
if (!isset($_SESSION['lstudent_id'])) {
    header('Location: UserSelection.php');
    session_destroy();
    exit;
}

$student_id = $_SESSION['lstudent_id'];

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "student360";

$conn = new mysqli($servername, $db_username, $db_password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Student</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <link rel="stylesheet" href="assets/css/studentstyle.css">
    <style>
        /* Modal styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: #C9D99E; 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
            color: #394626;
        }
        .modal-content {
            background-color: #C9D99E;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
            max-width: 400px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .close {
            color: #526436;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: #526436;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons button {
            margin: 0 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 45px;
            font-size: 16px;
            cursor: pointer;
        }
        #confirmLogout {
            background-color: firebrick;
            color: white;
        }
        #confirmLogout:hover {
            background-color: #811818;
        }
        #cancelLogout {
            background-color: #526436;
            color: white;
        }
        #cancelLogout:hover {
            background-color: #394626;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="topbar">
        <div class="logo">
            <img src="assets/imgs/S360white.png" type="image/png">
            <h1>Student360</h1>
        </div>
        <button type="button" class="logoutbtn" id="logoutBtn">
            <img src="assets/imgs/glogout.png">
            Log Out
        </button>
    </div>
    <!-- Logout Modal -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you sure you want to log out?</p>
            <div class="modal-buttons">
                <button id="confirmLogout">OK</button>
                <button id="cancelLogout">Cancel</button>
            </div>
        </div>
    </div>
    <!-- ========================= Cards ========================= -->
    <div class="cardBox">
        <div class="card">
            <div>
                <div class="studentName">
                    <?php
                        $sql = "SELECT CONCAT(surname, ', ', first_name, ' ', middle_name) AS student_name, student_id FROM students_list WHERE student_id = '$student_id'";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo $row['student_name'];
                            $student_id_val = $row['student_id'];
                        } else {
                            echo "No data found";
                        }
                    ?>
                </div>
                <div class="cardName">
                    <?php
                        if (isset($student_id_val)) {
                            echo $student_id_val;
                        }
                    ?>
                </div>
            </div>
            <div class="iconBx">
                <img src="assets/imgs/studentdbrd.png" alt="">
            </div>
        </div>

        <div class="card card4">
            <div class="date-container">
                <div class="numbers">
                    <?php
                        $date = new DateTime();
                        echo $date->format('F j, Y');
                    ?>
                </div>
                <div class="cardName">Date Today</div>
            </div>
        </div>
    </div>
    <div class="details">
        <div class="contents">
            <h2>Personal Information</h2>
            <table class="info-table" id="studentinformation">
                <?php

                $sql1 = "SELECT CONCAT(surname, ', ', first_name, ' ', middle_name) AS student_name, student_id FROM students_list WHERE student_id = '$student_id' ";
                $result1 = $conn->query($sql1);

                $sql2 = "SELECT age, gender, birthdate, address FROM students_list WHERE student_id = '$student_id'";
                $result2 = $conn->query($sql2);

                if ($result1->num_rows > 0) {
                    $row1 = $result1->fetch_assoc();
                    if ($result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        echo "<tr><th>Full Name</th><td>{$row1['student_name']}</td></tr>";
                        echo "<tr><th>Student ID</th><td>{$row1['student_id']}</td></tr>";
                        echo "<tr><th>Address</th><td>{$row2['address']}</td></tr>";
                        echo "<tr><th>Age</th><td>{$row2['age']}</td></tr>";
                        echo "<tr><th>Gender</th><td>{$row2['gender']}</td></tr>";
                        echo "<tr><th>Birthdate</th><td>{$row2['birthdate']}</td></tr>";
                    } else {
                        echo "<tr><td colspan='2'>No personal information found</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No student information found</td></tr>";
                }
                ?>
            </table>
            
            <h2>Contacts</h2>
            <table class="info-table" id="studentcontacts">
                <?php
                $sql3 = "SELECT email, contact_number FROM students_list WHERE student_id = '$student_id'";
                $result3 = $conn->query($sql3);

                if ($result3->num_rows > 0) {
                    while ($row3 = $result3->fetch_assoc()) {
                        echo "<tr><th>Email</th><td>{$row3['email']}</td></tr>";
                        echo "<tr><th>Phone Number</th><td>{$row3['contact_number']}</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No contact information found</td></tr>";
                }
                ?>
            </table>
            
        </div>
    </div>
</div>
<script>
    var modal = document.getElementById("logoutModal");

    var btn = document.getElementById("logoutBtn");

    var span = document.getElementsByClassName("close")[0];

    var confirmBtn = document.getElementById("confirmLogout");
    var cancelBtn = document.getElementById("cancelLogout");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    confirmBtn.onclick = function() {
        window.location.href = "logout.php";
    }

    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>
