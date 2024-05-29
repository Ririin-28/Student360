<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Selection</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <style>
        h1 {
            font-family: Verdana;
            color: #526436;
            text-align: center;
            margin-top: 80px;
            cursor: default;
        }
        body {
            margin: 140px;
            padding: 0;
            background-image: url('assets/imgs/Student360 BG.png');
            background-size: cover;
        }
        .UserEduc, .UserStu, .UserAdmin {
            background-color: #9FBB73;
            border-radius: 50px;
            padding: 10px 15px;
            border: 8px solid #526436;
        }
        .UserEduc {
            position: absolute;
            width: 296px;
            height: 370px;
            top: 200px;
            left: 361px;
        }
        .UserEduc p {
            font-family: Verdana;
            font-weight: bold;
            font-size: 30px;
            color: #526436;
            position: absolute;
            top: 280px;
            left: 85px;
            cursor: pointer;
        }
        .UserEduc .educimg {
            width: 200px;
            position: relative;
            top: 70px;
            left: 53px;
        }
        .UserEduc:hover {
            background-color: #D9EDBF;
            cursor: pointer;
        }
        .UserStu {
            position: absolute;
            width: 296px;
            height: 370px;
            top: 200px;
            left: 820px;
        }
        .UserStu p {
            font-family: Verdana;
            font-weight: bold;
            font-size: 30px;
            color: #526436;
            position: absolute;
            top: 280px;
            left: 100px;
            cursor: pointer;
        }
        .UserStu .stuimg {
            width: 200px;
            position: relative;
            top: 70px;
            left: 53px;
        }
        .UserStu:hover {
            background-color: #D9EDBF;
            cursor: pointer;
        }
        .UserAdmin {
            position: absolute;
            width: 225px;
            height: 25px;
            background-color: #9FBB73;
            border-radius: 25px;
            padding: 10px 15px;
            border: 4px solid #526436;
            top: 660px;
            left: 1200px;
        }
        .UserAdmin p {
            font-family: Verdana;
            font-weight: bold;
            color: #526436;
            position: absolute;
            top: -5px;
            left: 50px;
            cursor: pointer;
        }
        .UserAdmin .adminimg {
            width: 25px;
            position: absolute;
        }
        .UserAdmin:hover {
            background-color: #D9EDBF;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Select User Profile</h1>
    <!--Educator User-->
    <a href="LoginEduc.php">
        <div class="UserEduc">
            <img src="teacher.png" class="educimg">
            <p>Educator</p>
        </div>
    </a>

    <!--Student User-->
    <a href="LoginStu.php">
        <div class="UserStu">
            <img src="student.png" class="stuimg">
            <p>Student</p>
        </div>
    </a>
</body>
</html>
