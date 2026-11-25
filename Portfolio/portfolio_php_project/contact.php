<?php
require_once 'config/db.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
$name=$_POST['name']??'';
$email=$_POST['email']??'';
$message=$_POST['message']??'';
$stmt=$conn->prepare("INSERT INTO contacts(name,email,message) VALUES (?,?,?)");
$stmt->bind_param("sss",$name,$email,$message);
$stmt->execute();
echo "Message saved";
}
?>