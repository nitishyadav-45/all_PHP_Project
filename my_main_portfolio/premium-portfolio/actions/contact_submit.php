<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php#contact');
}

verify_csrf();

if (!empty($_POST['website'])) {
    flash('success', 'Thank you. Your message has been received.');
    redirect('index.php#contact');
}

$name = trim((string) ($_POST['name'] ?? ''));
$email = trim((string) ($_POST['email'] ?? ''));
$subject = trim((string) ($_POST['subject'] ?? ''));
$message = trim((string) ($_POST['message'] ?? ''));

try {
    if ($name === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Please complete the form with a valid email address.');
    }

    if (strlen($message) > 3000) {
        throw new RuntimeException('Please keep the message under 3000 characters.');
    }

    $ip = substr($_SERVER['REMOTE_ADDR'] ?? 'unknown', 0, 64);
    $agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255);

    $stmt = db()->prepare('INSERT INTO messages (name, email, subject, message, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $email, $subject, $message, $ip, $agent]);

    $mailSubject = 'New portfolio message: ' . $subject;
    $mailBody = "Name: {$name}\nEmail: {$email}\n\nMessage:\n{$message}\n";
    $headers = [
        'From: ' . CONTACT_NOTIFICATION_EMAIL,
        'Reply-To: ' . $email,
        'Content-Type: text/plain; charset=UTF-8',
    ];

    if (CONTACT_NOTIFICATION_EMAIL !== 'admin@example.com') {
        @mail(CONTACT_NOTIFICATION_EMAIL, $mailSubject, $mailBody, implode("\r\n", $headers));
    }

    flash('success', 'Your message has been sent successfully.');
} catch (Throwable $exception) {
    flash('error', $exception->getMessage());
}

redirect('index.php#contact');

