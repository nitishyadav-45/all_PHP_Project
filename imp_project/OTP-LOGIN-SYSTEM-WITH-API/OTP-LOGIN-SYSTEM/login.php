<?php
session_start();
require 'config/db.php';
require 'config/mail.php';

$error = '';
$success = $_SESSION['success'] ?? '';
unset($_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if user exists and is verified
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND is_verified = 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate and send OTP for login
        $otp = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        
        $stmt = $pdo->prepare("INSERT INTO otp_verification (email, otp, purpose, expires_at) VALUES (?, ?, 'login', ?)");
        $stmt->execute([$email, $otp, $expires_at]);

        if (sendOTP($email, $otp, 'Login')) {
            $_SESSION['login_email'] = $email;
            header("Location: verify-login.php");
            exit();
        } else {
            $error = "Failed to send OTP.";
        }
    } else {
        $error = "Email not found or not verified!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - OTP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter registered email" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Login OTP</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="forgot-password.php">Forgot Password?</a> | <a href="register.php">Create Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
