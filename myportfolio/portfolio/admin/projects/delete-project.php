<?php

require_once('../../config/auth.php');
require_once('../../config/db.php');

$id = intval($_GET['id']);

mysqli_query(
$conn,
"DELETE FROM projects WHERE id='$id'"
);

header("Location: manage-projects.php");

?>