<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM holidays ORDER BY holiday_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Holiday Notices | Teacher Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            /* --primary-gradient: linear-gradient(135deg, #FF9A8B 0%, #FF6A88 55%, #FF99AC 100%); */
            --primary-gradient: linear-gradient(135deg, #4361ee 0%, #7209b7 100%);

            --card-bg: #ffffff;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .header-bg {
            background: var(--primary-gradient);
            height: 200px;
            padding-top: 50px;
            border-radius: 0 0 50px 50px;
            color: white;
            text-align: center;
        }

        .holiday-container {
            margin-top: -60px;
            padding-bottom: 50px;
        }

        .holiday-card {
            background: var(--card-bg);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            border-left: 6px solid #4361ee;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .holiday-card:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .date-badge {
            background: #fff5f6;
            color: #4361ee;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 15px;
            border: 1px solid #ffe0e3;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 12px;
            padding: 8px 20px;
            text-decoration: none;
            transition: 0.3s;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .back-btn:hover {
            background: white;
            color: #4361ee;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #999;
        }
    </style>
</head>
<body>

<div class="header-bg shadow">
    <a href="dashboard.php" class="back-btn"><i class="fas fa-chevron-left me-2"></i> Dashboard</a>
    <h2 class="fw-bold animate__animated animate__fadeInDown">
        <i class="fas fa-calendar-star me-2"></i> Holiday Announcements
    </h2>
    <p class="opacity-75">Stay updated with the academic calendar</p>
</div>

<div class="container holiday-container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <?php if(mysqli_num_rows($result) > 0) { ?>
                <?php while($row=mysqli_fetch_assoc($result)){ ?>
                    <div class="holiday-card p-4 mb-4 animate__animated animate__fadeInUp">
                        <div class="row align-items-start">
                            <div class="col-md-9">
                                <div class="date-badge shadow-sm">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    <?php echo date("d M Y", strtotime($row['holiday_date'])); ?>
                                </div>
                                <h4 class="fw-bold text-dark mb-2"><?php echo $row['title']; ?></h4>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-info-circle me-1"></i> 
                                    <?php echo $row['reason']; ?>
                                </p>
                            </div>
                            <div class="col-md-3 text-md-end mt-3 mt-md-0">
                                <span class="badge rounded-pill bg-light text-dark p-2 px-3 border">
                                    Holiday
                                </span>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <div class="glass-card text-center py-5">
                    <i class="fas fa-umbrella-beach fa-4x text-muted mb-3 opacity-25"></i>
                    <h5 class="text-muted">No upcoming holidays announced yet.</h5>
                </div>
            <?php } ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>