<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function url(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/');
    $cleanPath = ltrim($path, '/');

    if ($cleanPath === '') {
        return $base === '' ? '/' : $base . '/';
    }

    return ($base === '' ? '' : $base) . '/' . $cleanPath;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function flash(string $type, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$type] = $message;
        return null;
    }

    if (!empty($_SESSION['flash'][$type])) {
        $value = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $value;
    }

    return null;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Security token expired. Please go back, refresh the page, and try again.');
    }
}

function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function current_admin(PDO $pdo): ?array
{
    if (!is_admin_logged_in()) {
        return null;
    }

    $stmt = $pdo->prepare('SELECT id, username, email, display_name, avatar_path, last_login_at FROM admins WHERE id = ? AND is_active = 1 LIMIT 1');
    $stmt->execute([(int) $_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    return $admin ?: null;
}

function require_admin(): void
{
    if (!is_admin_logged_in()) {
        redirect('admin/login.php');
    }
}

function admin_count(PDO $pdo): int
{
    return (int) $pdo->query('SELECT COUNT(*) FROM admins')->fetchColumn();
}

function profile_settings(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM profile_settings WHERE id = 1 LIMIT 1');
    $profile = $stmt->fetch();

    if ($profile) {
        return $profile;
    }

    return [
        'full_name' => 'Alex Morgan',
        'headline' => 'Full-Stack Web Developer',
        'tagline' => 'I build fast, elegant, and scalable digital experiences.',
        'bio' => 'I design and develop high-performing web applications with clean UI, robust backend systems, and thoughtful user experiences.',
        'email' => CONTACT_NOTIFICATION_EMAIL,
        'phone' => '+1 555 0189',
        'location' => 'Remote',
        'website' => '',
        'cv_path' => '',
        'avatar_path' => 'assets/images/profile-portrait.png',
        'linkedin_url' => '#',
        'github_url' => '#',
        'x_url' => '#',
        'instagram_url' => '#',
    ];
}

function record_page_view(PDO $pdo, string $page = 'home'): void
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $agent = substr($_SERVER['HTTP_USER_AGENT'] ?? 'unknown', 0, 255);
    $ipHash = hash('sha256', $ip . '|' . date('Y-m-d'));

    $stmt = $pdo->prepare('INSERT INTO site_views (ip_hash, page, user_agent) VALUES (?, ?, ?)');
    $stmt->execute([$ipHash, $page, $agent]);
}

function upload_file(array $file, string $folder, array $allowedMimes, array $allowedExtensions): ?string
{
    if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('The upload failed. Please try again.');
    }

    if (($file['size'] ?? 0) > MAX_UPLOAD_SIZE) {
        throw new RuntimeException('The file is too large. Maximum upload size is 4 MB.');
    }

    $extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        throw new RuntimeException('This file type is not allowed.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file((string) $file['tmp_name']);
    if (!in_array($mime, $allowedMimes, true)) {
        throw new RuntimeException('The uploaded file content is invalid.');
    }

    $targetDir = ROOT_PATH . '/uploads/' . trim($folder, '/');
    if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
        throw new RuntimeException('Could not prepare upload directory.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $targetPath = $targetDir . '/' . $filename;

    if (!move_uploaded_file((string) $file['tmp_name'], $targetPath)) {
        throw new RuntimeException('Could not save the uploaded file.');
    }

    return 'uploads/' . trim($folder, '/') . '/' . $filename;
}

function delete_upload(?string $relativePath): void
{
    if (!$relativePath || str_starts_with($relativePath, 'assets/')) {
        return;
    }

    $fullPath = ROOT_PATH . '/' . ltrim($relativePath, '/');
    $uploadsRoot = realpath(ROOT_PATH . '/uploads');
    $filePath = realpath($fullPath);

    if ($uploadsRoot && $filePath && str_starts_with($filePath, $uploadsRoot) && is_file($filePath)) {
        unlink($filePath);
    }
}

function slugify(string $value): string
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value) ?? '', '-'));
    return $slug !== '' ? $slug : 'project';
}

function plain_excerpt(string $text, int $length = 140): string
{
    $clean = trim(strip_tags($text));
    $stringLength = function_exists('mb_strlen') ? mb_strlen($clean) : strlen($clean);
    if ($stringLength <= $length) {
        return $clean;
    }

    $excerpt = function_exists('mb_substr') ? mb_substr($clean, 0, $length - 3) : substr($clean, 0, $length - 3);
    return $excerpt . '...';
}
