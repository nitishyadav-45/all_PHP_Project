<?php
require_once 'includes/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Handle Project Deletion
if (isset($_GET['delete_project']) && validate_csrf($_GET['token'])) {
    $id = (int)$_GET['delete_project'];
    $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin.php?status=deleted');
    exit;
}

// Handle Adding Project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    if (validate_csrf($_POST['csrf_token'])) {
        $title = sanitize($_POST['title']);
        $description = sanitize($_POST['description']);
        $link = sanitize($_POST['link']);
        $tech = sanitize($_POST['tech_stack']);
        
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, link, tech_stack) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $link, $tech]);
        header('Location: admin.php?status=added');
        exit;
    }
}

// Fetch Data
$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-dark text-white">
    <nav class="navbar navbar-dark bg-black mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            <a href="?logout=1" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <!-- Project Management -->
            <div class="col-md-8">
                <div class="glass-card p-4 mb-4">
                    <h4 class="mb-4">Manage Projects</h4>
                    <form method="POST" class="mb-4">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control glass-input" placeholder="Project Title" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="tech_stack" class="form-control glass-input" placeholder="Tech Stack (comma separated)">
                            </div>
                            <div class="col-12">
                                <textarea name="description" class="form-control glass-input" placeholder="Description" required></textarea>
                            </div>
                            <div class="col-12">
                                <input type="url" name="link" class="form-control glass-input" placeholder="Project Link">
                            </div>
                            <div class="col-12">
                                <button type="submit" name="add_project" class="btn btn-success w-100">Add Project</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Stack</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projects as $p): ?>
                                <tr>
                                    <td><?php echo $p['title']; ?></td>
                                    <td><?php echo $p['tech_stack']; ?></td>
                                    <td>
                                        <a href="?delete_project=<?php echo $p['id']; ?>&token=<?php echo $_SESSION['csrf_token']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="col-md-4">
                <div class="glass-card p-4">
                    <h4 class="mb-4">Recent Messages</h4>
                    <?php if (empty($messages)): ?>
                        <p class="text-white-50">No messages yet.</p>
                    <?php else: ?>
                        <?php foreach ($messages as $m): ?>
                        <div class="border-bottom border-secondary mb-3 pb-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0"><?php echo $m['name']; ?></h6>
                                <small class="text-white-50"><?php echo date('M d', strtotime($m['created_at'])); ?></small>
                            </div>
                            <p class="small text-primary mb-1"><?php echo $m['email']; ?></p>
                            <p class="small mb-0 text-white-50"><?php echo $m['message']; ?></p>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
