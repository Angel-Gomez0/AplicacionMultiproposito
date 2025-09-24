<?php

 require_once '../model/register.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $id_gender = $_POST['id_genero'];
        $passwordEncripted = password_hash($password, PASSWORD_BCRYPT);
        $registerModel = new RegisterModel();
        if ($registerModel->registerUser($username, $email, $passwordEncripted, $id_gender)) {
            header("Location: ../visual/login.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
            echo "error";
        }
    }