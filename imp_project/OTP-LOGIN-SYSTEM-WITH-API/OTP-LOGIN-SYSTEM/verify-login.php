<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['login_email'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$email = $_SESSION['login_email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];

    $stmt = $pdo->prepare("SELECT * FROM otp_verification WHERE email = ? AND otp = ? AND purpose = 'login' AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$email, $otp]);
    $row = $stmt->fetch();

    if ($row) {
        // Get user details
        $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        // Delete used OTP
        $stmt = $pdo->prepare("DELETE FROM otp_verification WHERE email = ? AND purpose = 'login'");
        $stmt->execute([$email]);

        unset($_SESSION['login_email']);
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid or expired OTP!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify Login - OTP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white text-center">
                    <h4>Verify Login OTP</h4>
                </div>
                <div class="card-body text-center">
                    <p>Enter the 6-digit OTP sent to <b><?php echo $email; ?></b></p>
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <input type="text" name="otp" class="form-control text-center fs-2" maxlength="6" placeholder="000000" required>
                        </div>
                        <button type="submit" class="btn btn-info w-100 text-white">Login</button>
                    </form>
                    <hr>
                    <a href="login.php" class="btn btn-link">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
