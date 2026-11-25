<?php
include("../config/database.php");

/* DELETE */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $get = mysqli_query($conn,"SELECT file_name FROM exam_schedules WHERE id='$id'");
    $data = mysqli_fetch_assoc($get);
    unlink("../uploads/exam_schedule/".$data['file_name']);
    mysqli_query($conn,"DELETE FROM exam_schedules WHERE id='$id'");
    header("Location: manage_exam_schedule.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exam Schedule | Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --glass-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
        }

        body {
            background: #0f172a; /* Deep Dark Blue */
            color: #f8fafc;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            padding: 40px 0;
        }

        /* Glassmorphism Card */
        .main-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .card-header {
            background: var(--primary-gradient);
            padding: 20px 25px;
            border: none;
        }

        .card-header h4 {
            font-weight: 700;
            margin: 0;
            color: white;
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

        /* Table Styling */
        .table {
            color: #f8fafc;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead th {
            background: rgba(255, 255, 255, 0.02);
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--card-border);
            padding: 15px;
        }

        .table tbody tr {
            border-bottom: 1px solid var(--card-border);
            transition: 0.2s;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .table td {
            padding: 15px;
            border: none;
        }

        /* Action Buttons */
        .btn-action {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-edit { background: rgba(245, 158, 11, 0.2); color: #f59e0b; }
        .btn-edit:hover { background: #f59e0b; color: #fff; }

        .btn-delete { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .btn-delete:hover { background: #ef4444; color: #fff; }

        .btn-view { background: rgba(16, 185, 129, 0.2); color: #10b981; border: none; }
        .btn-view:hover { background: #10b981; color: #fff; }

        /* Responsive */
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            .table-responsive {
                border: none;
            }
            .table {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card main-card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="fa-solid fa-list-check me-2"></i>Manage Schedule</h4>
            <a href="exam_schedule.php" class="btn btn-add">
                <i class="fa fa-plus-circle me-1"></i> Add New
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <!-- <th class="ps-4">ID</th> -->
                            <th>Title</th>
                            <th>Type</th>
                            <th>Dates</th>
                            <th>File</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM exam_schedules ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($query)){
                        ?>
                        <tr>
                            <!-- <td class="ps-4 text-muted small">#<?php echo $row['id']; ?></td> -->
                            <td class="fw-semibold"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><span class="badge bg-dark border border-secondary"><?php echo $row['exam_type']; ?></span></td>
                            <td>
                                <div class="small">
                                    <span class="text-info"><?php echo date("d M", strtotime($row['exam_start_date'])); ?></span>
                                    <span class="mx-1 text-muted">-</span>
                                    <span class="text-info"><?php echo date("d M Y", strtotime($row['exam_end_date'])); ?></span>
                                </div>
                            </td>
                            <td>
                                <a href="../uploads/exam_schedule/<?php echo $row['file_name']; ?>" 
                                   class="btn btn-view btn-sm" target="_blank">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td class="text-end pe-4">
                                <a href="edit_exam_schedule.php?id=<?php echo $row['id']; ?>" 
                                   class="btn-action btn-edit me-1 text-decoration-none">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="manage_exam_schedule.php?delete=<?php echo $row['id']; ?>" 
                                   class="btn-action btn-delete text-decoration-none"
                                   onclick="return confirm('Permanent delete this schedule?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>