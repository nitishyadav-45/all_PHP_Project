<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendOTP($email, $otp, $purpose = "Verification")
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;

        // Apni Gmail ID
        $mail->Username   = 'yourgmail@gmail.com';

        // Gmail App Password
        $mail->Password   = 'xxxxxxxxxxxxxxxx';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('yourgmail@gmail.com', 'OTP Login System');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = $purpose . ' OTP';

        $mail->Body = "
        <div style='font-family:Arial;padding:20px'>
            <h2>Email Verification</h2>
            <p>Your OTP Code:</p>
            <h1 style='color:#007bff;'>$otp</h1>
            <p>This OTP is valid for 5 minutes.</p>
        </div>
        ";

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;
    }
}
?>