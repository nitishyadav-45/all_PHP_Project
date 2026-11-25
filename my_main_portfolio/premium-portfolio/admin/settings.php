<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

$profile = profile_settings(db());

$adminPageTitle = 'Settings';
$activeMenu = 'settings';
include __DIR__ . '/../includes/admin-header.php';
?>

<div class="row g-4">
    <div class="col-xl-8">
        <section class="admin-card">
            <div class="card-heading">
                <div>
                    <span>Public Profile</span>
                    <h2>Portfolio Details</h2>
                </div>
            </div>
            <form action="<?= url('actions/settings_update.php') ?>" method="post" enctype="multipart/form-data" class="settings-form">
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="profile">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="full_name" value="<?= e($profile['full_name']) ?>" required maxlength="120">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Headline</label>
                        <input type="text" class="form-control" name="headline" value="<?= e($profile['headline']) ?>" required maxlength="160">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Tagline</label>
                        <input type="text" class="form-control" name="tagline" value="<?= e($profile['tagline']) ?>" required maxlength="220">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Bio</label>
                        <textarea class="form-control" name="bio" rows="5" required><?= e($profile['bio']) ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= e($profile['email']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="<?= e($profile['phone']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" value="<?= e($profile['location']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Website URL</label>
                        <input type="url" class="form-control" name="website" value="<?= e($profile['website']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" class="form-control" name="linkedin_url" value="<?= e($profile['linkedin_url']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">GitHub URL</label>
                        <input type="url" class="form-control" name="github_url" value="<?= e($profile['github_url']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">X URL</label>
                        <input type="url" class="form-control" name="x_url" value="<?= e($profile['x_url']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" class="form-control" name="instagram_url" value="<?= e($profile['instagram_url']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Profile Portrait</label>
                        <input type="file" class="form-control image-preview-input" name="avatar" accept="image/png,image/jpeg,image/webp">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CV PDF</label>
                        <input type="file" class="form-control" name="cv" accept="application/pdf">
                    </div>
                    <div class="col-12">
                        <button class="btn btn-admin-primary" type="submit">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Save Profile
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </div>
    <div class="col-xl-4">
        <section class="admin-card mb-4">
            <div class="card-heading">
                <div>
                    <span>Admin</span>
                    <h2>Account</h2>
                </div>
            </div>
            <form action="<?= url('actions/settings_update.php') ?>" method="post" class="settings-form">
                <?= csrf_field() ?>
                <input type="hidden" name="section" value="admin">
                <label class="form-label">Display Name</label>
                <input type="text" class="form-control mb-3" name="display_name" value="<?= e($admin['display_name']) ?>" required>
                <label class="form-label">Username</label>
                <input type="text" class="form-control mb-3" name="username" value="<?= e($admin['username']) ?>" required>
                <label class="form-label">Email</label>
                <input type="email" class="form-control mb-3" name="email" value="<?= e($admin['email']) ?>" required>
                <button class="btn btn-admin-primary w-100" type="submit">Update Account</button>
            </form>
        </section>

        <section class="admin-card">
            <div class="card-heading">
                <div>
                    <span>Security</span>
                    <h2>Password</h2>
                </div>
            </div>
            <form action="<?= url('actions/password_update.php') ?>" method="post" class="settings-form">
                <?= csrf_field() ?>
                <label class="form-label">Current Password</label>
                <input type="password" class="form-control mb-3" name="current_password" required autocomplete="current-password">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control mb-3" name="password" required minlength="10" autocomplete="new-password">
                <label class="form-label">Confirm Password</label>
                <input type="password" class="form-control mb-3" name="password_confirmation" required minlength="10" autocomplete="new-password">
                <button class="btn btn-danger-soft w-100" type="submit">Change Password</button>
            </form>
        </section>
    </div>
</div>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>

