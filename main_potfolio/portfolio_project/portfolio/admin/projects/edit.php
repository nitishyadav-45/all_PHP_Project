<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Fetch Existing Project Data
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $category = sanitize($_POST['category']);
    $link = sanitize($_POST['link']);
    $description = sanitize($_POST['description']);
    
    $imagePath = $project['image']; // Default to old image

    // Handle New Image Upload (if provided)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = '../../assets/images/projects/' . $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            // Nayi image upload ho gayi, ab purani delete karein
            if (!empty($project['image']) && file_exists('../../' . $project['image'])) {
                unlink('../../assets/images/projects/' . $project['image']);
            }
            $imagePath = $uploadDir . $fileName; 
        }
    }

    $updateStmt = $pdo->prepare("UPDATE projects SET title = ?, category = ?, link = ?, description = ?, image = ? WHERE id = ?");
    $updateStmt->execute([$title, $category, $link, $description, $imagePath, $id]);
    
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { border: none; border-radius: 12px; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Edit Project</h2>
            <a href="index.php" class="btn btn-outline-secondary px-4 rounded-pill">Cancel & Back</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Title</label>
                            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="Web" <?php echo ($project['category'] == 'Web') ? 'selected' : ''; ?>>Web</option>
                                <option value="Mobile" <?php echo ($project['category'] == 'Mobile') ? 'selected' : ''; ?>>Mobile</option>
                                <option value="Design" <?php echo ($project['category'] == 'Design') ? 'selected' : ''; ?>>Design</option>
                                <option value="Branding" <?php echo ($project['category'] == 'Branding') ? 'selected' : ''; ?>>Branding</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Link</label>
                            <input type="url" name="link" class="form-control" value="<?php echo htmlspecialchars($project['link']); ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Update Image (Leave blank to keep current)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <?php if(!empty($project['image'])): ?>
                                <div class="mt-2 small text-muted">
                                    Current Image: <img src="../../assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" width="50" class="rounded ms-2">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small">Description</label>
                            <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($project['description']); ?></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success px-5 rounded-pill shadow-sm">Update Project</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>