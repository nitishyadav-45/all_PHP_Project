<?php
session_start();
include("../config/database.php");

$branch   = $_SESSION['branch'];
$semester = $_SESSION['semester'];
$year     = $_SESSION['year'];

$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

$students = mysqli_query($conn,"SELECT id, full_name FROM students WHERE branch='$branch' AND semester='$semester' AND year='$year'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Date-wise Report</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h4>Date-wise Attendance</h4>

    <form method="GET" class="mb-3">
        <input type="date" name="date" value="<?php echo $date; ?>" class="form-control w-25 d-inline">
        <button class="btn btn-primary">View</button>
        
                   <a href="dashboard.php" class="btn btn-danger ">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>

            
    </form>


    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tr class="table-dark">
                <th>Sr.no</th>
                <th>Name</th>
                <th>Status</th>
            </tr>

            <?php $i=1;
            while($s=mysqli_fetch_assoc($students)){
                $sid=$s['id'];
                $status=mysqli_fetch_assoc(mysqli_query($conn,"SELECT status FROM attendance WHERE student_id='$sid' AND date='$date'"))['status'] ?? 'Not Marked';
                echo "<tr>
                        <td>".$i++."</td>
                        <td>".$s['full_name']."</td>
                        <td><b>$status</b></td>
                      </tr>";
            } ?>
        </table>
    </div>
</div>
</body>
</html>
