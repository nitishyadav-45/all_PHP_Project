<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('admin/settings.php');
}

verify_csrf();

$section = $_POST['section'] ?? '';

try {
    if ($section === 'admin') {
        $displayName = trim((string) ($_POST['display_name'] ?? ''));
        $username = trim((string) ($_POST['username'] ?? ''));
        $email = trim((string) ($_POST['email'] ?? ''));

        if ($displayName === '' || $username === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Please enter valid admin account details.');
        }

        $stmt = db()->prepare('UPDATE admins SET display_name = ?, username = ?, email = ? WHERE id = ?');
        $stmt->execute([$displayName, $username, $email, (int) $_SESSION['admin_id']]);
        flash('success', 'Admin account updated successfully.');
        redirect('admin/settings.php');
    }

    if ($section !== 'profile') {
        throw new RuntimeException('Invalid settings section.');
    }

    $profile = profile_settings(db());
    $fullName = trim((string) ($_POST['full_name'] ?? ''));
    $headline = trim((string) ($_POST['headline'] ?? ''));
    $tagline = trim((string) ($_POST['tagline'] ?? ''));
    $bio = trim((string) ($_POST['bio'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $location = trim((string) ($_POST['location'] ?? ''));
    $website = trim((string) ($_POST['website'] ?? ''));
    $linkedinUrl = trim((string) ($_POST['linkedin_url'] ?? ''));
    $githubUrl = trim((string) ($_POST['github_url'] ?? ''));
    $xUrl = trim((string) ($_POST['x_url'] ?? ''));
    $instagramUrl = trim((string) ($_POST['instagram_url'] ?? ''));

    if ($fullName === '' || $headline === '' || $tagline === '' || $bio === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new RuntimeException('Please complete the required public profile fields.');
    }

    $avatarPath = upload_file(
        $_FILES['avatar'] ?? [],
        'profile',
        ['image/jpeg', 'image/png', 'image/webp'],
        ['jpg', 'jpeg', 'png', 'webp']
    ) ?: $profile['avatar_path'];

    $cvPath = upload_file(
        $_FILES['cv'] ?? [],
        'cv',
        ['application/pdf', 'application/x-pdf'],
        ['pdf']
    ) ?: $profile['cv_path'];

    $stmt = db()->prepare(
        'UPDATE profile_settings
         SET full_name = ?, headline = ?, tagline = ?, bio = ?, email = ?, phone = ?, location = ?, website = ?, cv_path = ?, avatar_path = ?, linkedin_url = ?, github_url = ?, x_url = ?, instagram_url = ?
         WHERE id = 1'
    );
    $stmt->execute([
        $fullName,
        $headline,
        $tagline,
        $bio,
        $email,
        $phone,
        $location,
        $website,
        $cvPath,
        $avatarPath,
        $linkedinUrl,
        $githubUrl,
        $xUrl,
        $instagramUrl,
    ]);

    if ($avatarPath !== $profile['avatar_path']) {
        delete_upload($profile['avatar_path']);
    }
    if ($cvPath !== $profile['cv_path']) {
        delete_upload($profile['cv_path']);
    }

    flash('success', 'Public profile updated successfully.');
} catch (Throwable $exception) {
    flash('error', $exception->getMessage());
}

redirect('admin/settings.php');

