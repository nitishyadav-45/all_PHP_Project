



<!-- Sidebar Container -->
<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark h-100" style="min-height: 100vh;">

    <!-- Logo / Brand Section -->
    <a href="../admin/dashboard.php"
        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none gap-2">
        <i class="bi bi-shield-lock-fill fs-4 text-primary"></i>
        <span class="fs-4 fw-bold tracking-wide">Nitish Admin</span>
    </a>

    <hr class="border-secondary my-3">

    <!-- Navigation Menu Links -->
    <ul class="nav nav-pills flex-column mb-auto gap-1">

        <li class="nav-item">
            <a href="../admin/dashboard.php"
                class="nav-link text-white d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 sidebar-link">
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

    <hr class="border-secondary my-3">

    <!-- Logout Button at Bottom -->
    <div class="mb-2">
        <a href="../logout.php"
            class="nav-link text-danger d-flex align-items-center gap-3 py-2.5 px-3 rounded-3 logout-link fw-semibold">
            <i class="bi bi-box-arrow-left fs-5"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

<!-- Extra Styles for Hover and Active States -->
<style>
.sidebar-link {
    transition: all 0.2s ease-in-out;
}

.sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff !important;
}

.sidebar-link:hover i {
    color: #0d6efd !important;
    /* Changes icon color to bootstrap primary blue on hover */
}

.logout-link {
    transition: all 0.2s ease-in-out;
}

.logout-link:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545 !important;
}

/* Active State Helper Class (You can add 'active' class via PHP if matching current page) */
.sidebar-link.active {
    background-color: #0d6efd !important;
    color: white !important;
}

.sidebar-link.active i {
    color: white !important;
}
</style>