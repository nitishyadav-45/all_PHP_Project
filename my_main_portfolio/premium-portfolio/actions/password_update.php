<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/settings.php');
}

verify_csrf();

try {
    $currentPassword = (string) ($_POST['current_password'] ?? '');
    $password = (string) ($_POST['password'] ?? '');
    $confirmation = (string) ($_POST['password_confirmation'] ?? '');

    $stmt = db()->prepare('SELECT password_hash FROM admins WHERE id = ? LIMIT 1');
    $stmt->execute([(int) $_SESSION['admin_id']]);
    $adminRow = $stmt->fetch();

    if (!$adminRow || !password_verify($currentPassword, $adminRow['password_hash'])) {
        throw new RuntimeException('Current password is incorrect.');
    }

    if (strlen($password) < 10 || $password !== $confirmation) {
        throw new RuntimeException('New password must be at least 10 characters and match the confirmation.');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $update = db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?');
    $update->execute([$hash, (int) $_SESSION['admin_id']]);

    flash('success', 'Password updated successfully.');
} catch (Throwable $exception) {
    flash('error', $exception->getMessage());
}

redirect('admin/settings.php');

