<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

$profile = profile_settings(db());
$cvPath = trim((string) ($profile['cv_path'] ?? ''));

if ($cvPath === '') {
    http_response_code(404);
    exit('The CV file has not been uploaded yet. Add one from Admin > Settings.');
}

if (preg_match('#^https?://#i', $cvPath)) {
    header('Location: ' . $cvPath);
    exit;
}

$fullPath = realpath(ROOT_PATH . '/' . ltrim($cvPath, '/'));
$uploadsRoot = realpath(ROOT_PATH . '/uploads/cv');

if (!$fullPath || !$uploadsRoot || !str_starts_with($fullPath, $uploadsRoot) || !is_file($fullPath)) {
    http_response_code(404);
    exit('The CV file could not be found.');
}

$filename = basename($fullPath);
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($fullPath));
readfile($fullPath);
exit;

