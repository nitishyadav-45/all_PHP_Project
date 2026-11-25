<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

// --- DELETE PROJECT LOGIC ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Pehle image ka path get karein taki server se bhi delete ho sake
    $stmt = $pdo->prepare("SELECT image FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    $project = $stmt->fetch();
    
    if ($project && !empty($project['image']) && file_exists('../../' . $project['image'])) {
        unlink('../../assets/images/projects/' . $project['image']); // Server se image delete
    }

    // Database se project delete karein
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// --- ADD PROJECT LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $category = sanitize($_POST['category']);
    $link = sanitize($_POST['link']);
    $description = sanitize($_POST['description']);
    
    // Image Upload Logic
    $imagePath = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        // Agar uploads folder nahi hai toh bana dein
        if (!is_dir('../../assets/images/projects/' . $uploadDir)) {
            mkdir('../../assets/images/projects/' . $uploadDir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFilePath = '../../assets/images/projects/' . $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
            $imagePath = $uploadDir . $fileName; // DB me save karne ke liye relative path
        }
    }
    
    $stmt = $pdo->prepare("INSERT INTO projects (title, category, link, description, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $category, $link, $description, $imagePath]);
    
    // Page reload to prevent form resubmission
    header("Location: index.php");
    exit;
}

$projects = getProjects($pdo); // Make sure this function fetches all projects
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card { border: none; border-radius: 12px; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; transition: 0.3s; }
        .project-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Manage Projects</h2>
            <a href="../dashboard.php" class="btn btn-outline-secondary px-4 rounded-pill">Back to Dashboard</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-primary">Add New Project</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. E-commerce Website" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="" disabled selected>Select Category...</option>
                                <option value="Web">Web</option>
                                <option value="Mobile">Mobile</option>
                                <option value="Design">Design</option>
                                <option value="Branding">Branding</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Link (Optional)</label>
                            <input type="url" name="link" class="form-control" placeholder="https://...">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted small">Project Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Brief details about the project..."></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Save Project</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-dark">All Projects</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Link</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($projects)): ?>
                                <?php foreach($projects as $project): ?>
                                <tr>
                                    <td>
                                        <?php if(!empty($project['image'])): ?>
                                            <img src="../../assets/images/projects/<?php echo htmlspecialchars($project['image']); ?>" class="project-img shadow-sm" alt="Project">
                                        <?php else: ?>
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center project-img shadow-sm">No Img</div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-medium"><?php echo htmlspecialchars($project['title']); ?></td>
                                    <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars($project['category']); ?></span></td>
                                    <td>
                                        <?php if(!empty($project['link'])): ?>
                                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" class="text-decoration-none">View</a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="edit.php?id=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                                        <a href="?delete=<?php echo $project['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No projects found. Add one above!</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>