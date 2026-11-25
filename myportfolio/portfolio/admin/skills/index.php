<?php
require_once('../../config/auth.php');
require_once('../../config/db.php');

$result = mysqli_query(
    $conn,
    "SELECT * FROM skills ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
    body {
        background-color: #111827; /* डार्क कंसिस्टेंट बैकग्राउंड */
        color: #f3f4f6;
        overflow-x: hidden;
    }

    /* --- INTEGRATED SIDEBAR & LAYOUT STYLES --- */
    .sidebar-wrapper {
        min-height: 100vh;
        width: 280px;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
    }

    /* Main Content Wrapper - Sidebar ke space ko adjust karne ke liye */
    .main-content {
        margin-left: 280px;
        width: calc(100% - 280px);
        min-height: 100vh;
    }

    .sidebar-link {
        transition: all 0.2s ease-in-out;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff !important;
    }

    .sidebar-link:hover i {
        color: #0d6efd !important;
    }

    .sidebar-link.active {
        background-color: #0d6efd !important;
        color: white !important;
    }

    .sidebar-link.active i {
        color: white !important;
    }

    .logout-link {
        transition: all 0.2s ease-in-out;
    }

    .logout-link:hover {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545 !important;
    }

    /* --- PAGE CUSTOM STYLES --- */
    .card-custom {
        background-color: var(--card, #1f2937);
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .3);
    }

    .table-custom {
        background-color: transparent !important;
        color: var(--text, #fff) !important;
    }

    /* DataTables डार्क मोड फिक्स */
    .dataTables_wrapper .dataTables_length text,
    .dataTables_wrapper .dataTables_filter label,
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_info {
        color: #94a3b8 !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        background-color: #374151 !important;
        border: 1px solid #4b5563 !important;
        color: #fff !important;
        border-radius: 6px;
    }

    .page-link {
        background-color: var(--card, #1f2937) !important;
        border-color: #374151 !important;
        color: #fff !important;
    }

    .page-item.active .page-link {
        background: linear-gradient(45deg, var(--primary, #7c3aed), var(--secondary, #06b6d4)) !important;
        border: none;
    }

    .progress {
        background-color: #374151;
        height: 8px;
        border-radius: 5px;
    }

    /* Responsive Breakpoint Styles */
    @media (max-width: 991.98px) {
        .sidebar-wrapper {
            display: none;
        }
        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark d-lg-none px-3 sticky-top shadow-sm">
        <div class="container-fluid px-0">
            <a href="../admin/dashboard.php" class="navbar-brand d-flex align-items-center gap-2 m-0">
                <i class="bi bi-shield-lock-fill text-primary"></i>
                <span class="fw-bold fs-5">Nitish Admin</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="d-flex">

        <div class="sidebar-wrapper bg-dark text-white p-3 d-none d-lg-flex flex-column justify-content-between">
            <div>
                <a href="../admin/dashboard.php" class="d-flex align-items-center mb-3 text-white text-decoration-none gap-2 px-2 mt-2">
                    <i class="bi bi-shield-lock-fill fs-4 text-primary"></i>
                    <span class="fs-4 fw-bold">Nitish Admin</span>
                </a>
                <hr class="border-secondary my-3">

                <ul class="nav nav-pills flex-column mb-auto gap-1">
                    <li class="nav-item">
                        <a href="../admin/dashboard.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-speedometer2 fs-5 text-secondary"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../projects/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-folder-fill fs-5 text-secondary"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="../skills/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link active">
                            <i class="bi bi-code-slash fs-5 text-secondary"></i>
                            <span>Skills</span>
                        </a>
                    </li>
                    <li>
                        <a href="../education/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-mortarboard-fill fs-5 text-secondary"></i>
                            <span>Education</span>
                        </a>
                    </li>
                    <li>
                        <a href="../experience/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-briefcase-fill fs-5 text-secondary"></i>
                            <span>Experience</span>
                        </a>
                    </li>
                    <li>
                        <a href="../resume/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-file-earmark-person-fill fs-5 text-secondary"></i>
                            <span>Resume</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <hr class="border-secondary my-3">
                <a href="../logout.php" class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
                    <i class="bi bi-box-arrow-left fs-5"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

         <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 280px;">
            <div class="offcanvas-header border-bottom border-secondary">
                <h5 class="offcanvas-title d-flex align-items-center gap-2 text-white" id="mobileSidebarLabel">
                    <i class="bi bi-shield-lock-fill text-primary"></i> Nitish Admin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-close="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column justify-content-between">
                <ul class="nav nav-pills flex-column mb-auto gap-1">
                    <li class="nav-item">
                        <a href="../admin/dashboard.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-speedometer2 fs-5"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../projects/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-folder-fill fs-5"></i>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="../skills/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link active">
                            <i class="bi bi-code-slash fs-5"></i>
                            <span>Skills</span>
                        </a>
                    </li>
                    <li>
                        <a href="../education/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-mortarboard-fill fs-5"></i>
                            <span>Education</span>
                        </a>
                    </li>
                    <li>
                        <a href="../experience/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-briefcase-fill fs-5"></i>
                            <span>Experience</span>
                        </a>
                    </li>
                    <li>
                        <a href="../resume/index.php" class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                            <i class="bi bi-file-earmark-person-fill fs-5"></i>
                            <span>Resume</span>
                        </a>
                    </li>
                </ul>

                <div>
                    <hr class="border-secondary my-3">
                    <a href="../logout.php" class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
                        <i class="bi bi-box-arrow-left fs-5"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
        </div>  

        <div class="main-content p-3 p-md-4">
            <div class="container-fluid px-0">

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                    <div>
                        <h2 class="fw-bold m-0 text-white" style="letter-spacing: -0.5px;">
                            <i class="fa-solid fa-layer-group me-2 text-info"></i>Skills Management
                        </h2>
                        <p class="text-muted small mb-0">Manage your technical expertise and proficiency levels.</p>
                    </div>
                    <a href="add.php" class="btn btn-success d-flex align-items-center gap-2 px-4 py-2 fw-semibold shadow-sm" style="border-radius: 10px;">
                        <i class="fa-solid fa-plus"></i> Add New Skill
                    </a>
                </div>

                <div class="card card-custom p-4">
                    <div class="table-responsive">
                        <table id="skillTable" class="table table-custom table-hover align-middle mb-0">
                            <thead class="text-secondary border-bottom border-secondary">
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="40%">Skill Name</th>
                                    <th width="30%">Proficiency</th>
                                    <th width="20%" class="text-center">Actions</th>
                                </tr>
                            </table>
                            <tbody class="border-top-0">
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr class="border-bottom border-secondary border-opacity-25">
                                    <td class="fw-bold text-primary">#<?= $row['id'] ?></td>
                                    <td>
                                        <span class="fw-semibold text-white"><?= htmlspecialchars($row['skill_name']) ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar"
                                                    style="width: <?= $row['percentage'] ?>%; background: linear-gradient(45deg, var(--primary, #7c3aed), var(--secondary, #06b6d4));"
                                                    aria-valuenow="<?= $row['percentage'] ?>" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>
                                            </div>
                                            <span class="badge bg-dark text-info border border-secondary border-opacity-50"><?= $row['percentage'] ?>%</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1 px-3" title="Edit Skill">
                                                <i class="fa-solid fa-pen-to-square"></i> Edit
                                            </a>
                                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-3 delete-btn" title="Delete Skill">
                                                <i class="fa-solid fa-trash-can"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div> </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        $('#skillTable').DataTable({
            "responsive": true,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "searchPlaceholder": "Search skills...",
                "search": ""
            }
        });

        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            const deleteUrl = $(this).attr('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this skill deletion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7c3aed',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Yes, delete it!',
                background: '#1f2937',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });
    </script>

</body>

</html>