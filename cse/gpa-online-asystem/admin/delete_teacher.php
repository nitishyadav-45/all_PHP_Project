<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$id = $_GET['id'];
mysqli_query($conn,"DELETE FROM teachers WHERE id='$id'");
header("Location: manage_teachers.php");
exit();
?>
