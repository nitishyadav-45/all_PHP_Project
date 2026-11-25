<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

// Filters
$branch   = $_GET['branch'] ?? '';
$year     = $_GET['year'] ?? '';
$semester = $_GET['semester'] ?? '';
$student_id = $_GET['student_id'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - View Student Attendance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="text-center mb-4">📊 Student Attendance Overview</h3>

    <!-- 🔍 Filter Form -->
    <div class="card p-3 shadow-sm mb-4">
        <form method="GET" class="row g-3">

            <div class="col-md-3">
                <label>Branch</label>
                <select name="branch" class="form-select" required>
                    <option value="">Select</option>
                    <option value="CSE">CSE</option>
                    <option value="E.E">E.E</option>
                    <option value="M.E">M.E</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Year</label>
                <select name="year" class="form-select" required>
                    <option value="">Select</option>
                    <option>1st Year</option>
                    <option>2nd Year</option>
                    <option>3rd Year</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Semester</label>
                <select name="semester" class="form-select" required>
                    <option value="">Select</option>
                    <option>Sem 1</option>
                    <option>Sem 2</option>
                    <option>Sem 3</option>
                    <option>Sem 4</option>
                    <option>Sem 5</option>
                    <option>Sem 6</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Student</label>
                <select name="student_id" class="form-select" required>
                    <option value="">Select Student</option>
                    <?php
                    if($branch && $year && $semester){
                        $stmt = $conn->prepare("SELECT id, full_name FROM students WHERE branch=? AND year=? AND semester=?");
                        $stmt->bind_param("sss",$branch,$year,$semester);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while($s=$res->fetch_assoc()){
                            echo "<option value='{$s['id']}'>{$s['full_name']}</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-12 text-end">
                <button class="btn btn-primary">View Attendance</button>
            </div>
        </form>
    </div>

<?php
if($student_id){

    // Total / Present / Absent
    $stmt1 = $conn->prepare("SELECT COUNT(*) as total FROM attendance WHERE student_id=?");
    $stmt1->bind_param("i",$student_id);
    $stmt1->execute();
    $total = $stmt1->get_result()->fetch_assoc()['total'];

    $stmt2 = $conn->prepare("SELECT COUNT(*) as present FROM attendance WHERE student_id=? AND status='Present'");
    $stmt2->bind_param("i",$student_id);
    $stmt2->execute();
    $present = $stmt2->get_result()->fetch_assoc()['present'];

    $absent = $total - $present;
    $percent = ($total>0)? round(($present/$total)*100,2):0;

    // Month wise data
    $months = [];
    $attendanceData = [];

    $query = $conn->prepare("SELECT DATE_FORMAT(date,'%b') as month,
        SUM(status='Present') as present_count
        FROM attendance WHERE student_id=?
        GROUP BY MONTH(date)");
    $query->bind_param("i",$student_id);
    $query->execute();
    $res = $query->get_result();

    while($row=$res->fetch_assoc()){
        $months[] = $row['month'];
        $attendanceData[] = $row['present_count'];
    }
?>
    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-3"><div class="alert alert-primary">Total Classes<br><b><?php echo $total; ?></b></div></div>
        <div class="col-md-3"><div class="alert alert-success">Present<br><b><?php echo $present; ?></b></div></div>
        <div class="col-md-3"><div class="alert alert-danger">Absent<br><b><?php echo $absent; ?></b></div></div>
        <div class="col-md-3"><div class="alert alert-dark">Attendance %<br><b><?php echo $percent; ?>%</b></div></div>
    </div>

    <div class="row">
        <!-- Pie Chart -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h5 class="text-center">🥧 Present vs Absent</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-md-6 mb-4">
            <div class="card p-3 shadow-sm">
                <h5 class="text-center">📊 Monthly Attendance</h5>
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

<script>
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Present', 'Absent'],
        datasets: [{
            data: [<?php echo $present; ?>, <?php echo $absent; ?>],
            backgroundColor: ['#28a745','#dc3545']
        }]
    }
});

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Present Days',
            data: <?php echo json_encode($attendanceData); ?>,
            backgroundColor: '#0d6efd'
        }]
    },
    options: { responsive:true }
});
</script>

<?php } ?>

</div>
</body>
</html>
