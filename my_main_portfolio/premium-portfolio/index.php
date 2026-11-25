<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/functions.php';

record_page_view(db(), 'home');

$profile = profile_settings(db());
$projectsStmt = db()->query('SELECT * FROM projects WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, created_at DESC');
$projects = $projectsStmt->fetchAll();
$categories = array_values(array_unique(array_filter(array_map(static fn ($project) => $project['category'] ?? '', $projects))));
$typingWords = [
    $profile['headline'] ?? 'Full-Stack Web Developer',
    'UI-focused Engineer',
    'PHP/MySQL Specialist',
    'Dashboard Builder',
];

$skills = [
    ['name' => 'PHP / MySQL', 'level' => 92],
    ['name' => 'JavaScript ES6+', 'level' => 88],
    ['name' => 'Bootstrap / UI Systems', 'level' => 95],
    ['name' => 'API Design', 'level' => 84],
];

$services = [
    ['icon' => 'fa-code', 'title' => 'Web Development', 'text' => 'Responsive websites and admin systems with clean architecture, secure forms, and scalable PHP/MySQL foundations.'],
    ['icon' => 'fa-pen-nib', 'title' => 'UI/UX Engineering', 'text' => 'Polished interfaces, interaction states, motion design, and design systems that make products feel premium.'],
    ['icon' => 'fa-gauge-high', 'title' => 'Performance Optimization', 'text' => 'Fast pages, optimized assets, careful database queries, and measurable improvements across devices.'],
    ['icon' => 'fa-lock', 'title' => 'Secure Backends', 'text' => 'Authentication, session handling, upload validation, CSRF protection, and pragmatic production hardening.'],
];

$experience = [
    ['year' => '2026', 'title' => 'Senior Full-Stack Developer', 'text' => 'Building robust web platforms, dashboards, and customer-facing experiences.'],
    ['year' => '2024', 'title' => 'Product UI Engineer', 'text' => 'Delivered responsive interfaces, component systems, and conversion-focused product flows.'],
    ['year' => '2022', 'title' => 'Backend Developer', 'text' => 'Created secure PHP/MySQL systems, admin panels, reporting tools, and integrations.'],
];

$pageTitle = 'Home';
include __DIR__ . '/includes/public-header.php';
?>

<section class="hero-section" id="home">
    <div class="hero-visual-grid" aria-hidden="true"></div>
    <div class="container position-relative">
        <div class="row align-items-center min-vh-100 py-5 gy-5">
            <div class="col-lg-7" data-aos="fade-right">
                <span class="eyebrow"><i class="fa-solid fa-sparkles me-2"></i>Available for premium web projects</span>
                <h1 class="hero-title animate__animated animate__fadeInUp">
                    Hi, I am <?= e($profile['full_name']) ?>.
                    <span class="text-gradient typing-line"
                        data-typing='<?= e(json_encode($typingWords, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)) ?>'></span>
                </h1>
                <p class="hero-copy"><?= e($profile['tagline']) ?></p>
                <div class="hero-actions">
                    <a class="btn btn-primary-glow" href="<?= url('download_cv.php') ?>">
                        <i class="fa-solid fa-download me-2"></i>Download CV
                    </a>
                    <a class="btn btn-outline-light" href="#portfolio">
                        <i class="fa-solid fa-layer-group me-2"></i>View Projects
                    </a>
                </div>
                <div class="hero-stats">
                    <div><strong>7+</strong><span>Years</span></div>
                    <div><strong>60+</strong><span>Projects</span></div>
                    <div><strong>24/7</strong><span>Support</span></div>
                </div>
            </div>
            <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="150">
                <div class="portrait-shell">
                    <img src="<?= url($profile['avatar_path'] ?: 'assets/images/profile-portrait.png') ?>"
                        alt="<?= e($profile['full_name']) ?>" class="img-fluid portrait-img">
                    <div class="floating-card top-card">
                        <i class="fa-solid fa-bolt"></i>
                        <span>Fast delivery</span>
                    </div>
                    <div class="floating-card bottom-card">
                        <i class="fa-solid fa-shield-heart"></i>
                        <span>Secure code</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($message = flash('success')): ?>
