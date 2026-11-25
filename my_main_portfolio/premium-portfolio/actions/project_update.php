<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/projects.php');
}

verify_csrf();

try {
    $id = (int) ($_POST['id'] ?? 0);
    $stmt = db()->prepare('SELECT * FROM projects WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    $project = $stmt->fetch();

    if (!$project) {
        throw new RuntimeException('Project not found.');
    }

    $title = trim((string) ($_POST['title'] ?? ''));
    $category = trim((string) ($_POST['category'] ?? ''));
    $shortDescription = trim((string) ($_POST['short_description'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $technologies = trim((string) ($_POST['technologies'] ?? ''));
    $projectUrl = trim((string) ($_POST['project_url'] ?? ''));
    $githubUrl = trim((string) ($_POST['github_url'] ?? ''));
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);
    $isFeatured = isset($_POST['is_featured']) ? 1 : 0;
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if ($title === '' || $category === '' || $shortDescription === '' || $description === '') {
        throw new RuntimeException('Please complete all required project fields.');
    }

    $newImage = upload_file(
        $_FILES['image'] ?? [],
        'projects',
        ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
        ['jpg', 'jpeg', 'png', 'webp', 'gif']
    );
    $imagePath = $newImage ?: $project['image_path'];

    $update = db()->prepare(
        'UPDATE projects
         SET title = ?, category = ?, short_description = ?, description = ?, technologies = ?, image_path = ?, project_url = ?, github_url = ?, is_featured = ?, is_active = ?, sort_order = ?
         WHERE id = ?'
    );
    $update->execute([
        $title,
        $category,
        $shortDescription,
        $description,
        $technologies,
        $imagePath,
        $projectUrl,
        $githubUrl,
        $isFeatured,
        $isActive,
        $sortOrder,
        $id,
    ]);

    if ($newImage) {
        delete_upload($project['image_path']);
    }

    flash('success', 'Project updated successfully.');
} catch (Throwable $exception) {
    flash('error', $exception->getMessage());
}

redirect('admin/projects.php');

