<?php
include("../config/database.php");

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM exam_schedules WHERE id='$id'"));

// Notification flag
$updated = false;

if(isset($_POST['update'])){
    $title = $_POST['title'];
    $type = $_POST['exam_type'];
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];

    mysqli_query($conn,"UPDATE exam_schedules SET 
        title='$title', 
        exam_type='$type', 
        exam_start_date='$start', 
        exam_end_date='$end' 
        WHERE id='$id'");

    // Success flag set kiya hai bina code logic badle
    $updated = true;
    
    // Agar aap doosre page par redirect karna chahte hain to ise uncomment karein:
    // header("Location: manage_exam_schedule.php?msg=success");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Exam Schedule | Stylish UI</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --glass-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background: #0f172a; /* Deep Dark Blue/Black */
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        /* Full Width Container */
        .main-container {
            width: 100%;
            max-width: 800px; /* Thoda wide rakha hai stylish look ke liye */
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.07) !important;
            border: 1px solid var(--glass-border) !important;
            color: #fff !important;
            padding: 12px;
            border-radius: 10px;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.3);
            border-color: #667eea !important;
        }

        label {
            font-weight: 500;
            margin-bottom: 8px;
            color: #94a3b8;
        }

        .btn-update {
            background: var(--primary-gradient);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 10px;
            transition: transform 0.3s ease;
            width: 100%;
            color: white;
        }

        .btn-update:hover {
            transform: translateY(-3px);
            opacity: 0.9;
        }

        .notification-top {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 90%;
            max-width: 500px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-section i {
            font-size: 3rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .header-title {
            font-weight: 700;
            margin-bottom: 30px;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php if($updated): ?>
    <div class="notification-top">
        <div class="alert alert-success alert-dismissible fade show shadow-lg border-0" role="alert">
            <strong><i class="fas fa-check-circle me-2"></i> Success!</strong> Schedule updated successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php endif; ?>

    <div class="main-container">
        <div class="glass-card">
            <div class="header-section">
                <i class="fas fa-calendar-edit mb-3"></i>
                <h2 class="fw-bold header-title "><i class="fas fa-calendar-check me-2"></i>Edit Exam Schedule</h2>
                <span class="text-light">Modify the details for the selected examination</span>
            </div>

            <form method="POST">
                <div class="mb-4">
                    <label><i class="fas fa-heading me-2"></i> Exam Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>" placeholder="Enter Exam Title">
                </div>

                <div class="mb-4">
                    <label><i class="fas fa-layer-group me-2"></i> Exam Type</label>
                    <select name="exam_type" class="form-select">
                        <option selected><?php echo $data['exam_type']; ?></option>
                        <option>Mid Term</option>
                        <option>Final Exam</option>
                        <option>Practical</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label><i class="fas fa-calendar-alt me-2"></i> Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?php echo $data['exam_start_date']; ?>">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label><i class="fas fa-calendar-check me-2"></i> End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?php echo $data['exam_end_date']; ?>">
                    </div>
                </div>

                <div class="mt-2">
                    <button name="update" class="btn btn-update">
                        <i class="fas fa-sync-alt me-2"></i> Update Schedule
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <a href="manage_exam_schedule.php" class="text-decoration-none ">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-close notification after 4 seconds
        setTimeout(function() {
            let alert = document.querySelector('.alert');
            if(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 4000);
    </script>
</body>
</html>