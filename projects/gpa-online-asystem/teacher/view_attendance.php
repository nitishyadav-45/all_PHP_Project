<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$branch   = $_SESSION['branch'];
$semester = $_SESSION['semester'];
$year     = $_SESSION['year'];

$students = mysqli_query($conn,"SELECT id, full_name FROM students WHERE branch='$branch' AND semester='$semester' AND year='$year' ORDER BY full_name ASC");

$selected_student = $_GET['student_id'] ?? '';
$present = $absent = 0;
$student_name = "";

if($selected_student){
    $res_p = mysqli_query($conn,"SELECT COUNT(*) as p FROM attendance WHERE student_id='$selected_student' AND status='Present'");
    $present = mysqli_fetch_assoc($res_p)['p'];
    
    $res_a = mysqli_query($conn,"SELECT COUNT(*) as a FROM attendance WHERE student_id='$selected_student' AND status='Absent'");
    $absent  = mysqli_fetch_assoc($res_a)['a'];

    $res_n = mysqli_query($conn,"SELECT full_name FROM students WHERE id='$selected_student'");
    $student_name = mysqli_fetch_assoc($res_n)['full_name'];
}

$total = $present + $absent;
$percentage = ($total > 0) ? round(($present / $total) * 180) : 0; // Simple logic for percentage
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Analytics | Smart Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            --accent-color: #4361ee;
        }

        body {
            background: var(--bg-gradient);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            color: #2d3436;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        }

        .stat-box {
            padding: 20px;
            border-radius: 18px;
            background: #fff;
            transition: 0.3s;
            border: 1px solid #edf2f7;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .custom-select {
            border-radius: 12px;
            padding: 12px;
            border: 2px solid #e2e8f0;
            font-weight: 600;
        }

        .custom-select:focus {
            border-color: var(--accent-color);
            box-shadow: none;
        }

        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 300px;
        }

        .back-btn {
            background: white;
            color: #ff4757;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
        }

        .back-btn:hover {
            background: #ff4757;
            color: white;
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.3);
        }

        .badge-percent {
            background: var(--accent-color);
            color: white;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="dashboard.php" class="back-btn shadow-sm">
                    <i class="fas fa-chevron-left me-2"></i> Dashboard
                </a>
                <h4 class="fw-bold m-0"><i class="fas fa-chart-pie text-primary me-2"></i>Attendance Analytics</h4>
            </div>

            <div class="glass-card p-4 p-md-5 animate__animated animate__fadeIn">
                
                <div class="text-center mb-5">
                    <h5 class="text-muted mb-3 small text-uppercase fw-bold tracking-wider">Select Student to analyze</h5>
                    <form method="GET" class="row justify-content-center">
                        <div class="col-md-7">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3">
                                    <i class="fas fa-user-graduate text-muted"></i>
                                </span>
                                <select name="student_id" class="form-select custom-select border-start-0 rounded-end-pill" onchange="this.form.submit()">
                                    <option value="">Choose a student from <?php echo $branch; ?>...</option>
                                    <?php while($s=mysqli_fetch_assoc($students)){ ?>
                                        <option value="<?php echo $s['id']; ?>" <?php if($selected_student==$s['id']) echo 'selected'; ?>>
                                            <?php echo $s['full_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <?php if($selected_student){ ?>
                    <div class="row align-items-center g-4">
                        <div class="col-md-6 text-center">
                            <div class="chart-container">
                                <canvas id="attendancePie"></canvas>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="ps-md-4">
                                <div class="mb-4">
                                    <h3 class="fw-bold mb-1"><?php echo $student_name; ?></h3>
                                    <span class="badge-percent">Attendance Performance</span>
                                </div>

                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="stat-box">
                                            <small class="text-muted d-block mb-1">Present</small>
                                            <h3 class="text-success fw-bold m-0"><?php echo $present; ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box">
                                            <small class="text-muted d-block mb-1">Absent</small>
                                            <h3 class="text-danger fw-bold m-0"><?php echo $absent; ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="stat-box d-flex justify-content-between align-items-center" style="background: #f8faff;">
                                            <div>
                                                <small class="text-muted d-block mb-1">Total Scheduled Classes</small>
                                                <h4 class="fw-bold m-0 text-primary"><?php echo $total; ?></h4>
                                            </div>
                                            <i class="fas fa-calendar-check fa-2x text-light"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="small fw-bold">Attendance Score</span>
                                        <span class="small fw-bold text-primary"><?php echo ($total > 0) ? round(($present/$total)*100) : 0; ?>%</span>
                                    </div>
                                    <div class="progress" style="height: 10px; border-radius: 10px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                                             role="progressbar" 
                                             style="width: <?php echo ($total > 0) ? ($present/$total)*100 : 0; ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    const ctx = document.getElementById('attendancePie');
                    new Chart(ctx, {
                        type: 'doughnut', // Doughnut zyada modern lagta hai
                        data: {
                            labels: ['Present', 'Absent'],
                            datasets: [{
                                data: [<?php echo $present; ?>, <?php echo $absent; ?>],
                                backgroundColor: ['#00db71', '#ff4757'],
                                hoverOffset: 15,
                                borderWidth: 0
                            }]
                        },
                        options: {
                            cutout: '70%',
                            responsive: true,
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                    </script>
                <?php } else { ?>
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="100" class="mb-3 opacity-25" alt="Select">
                        <h5 class="text-muted">Please select a student to see the visual report</h5>
                    </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

</body>
</html>