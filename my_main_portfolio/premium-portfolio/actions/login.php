<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/login.php');
}

verify_csrf();

$mode = $_POST['mode'] ?? 'login';

try {
    if ($mode === 'setup') {
        if (admin_count(db()) > 0) {
            flash('error', 'Admin setup has already been completed.');
            redirect('admin/login.php');
        }

        $displayName = trim((string) ($_POST['display_name'] ?? ''));
        $username = trim((string) ($_POST['username'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $confirmation = (string) ($_POST['password_confirmation'] ?? '');

        if ($displayName === '' || $username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Please enter a valid name, username, and email address.');
        }

        if (strlen($password) < 10 || $password !== $confirmation) {
            throw new RuntimeException('Password must be at least 10 characters and match the confirmation.');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = db()->prepare('INSERT INTO admins (username, email, display_name, password_hash) VALUES (?, ?, ?, ?)');
        $stmt->execute([$username, $email, $displayName, $hash]);

        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int) db()->lastInsertId();
        flash('success', 'Admin account created successfully.');
        redirect('admin/dashboard.php');
    }

    $login = trim((string) ($_POST['login'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');

    if ($login === '' || $password === '') {
        throw new RuntimeException('Please enter your login details.');
    }

    $stmt = db()->prepare('SELECT * FROM admins WHERE (username = ? OR email = ?) AND is_active = 1 LIMIT 1');
    $stmt->execute([$login, $login]);
    $admin = $stmt->fetch();

    if (!$admin || !password_verify($password, $admin['password_hash'])) {
        throw new RuntimeException('Invalid username/email or password.');
    }

    if (password_needs_rehash($admin['password_hash'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $updateHash = db()->prepare('UPDATE admins SET password_hash = ? WHERE id = ?');
        $updateHash->execute([$newHash, (int) $admin['id']]);
    }

    session_regenerate_id(true);
    $_SESSION['admin_id'] = (int) $admin['id'];

    $updateLogin = db()->prepare('UPDATE admins SET last_login_at = NOW() WHERE id = ?');
    $updateLogin->execute([(int) $admin['id']]);

    redirect('admin/dashboard.php');
} catch (Throwable $exception) {
    flash('error', $exception->getMessage());
    redirect('admin/login.php');
}

