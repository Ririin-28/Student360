<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: LoginEduc.php');
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
    <title>Dashboard</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<style>
.date-container {
  position: relative;
  font-weight: 500;
  font-size: 2.2rem;
  color: var(--green);
}

.card4 .date-container:hover {
  color: var(--white);
}

.table-container {
  margin-top: 20px;
}

.table {
  width: 100%;
  border-collapse: collapse;
  text-align: center;
}

.table th, .table td {
  border: 1px solid #47572f;
  padding: 8px;
  text-align: center;
}

.table th {
  background-color: var(--green);
  color: white;
  text-align: center;
}

.table td input {
  width: 100%;
  border: none;
  background-color: transparent;
  font-size: 1rem;
  padding: 4px;
  text-align: center;
}

.table-buttons {
  margin-top: 10px;
}

.table-buttons button {
  padding: 10px 15px;
  font-size: 1rem;
  cursor: pointer;
}

.add-row {
  background-color: var(--green);
  border-radius: 45px;
  color: white;
  border: none;
  margin-right: 10px;
}

.add-row:hover {
  background-color: #394626;
}

.save-row {
  background-color: var(--green);
  border-radius: 45px;
  color: var(--white);
  border: none;
  font-weight: 500;
  border: 10px solid var(--green);
}

.delete-row {
  background-color: firebrick;
  border-radius: 45px;
  color: var(--white);
  border: none;
  font-weight: 500;
  border: 10px solid firebrick;
}

.save-row:hover{
  background-color: #394626;
  border: 10px solid #394626;
}

.delete-row:hover{
  background-color: #811818;
  border: 10px solid #811818;
}

.details .dshbrd {
  background: var(--lgreen);
  padding: 20px;
  box-shadow: 0 7px 25px rgba(0, 0, 0, 0.08);
  border-radius: 20px;
  color: var(--green);
  height: auto;
  overflow: hidden;
}

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

.navigation ul li:nth-child(5) {
  margin-bottom: 1px;
}

.navigation ul li:nth-child(6) {
  margin-bottom: 1px;
}

.navigation ul li:nth-child(7) {
  margin-bottom: 120px;
}

.table th:nth-child(1), .table td:nth-child(1) {
  width: 15%;
}

.table th:nth-child(2), .table td:nth-child(2) {
  width: 15%;
}

.table th:nth-child(3), .table td:nth-child(3) {
  width: 10%;
}

.table th:nth-child(4), .table td:nth-child(4) {
  width: 10%;
}

