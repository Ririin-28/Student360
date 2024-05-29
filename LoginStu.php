<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login as a Student</title>
    <link rel="icon" href="assets/imgs/S360white.png" type="image/png">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #D9EDBF;
            margin-top: 170px;
            background-image: url('assets/imgs/Student360 BG.png');
            background-size: cover;
        }
        .container {
            width: 300px;
            height: 380px;
            background-color: #9FBB73;
            border-radius: 25px;
            padding: 10px 15px;
            border: 4px dashed #526436;
            position: relative;
        }
        .container:hover {
            border: 4px solid #526436;
        }
        .container h1 {
            font-family: Verdana;
            font-size: 35px;
            text-align: center;
            color: #526436;
        }
        .usernamebox, .passwordbox {
            width: 100%;
            height: 40px;
            margin: 20px 0;
            position: relative;
        }
        #show-passwd {
            position: absolute;
            background-color: transparent;
            border-radius: 50px;
            border: none;
            top: 25%;
            left: 90%;
            transform: translate(-50%);
            cursor: pointer;
            align-content: center;
        }
        .usernamebox input, .passwordbox input {
            width: 92%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            border: 4px solid #526436;
            border-radius: 40px;
            font-weight: 600;
            color: #D9EDBF;
            padding: 0 0 0 15px;
            letter-spacing: 0.125em;
        }
        .usernamebox input::placeholder, .passwordbox input::placeholder {
            color: #D9EDBF;
        }
        .usernamebox input:hover, .passwordbox input:hover {
            background-color: #D9EDBF;
            color: #526436;
            border: 4px solid #526436;
        }
        .rememberpassword {
            font-family: Helvetica;
            font-size: 12px;
            font-weight: 600;
            color: #D9EDBF;
            padding: 0 0 15px 15px;
        }
        .submitbtn {
            width: 60%;
            height: 45px;
            background: #526436;
            color: #D9EDBF;
            border: 3px solid #D9EDBF;
            border-radius: 45px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin: 0 20% 20px;
        }
        .submitbtn:hover {
            background-color: #D9EDBF;
            color: #526436;
            border: 3px solid #D9EDBF;
        }
        .register, .forgotpassword {
            font-family: Helvetica;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
        }
        .register {
            color: green;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #FFBABA;
            border: 3px solid #D8000C;
            border-radius: 10px;
            width: 250px;
            text-align: center;
            padding: 10px;
            animation: fadeIn 0.9s;
            cursor: pointer;
        }
        .modal-content h2 {
            color: #D8000C;
            font-family: Helvetica;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .modal-content button {
            background-color: #D8000C;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .modal-content button:hover {
            background-color: #FFBABA;
            border: 2px solid #D8000C;
            color: #D8000C;
            font-weight: bold
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <!--Container of the Login Panel -->
    <div class="container">
        <form action="indexloginstu.php" method="post">
            <h1>Welcome Student</h1>

            <div class="usernamebox">
                <input type="text" id="lstudent_id" name="lstudent_id" placeholder="Username" required>
            </div>

            <div class="passwordbox">
                <input type="password" placeholder="Password" name="password" id="password" required>
                <button type="button" id="show-passwd">
                    <img src="view.png" alt="Show Password">
                </button>
            </div>

            <div class="rememberpassword">
                <label><input type="checkbox">Remember Password</label>
            </div>
        
            <button type="submit" class="submitbtn">Login</button>           
        </form>
    </div>

    <!--Error Modal-->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <h2>Oops!</h2>
            <p>Your password or username is incorrect.</p>
            <button id="closeModal">OK</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const params = new URLSearchParams(window.location.search);
            if (params.has('error')) {
                document.getElementById('errorModal').style.display = 'flex';
            }

            document.getElementById('closeModal').onclick = function() {
                document.getElementById('errorModal').style.display = 'none';
            }
        });
    </script>

    <script src="assets/js/password.js"></script>
</body>
</html>
