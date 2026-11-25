<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "gpaa_attendance_system";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
