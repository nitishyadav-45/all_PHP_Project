<?php
$pass = "admin123"; // New password
$hash = password_hash($pass, PASSWORD_DEFAULT);
echo $hash;
?>
