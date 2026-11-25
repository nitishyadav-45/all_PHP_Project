<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

// --- DELETE EDUCATION LOGIC ---
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM education WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// --- ADD EDUCATION LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institution = sanitize($_POST['institution']);
    $degree = sanitize($_POST['degree']);
    $description = sanitize($_POST['description']);
    
    // Only Year is coming from form, convert to valid MySQL DATE format (YYYY-01-01)
    $start_date = $_POST['start_year'] . '-01-01';
    
    // Check if currently studying
    $is_current = isset($_POST['is_current']) ? 1 : 0;
    
    // If currently studying, end_date is NULL, otherwise format the end year
    $end_date = ($is_current == 1 || empty($_POST['end_year'])) ? NULL : ($_POST['end_year'] . '-01-01');
    
    $stmt = $pdo->prepare("INSERT INTO education (institution, degree, start_date, end_date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$institution, $degree, $start_date, $end_date, $description]);
    
    header("Location: index.php");
    exit;
}

// Fetch all education records (Latest start date first)
$stmt = $pdo->query("SELECT * FROM education ORDER BY start_date DESC");
$educations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Education | Admin</title>
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
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-graduation-cap text-primary me-2"></i>Manage Education</h2>
            <a href="../dashboard.php" class="btn btn-outline-secondary px-4 rounded-pill">Back to Dashboard</a>
        </div>
        
        <div class="card shadow-sm mb-5">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-primary">Add New Qualification</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Institution / University</label>
                            <input type="text" name="institution" class="form-control" placeholder="e.g. Oxford University" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Degree / Certificate</label>
                            <input type="text" name="degree" class="form-control" placeholder="e.g. Bachelor of Science in Computer Science" required>
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">Start Year</label>
                            <input type="number" name="start_year" class="form-control" min="1950" max="2030" placeholder="YYYY" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small fw-bold">End Year</label>
                            <input type="number" name="end_year" id="end_year" class="form-control" min="1950" max="2030" placeholder="YYYY">
                        </div>

                        <div class="col-md-4 d-flex align-items-end pb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_current" id="is_current" value="1">
                                <label class="form-check-label ms-2 fw-medium text-dark" for="is_current">Currently Studying Here</label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label text-muted small fw-bold">Description / Achievements</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Key subjects, GPA, or honors..."></textarea>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">Save Education</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-semibold text-dark">Education History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Degree</th>
                                <th>Institution</th>
                                <th>Year</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($educations)): ?>
                                <?php foreach($educations as $edu): 
                                    // Extract just the Year from the Date
                                    $start_year_display = date('Y', strtotime($edu['start_date']));
                                    $end_year_display = !empty($edu['end_date']) ? date('Y', strtotime($edu['end_date'])) : 'Present';
                                ?>
                                <tr>
                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($edu['degree']); ?></td>
                                    <td class="text-muted"><?php echo htmlspecialchars($edu['institution']); ?></td>
                                    <td>
                                        <span class="small bg-light px-2 py-1 rounded border fw-medium">
                                            <?php echo $start_year_display; ?> - <?php echo $end_year_display; ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="edit.php?id=<?php echo $edu['id']; ?>" class="btn btn-sm btn-outline-primary me-2"><i class="fas fa-edit"></i></a>
                                        <a href="?delete=<?php echo $edu['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this education record?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No education details added yet.</td>
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
            const endYearInput = document.getElementById('end_year');

            currentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    endYearInput.value = ''; // Clear value
                    endYearInput.disabled = true; // Disable input
                } else {
                    endYearInput.disabled = false; // Enable input
                }
            });
        });
    </script>
</body>
</html>