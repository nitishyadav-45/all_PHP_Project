<?php
session_start();
include("../config/database.php");

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM notices WHERE id='$id'");
$notice = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$title = mysqli_real_escape_string($conn,$_POST['title']);
$description = mysqli_real_escape_string($conn,$_POST['description']);
$date = $_POST['date'];

mysqli_query($conn,"UPDATE notices 
SET title='$title',description='$description',notice_date='$date'
WHERE id='$id'");

header("Location: manage_notices.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Notice</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-light">

<div class="container mt-5">

<div class="card p-4 bg-secondary">

<h3>Edit Notice</h3>

<form method="POST">

<input type="text" name="title"
value="<?php echo $notice['title']; ?>"
class="form-control mb-3">

<textarea name="description"
class="form-control mb-3"><?php echo $notice['description']; ?></textarea>

<input type="date" name="date"
value="<?php echo $notice['notice_date']; ?>"
class="form-control mb-3">

<button name="update" class="btn btn-success">
Update Notice
</button>

</form>

</div>

</div>

</body>
</html>