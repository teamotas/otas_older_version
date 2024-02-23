<?php
error_reporting(0);
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Database connection
$hostserver = 'localhost';
$user = 'root';
$user_password = '';
$database = 'otas';

try {
    $conn = mysqli_connect($hostserver, $user, $user_password, $database);
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>