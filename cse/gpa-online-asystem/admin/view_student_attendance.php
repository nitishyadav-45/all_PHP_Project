<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/adminlogin.php");
    exit();
}

$student_id = $_GET['id'];
$student = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM students WHERE id='$student_id'"));

// Attendance Summary
$total_q = mysqli_query($conn,"SELECT COUNT(*) as total FROM attendance WHERE student_id='$student_id'");
$total = mysqli_fetch_assoc($total_q)['total'];

$present_q = mysqli_query($conn,"SELECT COUNT(*) as present FROM attendance WHERE student_id='$student_id' AND status='Present'");
$present = mysqli_fetch_assoc($present_q)['present'];

$absent = $total - $present;
$percent = ($total>0)? round(($present/$total)*100,2):0;


// Month-wise Attendance Data
$monthly_data = mysqli_query($conn,"
    SELECT MONTH(date) as month, 
           SUM(status='Present') as present_count
    FROM attendance
    WHERE student_id='$student_id'
    GROUP BY MONTH(date)
");

$months = [];
$presents = [];

while($row = mysqli_fetch_assoc($monthly_data)){
    $months[] = date("M", mktime(0,0,0,$row['month'],10));
    $presents[] = $row['present_count'];
}

?>




<!DOCTYPE html>
<html>

<head>
    <title>Student Attendance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
    body {
        background: #f2f4f7;
    }

    .card {
        border-radius: 15px;
    }
    </style>
</head>

<body>

    <div class="container mt-4">
        <a href="manage_students.php" class="btn btn-secondary mb-3">⬅ Back</a>

        <div class="card p-4 shadow mb-4">
            <h4 class="mb-3">Attendance Details — <?php echo $student['full_name']; ?></h4>

            <div class="row text-center">
                <div class="col-md-3">
                    <div class="alert alert-primary">Total Classes<br><b><?php echo $total; ?></b></div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-success">Present<br><b><?php echo $present; ?></b></div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-danger">Absent<br><b><?php echo $absent; ?></b></div>
                </div>
                <div class="col-md-3">
                    <div class="alert alert-dark">Attendance %<br><b><?php echo $percent; ?>%</b></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <!-- 📊 Pie Chart -->
                <div class="card p-4 shadow mb-4" style="max-width:500px; ">
                    <h5 class="mb-3 text-center">Attendance Distribution</h5>
                    <canvas id="attendancePie"></canvas>
                </div>

            </div>
            <div class="col-sm-6">
                <!-- 📊 Monthly Attendance Graph -->
                <div class="card p-4 shadow mb-4" style="max-width:600px; ">
                    <h5 class="mb-3 text-center">📅 Month-wise Attendance</h5>
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>


        <!-- 📅 Date-wise Attendance -->
        <div class="card p-4 shadow">
            <h5>📅 Date-wise Attendance</h5>
            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                $records = mysqli_query($conn,"SELECT date,status FROM attendance WHERE student_id='$student_id' ORDER BY date DESC");
                while($r = mysqli_fetch_assoc($records)){
                    $badge = ($r['status']=='Present') ? "success" : "danger";
                    echo "<tr>
                        <td>{$r['date']}</td>
                        <td><span class='badge bg-$badge'>{$r['status']}</span></td>
                    </tr>";
                }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('attendancePie');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [<?php echo $present; ?>, <?php echo $absent; ?>],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    </script>

    <script>
    const monthlyCtx = document.getElementById('monthlyChart');

    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($months); ?>,
            datasets: [{
                label: 'Present Days',
                data: <?php echo json_encode($presents); ?>,
                backgroundColor: '#0d6efd',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>


</body>

</html>