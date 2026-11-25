<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - OTP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">OTP Auth System</a>
        <div class="ms-auto">
            <span class="text-white me-3">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-body text-center">
                    <h2 class="card-title">Welcome to Your Dashboard</h2>
                    <p class="lead">You have successfully logged in using the OTP Authentication System.</p>
                    <hr>
                    <div class="text-start">
                        <h5>Your Profile Details:</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
                            <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
                            <li class="list-group-item"><strong>Account Status:</strong> <span class="badge bg-success">Verified</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
