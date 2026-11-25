<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$student_id = $_GET['id'];
$student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE id='$student_id'"));

if(isset($_POST['update'])){
    $name = $_POST['full_name'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $mobile = $_POST['mobile'];

    mysqli_query($conn,"UPDATE students SET 
        full_name='$name',
        branch='$branch',
        year='$year',
        semester='$semester',
        mobile='$mobile'
        WHERE id='$student_id'");

    echo "<script>alert('Student Updated'); window.location='manage_students.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{background:#eef2f7;}
        .card{border-radius:15px;}
    </style>
</head>
<body>

<div class="container mt-5">
    <a href="manage_students.php" class="btn btn-secondary mb-3">⬅ Back</a>

    <div class="card shadow p-4">
        <h4 class="mb-4 text-center">✏ Edit Student</h4>

        <form method="POST">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo $student['full_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label>Branch</label>
                <select name="branch" class="form-select">
                    <option <?php if($student['branch']=='CSE') echo 'selected'; ?>>CSE</option>
                    <option <?php if($student['branch']=='E.E') echo 'selected'; ?>>E.E</option>
                    <option <?php if($student['branch']=='M.E') echo 'selected'; ?>>M.E</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Year</label>
                <select name="year" class="form-select">
                    <option <?php if($student['year']=='First Year') echo 'selected'; ?>>First Year</option>
                    <option <?php if($student['year']=='Second Year') echo 'selected'; ?>>Second Year</option>
                    <option <?php if($student['year']=='Third Year') echo 'selected'; ?>>Third Year</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Semester</label>
                <select name="semester" class="form-select">
                    <option <?php if($student['semester']=='Sem 1') echo 'selected'; ?>>Sem 1</option>
                    <option <?php if($student['semester']=='Sem 2') echo 'selected'; ?>>Sem 2</option>
                    <option <?php if($student['semester']=='Sem 3') echo 'selected'; ?>>Sem 3</option>
                    <option <?php if($student['semester']=='Sem 4') echo 'selected'; ?>>Sem 4</option>
                    <option <?php if($student['semester']=='Sem 5') echo 'selected'; ?>>Sem 5</option>
                    <option <?php if($student['semester']=='Sem 6') echo 'selected'; ?>>Sem 6</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control" value="<?php echo $student['mobile']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary w-100">Update Student</button>
        </form>
    </div>
</div>

</body>
</html>
