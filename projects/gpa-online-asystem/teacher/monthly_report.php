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

$selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
$selected_year  = date('Y');

// Get students
$students_query = "SELECT id, full_name FROM students 
                   WHERE branch='$branch' AND semester='$semester' AND year='$year'
                   ORDER BY full_name ASC";
$students_result = mysqli_query($conn, $students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report | Analytics Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #2ec4b6;
            --danger: #e71d36;
            --dark: #212529;
            --light-bg: #f8f9fd;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Inter', sans-serif;
            color: var(--dark);
        }

        .header-section {
            background: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);
            padding: 50px 0 100px 0;
            color: white;
            border-radius: 0 0 50px 50px;
            margin-bottom: -60px;
        }

        .report-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .filter-bar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .table thead {
            background: #f8f9fa;
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table td {
            vertical-align: middle;
            padding: 15px 10px;
            font-weight: 500;
        }

        .progress {
            height: 8px;
            border-radius: 10px;
            background-color: #eee;
        }

        .chart-box {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .btn-action {
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .back-link {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .back-link:hover {
            color: white;
        }
    </style>
</head>
<body>

<div class="header-section shadow-sm">
    <div class="container text-center animate__animated animate__fadeIn">
        <div class="mb-3">
            <a href="dashboard.php" class="back-link"><i class="fas fa-chevron-left me-2"></i> Back to Dashboard</a>
        </div>
        <h2 class="fw-bold"><i class="fas fa-file-invoice me-2"></i> Monthly Attendance Report</h2>
        <p class="opacity-75">
            <?php echo "$branch | Sem $semester | Year $year"; ?> <br>
            <span class="badge bg-white text-primary mt-2 px-3 py-2">
                <i class="far fa-calendar-alt me-1"></i> <?php echo date('F Y', mktime(0,0,0,$selected_month,1)); ?>
            </span>
        </p>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center mb-5">
        <div class="col-lg-11">
            <div class="filter-bar animate__animated animate__fadeInUp">
                <form method="GET" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted mb-1">Select Month</label>
                        <select name="month" class="form-select border-0 bg-light shadow-sm py-2" onchange="this.form.submit()">
                            <?php for($m=1;$m<=12;$m++): ?>
                            <option value="<?php echo $m; ?>" <?php if($m==$selected_month) echo 'selected'; ?>>
                                <?php echo date('F', mktime(0,0,0,$m,1)); ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-8 d-flex justify-content-md-end gap-2 align-items-end">
                        <a href="date_wise_report.php" class="btn btn-light btn-action text-primary shadow-sm">
                            <i class="fas fa-history me-1"></i> Date-wise
                        </a>
                        <a href="download_report.php?month=<?php echo $selected_month; ?>" class="btn btn-danger btn-action shadow-sm">
                            <i class="fas fa-file-pdf me-1"></i> Export PDF
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="report-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="ps-4">Sr.</th>
                                <th class="text-start">Student Name</th>
                                <th>Total</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th width="200">Attendance %</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            $chart_names = [];
                            $chart_percents = [];

                            while($student = mysqli_fetch_assoc($students_result)) {
                                $sid = $student['id'];

                                // Total Queries
                                $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM attendance WHERE student_id='$sid' AND MONTH(date)='$selected_month' AND YEAR(date)='$selected_year'"))['t'];
                                $present = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as p FROM attendance WHERE student_id='$sid' AND status='Present' AND MONTH(date)='$selected_month' AND YEAR(date)='$selected_year'"))['p'];

                                $absent = $total - $present;
                                $percent = ($total > 0) ? round(($present / $total) * 100, 1) : 0;
                                
                                // Data for Chart
                                $chart_names[] = $student['full_name'];
                                $chart_percents[] = $percent;
                                
                                // Color based on percentage
                                $color_class = ($percent >= 75) ? 'bg-success' : (($percent >= 50) ? 'bg-warning' : 'bg-danger');
                            ?>
                            <tr>
                                <td class="ps-4 text-muted small"><?php echo str_pad($i++, 2, "0", STR_PAD_LEFT); ?></td>
                                <td class="text-start fw-bold"><?php echo $student['full_name']; ?></td>
                                <td><span class="badge bg-light text-dark px-3"><?php echo $total; ?></span></td>
                                <td class="text-success fw-bold"><?php echo $present; ?></td>
                                <td class="text-danger fw-bold"><?php echo $absent; ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1">
                                            <div class="progress-bar <?php echo $color_class; ?>" role="progressbar" style="width: <?php echo $percent; ?>%"></div>
                                        </div>
                                        <span class="small fw-bold"><?php echo $percent; ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-11">
            <div class="chart-box animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold m-0"><i class="fas fa-chart-bar text-primary me-2"></i> Performance Analysis</h5>
                    <span class="text-muted small">Comparison of all students</span>
                </div>
                <canvas id="studentChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const ctx = document.getElementById('studentChart').getContext('2d');
    
    // Gradient Background for Chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(67, 97, 238, 0.8)');
    gradient.addColorStop(1, 'rgba(67, 97, 238, 0.1)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($chart_names); ?>,
            datasets: [{
                label: 'Attendance %',
                data: <?php echo json_encode($chart_percents); ?>,
                backgroundColor: gradient,
                borderColor: '#4361ee',
                borderWidth: 2,
                borderRadius: 8,
                barThickness: 25,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: { display: true, drawBorder: false, color: '#f0f0f0' },
                    ticks: { callback: value => value + '%' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

</body>
</html>