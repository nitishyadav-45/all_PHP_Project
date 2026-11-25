<?php
/**
 * Secure Contact Form Handler
 * This script processes the contact form submission, sanitizes input,
 * and would typically send an email or save to a database.
 */

// Set response header to JSON for potential AJAX handling, 
// though we'll use a simple redirect for this version.
header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize Input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    // 2. Basic Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill in all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // 3. Configuration (Update these with your details)
    $to = "your-email@example.com"; // Your professional email
    $email_subject = "Portfolio Contact: $subject";
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $email_body = "You have received a new message from your portfolio website.\n\n".
                  "Name: $name\n".
                  "Email: $email\n".
                  "Subject: $subject\n\n".
                  "Message:\n$message";

    // 4. Send Email (Requires a configured mail server)
    // In a real production environment, you might use PHPMailer or a service like SendGrid.
    $success = mail($to, $email_subject, $email_body, $headers);

    // 5. User Feedback
    if ($success) {
        echo "<div style='background: #121212; color: #00d4ff; height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; font-family: sans-serif;'>";
        echo "<h1>Thank You!</h1>";
        echo "<p>Your message has been sent successfully. I will get back to you soon.</p>";
        echo "<a href='index.html' style='color: #fff; text-decoration: none; border: 1px solid #00d4ff; padding: 10px 20px; border-radius: 5px; margin-top: 20px;'>Go Back</a>";
        echo "</div>";
    } else {
        // Fallback for local testing or server without mail() support
        echo "<div style='background: #121212; color: #ff4d4d; height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center; font-family: sans-serif;'>";
        echo "<h1>Notice</h1>";
        echo "<p>Message processed, but email sending failed (requires mail server configuration).</p>";
        echo "<p>Data received: Name: $name, Email: $email</p>";
        echo "<a href='index.html' style='color: #fff; text-decoration: none; border: 1px solid #ff4d4d; padding: 10px 20px; border-radius: 5px; margin-top: 20px;'>Go Back</a>";
        echo "</div>";
    }
} else {
    // Redirect if accessed directly
    header("Location: index.html");
    exit();
}
?>
