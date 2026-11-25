<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['verify_email'])) {
    header("Location: register.php");
    exit();
}

$error = '';
$email = $_SESSION['verify_email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = $_POST['otp'];

    $stmt = $pdo->prepare("SELECT * FROM otp_verification WHERE email = ? AND otp = ? AND purpose = 'register' AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$email, $otp]);
    $row = $stmt->fetch();

    if ($row) {
        // Mark user as verified
        $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE email = ?");
        $stmt->execute([$email]);

        // Delete used OTP
        $stmt = $pdo->prepare("DELETE FROM otp_verification WHERE email = ? AND purpose = 'register'");
        $stmt->execute([$email]);

        unset($_SESSION['verify_email']);
        $_SESSION['success'] = "Registration verified! Please login.";
        header("Location: login.php");
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
    <title>Verify Registration - OTP System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>Verify OTP</h4>
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
                        <button type="submit" class="btn btn-success w-100">Verify OTP</button>
                    </form>
                    <hr>
                    <a href="register.php" class="btn btn-link">Back to Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
