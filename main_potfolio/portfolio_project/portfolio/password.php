<?php
$pass = "Nitish@123"; // New password
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo $hash;
?>
