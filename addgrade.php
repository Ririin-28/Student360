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
        $gstudent_id = $_POST["gstudent_id"];
        $semesters = [
            'first_year_first_semester' => [
                'sub_code' => $_POST["ffsem_header1"],
                'sub_description' => $_POST["ffsem_header2"],
                'grade' => $_POST["ffsem_header3"],
                'unit' => $_POST["ffsem_header4"],
                'semester' => 1,
                'year' => 1
            ],
            'first_year_second_semester' => [
                'sub_code' => $_POST["fssem_header1"],
                'sub_description' => $_POST["fssem_header2"],
                'grade' => $_POST["fssem_header3"],
                'unit' => $_POST["fssem_header4"],
                'semester' => 2,
                'year' => 1
            ],
            'second_year_first_semester' => [
                'sub_code' => $_POST["sfsem_header1"],
                'sub_description' => $_POST["sfsem_header2"],
                'grade' => $_POST["sfsem_header3"],
                'unit' => $_POST["sfsem_header4"],
                'semester' => 1,
                'year' => 2
            ],
            'second_year_second_semester' => [
                'sub_code' => $_POST["sssem_header1"],
                'sub_description' => $_POST["sssem_header2"],
                'grade' => $_POST["sssem_header3"],
                'unit' => $_POST["sssem_header4"],
                'semester' => 2,
                'year' => 2
            ],
            'third_year_first_semester' => [
                'sub_code' => $_POST["tfsem_header1"],
                'sub_description' => $_POST["tfsem_header2"],
                'grade' => $_POST["tfsem_header3"],
                'unit' => $_POST["tfsem_header4"],
                'semester' => 1,
                'year' => 3
            ],
            'third_year_second_semester' => [
                'sub_code' => $_POST["tssem_header1"],
                'sub_description' => $_POST["tssem_header2"],
                'grade' => $_POST["tssem_header3"],
                'unit' => $_POST["tssem_header4"],
                'semester' => 2,
                'year' => 3
            ],
            'fourth_year_first_semester' => [
                'sub_code' => $_POST["fofsem_header1"],
                'sub_description' => $_POST["fofsem_header2"],
                'grade' => $_POST["fofsem_header3"],
                'unit' => $_POST["fofsem_header4"],
                'semester' => 1,
                'year' => 4
            ],
            'fourth_year_second_semester' => [
                'sub_code' => $_POST["fossem_header1"],
                'sub_description' => $_POST["fossem_header2"],
                'grade' => $_POST["fossem_header3"],
                'unit' => $_POST["fossem_header4"],
                'semester' => 2,
                'year' => 4
            ]
        ];

        $semester_remarks = [
            'fyfstotal_gwa' => $_POST["fyfstotal_gwa"],
            'fyfstotal_units' => $_POST["fyfstotal_units"],
            'fyfs_remarks' => $_POST["fyfs_remarks"],
            'fysstotal_gwa' => $_POST["fysstotal_gwa"],
            'fysstotal_units' => $_POST["fysstotal_units"],
            'fyss_remarks' => $_POST["fyss_remarks"],
            'syfstotal_gwa' => $_POST["syfstotal_gwa"],
            'syfstotal_units' => $_POST["syfstotal_units"],
            'syfs_remarks' => $_POST["syfs_remarks"],
            'sysstotal_gwa' => $_POST["sysstotal_gwa"],
            'sysstotal_units' => $_POST["sysstotal_units"],
            'syss_remarks' => $_POST["syss_remarks"],
            'tyfstotal_gwa' => $_POST["tyfstotal_gwa"],
            'tyfstotal_units' => $_POST["tyfstotal_units"],
            'tyfs_remarks' => $_POST["tyfs_remarks"],
            'tysstotal_gwa' => $_POST["tysstotal_gwa"],
            'tysstotal_units' => $_POST["tysstotal_units"],
            'tyss_remarks' => $_POST["tyss_remarks"],
            'qyfstotal_gwa' => $_POST["qyfstotal_gwa"],
            'qyfstotal_units' => $_POST["qyfstotal_units"],
            'qyfs_remarks' => $_POST["qyfs_remarks"],
            'qysstotal_gwa' => $_POST["qysstotal_gwa"],
            'qysstotal_units' => $_POST["qysstotal_units"],
            'qyss_remarks' => $_POST["qyss_remarks"]
        ];

        if (empty($gstudent_id)) {
            echo "Student ID is required";
            exit;
        }

        foreach ($semesters as $semester) {
            if (empty($semester['sub_code']) || empty($semester['sub_description']) || empty($semester['grade']) || empty($semester['unit'])) {
                echo "All fields are required for each semester";
                exit;
            }
        }

        $stmt = $conn->prepare("SELECT student_id FROM students_list WHERE student_id = ?");
        $stmt->bind_param("s", $gstudent_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo "No Student ID Found";
            $stmt->close();
            exit;
        }

        $stmt->close();

        // Insert into student_grades table
        $sql = "INSERT INTO student_grades (gstudent_id, sub_code, sub_description, grade, unit, semester, year) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        foreach ($semesters as $semester) {
            $numRows = count($semester['sub_code']);
            for ($i = 0; $i < $numRows; $i++) {
                if (!empty($semester['sub_code'][$i]) && !empty($semester['sub_description'][$i]) && !empty($semester['grade'][$i]) && !empty($semester['unit'][$i])) {
                    $stmt->bind_param("ssssssi", $gstudent_id, $semester['sub_code'][$i], $semester['sub_description'][$i], $semester['grade'][$i], $semester['unit'][$i], $semester['semester'], $semester['year']);
                    $result = $stmt->execute();
                    if (!$result) {
                        echo "Invalid query: " . $stmt->error;
                        $stmt->close();
                        exit;
                    }
                }
            }
        }

        // Insert into students_finalgrades table
        $semesters_remarks = [
            'First Year First Semester' => ['gwa' => $semester_remarks['fyfstotal_gwa'], 'units' => $semester_remarks['fyfstotal_units'], 'remarks' => $semester_remarks['fyfs_remarks']],
            'First Year Second Semester' => ['gwa' => $semester_remarks['fysstotal_gwa'], 'units' => $semester_remarks['fysstotal_units'], 'remarks' => $semester_remarks['fyss_remarks']],
            'Second Year First Semester' => ['gwa' => $semester_remarks['syfstotal_gwa'], 'units' => $semester_remarks['syfstotal_units'], 'remarks' => $semester_remarks['syfs_remarks']],
            'Second Year Second Semester' => ['gwa' => $semester_remarks['sysstotal_gwa'], 'units' => $semester_remarks['sysstotal_units'], 'remarks' => $semester_remarks['syss_remarks']],
            'Third Year First Semester' => ['gwa' => $semester_remarks['tyfstotal_gwa'], 'units' => $semester_remarks['tyfstotal_units'], 'remarks' => $semester_remarks['tyfs_remarks']],
            'Third Year Second Semester' => ['gwa' => $semester_remarks['tysstotal_gwa'], 'units' => $semester_remarks['tysstotal_units'], 'remarks' => $semester_remarks['tyss_remarks']],
            'Fourth Year First Semester' => ['gwa' => $semester_remarks['qyfstotal_gwa'], 'units' => $semester_remarks['qyfstotal_units'], 'remarks' => $semester_remarks['qyfs_remarks']],
            'Fourth Year Second Semester' => ['gwa' => $semester_remarks['qysstotal_gwa'], 'units' => $semester_remarks['qysstotal_units'], 'remarks' => $semester_remarks['qyss_remarks']],
        ];

        $sql_final = "INSERT INTO students_finalgrades (gstudent_id, semester, total_gwa, total_units, remarks) 
                      VALUES (?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE 
                      total_gwa = VALUES(total_gwa), 
                      total_units = VALUES(total_units), 
                      remarks = VALUES(remarks)";
        $stmt_final = $conn->prepare($sql_final);

        foreach ($semesters_remarks as $semester_name => $semester_data) {
            $stmt_final->bind_param("ssdis", $gstudent_id, $semester_name, $semester_data['gwa'], $semester_data['units'], $semester_data['remarks']);
            $result = $stmt_final->execute();
            if (!$result) {
                echo "Invalid query: " . $stmt_final->error;
                $stmt_final->close();
                exit;
            }
        }

        echo "Grades added successfully!";
        $stmt->close();
        $stmt_final->close();
        $conn->close();
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Grade</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">

    <!-- ========================= Styles ========================= -->
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

        .navigation ul li:nth-child(5) {
            margin-bottom: 1px;
        }

        .navigation ul li:nth-child(6) {
            margin-bottom: 1px;
        }

        .navigation ul li:nth-child(7) {
            margin-bottom: 120px;
        }

        .tables-container {
            display: flex;
            gap: 20px;
            justify-content: space-between;
            width: 100%;
        }

        .grades-table {
            width: 45%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .grades-table th, .grades-table td {
            border: 2px solid #394626;
            padding: 8px;
            text-align: left;
        }

        .grades-table th {
            text-align: center;
            background-color: #A3DE73;
            font-weight: bold;
        }

        .grades-table tbody tr:hover {
            background-color: #ddd;
        }

        .grades-table input[type="text"] {
            width: 100%;
            padding: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .grades-table .wider-column {
            width: 30%;
        }

        .grades-table .narrow-column {
            width: 10%;
        }
        .student_id {
            margin: 20px 0;
            margin: 50px 0px 0px;
        }
        .student_id input {
            width: 22%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid var(--green);
            border-radius: 40px;
            font-weight: 600;
            color: var(--green);
            padding: 0px 0px 0px 15px;
        }

        .student_id input::placeholder {
            color: #394626;
        }
        .student_id input:focus{
            background-color: var(--white);
            color: #6B8149;
            border: 4px solid #394626;
        }
        .remarks-container {
            margin: 20px 0;
            display: flex;
            flex-direction: row;
            gap: 115px;
            margin: -10px 0px 50px;
        }

        .remarks-container select {
            width: 32%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid var(--green);
            border-radius: 40px;
            font-weight: 600;
            color: var(--green);
            padding: 0px 0px 0px 15px;
        }

        .remarks-container select::placeholder {
            color: #394626;
        }
        .remarks-container select:focus{
            background-color: var(--white);
            color: #6B8149;
            border: 4px solid #394626;
        }
        .remarks-container select:after {
            content: '\25BC';
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #6B8149;
        }

        .remarks-container select:hover:after {
            color: #526436;
        }

        .remarks-container select option {
            background: #6B8149; 
            color: #fff; 
            font-weight: bold;
            padding: 10px 15px; 
        }

        .remarks-container select option:hover {
            background: #526436; 
        }

        -------------------------------------------------------
        .ffsemremarks{
            margin: 20px 0;
            display: flex;
            flex-direction: row;
            gap: 115px;
            margin: -10px 0px 50px;
        }
        .ffsemremarks input{
            width: 33%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid var(--green);
            border-radius: 40px;
            font-weight: 600;
            color: var(--green);
            padding: 0px 0px 0px 15px;
        }
        .ffsemremarks input::placeholder {
            color: var(--green);
        }
        .ffsemremarks input:focus{
            background-color: var(--white);
            color: var(--green);
            border: 4px solid #394626;
        }

        -------------------------------------------------
        .fssemremarks{
            margin: 20px 0;
            display: flex;
            flex-direction: row;
            gap: 115px;
            margin: -10px 0px 50px;
        }
        .fssemremarks input{
            width: 33%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid var(--green);
            border-radius: 40px;
            font-weight: 600;
            color: var(--green);
            padding: 0px 0px 0px 15px;
        }
        .fssemremarks input::placeholder {
            color: var(--green);
        }
        .fssemremarks input:focus{
            background-color: var(--white);
            color: var(--green);
            border: 4px solid #394626;
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
                <div class="toggle">
                    <img src="assets/imgs/dgmenubar.png" alt="">
                </div>
                <div class="search"></div>
                <div class="user"></div>
            </div>

            <div class="header">Add Grades</div>

            <div class="addcoursedetails">
                <div class="addcoursecontainer">
                    <div class="cardHeader">
                        <h2>New Grades for Student</h2>
                    </div>

                    <form id="addGradesForm">
                        <div class="student_id">
                            <input type="text" id="gstudent_id" name="gstudent_id" placeholder="Input Student Id" required>
                        </div>

                        <div class="tables-container">
                            <table class="grades-table">
                            <thead>
    <tr>
        <th colspan="4">First Year - First Semester</th>
    </tr>
    <tr>
        <th class="narrow-column">Sub. Code</th>
        <th class="wider-column">Sub. Description</th>
        <th class="narrow-column">Grade</th>
        <th class="narrow-column">Unit</th>
    </tr>
</thead>
<tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="ffsem_header1[]" placeholder=""></td>
            <td><input type="text" name="ffsem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="ffsem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="ffsem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="ffsem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
</tbody>
                            </table>
                            <table class="grades-table">
                            <thead>
    <tr>
        <th colspan="4">First Year - Second Semester</th>
    </tr>
    <tr>
        <th class="narrow-column">Sub. Code</th>
        <th class="wider-column">Sub. Description</th>
        <th class="narrow-column">Grade</th>
        <th class="narrow-column">Unit</th>
    </tr>
</thead>
<tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="fssem_header1[]" placeholder=""></td>
            <td><input type="text" name="fssem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="fssem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="fssem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="fssem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
</tbody>
                            </table>
                        </div>

                        <div class="remarks-container">
                        <div class="ffsemremarks">
                            <input type="text" name="fyfstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="fyfstotal_units" placeholder="Total Units">
                            <select type="text" name="fyfs_remarks" placeholder="Remarks">
                                <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="fssemremarks">
                            <input type="text" name="fysstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="fysstotal_units" placeholder="Total Units">
                            <select type="text" name="fyss_remarks" placeholder="Remarks">
                            <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        </div>

                        <div class="tables-container">
                            <table class="grades-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Second Year - First Semester</th>
                                    </tr>
                                    <tr>
                                        <th class="narrow-column">Sub. Code</th>
                                        <th class="wider-column">Sub. Description</th>
                                        <th class="narrow-column">Grade</th>
                                        <th class="narrow-column">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="sfsem_header1[]" placeholder=""></td>
            <td><input type="text" name="sfsem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="sfsem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="sfsem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="sfsem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
                                </tbody>
                            </table>
                            <table class="grades-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Second Year - Second Semester</th>
                                    </tr>
                                    <tr>
                                        <th class="narrow-column">Sub. Code</th>
                                        <th class="wider-column">Sub. Description</th>
                                        <th class="narrow-column">Grade</th>
                                        <th class="narrow-column">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="sssem_header1[]" placeholder=""></td>
            <td><input type="text" name="sssem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="sssem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="sssem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="sssem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="remarks-container">
                        <div class="ffsemremarks">
                            <input type="text" name="syfstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="syfstotal_units" placeholder="Total Units">
                            <select type="text" name="syfs_remarks" placeholder="Remarks">
                                <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="fssemremarks">
                            <input type="text" name="sysstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="sysstotal_units" placeholder="Total Units">
                            <select type="text" name="syss_remarks" placeholder="Remarks">
                            <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        </div>

                        <div class="tables-container">
                            <table class="grades-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Third Year - First Semester</th>
                                    </tr>
                                    <tr>
                                        <th class="narrow-column">Sub. Code</th>
                                        <th class="wider-column">Sub. Description</th>
                                        <th class="narrow-column">Grade</th>
                                        <th class="narrow-column">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="tfsem_header1[]" placeholder=""></td>
            <td><input type="text" name="tfsem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="tfsem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="tfsem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="tfsem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
                                </tbody>
                            </table>
                            <table class="grades-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Third Year - Second Semester</th>
                                    </tr>
                                    <tr>
                                        <th class="narrow-column">Sub. Code</th>
                                        <th class="wider-column">Sub. Description</th>
                                        <th class="narrow-column">Grade</th>
                                        <th class="narrow-column">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="tssem_header1[]" placeholder=""></td>
            <td><input type="text" name="tssem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="tssem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="tssem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="tssem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="remarks-container">
                        <div class="ffsemremarks">
                            <input type="text" name="tyfstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="tyfstotal_units" placeholder="Total Units">
                            <select type="text" name="tyfs_remarks" placeholder="Remarks">
                                <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="fssemremarks">
                            <input type="text" name="tysstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="tysstotal_units" placeholder="Total Units">
                            <select type="text" name="tyss_remarks" placeholder="Remarks">
                            <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        </div>

                        <div class="tables-container">
                            <table class="grades-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Fourth Year - First Semester</th>
                                    </tr>
                                    <tr>
                                        <th class="narrow-column">Sub. Code</th>
                                        <th class="wider-column">Sub. Description</th>
                                        <th class="narrow-column">Grade</th>
                                        <th class="narrow-column">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="fofsem_header1[]" placeholder=""></td>
            <td><input type="text" name="fofsem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="fofsem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="fofsem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="fofsem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
                                </tbody>
                            </table>
                            <table class="grades-table">
                                <thead>
                                    <tr>
                                        <th colspan="4">Fourth Year - Second Semester</th>
                                    </tr>
                                    <tr>
                                        <th class="narrow-column">Sub. Code</th>
                                        <th class="wider-column">Sub. Description</th>
                                        <th class="narrow-column">Grade</th>
                                        <th class="narrow-column">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php for ($i = 0; $i < 12; $i++): ?>
        <tr>
            <td><input type="text" name="fossem_header1[]" placeholder=""></td>
            <td><input type="text" name="fossem_header2[]" placeholder=""></td>
            <?php if ($i < 11): ?>
                <td>
                    <select type="text" name="fossem_header3[]" placeholder="">
                        <option value="" disabled selected>Select Grade</option>
                        <option value="1.0">1.0</option>
                        <option value="1.25">1.25</option>
                        <option value="1.5">1.5</option>
                        <option value="1.75">1.75</option>
                        <option value="1.75">2.0</option>
                        <option value="1.75">2.25</option>
                        <option value="1.75">2.5</option>
                        <option value="1.75">2.75</option>
                        <option value="1.75">3.0</option>
                        <option value="1.75">4.0</option>
                        <option value="1.75">5.0</option>
                    </select>
                </td>
            <?php else: ?>
                <td><input type="text" name="fossem_header3[]" placeholder=""></td>
            <?php endif; ?>
            <td><input type="text" name="fossem_header4[]" placeholder=""></td>
        </tr>
    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="remarks-container">
                        <div class="ffsemremarks">
                            <input type="text" name="qyfstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="qyfstotal_units" placeholder="Total Units">
                            <select type="text" name="qyfs_remarks" placeholder="Remarks">
                                <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        <div class="fssemremarks">
                            <input type="text" name="qysstotal_gwa" placeholder="Total GWA">
                            <input type="text" name="qysstotal_units" placeholder="Total Units">
                            <select type="text" name="qyss_remarks" placeholder="Remarks">
                            <option value="" disabled selected>Select Remarks</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="none">None</option>
                            </select>
                        </div>
                        </div>

                        <div class="coursebox">
                            <button type="submit" class="coursesubmitbtn">Add Grades</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- ========================= Scripts =========================  -->
    <script src="assets/js/main.js"></script>

    <script>
    $(document).ready(function() {
        function calculateAndDisplay() {
            $('table').each(function() {
                var totalUnits = 0;
                var weightedSum = 0;

                $(this).find('tbody tr').each(function(index, row) {
                    if (index < 11) {
                        var grade = parseFloat($(row).find('select[name$="header3[]"]').val()) || 0;
                        var unit = parseFloat($(row).find('input[name$="header4[]"]').val()) || 0;

                        totalUnits += unit;
                        weightedSum += grade * unit;
                    }
                });

                var weightedAverage = totalUnits ? (weightedSum / totalUnits).toFixed(2) : 0;

                var lastRow = $(this).find('tbody tr').last();
                lastRow.find('input[name$="header3[]"]').val(weightedAverage);
                lastRow.find('input[name$="header4[]"]').val(totalUnits);
            });
        }

        $('select[name$="header3[]"], input[name$="header4[]"]').on('input', function() {
            calculateAndDisplay();
        });

        calculateAndDisplay();

        $('#addGradesForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serializeArray();
            var valid = true;
            var messages = [];

            var studentID = $('#gstudent_id').val();
            var studentIDPattern = /^\d{8}-[NS]$/;
            if (!studentIDPattern.test(studentID)) {
                valid = false;
                messages.push("Student ID must be in the format 20220636-N or 20220636-S");
            }

            if (!valid) {
                alert(messages.join("\n"));
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '',
                data: $.param(formData),
                success: function(response) {
                    alert(response);
                    $('#addGradesForm')[0].reset();
                    calculateAndDisplay();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('Error occurred, please try again.');
                }
            });
        });

        $('#addFinalGradesForm').submit(function(e) {
            e.preventDefault();

            var formData = $(this).serializeArray();
            var valid = true;
            var messages = [];

            if (!valid) {
                alert(messages.join("\n"));
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '',
                data: $.param(formData),
                success: function(response) {
                    alert(response);
                    $('#addFinalGradesForm')[0].reset();
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