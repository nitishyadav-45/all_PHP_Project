<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$teacher_id = $_SESSION['teacher_id'];

if(isset($_POST['save'])){

    $teacher_unique_id = $_POST['teacher_unique_id'];
    $branch   = $_POST['branch'];
    $semester = $_POST['semester'];
    $year     = $_POST['year'];

    $update = "UPDATE teachers 
               SET teacher_id='$teacher_unique_id', branch='$branch', semester='$semester', year='$year' 
               WHERE id='$teacher_id'";

    if(mysqli_query($conn, $update)){
        $_SESSION['branch'] = $branch;
        $_SESSION['semester'] = $semester;
        $_SESSION['year'] = $year;

        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Error saving data');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Complete Teacher Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:linear-gradient(120deg,#6610f2,#0d6efd);height:100vh;display:flex;align-items:center;justify-content:center;">

<div class="col-md-5">
    <div class="card p-4 shadow">
        <h4 class="text-center mb-3"> Complete Your Profile</h4>

        <form method="POST">
            <div class="mb-3">
                <label>Teacher ID</label>
                <input type="text" name="teacher_unique_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Branch</label>
                <select name="branch" class="form-control" required>
                    <option value="">Select Branch</option>
                    <option>CSE</option>
                    <option>E.E</option>
                    <option>M.E</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Semester</label>
                <select name="semester" class="form-control" required>
                    <option value="">Select Semester</option>
                    <option>1</option><option>2</option><option>3</option>
                    <option>4</option><option>5</option><option>6</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Year</label>
                <select name="year" class="form-control" required>
                    <option value="">Select Year</option>
                    <option>First Year</option>
                    <option>Second Year</option>
                    <option>Third Year</option>
                </select>
            </div>

            <button type="submit" name="save" class="btn btn-primary w-100">Save & Continue</button>
        </form>
    </div>
</div>

</body>
</html>
