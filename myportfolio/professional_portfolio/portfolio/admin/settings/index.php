<?php
require_once '../../includes/auth.php';
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkAuth();

$settings = getSettings($pdo);
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $site_title = sanitize($_POST['site_title']);
    $meta_description = sanitize($_POST['meta_description']);
    $meta_keywords = sanitize($_POST['meta_keywords']);
    $footer_text = sanitize($_POST['footer_text']);

    if ($settings) {
        $stmt = $pdo->prepare("UPDATE settings SET site_title=?, meta_description=?, meta_keywords=?, footer_text=? WHERE id=?");
        $stmt->execute([$site_title, $meta_description, $meta_keywords, $footer_text, $settings['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO settings (site_title, meta_description, meta_keywords, footer_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$site_title, $meta_description, $meta_keywords, $footer_text]);
    }
    
    $message = "Settings updated successfully!";
    $settings = getSettings($pdo);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Settings - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Site Settings</h2>
            <a href="../dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
        <?php if($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Site Title</label>
                        <input type="text" name="site_title" class="form-control" value="<?php echo $settings['site_title'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="3"><?php echo $settings['meta_description'] ?? ''; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="<?php echo $settings['meta_keywords'] ?? ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Footer Text</label>
                        <input type="text" name="footer_text" class="form-control" value="<?php echo $settings['footer_text'] ?? ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
