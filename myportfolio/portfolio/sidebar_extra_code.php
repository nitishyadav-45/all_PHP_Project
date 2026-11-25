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

<div class="sidebar-wrapper bg-dark text-white p-3 d-none d-lg-flex flex-column justify-content-between">
    <div>
        <a href="../admin/dashboard.php"
            class="d-flex align-items-center mb-3 text-white text-decoration-none gap-2 px-2 mt-2">
            <i class="bi bi-shield-lock-fill fs-4 text-primary"></i>
            <span class="fs-4 fw-bold">Nitish Admin</span>
        </a>
        <hr class="border-secondary my-3">

        <ul class="nav nav-pills flex-column mb-auto gap-1">
            <li class="nav-item">
                <a href="../admin/dashboard.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link active">
                    <i class="bi bi-speedometer2 fs-5 text-secondary"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../projects/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-folder-fill fs-5 text-secondary"></i>
                    <span>Projects</span>
                </a>
            </li>
            <li>
                <a href="../skills/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-code-slash fs-5 text-secondary"></i>
                    <span>Skills</span>
                </a>
            </li>
            <li>
                <a href="../education/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-mortarboard-fill fs-5 text-secondary"></i>
                    <span>Education</span>
                </a>
            </li>
            <li>
                <a href="../experience/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-briefcase-fill fs-5 text-secondary"></i>
                    <span>Experience</span>
                </a>
            </li>
            <li>
                <a href="../resume/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-file-earmark-person-fill fs-5 text-secondary"></i>
                    <span>Resume</span>
                </a>
            </li>
        </ul>
    </div>

    <div>
        <hr class="border-secondary my-3">
        <a href="../logout.php"
            class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
            <i class="bi bi-box-arrow-left fs-5"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar"
    aria-labelledby="mobileSidebarLabel" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title d-flex align-items-center gap-2 text-white" id="mobileSidebarLabel">
            <i class="bi bi-shield-lock-fill text-primary"></i> Nitish Admin
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-close="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column justify-content-between">
        <ul class="nav nav-pills flex-column mb-auto gap-1">
            <li class="nav-item">
                <a href="../admin/dashboard.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link active">
                    <i class="bi bi-speedometer2 fs-5"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="../projects/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-folder-fill fs-5"></i>
                    <span>Projects</span>
                </a>
            </li>
            <li>
                <a href="../skills/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-code-slash fs-5"></i>
                    <span>Skills</span>
                </a>
            </li>
            <li>
                <a href="../education/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                    <span>Education</span>
                </a>
            </li>
            <li>
                <a href="../experience/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-briefcase-fill fs-5"></i>
                    <span>Experience</span>
                </a>
            </li>
            <li>
                <a href="../resume/index.php"
                    class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
                    <i class="bi bi-file-earmark-person-fill fs-5"></i>
                    <span>Resume</span>
                </a>
            </li>
        </ul>

        <div>
            <hr class="border-secondary my-3">
            <a href="../logout.php"
                class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
                <i class="bi bi-box-arrow-left fs-5"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>



<style>
/* Sidebar Fixed Layout Structure */
.sidebar-wrapper {
    min-height: 100vh;
    width: 280px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 100;
}

/* Main Content Wrapper (Yeh lagana zaroori hai taaki sidebar content ko na dabaye) */
.main-content {
    margin-left: 280px;
    width: calc(100% - 280px);
    min-height: 100vh;
}

/* Links Hover & Transitions */
.sidebar-link {
    transition: all 0.2s ease-in-out;
}

.sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff !important;
}

.sidebar-link:hover i {
    color: #0d6efd !important;
    /* Icon turns Blue on hover */
}

/* Active State Template Class */
.sidebar-link.active {
    background-color: #0d6efd !important;
    color: white !important;
}

.sidebar-link.active i {
    color: white !important;
}

/* Logout Button Special Hover Effect */
.logout-link {
    transition: all 0.2s ease-in-out;
}

.logout-link:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545 !important;
}

/* Responsive Breakpoint: Hide desktop sidebar on mobile/tablet */
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