<div class="container pt-4">
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>
<?php if ($message = flash('error')): ?>
<div class="container pt-4">
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <?= e($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>

<section class="section-pad" id="about">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5" data-aos="fade-up">
                <span class="section-kicker">About Me</span>
                <h2 class="section-title">Clean code, thoughtful interfaces, real business outcomes.</h2>
                <p class="section-copy"><?= nl2br(e($profile['bio'])) ?></p>
                <div class="contact-mini">
                    <a href="mailto:<?= e($profile['email']) ?>"><i
                            class="fa-solid fa-envelope"></i><?= e($profile['email']) ?></a>
                    <a href="tel:<?= e($profile['phone']) ?>"><i
                            class="fa-solid fa-phone"></i><?= e($profile['phone']) ?></a>
                    <span><i class="fa-solid fa-location-dot"></i><?= e($profile['location']) ?></span>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                <div class="skills-panel">
                    <?php foreach ($skills as $skill): ?>
                    <div class="skill-item">
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= e($skill['name']) ?></span>
                            <span><?= (int) $skill['level'] ?>%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" data-progress="<?= (int) $skill['level'] ?>"
                                style="width: 0%" aria-valuenow="<?= (int) $skill['level'] ?>" aria-valuemin="0"
                                aria-valuemax="100"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="timeline-grid mt-5">
            <?php foreach ($experience as $item): ?>
            <article class="timeline-card" data-aos="fade-up">
                <span><?= e($item['year']) ?></span>
                <h3><?= e($item['title']) ?></h3>
                <p><?= e($item['text']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad section-muted" id="services">
    <div class="container">
        <div class="section-heading text-center" data-aos="fade-up">
            <span class="section-kicker">Services</span>
            <h2 class="section-title">Everything a polished web product needs.</h2>
        </div>
        <div class="row g-4 mt-2">
            <?php foreach ($services as $service): ?>
            <div class="col-md-6 col-xl-3" data-aos="fade-up">
                <article class="service-card">
                    <div class="icon-ring"><i class="fa-solid <?= e($service['icon']) ?>"></i></div>
                    <h3><?= e($service['title']) ?></h3>
                    <p><?= e($service['text']) ?></p>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-pad" id="portfolio">
    <div class="container">
        <div class="row align-items-end gy-3 mb-4">
            <div class="col-lg-7" data-aos="fade-up">
                <span class="section-kicker">Portfolio</span>
                <h2 class="section-title">Selected projects with real-world polish.</h2>
            </div>
            <div class="col-lg-5" data-aos="fade-up" data-aos-delay="100">
                <div class="filter-bar">
                    <button class="filter-btn active" type="button" data-filter="all">All</button>
                    <?php foreach ($categories as $category): ?>
                    <button class="filter-btn" type="button"
                        data-filter="<?= e(strtolower($category)) ?>"><?= e($category) ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="row g-4 portfolio-grid">
            <?php foreach ($projects as $project): ?>
            <?php $filter = strtolower($project['category'] ?: 'general'); ?>
            <div class="col-md-6 col-xl-4 portfolio-item" data-category="<?= e($filter) ?>" data-aos="zoom-in">
                <article class="project-card">
                    <img src="<?= url($project['image_path'] ?: 'assets/images/projects/project-1.png') ?>"
                        alt="<?= e($project['title']) ?>">
                    <div class="project-content">
                        <span><?= e($project['category']) ?></span>
                        <h3><?= e($project['title']) ?></h3>
                        <p><?= e($project['short_description']) ?></p>
                        <button class="project-link" type="button" data-bs-toggle="modal"
                            data-bs-target="#projectModal<?= (int) $project['id'] ?>">
                            View Details <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </article>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php foreach ($projects as $project): ?>
<div class="modal fade project-modal" id="projectModal<?= (int) $project['id'] ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <img src="<?= url($project['image_path'] ?: 'assets/images/projects/project-1.png') ?>"
                alt="<?= e($project['title']) ?>" class="modal-project-img">
            <div class="modal-body p-4 p-lg-5">
                <span class="section-kicker"><?= e($project['category']) ?></span>
                <h2 class="mb-3"><?= e($project['title']) ?></h2>
                <p><?= nl2br(e($project['description'])) ?></p>
                <?php if (!empty($project['technologies'])): ?>
                <div class="tech-stack">
                    <?php foreach (array_filter(array_map('trim', explode(',', $project['technologies']))) as $tech): ?>
                    <span><?= e($tech) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <?php if (!empty($project['project_url'])): ?>
                    <a class="btn btn-primary-glow" href="<?= e($project['project_url']) ?>" target="_blank"
                        rel="noopener"><i class="fa-solid fa-up-right-from-square me-2"></i>Live Project</a>
                    <?php endif; ?>
                    <?php if (!empty($project['github_url'])): ?>
                    <a class="btn btn-outline-dark" href="<?= e($project['github_url']) ?>" target="_blank"
                        rel="noopener"><i class="fa-brands fa-github me-2"></i>Source Code</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<section class="section-pad contact-section" id="contact">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <span class="section-kicker">Contact</span>
                <h2 class="section-title">Let us build something sharp.</h2>
                <p class="section-copy">Send a message and it will be stored in the dashboard while also triggering an
                    email notification when mail is configured on the server.</p>
                <div class="contact-stack">
                    <a href="mailto:<?= e($profile['email']) ?>"><i
                            class="fa-solid fa-envelope"></i><?= e($profile['email']) ?></a>
                    <a href="tel:<?= e($profile['phone']) ?>"><i
                            class="fa-solid fa-phone"></i><?= e($profile['phone']) ?></a>
                    <span><i class="fa-solid fa-map-location-dot"></i><?= e($profile['location']) ?></span>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <form class="contact-form" action="<?= url('actions/contact_submit.php') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="text" name="website" class="honeypot" tabindex="-1" autocomplete="off">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required maxlength="120">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required maxlength="160">
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required
                                maxlength="180">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required
                                maxlength="3000"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary-glow w-100" type="submit">
                                <i class="fa-solid fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/public-footer.php'; ?>