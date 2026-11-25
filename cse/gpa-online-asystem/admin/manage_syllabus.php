<?php
include("../config/database.php");

$msg = "";
/* APPROVE logic */
if(isset($_GET['approve'])){
    $id = mysqli_real_escape_string($conn, $_GET['approve']);
    if(mysqli_query($conn, "UPDATE syllabus SET status='approved' WHERE id='$id'")){
        $msg = "Syllabus Approved Successfully!";
    }
}

/* DELETE logic */
if(isset($_GET['delete'])){
    $id = mysqli_real_escape_string($conn, $_GET['delete']);
    if(mysqli_query($conn, "DELETE FROM syllabus WHERE id='$id'")){
        $msg = "Syllabus Deleted Successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Syllabus | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Inter', sans-serif;
        }
        .main-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            background: #fff;
            overflow: hidden;
        }
        .table-header {
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white;
            padding: 20px;
        }
        .table thead th {
            background-color: #f8f9fc;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #5a5c69;
            border-bottom: 2px solid #e3e6f0;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .btn-action {
            border-radius: 8px;
            transition: all 0.2s;
            margin: 2px;
        }
        .btn-action:hover {
            transform: scale(1.05);
        }
        .table-responsive {
            padding: 15px;
        }
        /* Custom scrollbar for table */
        ::-webkit-scrollbar {
            height: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h3 class="fw-bold text-dark"><i class="fa-solid fa-list-check text-primary me-2"></i> Manage Syllabus</h3>
                <p class="text-muted">Review, Approve or Remove syllabus entries.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="upload_page.php" class="btn btn-primary shadow-sm rounded-pill">
                    <i class="fa-solid fa-plus me-1"></i> Add New Syllabus
                </a>
            </div>
        </div>

        <?php if($msg != ""){ ?>
            <div id="status-msg" class="alert alert-info border-0 shadow-sm alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-bell me-2"></i> <?php echo $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php } ?>

        <div class="card main-card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-book-open me-2"></i>Subject</th>
                            <th><i class="fa-solid fa-code-branch me-2"></i>Branch</th>
                            <th><i class="fa-solid fa-layer-group me-2"></i>Semester</th>
                            <th><i class="fa-solid fa-signal me-2"></i>Status</th>
                            <th class="text-center"><i class="fa-solid fa-bolt me-2"></i>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM syllabus ORDER BY id DESC");
                        if(mysqli_num_rows($q) > 0){
                            while($row = mysqli_fetch_assoc($q)){
                                ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold text-primary"><?php echo $row['subject_name']; ?></div>
                                        <small class="text-muted"><?php echo $row['year']; ?></small>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?php echo $row['branch']; ?></span></td>
                                    <td><?php echo $row['semester']; ?></td>
                                    <td>
                                        <?php if($row['status'] == 'pending'){ ?>
                                            <span class="status-badge bg-warning text-dark">
                                                <i class="fa-solid fa-clock me-1"></i> Pending
                                            </span>
                                        <?php } else { ?>
                                            <span class="status-badge bg-success text-white">
                                                <i class="fa-solid fa-check-circle me-1"></i> Approved
                                            </span>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($row['status'] == 'pending'){ ?>
                                            <a href="?approve=<?php echo $row['id']; ?>" class="btn btn-success btn-sm btn-action" title="Approve Now">
                                                <i class="fa-solid fa-thumbs-up"></i> Approve
                                            </a>
                                        <?php } ?>
                                        
                                        <a href="?delete=<?php echo $row['id']; ?>" 
                                           class="btn btn-outline-danger btn-sm btn-action" 
                                           onclick="return confirm('Are you sure you want to delete this?')"
                                           title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php 
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-5 text-muted'>No syllabus found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // 3 seconds auto-hide for messages
    const alertMsg = document.getElementById('status-msg');
    if (alertMsg) {
        setTimeout(() => {
            alertMsg.style.transition = "opacity 0.5s ease";
            alertMsg.style.opacity = "0";
            setTimeout(() => alertMsg.remove(), 500);
        }, 3000);
    }
</script>

</body>
</html>