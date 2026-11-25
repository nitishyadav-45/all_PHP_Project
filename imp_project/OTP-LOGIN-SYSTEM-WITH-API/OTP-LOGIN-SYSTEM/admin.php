<?php
session_start();
require 'config/db.php';

// Simple admin check - in a real app, you'd have a role column
// For this demo, we'll just show the stats

// Total Users
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

// Verified Users
$verified_users = $pdo->query("SELECT COUNT(*) FROM users WHERE is_verified = 1")->fetchColumn();

// Recent OTP Logs
$otp_logs = $pdo->query("SELECT * FROM otp_verification ORDER BY created_at DESC LIMIT 10")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - OTP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">OTP System Admin</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card bg-info text-white shadow">
                <div class="card-body text-center">
                    <h3>Total Users</h3>
                    <h1><?php echo $total_users; ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-success text-white shadow">
                <div class="card-body text-center">
                    <h3>Verified Users</h3>
                    <h1><?php echo $verified_users; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4>Recent OTP Logs</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>OTP</th>
                        <th>Purpose</th>
                        <th>Expires At</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($otp_logs as $log): ?>
                    <tr>
                        <td><?php echo $log['email']; ?></td>
                        <td><?php echo $log['otp']; ?></td>
                        <td><span class="badge bg-secondary"><?php echo $log['purpose']; ?></span></td>
                        <td><?php echo $log['expires_at']; ?></td>
                        <td><?php echo $log['created_at']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
