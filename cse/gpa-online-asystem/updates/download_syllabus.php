<?php
include("../config/database.php");

$id=$_GET['id'];

$data=mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM syllabus WHERE id='$id'"));

/* Increase Download Count */
mysqli_query($conn,
"UPDATE syllabus SET download_count=download_count+1 WHERE id='$id'");

/* Download File */
$file="../updates/gallery/".$data['file_name'];

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$data['file_name']);
readfile($file);
exit;
?>