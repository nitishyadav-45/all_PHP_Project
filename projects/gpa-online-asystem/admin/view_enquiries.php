<?php
session_start();
include("../config/database.php");

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enquiries Dashboard</title>
<!-- 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet"> -->

    <style>
        body {
            background: #f0f2f5;
            font-family: 'Inter', sans-serif;
            color: #333;
            
        }

        /* .main-content {
            padding: 30px 15px;
        } */

        /* Header Styling */
        .page-title {
            font-weight: 700;
            color: #1a237e;
            position: relative;
            display: inline-block;
            margin-bottom: 30px;
        }

        /* Card Styling */
        .enquiry-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            background: #fff;
            overflow: hidden;
        }

        /* Table Design */
        .table {
            margin-bottom: 0;
            vertical-align: middle;
        }

        .table thead {
            background: linear-gradient(45deg, #1a237e, #3949ab);
            color: white;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr:hover {
            background-color: #f8f9ff;
            transition: 0.2s;
        }

        /* Icons & Badges */
        .icon-box {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin-right: 10px;
        }

        .contact-info div {
            margin-bottom: 4px;
        }

        .msg-text {
            max-width: 250px;
            font-size: 0.9rem;
            color: #555;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .btn-delete {
            background-color: #ffeded;
            color: #dc3545;
            border: 1px solid #ffc1c1;
            transition: 0.3s;
        }

        .btn-delete:hover {
            background-color: #dc3545;
            color: white;
        }

        .btn-back {
            border-radius: 10px;
            font-weight: 600;
            padding: 10px 20px;
        }

        /* Custom Scrollbar for responsiveness */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }
        .table-responsive::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class=" main-content">
        
        <div class="row align-items-center mb-4">
            <!-- <div class="col-md-6">
                <a href="dashboard.php" class="btn btn-white btn-back shadow-sm bg-white">
                    <i class="fas fa-chevron-left me-2 text-primary"></i> Dashboard
                </a>
            </div> -->
            <div class="col-md-6 text-md-6  mt-3 mt-md-0">
                <h3 class="page-title m-0">📩 Message Inbox</h3>
            </div>
        </div>

        <?php if(isset($_GET['msg']) && $_GET['msg']=="deleted"){ ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> Enquiry has been successfully removed.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php } ?>

        <div class="card enquiry-card">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="ps-4">No.</th>
                            <th>Sender Details</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sr = 1;
                        while($row=mysqli_fetch_assoc($result)){ 
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?php echo $sr++; ?></td>
                            <td>
                                <div class="contact-info">
                                    <div class="fw-bold text-dark"><i class="fas fa-user-circle text-primary me-2"></i><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div class="small text-muted"><i class="fas fa-phone-alt me-2"></i><?php echo htmlspecialchars($row['mobile']); ?></div>
                                    <div class="small text-muted"><i class="fas fa-envelope me-2"></i><?php echo htmlspecialchars($row['email']); ?></div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border border-primary-subtle p-2">
                                    <?php echo htmlspecialchars($row['subject']); ?>
                                </span>
                            </td>
                            <td>
                                <div class="msg-text" title="<?php echo htmlspecialchars($row['message']); ?>">
                                    <?php echo htmlspecialchars($row['message']); ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="?delete=<?php echo $row['id']; ?>" 
                                   class="btn btn-delete btn-sm border border-danger-subtle bg-danger text-light px-3">
                                   
                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if(mysqli_num_rows($result) == 0){ ?>
                <div class="p-5 text-center text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                    <p>No enquiries found yet.</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
</body>

</html>