<?php
require_once '../config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    redirect('../admin_login.php');
}

$user = getUserData();
$services = getAllServices();
$skills = getAllSkills();
$projects = getAllProjects();
$testimonials = getAllTestimonials();

// Get contact messages count
$messages_query = "SELECT COUNT(*) as count FROM contact_messages";
$messages_result = $conn->query($messages_query);
$messages_count = $messages_result->fetch_assoc()['count'];

// Set default profile image if none exists in database
$user_avatar = (!empty($user['profile_image']) && file_exists('../uploads/' . $user['profile_image'])) 
    ? '../uploads/' . $user['profile_image'] 
    : 'https://via.placeholder.com/150';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            background: #f4f6f9;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden; /* Prevents global horizontal layout breaking */
            width: 100%;
        }
        
        /* Desktop Sidebar Styling */
        .sidebar-desktop {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 25px 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            color: white;
            z-index: 1000;
        }
        
        /* Mobile Offcanvas Sidebar Styling */
        .offcanvas-sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            width: 280px;
        }
        
        .sidebar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-profile {
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            margin-bottom: 25px;
        }
        
        .sidebar-profile img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        
        .sidebar-menu li a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(5px);
        }
        
        /* Main Layout Content Area */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            transition: all 0.3s ease;
            width: calc(100% - 260px);
        }
        
        /* Top Navigation Header bar */
        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        
        .top-navbar h1 {
            margin: 0;
            font-size: 1.6rem;
            color: #2d3436;
            font-weight: 700;
        }
        
        /* Navbar Profile Dropdown Menu Styling */
        .nav-profile-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .nav-profile-img {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid #667eea;
        }
        
        .dropdown-menu-custom {
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 15px;
            min-width: 230px;
        }
        
        /* Data Statistics Section Layout Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            text-align: center;
            border-bottom: 4px solid #667eea;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card h3 {
            font-size: 2.2rem;
            color: #2d3436;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card p {
            color: #888;
            margin: 0;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .content-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
        }
        
        .content-section h2 {
            margin-bottom: 20px;
            color: #2d3436;
            font-weight: 700;
            font-size: 1.3rem;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        /* Modernized Data Tables Styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table thead {
            background: #f8f9fa;
        }
        
        table th {
            padding: 14px;
            text-align: left;
            color: #2d3436;
            font-weight: 600;
            border-bottom: 2px solid #edf2f7;
            white-space: nowrap;
        }
        
        table td {
            padding: 14px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
            color: #4a5568;
            white-space: nowrap;
        }
        
        .action-btn {
            padding: 6px 14px;
            margin-right: 5px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-edit {
            background: #ebf8ff;
            color: #2b6cb0;
        }
        
        .btn-edit:hover {
            background: #2b6cb0;
            color: white;
        }
        
        .btn-delete {
            background: #fff5f5;
            color: #c53030;
        }
        
        .btn-delete:hover {
            background: #c53030;
            color: white;
        }
        
        /* Responsive Framework View Breaks */
        @media (max-width: 991px) {
            .sidebar-desktop {
                display: none;
            }
            .main-content {
                margin-left: 0;
                padding: 15px;
                width: 100%;
            }
            .top-navbar {
                padding: 15px;
                margin-bottom: 20px;
            }
            .content-section {
                padding: 15px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar-desktop">
        <div class="sidebar-brand">
            <i class="bi bi-speedometer2"></i> Admin Panel
        </div>
        <div class="sidebar-profile d-flex align-items-center gap-3">
            <img src="<?php echo $user_avatar; ?>" class="rounded-circle" alt="Avatar">
            <div>
                <h6 class="mb-0 fw-bold text-truncate" style="max-width: 140px;"><?php echo htmlspecialchars($user['name']); ?></h6>
                <small class="opacity-75">Administrator</small>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php" class="active"><i class="bi bi-house"></i> Dashboard</a></li>
            <li><a href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
            <li><a href="services.php"><i class="bi bi-briefcase"></i> Services</a></li>
            <li><a href="skills.php"><i class="bi bi-star"></i> Skills</a></li>
            <li><a href="projects.php"><i class="bi bi-folder"></i> Projects</a></li>
            <li><a href="testimonials.php"><i class="bi bi-chat-quote"></i> Testimonials</a></li>
            <li><a href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
            <li><a href="../admin_logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
    </div>

    <div class="offcanvas offcanvas-start offcanvas-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header border-0">
            <h5 class="offcanvas-title text-white fw-bold" id="mobileSidebarLabel"><i class="bi bi-speedometer2 me-2"></i> Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body px-4">
            <div class="sidebar-profile d-flex align-items-center gap-3">
                <img src="<?php echo $user_avatar; ?>" class="rounded-circle" alt="Avatar">
                <div>
                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($user['name']); ?></h6>
                    <small class="opacity-75">Administrator</small>
                </div>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard.php" class="active"><i class="bi bi-house"></i> Dashboard</a></li>
                <li><a href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
                <li><a href="services.php"><i class="bi bi-briefcase"></i> Services</a></li>
                <li><a href="skills.php"><i class="bi bi-star"></i> Skills</a></li>
                <li><a href="projects.php"><i class="bi bi-folder"></i> Projects</a></li>
                <li><a href="testimonials.php"><i class="bi bi-chat-quote"></i> Testimonials</a></li>
                <li><a href="messages.php"><i class="bi bi-envelope"></i> Messages</a></li>
                <li><a href="../admin_logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        
        <div class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none text-dark fs-4 px-2 py-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1>Dashboard</h1>
                </div>
            </div>
            
            <div class="dropdown nav-profile-dropdown">
                <div class="dropdown-toggle d-flex align-items-center gap-2" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $user_avatar; ?>" class="nav-profile-img" alt="User Profile Image">
                    <span class="d-none d-md-inline fw-semibold text-dark m-0"><?php echo htmlspecialchars($user['name']); ?> <i class="bi bi-chevron-down small text-muted ms-1"></i></span>
                </div>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom m-0 mt-2 shadow-lg" aria-labelledby="profileDropdown">
                    <li class="px-2 py-1 mb-2 border-bottom pb-2">
                        <div class="d-flex align-items-center gap-2">
                            <img src="<?php echo $user_avatar; ?>" style="width:40px; height:40px; object-fit:cover; border-radius:50%;" alt="Menu Avatar">
                            <div style="max-width: 150px;">
                                <h6 class="mb-0 fw-bold text-truncate text-dark" style="font-size:0.9rem;"><?php echo htmlspecialchars($user['name']); ?></h6>
                                <p class="mb-0 text-muted text-truncate" style="font-size:0.8rem;"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                    </li>
                    <li><a class="dropdown-item py-2 text-dark fw-medium rounded-2" href="profile.php"><i class="bi bi-person me-2 text-primary"></i> My Profile</a></li>
                    <li><a class="dropdown-item py-2 text-dark fw-medium rounded-2" href="messages.php"><i class="bi bi-envelope me-2 text-success"></i> Inbox Messages</a></li>
                    <li><hr class="dropdown-divider my-2 opacity-50"></li>
                    <li><a class="dropdown-item py-2 text-danger fw-medium rounded-2" href="../admin_logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sign Out</a></li>
                </ul>
            </div>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo count($projects); ?></h3>
                <p>Total Projects</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count($services); ?></h3>
                <p>Services Provided</p>
            </div>
            <div class="stat-card">
                <h3><?php echo count($skills); ?></h3>
                <p>Technical Skills</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $messages_count; ?></h3>
                <p>Inquiry Messages</p>
            </div>
        </div>
        
        <div class="content-section">
            <h2>Quick Actions Shortcut</h2>
            <div class="row g-2">
                <div class="col-xl-3 col-sm-6">
                    <a href="profile.php" class="btn btn-add w-100 py-2 text-truncate">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profile Info
                    </a>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <a href="projects.php" class="btn btn-add w-100 py-2 text-truncate">
                        <i class="bi bi-plus-lg me-1"></i> Add New Project
                    </a>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <a href="services.php" class="btn btn-add w-100 py-2 text-truncate">
                        <i class="bi bi-plus-lg me-1"></i> Add New Service
                    </a>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <a href="messages.php" class="btn btn-add w-100 py-2 text-truncate">
                        <i class="bi bi-envelope-open me-1"></i> Read Messages
                    </a>
                </div>
            </div>
        </div>
        
        <div class="content-section">
            <h2>Recent Projects Matrix</h2>
            <?php if (count($projects) > 0): ?>
                <div class="table-responsive w-100">
                    <table class="table align-middle m-0">
                        <thead>
                            <tr>
                                <th>Project Title</th>
                                <th>Category Domain</th>
                                <th>Timestamp</th>
                                <th>Management Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($projects, 0, 5) as $project): ?>
                                <tr>
                                    <td class="fw-semibold text-dark"><?php echo htmlspecialchars($project['title']); ?></td>
                                    <td><span class="badge bg-secondary px-2.5 py-1.5"><?php echo htmlspecialchars($project['category_name'] ?? 'Uncategorized'); ?></span></td>
                                    <td class="text-muted"><?php echo date('M d, Y', strtotime($project['created_at'])); ?></td>
                                    <td>
                                        <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="action-btn btn-edit"><i class="bi bi-pencil"></i> Edit</a>
                                        <button type="button" class="action-btn btn-delete" onclick="confirmDelete('delete_project.php?id=<?php echo $project['id']; ?>', 'the project \'<?php echo addslashes($project['title']); ?>\'')">
                                            <i class="bi bi-trash3"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted m-0">No records found. <a href="projects.php" class="text-primary fw-medium">Upload your first portfolio item</a></p>
            <?php endif; ?>
        </div>

        <div class="content-section">
            <h2>Technical Proficiency Matrix</h2>
            <?php if (count($skills) > 0): ?>
                <div class="table-responsive w-100">
                    <table class="table align-middle m-0">
                        <thead>
                            <tr>
                                <th>Skill Element Name</th>
                                <th>Proficiency Spectrum Metric</th>
                                <th>Management Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($skills as $skill): ?>
                                <tr>
                                    <td class="fw-semibold text-dark"><?php echo htmlspecialchars($skill['name']); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="progress flex-grow-1" style="height: 10px; min-width: 120px; max-width: 200px; border-radius:10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $skill['percentage']; ?>%; border-radius:10px;"></div>
                                            </div>
                                            <span class="fw-bold text-dark fs-6" style="min-width: 45px;"><?php echo $skill['percentage']; ?>%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="edit_skill.php?id=<?php echo $skill['id']; ?>" class="action-btn btn-edit">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <button type="button" class="action-btn btn-delete" onclick="confirmDelete('delete_skill.php?id=<?php echo $skill['id']; ?>', 'the skill \'<?php echo addslashes($skill['name']); ?>\'')">
                                            <i class="bi bi-trash3"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted m-0">No technical skills recorded yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: none; border-radius: 16px; box-shadow: 0 15px 35px rgba(0,0,0,0.12);">
                <div class="modal-header border-0 bg-light" style="border-radius: 16px 16px 0 0; padding: 20px;">
                    <h5 class="modal-title fw-bold text-dark" id="deleteModalLabel"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> System Security Check</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4 p-md-5">
                    <div class="text-danger mb-3" style="font-size: 3.5rem;">
                        <i class="bi bi-shield-x"></i>
                    </div>
                    <p class="fs-4 mb-2 fw-bold text-dark">Confirm Data Purging</p>
                    <p class="text-muted m-0 fs-6">Are you completely certain you want to erase <span id="deleteItemName" class="fw-bold text-danger"></span>? This structural transaction is absolute and cannot be rolled back.</p>
                </div>
                <div class="modal-footer border-0 bg-light d-flex justify-content-center gap-3" style="border-radius: 0 0 16px 16px; padding: 20px;">
                    <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-weight: 600;">Cancel Operations</button>
                    <a href="#" id="finalDeleteBtn" class="btn btn-danger px-4 py-2" style="border-radius: 8px; font-weight: 600; background: #e53e3e; border: none;">Purge Records</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function confirmDelete(deleteUrl, itemName) {
        document.getElementById('deleteItemName').innerText = itemName;
        document.getElementById('finalDeleteBtn').setAttribute('href', deleteUrl);
        var myModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        myModal.show();
    }
    </script>
</body>
</html>