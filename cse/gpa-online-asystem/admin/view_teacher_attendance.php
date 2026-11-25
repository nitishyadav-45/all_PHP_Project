<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

// ✅ Check if ID exists
if(!isset($_GET['id']) || empty($_GET['id'])){
    echo "<div style='padding:20px;font-family:sans-serif;'>
            <h3>❌ Teacher ID Missing</h3>
            <a href='manage_teachers.php'>⬅ Back</a>
          </div>";
    exit();
}

$id = intval($_GET['id']); // Secure

$teacher_q = mysqli_query($conn,"SELECT * FROM teachers WHERE id='$id'");
$teacher = mysqli_fetch_assoc($teacher_q);

// ✅ If teacher not found
if(!$teacher){
    echo "<div style='padding:20px;font-family:sans-serif;'>
            <h3>❌ Teacher Not Found</h3>
            <a href='manage_teachers.php'>⬅ Back</a>
          </div>";
    exit();
}

// Attendance records based on teacher's class
$records = mysqli_query($conn,"
    SELECT a.date, s.full_name, a.status 
    FROM attendance a
    JOIN students s ON a.student_id = s.id
    WHERE s.branch='{$teacher['branch']}'
    AND s.year='{$teacher['year']}'
    AND s.semester='{$teacher['semester']}'
    ORDER BY a.date DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teacher Attendance View</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <a href="manage_teachers.php" class="btn btn-secondary mb-3">⬅ Back</a>

    <div class="card p-4 shadow">
        <h4>Attendance Records — <?php echo $teacher['full_name']; ?></h4>
        <p><b>Branch:</b> <?php echo $teacher['branch']; ?> |
           <b>Year:</b> <?php echo $teacher['year']; ?> |
           <b>Semester:</b> <?php echo $teacher['semester']; ?></p>

        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($r = mysqli_fetch_assoc($records)){ ?>
                    <tr>
                        <td><?php echo $r['date']; ?></td>
                        <td><?php echo $r['full_name']; ?></td>
                        <td>
                            <span class="badge bg-<?php echo ($r['status']=='Present')?'success':'danger'; ?>">
                                <?php echo $r['status']; ?>
                            </span>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
