<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $subject, $message]);
            
            // Redirect with success message (simplified for this structure)
            echo "<script>alert('Message sent successfully!'); window.location.href='index.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Something went wrong. Please try again.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields.'); window.location.href='index.php';</script>";
    }
} else {
    redirect('index.php');
}
?>
