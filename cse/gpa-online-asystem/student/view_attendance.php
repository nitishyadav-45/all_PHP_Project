<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['student_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$student_name = $_SESSION['student_name'];

/* TOTAL ATTENDANCE */
$total_query = mysqli_query($conn,"SELECT COUNT(*) as total FROM attendance WHERE student_id='$student_id'");
$total_classes = mysqli_fetch_assoc($total_query)['total'];

$present_query = mysqli_query($conn,"SELECT COUNT(*) as total FROM attendance WHERE student_id='$student_id' AND status='Present'");
$total_present = mysqli_fetch_assoc($present_query)['total'];

$total_absent = $total_classes - $total_present;
$total_percent = ($total_classes > 0) ? round(($total_present/$total_classes)*100,2) : 0;


/* MONTHLY DATA */
$months=[];
$present=[];
$absent=[];

for($m=1;$m<=12;$m++){

    $month_name = date("F",mktime(0,0,0,$m,1));
    $months[] = $month_name;

    $p = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM attendance 
     WHERE student_id='$student_id' 
     AND status='Present'
     AND MONTH(date)='$m'");

    $present_count = mysqli_fetch_assoc($p)['total'];

    $a = mysqli_query($conn,
    "SELECT COUNT(*) as total FROM attendance 
     WHERE student_id='$student_id'
     AND status='Absent'
     AND MONTH(date)='$m'");

    $absent_count = mysqli_fetch_assoc($a)['total'];

    $present[] = $present_count;
    $absent[] = $absent_count;
    
}

$profile_img = $_SESSION['profile_image'] ?? "../assets/images/default_user.png";
?>

<!DOCTYPE html>
<html>

<head>

    <title>Attendance Report</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
    body {
        background: #f4f6f9;
     font-family: 'Poppins', sans-serif;

        
    }

    
    

   

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .header-title {
        font-weight: 600;
    }

    .chart-box {
        padding: 20px;
    }
    


    
    </style>

</head>

<body>

    

     <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container-fluid">

            <button class="btn btn-dark d-md-none me-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand" href="../index.php">Student Dashboard</a>

            <span class="text-white welcome-text d-none d-lg-block"
                style="font-weight:bold; position: absolute; left: 50%; transform: translateX(-50%); font-size:20px;">
                <?php echo "Welcome $student_name"; ?>
            </span>

            <div class="ms-auto d-flex align-items-center">




                <span class="me-3 text-white d-none d-sm-inline">
                    <?php echo " $student_name"; ?>
                </span>

                <div class="dropdown">
                    <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="profileDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $profile_img; ?>" alt="image" width="40" height="40"
                            class="rounded-circle border border-2 border-secondary">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark text-small  shadow"
                        aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="settings.php">
                                <i class="fas fa-cog me-2"></i> Settings
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="change_password.php">
                                <i class="fas fa-lock me-2"></i> Forgot Password
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-danger " href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>

    <div class="sidebar animate__animated animate__fadeInLeft ">

        <a href="dashboard.php" ><i class="bi bi-speedometer2 me-2"></i></i>Dashboard</a>
        <a href="view_attendance.php" class="active"><i class="fas fa-calendar-check me-2"></i>Attendance</a>
        <a href="#"><i class="fas fa-file-alt me-2"></i>Reports</a>
        <a href="view_holidays.php"><i class=" fa-solid fa-bell me-2"></i>Holiday</a>
        <a href="profile.php"><i class="fas fa-user me-2"></i>Profile</a>
        <a href="viewid.php"><i class="fa-solid fa-id-card-clip me-2"></i>View id card</a>
        <a href="student_apply_leave.php"><i class="fa-solid fa-file-signature me-2"></i>Apply Leave</a>
        <a href="my_leaves.php"><i class="fa-solid fa-calendar-check me-2"></i>My Leave</a>
        <a href="add_grievance.php"><i class="fa-solid fa-comment-medical me-2"></i> Add Grievance</a>
        <a href="my_grievance.php"><i class="fa-solid fa-clipboard-list me-2"></i>view my Grievance</a>
        <a href="generate_id_card.php"><i class="fa-solid fa-id-card me-2"></i>
            Generate ID Card
        </a>

        <hr>
        <li><a href="../auth/logout.php" class="text-danger "><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>

    </div>

    <div class="main-content mx-center">

        <div class="container-fluid  mt-5 py-5">

            <!-- HEADER -->
            <div class="d-flex  justify-content-between align-items-center mb-4">

                <h3 class="header-title">
                    <i class="fa fa-chart-line"></i> Attendance Analytics
                </h3>

                <div class="d-flex align-items-center">

                    <span class="me-3 fw-bold"><?php echo $student_name; ?></span>

                    <img src="<?php echo $profile_img;?>" width="40" height="40" class="rounded-circle">

                </div>

            </div>

            <!-- SUMMARY CARDS -->

            <div class="row g-4 mb-4">

                <div class="col-md-3">

                    <div class="card p-4 text-center bg-primary text-white">

                        <h5>Total Classes</h5>
                        <h2><?php echo $total_classes;?></h2>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card p-4 text-center bg-success text-white">

                        <h5>Present</h5>
                        <h2><?php echo $total_present;?></h2>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="card p-4 text-center bg-danger text-white">

                        <h5>Absent</h5>
                        <h2><?php echo $total_absent;?></h2>

                    </div>

                </div>
                <div class="col-md-3">

                    <div class="card p-4 text-center bg-info text-white">

                        <h5>Total Attendance %</h5>
                        <h2><?php echo $total_percent; ?>%</h2>

                    </div>

                </div>

            </div>


            <!-- CHARTS -->

            <div class="row g-4">

                <!-- BAR CHART -->

                <div class="col-lg-8">

                    <div class="card chart-box">

                        <h5 class="mb-3">Monthly Attendance Chart</h5>

                        <canvas id="barChart"></canvas>

                    </div>

                </div>


                <!-- PIE CHART -->

                <div class="col-lg-4">

                    <div class="card chart-box">

                        <h5 class="mb-3 text-center">Attendance Distribution</h5>

                        <canvas id="pieChart"></canvas>

                    </div>

                </div>

            </div>
        </div>


    </div>




    <script>
    /* BAR CHART */

    const barChart = new Chart(document.getElementById("barChart"), {

        type: "bar",

        data: {

            labels: <?php echo json_encode($months); ?>,

            datasets: [{
                    label: "Present",
                    data: <?php echo json_encode($present); ?>,
                    backgroundColor: "#28a745"
                },
                {
                    label: "Absent",
                    data: <?php echo json_encode($absent); ?>,
                    backgroundColor: "#dc3545"
                }
            ]

        },

        options: {

            responsive: true,

            plugins: {
                legend: {
                    position: 'top'
                }
            },

            scales: {
                y: {
                    beginAtZero: true
                }
            }

        }

    });


    /* PIE CHART */

    const pieChart = new Chart(document.getElementById("pieChart"), {

        type: "pie",

        data: {

            labels: ["Present", "Absent"],

            datasets: [{

                data: [<?php echo $total_present;?>, <?php echo $total_absent;?>],

                backgroundColor: [
                    "#28a745",
                    "#dc3545"
                ]

            }]

        },

        options: {
            responsive: true
        }

    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <!-- <script>
    // Toggle button par click karne par sidebar me 'active' class add/remove karega
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Agar mobile par sidebar open hai aur user bahar click karta hai, to band ho jaye
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        }
    });
    </script> -->

</body>

</html>