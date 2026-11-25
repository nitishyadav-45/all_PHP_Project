<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendOTP($email, $otp, $purpose) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Change to your SMTP host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'yourmail@gmail.com'; // Change to your email
        $mail->Password   = 'your-app-password'; // Change to your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('yourmail@gmail.com', 'OTP Login System');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Your OTP for $purpose";
        
        $message = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px;'>
            <h2 style='color: #333;'>OTP Verification</h2>
            <p>Your OTP for <strong>$purpose</strong> is:</p>
            <h1 style='color: #007bff; font-size: 40px; letter-spacing: 5px;'>$otp</h1>
            <p>This OTP is valid for 5 minutes. Please do not share it with anyone.</p>
            <hr>
            <p style='font-size: 12px; color: #777;'>If you didn't request this, please ignore this email.</p>
        </div>
        ";

        $mail->Body = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
