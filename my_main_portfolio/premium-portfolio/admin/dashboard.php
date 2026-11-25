<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

$stats = [
    'projects' => (int) db()->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
    'messages' => (int) db()->query('SELECT COUNT(*) FROM messages')->fetchColumn(),
    'unread' => (int) db()->query('SELECT COUNT(*) FROM messages WHERE is_read = 0')->fetchColumn(),
    'views' => (int) db()->query('SELECT COUNT(*) FROM site_views')->fetchColumn(),
];

$recentMessages = db()->query('SELECT * FROM messages ORDER BY created_at DESC LIMIT 5')->fetchAll();
$recentProjects = db()->query('SELECT title, category, is_active, created_at FROM projects ORDER BY created_at DESC LIMIT 5')->fetchAll();

$adminPageTitle = 'Overview';
$activeMenu = 'dashboard';
include __DIR__ . '/../includes/admin-header.php';
?>

<div class="stat-grid">
    <article class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-layer-group"></i></div>
        <span>Total Projects</span>
        <strong><?= $stats['projects'] ?></strong>
    </article>
    <article class="stat-card">
        <div class="stat-icon accent"><i class="fa-solid fa-envelope"></i></div>
        <span>Total Messages</span>
        <strong><?= $stats['messages'] ?></strong>
    </article>
    <article class="stat-card">
        <div class="stat-icon warm"><i class="fa-solid fa-bell"></i></div>
        <span>Unread Messages</span>
        <strong><?= $stats['unread'] ?></strong>
    </article>
    <article class="stat-card">
        <div class="stat-icon green"><i class="fa-solid fa-eye"></i></div>
        <span>Total Views</span>
        <strong><?= $stats['views'] ?></strong>
    </article>
</div>

<div class="row g-4 mt-1">
    <div class="col-xl-7">
        <section class="admin-card">
            <div class="card-heading">
                <div>
                    <span>Inbox</span>
                    <h2>Recent Messages</h2>
                </div>
                <a href="<?= url('admin/messages.php') ?>" class="btn btn-sm btn-outline-admin">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table align-middle">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($recentMessages as $message): ?>
                        <tr>
                            <td><?= e($message['name']) ?></td>
                            <td><?= e(plain_excerpt($message['subject'], 48)) ?></td>
                            <td><?= e(date('M d, Y', strtotime($message['created_at']))) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$recentMessages): ?>
                        <tr><td colspan="3" class="text-center text-muted py-4">No messages yet.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <div class="col-xl-5">
        <section class="admin-card">
            <div class="card-heading">
                <div>
                    <span>Portfolio</span>
                    <h2>Latest Projects</h2>
                </div>
                <a href="<?= url('admin/projects.php') ?>" class="btn btn-sm btn-admin-primary">Add Project</a>
            </div>
            <div class="activity-list">
                <?php foreach ($recentProjects as $project): ?>
                    <div class="activity-item">
                        <div class="activity-dot"></div>
                        <div>
                            <strong><?= e($project['title']) ?></strong>
                            <span><?= e($project['category']) ?> · <?= $project['is_active'] ? 'Published' : 'Draft' ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (!$recentProjects): ?>
                    <p class="text-muted mb-0">No projects yet.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>

