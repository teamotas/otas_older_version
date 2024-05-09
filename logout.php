<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['admin_id'])) {
    unset($_SESSION['admin_id']);
    session_destroy();
    header("location: login-admin.php");
}
else if (isset($_SESSION['user_id'])) {
    unset($_SESSION['user_id']);
    session_destroy();
    header("location: login-user.php");
}
?>

