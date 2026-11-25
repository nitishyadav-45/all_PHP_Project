<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/messages.php');
}

verify_csrf();

$id = (int) ($_POST['id'] ?? 0);
$stmt = db()->prepare('DELETE FROM messages WHERE id = ?');
$stmt->execute([$id]);

flash('success', 'Message deleted successfully.');
redirect('admin/messages.php');

