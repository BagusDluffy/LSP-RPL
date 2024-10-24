<?php
session_start();
include ($_SERVER['DOCUMENT_ROOT'] . '/cobalsp/config/db.php');

function checkAuth()
{
    if(!isset($_SESSION['admin'])) {
        header("Location: ../view/login/login.php");
        exit();
    }
}

function login($email, $password)
{
    global $conn;
    $password = md5($password);
    $stmt = $conn->prepare ("SELECT * FROM admin WHERE email = :email AND password = :password");
    $stmt->execute(['email' => $email, 'password' => $password]);
    if ($stmt->rowCount() > 0) {
        $admin = $stmt->fetch();
        $_SESSION['admin'] = $admin['nama'];
        return true;
    }
    return false;
}