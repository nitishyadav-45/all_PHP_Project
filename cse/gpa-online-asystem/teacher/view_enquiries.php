<?php
session_start();
include("../config/database.php");

if(!isset($_SESSION['teacher_id'])){
    header("Location: ../auth/login.php");
    exit();
}

// 🔐 Delete enquiry securely
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    header("Location: view_enquiries.php?msg=deleted");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM enquiries ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Enquiries | Support Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary-color: #0d6efd;
            --primary-dark: #0a58ca;
            --bg-light: #f4f7fe;
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Inter', sans-serif;
            color: #334155;
        }

        .header-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, #4361ee 100%);
            padding: 40px 0 80px 0;
            color: white;
            border-radius: 0 0 30px 30px;
            margin-bottom: -50px;
        }

        .main-card {
            background: white;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 20px;
        }

        .table thead {
            background-color: #f8fafc;
        }

        .table thead th {
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border: none;
            padding: 15px;
        }

        .table tbody tr {
            transition: all 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover {
            background-color: #f1f7ff;
            transform: scale(1.002);
        }

        .table td {
            padding: 18px 15px;
            font-size: 0.95rem;
            vertical-align: middle;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 10px;
            padding: 8px 18px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-back:hover {
            background: white;
            color: var(--primary-color);
        }

        .msg-box {
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #64748b;
            font-size: 0.85rem;
        }

        .badge-id {
            background-color: #eef2ff;
            color: var(--primary-color);
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 8px;
        }

        .btn-delete {
            color: #ef4444;
            background: #fef2f2;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .icon-circle {
            width: 35px;
            height: 35px;
            background: #e0e7ff;
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div class="header-banner shadow-sm">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center animate__animated animate__fadeIn">
                <a href="dashboard.php" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Dashboard
                </a>
                <div class="text-center">
                    <h2 class="fw-bold mb-0">Contact Enquiries</h2>
                    <p class="opacity-75 small mb-0">Manage all student and visitor queries</p>
                </div>
                <div style="width: 100px;"></div> </div>
        </div>
    </div>

    <div class="container-fluid px-lg-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="main-card animate__animated animate__fadeInUp">
                    
                    <?php if(isset($_GET['msg']) && $_GET['msg']=="deleted"){ ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Enquiry removed successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php } ?>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Ref. ID</th>
                                    <th>Sender Details</th>
                                    <th>Contact Info</th>
                                    <th>Subject</th>
                                    <th>Message Content</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sr = 1;
                                while($row=mysqli_fetch_assoc($result)){ 
                                ?>
                                <tr>
                                    <td><span class="badge-id">#<?php echo $sr++; ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="icon-circle">
                                                <i class="fas fa-user-alt small"></i>
                                            </div>
                                            <span class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small"><i class="fas fa-phone-alt text-muted me-1" style="width: 15px;"></i> <?php echo htmlspecialchars($row['mobile']); ?></div>
                                        <div class="small"><i class="fas fa-envelope text-muted me-1" style="width: 15px;"></i> <?php echo htmlspecialchars($row['email']); ?></div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill bg-light text-primary border px-3">
                                            <?php echo htmlspecialchars($row['subject']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="msg-box" title="<?php echo htmlspecialchars($row['message']); ?>">
                                            <?php echo htmlspecialchars($row['message']); ?>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <a href="?delete=<?php echo $row['id']; ?>" class="btn-delete"
                                            onclick="return confirm('Do you really want to delete this enquiry?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if(mysqli_num_rows($result) == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                            <p>No enquiries found in the database.</p>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>