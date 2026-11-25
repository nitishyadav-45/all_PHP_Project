<?php
// Required files and authentication
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

// Fetch services from the database using PDO
$query = "SELECT * FROM services ORDER BY id DESC";
$stmt = $pdo->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Dashboard</span>
            <a href="../../logout.php" class="btn btn-sm btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 text-secondary"><i class="fa-solid fa-bell-concierge me-2"></i>Manage Services</h2>
            <a href="create.php" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Add New Service
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" width="5%">ID</th>
                                <th scope="col" width="10%">Icon</th>
                                <th scope="col" width="25%">Service Name</th>
                                <th scope="col" width="40%">Description</th>
                                <th scope="col" width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php if ($stmt->rowCount() > 0): ?>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                
                <td>
                    <?php 
                    $icon_data = $row['icon'];
                    $img_src = '';
                    
                    // Check if the data is a valid URL (http:// or https://)
                    if (filter_var($icon_data, FILTER_VALIDATE_URL)) {
                        $img_src = htmlspecialchars($icon_data); // Direct link
                    } else {
                        // Agar URL nahi hai, toh matlab local file hai
                        $img_src = '../../assets/images/services/' . htmlspecialchars($icon_data);
                    }
                    ?>
                    
                    <?php if (!empty($icon_data)): ?>
                        <img src="<?php echo $img_src; ?>" alt="Service Icon" width="50" height="50" style="object-fit: contain;">
                    <?php else: ?>
                        <span class="text-muted small">No Image</span>
                    <?php endif; ?>
                </td>
                
                <td class="fw-bold"><?php echo htmlspecialchars($row['service_name']); ?></td>
                
                <td class="text-start">
                    <?php echo htmlspecialchars(substr($row['description'], 0, 80)) . '...'; ?>
                </td>
                
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success mb-1">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Are you sure?');">
                        <i class="fa-solid fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="text-muted py-4">No services found. Click "Add New Service" to create one.</td>
        </tr>
    <?php endif; ?>
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>