.table th:nth-child(6), .table td:nth-child(6) {
  width: 10%;
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
                </div>

                <div class="sysname">
                    <span class="sysname">Student360</span>
                </div>
            </div>
            <!-- ========================= Header ========================= -->
            <div class="header">Educator's Dashboard</div>

            <!-- ========================= Cards ========================= -->
            <div class="cardBox">
                <div class="card">
                    <div>
                        <?php
                            $servername = "localhost";
                            $db_username = "root";
                            $db_password = "";
                            $dbname = "student360";
                            
                            $conn = new mysqli($servername, $db_username, $db_password, $dbname); 

                            if ($conn->connect_error) {
                                die("Connection failed. Please try again: " . $conn->connect_error);
                            }

                            $count_sql = "SELECT COUNT(*) AS total_students FROM students_list";
                            $count_result = $conn->query($count_sql);
                            $total_students = 0;

                            if ($count_result && $count_result->num_rows > 0) {
                                $count_row = $count_result->fetch_assoc();
                                $total_students = $count_row['total_students'];
                            }
                        ?>
                        <div class="numbers"><?php echo $total_students; ?></div>
                        <div class="cardName">Total Students</div>
                    </div>
                    <div class="iconBx">
                        <img src="assets/imgs/studentdbrd.png" alt="">
                    </div>
                </div>

                <div class="card">
                    <div>
                        <?php
                            $count_sql = "SELECT COUNT(*) AS total_courses FROM courses";
                            $count_result = $conn->query($count_sql);
                            $total_courses = 0;

                            if ($count_result && $count_result->num_rows > 0) {
                                $count_row = $count_result->fetch_assoc();
                                $total_courses = $count_row['total_courses'];
                            }
                        ?>
                        <div class="numbers"><?php echo $total_courses; ?></div>
                        <div class="cardName">Total Courses</div>
                    </div>
                    <div class="iconBx">
                        <img src="assets/imgs/coursedbrd.png" alt="">
                    </div>
                </div>

                <div class="card">
                    <div>
                        <?php
                            $count_sql = "SELECT COUNT(*) AS total_year_sec FROM courses";
                            $count_result = $conn->query($count_sql);
                            $total_subjects = 0;

                            if ($count_result && $count_result->num_rows > 0) {
                                $count_row = $count_result->fetch_assoc();
                                $total_subjects = $count_row['total_year_sec'];
                            }
                        ?>
                        <div class="numbers"><?php echo $total_subjects; ?></div>
                        <div class="cardName">Total Sections</div>
                    </div>
                    <div class="iconBx">
                        <img src="assets/imgs/sectiondbrd.png" alt="">
                    </div>
                </div>

                <div class="card4">
                    <div class="date-container">
                        <?php
                            date_default_timezone_set('Asia/Manila');
                            $date = new DateTime();
                            echo $date->format('F j, Y');
                        ?>
                        <div class="cardName">Date Today</div>
                    </div>
                </div>
            </div>

            <!-- ========================= Display (List and Create ) ========================= -->
        <div class="details">
        <div class="dshbrd">
            <h2> Schedule </h2>
            <div class="table-container">
                <table class="table" id="scheduleTable">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Course</th>
                            <th>Year and Section</th>
                            <th>Subject</th>
                            <th>Room</th>
                            <th>Action</th>
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
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $schedule_sql = "SELECT * FROM schedule";
                        $schedule_result = $conn->query($schedule_sql);

                        if ($schedule_result && $schedule_result->num_rows > 0) {
                            while ($row = $schedule_result->fetch_assoc()) {
                                echo '<tr data-id="' . $row['id'] . '">';
                                echo '<td><input type="text" placeholder="" value="' . htmlspecialchars($row['day']) . '"></td>';
                                echo '<td><input type="text" placeholder="" value="' . htmlspecialchars($row['time']) . '" oninput="validateTime(this)"></td>';
                                echo '<td><input type="text" placeholder="" value="' . htmlspecialchars($row['course']) . '"></td>';
                                echo '<td><input type="text" placeholder="" value="' . htmlspecialchars($row['year_section']) . '"></td>';
                                echo '<td><input type="text" placeholder="" value="' . htmlspecialchars($row['subject']) . '"></td>';
                                echo '<td><input type="text" placeholder="" value="' . htmlspecialchars($row['room']) . '"></td>';
                                echo '<td>
                                        <button class="save-row" onclick="saveRow(this)">Save</button>
                                        <button class="delete-row" onclick="deleteRow(this)">Delete</button>
                                      </td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr>';
                            echo '<td><input type="text" placeholder=""></td>';
                            echo '<td><input type="text" placeholder="" oninput="validateTime(this)"></td>';
                            echo '<td><input type="text" placeholder=""></td>';
                            echo '<td><input type="text" placeholder=""></td>';
                            echo '<td><input type="text" placeholder=""></td>';
                            echo '<td><input type="text" placeholder=""></td>';
                            echo '<td>
                                    <button class="save-row" onclick="saveRow(this)">Save</button>
                                    <button class="delete-row" onclick="deleteRow(this)">Delete</button>
                                  </td>';
                            echo '</tr>';
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
                <div class="table-buttons">
                    <button class="add-row" onclick="addRow()">Add Row</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================= Scripts =========================  -->
    <script src="assets/js/main.js"></script>
    <script>
    function saveRow(button) {
        const row = button.parentNode.parentNode;
        const id = row.getAttribute('data-id') || '';
        const day = row.cells[0].querySelector('input').value;
        const time = row.cells[1].querySelector('input').value;
        const course = row.cells[2].querySelector('input').value;
        const year_section = row.cells[3].querySelector('input').value;
        const subject = row.cells[4].querySelector('input').value;
        const room = row.cells[5].querySelector('input').value;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_schedule.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                if (!id) {
                    row.setAttribute('data-id', xhr.responseText);
                }
                alert('Row saved successfully.');
            } else {
                alert('Error saving row.');
            }
        };
        xhr.send(`id=${id}&day=${day}&time=${time}&course=${course}&year_section=${year_section}&subject=${subject}&room=${room}`);
    }

    function deleteRow(button) {
        if (confirm("Are you sure you want to delete this row?")) {
            const row = button.parentNode.parentNode;
            const id = row.getAttribute('data-id');

            if (id) {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_schedule.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        row.parentNode.removeChild(row);
                        alert('Row deleted successfully.');
                    } else {
                        alert('Error deleting row.');
                    }
                };
                xhr.send(`id=${id}`);
            } else {
                row.parentNode.removeChild(row);
            }
        }
    }

    function addRow() {
        const table = document.getElementById('scheduleTable').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.innerHTML = `
            <td><input type="text" placeholder=""></td>
            <td><input type="text" placeholder="" oninput="validateTime(this)"></td>
            <td><input type="text" placeholder=""></td>
            <td><input type="text" placeholder=""></td>
            <td><input type="text" placeholder=""></td>
            <td><input type="text" placeholder=""></td>
            <td><button class="save-row" onclick="saveRow(this)">Save</button>
                <button class="delete-row" onclick="deleteRow(this)">Delete</button></td>
        `;
    }

    function validateTime(input) {
        const validTimeRegex = /^[0-9:-]*$/;
        if (!validTimeRegex.test(input.value)) {
            input.value = input.value.slice(0, -1);
        }
    }
</script>

</body>

</html>