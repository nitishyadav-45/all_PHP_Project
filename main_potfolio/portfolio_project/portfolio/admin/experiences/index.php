<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

// --- DELETE EXPERIENCE LOGIC ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM experiences WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// --- ADD EXPERIENCE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company = sanitize($_POST['company']);
    $position = sanitize($_POST['position']);
    $start_date = $_POST['start_date'];
    $description = sanitize($_POST['description']);
    
    // Check if currently working
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    
    // If currently working, end_date should be NULL, otherwise take the input
    $end_date = ($is_current == 1 || empty($_POST['end_date'])) ? NULL : $_POST['end_date'];
    
    $stmt = $pdo->prepare("INSERT INTO experiences (company, position, start_date, end_date, is_current, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$company, $position, $start_date, $end_date, $is_current, $description]);
    
    header("Location: index.php");
    exit;
}

// Fetch all experiences (Latest start date first)
$stmt = $pdo->query("SELECT * FROM experiences ORDER BY start_date DESC");
$experiences = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Experiences | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { border: none; border-radius: 12px; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; transition: 0.3s; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-briefcase text-primary me-2"></i>Manage Experience</h2>
            <a href="../dashboard.php" class="btn btn-outline-secondary px-4 rounded-pill">Back to Dashboard</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-primary">Add New Experience</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Company Name</label>
                            <input type="text" name="company" class="form-control" placeholder="e.g. Google, Microsoft" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Position / Job Title</label>
                            <input type="text" name="position" class="form-control" placeholder="e.g. Senior Web Developer" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        <div class="col-md-4 d-flex align-items-end pb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1">
                                <label class="form-check-label ms-2 fw-medium text-dark" for="is_current">I currently work here</label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Job Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Describe your responsibilities and achievements..."></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Save Experience</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-dark">Work History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Position</th>
                                <th>Company</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($experiences)): ?>
                                <?php foreach($experiences as $exp): ?>
                                <tr>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($exp['position']); ?></td>
                                    <td class="text-muted"><?php echo htmlspecialchars($exp['company']); ?></td>
                                    <td>
                                        <span class="small bg-light px-2 py-1 rounded border">
                                            <?php echo date('M Y', strtotime($exp['start_date'])); ?> - 
                                            <?php echo $exp['is_current'] ? 'Present' : date('M Y', strtotime($exp['end_date'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($exp['is_current']): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success">Current</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">Past</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="edit.php?id=<?php echo $exp['id']; ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                                        <a href="?delete=<?php echo $exp['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this experience?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No work experience added yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentCheckbox = document.getElementById('is_current');
            const endDateInput = document.getElementById('end_date');

            currentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    endDateInput.value = ''; // Clear the date
                    endDateInput.disabled = true; // Disable input
                } else {
                    endDateInput.disabled = false; // Enable input
                }
            });
        });
    </script>
</body>
</html>