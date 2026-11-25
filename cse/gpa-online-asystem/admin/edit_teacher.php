<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$id = $_GET['id'];
$teacher = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM teachers WHERE id='$id'"));

if(isset($_POST['update'])){
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];

    mysqli_query($conn,"UPDATE teachers SET 
        full_name='$name',
        email='$email',
        mobile='$mobile',
        branch='$branch',
        year='$year',
        semester='$semester'
        WHERE id='$id'");

    echo "<script>alert('Teacher Updated'); window.location='manage_teachers.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Teacher</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <a href="manage_teachers.php" class="btn btn-secondary mb-3">⬅ Back</a>

    <div class="card p-4 shadow">
        <h4>Edit Teacher</h4>
        <form method="POST">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo $teacher['full_name']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $teacher['email']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Branch</label>
                <input type="text" name="branch" value="<?php echo $teacher['branch']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mobile Number</label>
                <input type="text" name="mobile" value="<?php echo $teacher['mobile']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Year</label>
                <input type="text" name="year" value="<?php echo $teacher['year']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Semester</label>
                <input type="text" name="semester" value="<?php echo $teacher['semester']; ?>" class="form-control" required>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Teacher</button>
        </form>
    </div>
</div>

</body>
</html>
