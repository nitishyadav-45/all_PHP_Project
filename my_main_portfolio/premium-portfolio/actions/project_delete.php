<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/projects.php');
}

verify_csrf();

try {
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = db()->prepare('SELECT image_path FROM projects WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if (!$project) {
        throw new RuntimeException('Project not found.');
    }

    $delete = db()->prepare('DELETE FROM projects WHERE id = ?');
    $delete->execute([$id]);
    delete_upload($project['image_path']);

    flash('success', 'Project deleted successfully.');
} catch (Throwable $exception) {
    flash('error', $exception->getMessage());
}

redirect('admin/projects.php');

