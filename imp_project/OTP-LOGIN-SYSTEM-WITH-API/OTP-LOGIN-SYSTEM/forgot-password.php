<?php
session_start();
require 'config/db.php';
require 'config/mail.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $otp = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        
        $stmt = $pdo->prepare("INSERT INTO otp_verification (email, otp, purpose, expires_at) VALUES (?, ?, 'reset', ?)");
        $stmt->execute([$email, $otp, $expires_at]);

        if (sendOTP($email, $otp, 'Password Reset')) {
            $_SESSION['reset_email'] = $email;
            header("Location: verify-reset-otp.php");
            exit();
        } else {
            $error = "Failed to send OTP.";
        }
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - OTP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark text-center">
                    <h4>Forgot Password</h4>
                </div>
                <div class="card-body">
                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Send Reset OTP</button>
                    </form>
                    <p class="mt-3 text-center"><a href="login.php">Back to Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
