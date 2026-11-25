<?php
session_start();
include("../config/database.php");


$msg = "";


if(isset($_POST['upload'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $type = $_POST['exam_type'];
    $start_date = $_POST['start_date'];
    $end_date   = $_POST['end_date'];

    $file = $_FILES['pdf']['name'];
    $tmp = $_FILES['pdf']['tmp_name'];

    if(move_uploaded_file($tmp, "../uploads/exam_schedule/".$file)){
        mysqli_query($conn, "INSERT INTO exam_schedules (title, exam_type, exam_start_date, exam_end_date, file_name, upload_date) 
        VALUES ('$title', '$type', '$start_date', '$end_date', '$file', NOW())");
        $msg = "Exam Schedule Uploaded Successfully!";
    } else {
        $msg = "Error: File upload failed.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exam Schedule | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-bg: rgba(255, 255, 255, 0.05);
    }

    body {
        background: #0f172a;
        /* Deep Dark Blue/Black */
        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .upload-card {
        background: #1e293b;
        border: 1px solid #334155;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    .header-section {
        background: var(--primary-gradient);
        padding: 30px;
        text-align: center;
    }

    .form-label {
        font-weight: 500;
        font-size: 0.9rem;
        color: #94a3b8;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        background-color: #0f172a !important;
        border: 1px solid #334155 !important;
        color: #fff !important;
        padding: 12px 15px;
        border-radius: 10px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #818cf8 !important;
        box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.2) !important;
    }

    .input-group-text {
        background-color: #334155;
        border: 1px solid #334155;
        color: #818cf8;
        border-radius: 10px 0 0 10px;
    }

    .btn-upload {
        background: var(--primary-gradient);
        border: none;
        padding: 14px;
        font-weight: 600;
        letter-spacing: 0.5px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(118, 75, 162, 0.4);
        opacity: 0.9;
    }

    .custom-file-upload {
        border: 2px dashed #334155;
        padding: 20px;
        text-align: center;
        border-radius: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    .custom-file-upload:hover {
        border-color: #818cf8;
        background: rgba(129, 140, 248, 0.05);
    }

    /* Add New Button */
    .btn-add {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        color: white;
        font-weight: 500;
        transition: 0.3s;
    }

    .btn-add:hover {
        background: white;
        color: #764ba2;
    }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">

                <div class="upload-card">
                    <div class="header-section">
                        <i class="fas fa-file-invoice fa-3x mb-3 text-white"></i>
                        <h3 class="mb-0 fw-bold">Manage Exam Schedule</h3>

                        <p class="text-white-50 small mt-2">Upload and publish new exam dates for students</p>
                        <a href="manage_exam_schedule.php" class="btn btn-add">
                            <i class="fa fa-plus-circle me-1"></i> Manage Exam Schedule
                        </a>
                    </div>

                    <div class="p-4 p-md-5">
                        <?php if($msg != ""){ ?>
                        <div class="alert alert-success alert-dismissible fade show border-0 bg-success text-white shadow-sm mb-4"
                            role="alert">
                            <i class="fas fa-check-circle me-2"></i> <?php echo $msg; ?>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                        <?php } ?>

                        <form method="POST" enctype="multipart/form-data">

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-tag me-2"></i>Exam Title</label>
                                <input type="text" name="title" class="form-control "
                                    placeholder="e.g. Annual Semester Examination 2026" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-layer-group me-2"></i>Category</label>
                                <select name="exam_type" class="form-select" required>
                                    <option value="" selected disabled>Select Exam Type</option>
                                    <option>Mid Term</option>
                                    <option>Final Exam</option>
                                    <option>Practical</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-calendar-plus me-2"></i>Start
                                        Date</label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label"><i class="fas fa-calendar-check me-2"></i>End Date</label>
                                    <input type="date" name="end_date" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><i class="fas fa-cloud-upload-alt me-2"></i>Attachment
                                    (PDF/Image)</label>
                                <input type="file" name="pdf" class="form-control" accept=".pdf, .jpg, .png, .jpeg"
                                    required>
                                <div class="form-text text-light ">Please upload official signed schedule only.</div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" name="upload" class="btn btn-primary btn-upload text-white">
                                    <i class="fas fa-paper-plane me-2"></i> Publish Schedule
                                </button>
                                <a href="javascript:history.back()"
                                    class="btn btn-link text-secondary text-decoration-none text-center mt-2 small">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel & Go Back
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <p class="text-center text-secondary mt-4 small">
                    &copy; 2026 Campus Portal | Attendance & Exam Management System
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>