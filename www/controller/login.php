<?php

require_once '../model/login.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['email'];
    $password = $_POST['password'];
    $loginModel = (new LoginModel());
    if ($loginModel->authenticate($username, $password)) {
        session_start();
        $_SESSION['username'] = $username;
        header("Location: ../visual/dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
         header("Location: ../visual/login.php");
        echo "error";
    }
}