<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

$projects = db()->query('SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC')->fetchAll();

$adminPageTitle = 'Manage Portfolio';
$activeMenu = 'projects';
include __DIR__ . '/../includes/admin-header.php';
?>

<section class="admin-card">
    <div class="card-heading">
        <div>
            <span>Projects</span>
            <h2>Portfolio CRUD</h2>
        </div>
        <button class="btn btn-admin-primary" type="button" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <i class="fa-solid fa-plus me-2"></i>New Project
        </button>
    </div>

    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
            <tr>
                <th>Project</th>
                <th>Category</th>
                <th>Status</th>
                <th>Order</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td>
                        <div class="project-row">
                            <img src="<?= url($project['image_path'] ?: 'assets/images/projects/project-1.png') ?>" alt="<?= e($project['title']) ?>">
                            <div>
                                <strong><?= e($project['title']) ?></strong>
                                <span><?= e(plain_excerpt($project['short_description'], 74)) ?></span>
                            </div>
                        </div>
                    </td>
                    <td><?= e($project['category']) ?></td>
                    <td>
                        <span class="status-pill <?= $project['is_active'] ? 'published' : 'draft' ?>">
                            <?= $project['is_active'] ? 'Published' : 'Draft' ?>
                        </span>
                    </td>
                    <td><?= (int) $project['sort_order'] ?></td>
                    <td class="text-end">
                        <button class="icon-button small" type="button" data-bs-toggle="modal" data-bs-target="#editProjectModal<?= (int) $project['id'] ?>" aria-label="Edit project">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <form action="<?= url('actions/project_delete.php') ?>" method="post" class="d-inline confirm-delete">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">
                            <button class="icon-button small danger" type="submit" aria-label="Delete project">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$projects): ?>
                <tr><td colspan="5" class="text-center text-muted py-5">No projects yet. Add your first featured work.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<div class="modal fade admin-modal" id="createProjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form class="modal-content" action="<?= url('actions/project_store.php') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h2 class="modal-title">Create Project</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php unset($project); include __DIR__ . '/../includes/project-form-fields.php'; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-admin" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-admin-primary">Save Project</button>
            </div>
        </form>
    </div>
</div>

<?php foreach ($projects as $project): ?>
    <div class="modal fade admin-modal" id="editProjectModal<?= (int) $project['id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <form class="modal-content" action="<?= url('actions/project_update.php') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= (int) $project['id'] ?>">
                <div class="modal-header">
                    <h2 class="modal-title">Edit Project</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/../includes/project-form-fields.php'; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-admin" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-primary">Update Project</button>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>
