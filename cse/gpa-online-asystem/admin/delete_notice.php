

<?php
session_start();
include("../config/database.php");

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    $query = mysqli_query($conn, "DELETE FROM notices WHERE id = '$id'");

    if($query){
        $_SESSION['status'] = "Notice Deleted Successfully!";
        $_SESSION['status_code'] = "warning"; // Warning color (Orange) delete ke liye sahi rehta hai
    } else {
        $_SESSION['status'] = "Failed to Delete Notice!";
        $_SESSION['status_code'] = "danger";
    }
}

header("Location: manage_notices.php"); // Wapas manage page par bhejein
exit();
?>