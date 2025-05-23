<?php
session_start();
include '../Model/user.php';
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->login($email, $password)) {
            $_SESSION['user_id'] = $user->getUserId($email);
            header("location: ../View/AdminDashboard.php");
            exit();
        } else {
            header("location: ../View/login.php?error=Invalid email or password");
            exit();
        }
    }
}
