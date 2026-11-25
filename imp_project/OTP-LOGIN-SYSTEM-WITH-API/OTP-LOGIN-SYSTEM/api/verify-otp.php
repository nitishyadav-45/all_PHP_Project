<?php
header("Content-Type: application/json");
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests allowed']);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? '';
$otp = $input['otp'] ?? '';

if (empty($email) || empty($otp)) {
    echo json_encode(['status' => 'error', 'message' => 'Email and OTP are required']);
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM otp_verification WHERE email = ? AND otp = ? AND purpose = 'login' AND expires_at > NOW() ORDER BY created_at DESC LIMIT 1");
$stmt->execute([$email, $otp]);
$row = $stmt->fetch();

if ($row) {
    // Get user details
    $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Delete used OTP
    $stmt = $pdo->prepare("DELETE FROM otp_verification WHERE email = ? AND purpose = 'login'");
    $stmt->execute([$email]);

    echo json_encode([
        'status' => 'success', 
        'message' => 'OTP verified successfully',
        'user' => [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or expired OTP']);
}
?>
