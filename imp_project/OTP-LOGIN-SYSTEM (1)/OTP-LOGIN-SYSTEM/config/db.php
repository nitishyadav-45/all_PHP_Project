<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "otp_login_system";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');

?>