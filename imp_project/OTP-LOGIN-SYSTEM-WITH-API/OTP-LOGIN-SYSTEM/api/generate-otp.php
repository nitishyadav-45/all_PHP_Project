<?php
header("Content-Type: application/json");
require '../config/db.php';
require '../config/mail.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests allowed']);
    exit();
}

// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? '';

if (empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Email is required']);
    exit();
}

// Check if user exists and is verified
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND is_verified = 1");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    $otp = rand(100000, 999999);
    $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
    
    $stmt = $pdo->prepare("INSERT INTO otp_verification (email, otp, purpose, expires_at) VALUES (?, ?, 'login', ?)");
    if ($stmt->execute([$email, $otp, $expires_at])) {
        if (sendOTP($email, $otp, 'API Login')) {
            echo json_encode([
                'status' => 'success', 
                'message' => 'OTP sent successfully to ' . $email,
                'expires_at' => $expires_at
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email not found or not verified']);
}
?>
