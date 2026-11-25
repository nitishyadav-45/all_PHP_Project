<?php
include("../config/database.php");

$msg = "";

if (isset($_POST['upload'])) {
    $subject  = mysqli_real_escape_string($conn, $_POST['subject']);
    $branch   = mysqli_real_escape_string($conn, $_POST['branch']);
    $year     = mysqli_real_escape_string($conn, $_POST['year']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $desc     = mysqli_real_escape_string($conn, $_POST['description']);

    $file     = $_FILES['file']['name'];
    $tmp      = $_FILES['file']['tmp_name'];

    // File upload logic
    if (move_uploaded_file($tmp, "../updates/gallery/" . $file)) {
        $query = "INSERT INTO syllabus (subject_name, branch, year, semester, file_name, description, upload_date) 
                  VALUES ('$subject', '$branch', '$year', '$semester', '$file', '$desc', NOW())";
        
        if (mysqli_query($conn, $query)) {
            $msg = "Uploaded! Waiting for Admin Approval";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Syllabus | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .upload-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            background: #fff;
        }
        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
        }
        .form-label {
            font-weight: 600;
            color: #555;
        }
        .input-group-text {
            background-color: #f8f9fa;
            color: #007bff;
        }
        .btn-upload {
            padding: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.3);
        }
        /* Message animation */
        #status-msg {
            transition: opacity 0.5s ease-out;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <?php if($msg != ""){ ?>
                <div id="status-msg" class="alert alert-success border-0 shadow-sm d-flex align-items-center" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    <div><?php echo $msg; ?></div>
                </div>
            <?php } ?>

            <div class="card upload-card">
                <div class="card-header text-center">
                    <h4 class="mb-0"><i class="fa-solid fa-cloud-arrow-up me-2"></i> Upload Syllabus</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Subject Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                                <input type="text" name="subject" class="form-control" placeholder="e.g. Data Structures" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Branch</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-code-branch"></i></span>
                                    <input type="text" name="branch" class="form-control" placeholder="e.g. CS / IT" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Year</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
                                    <select name="year" class="form-select">
                                        <option>1st Year</option>
                                        <option>2nd Year</option>
                                        <option>3rd Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semester</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-layer-group"></i></span>
                                <select name="semester" class="form-select">
                                    <?php for($i=1; $i<=6; $i++) { echo "<option>Sem $i</option>"; } ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Additional details..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Choose File (PDF/Doc)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-file-pdf"></i></span>
                                <input type="file" name="file" class="form-control" required>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button name="upload" class="btn btn-primary btn-upload">
                                <i class="fa-solid fa-paper-plane me-2"></i> Submit Syllabus
                            </button>
                        </div>

                    </form>
                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small">&copy; <?php echo date('Y'); ?> Your Institution Portal</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // 3 seconds baad message hide karne ka function
    const statusMsg = document.getElementById('status-msg');
    if (statusMsg) {
        setTimeout(() => {
            statusMsg.style.opacity = '0';
            setTimeout(() => {
                statusMsg.style.display = 'none';
            }, 500); // fade out animation time
        }, 3000); // 3000ms = 3 seconds
    }
</script>

</body>
</html>