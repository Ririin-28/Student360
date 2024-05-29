<?php
session_start();

$admin_username = "Educator";
$admin_password = "123";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        header('Location: LoginEduc.php?error=1');
        exit;
    }
}
?>