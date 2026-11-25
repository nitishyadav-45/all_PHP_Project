<?php
declare(strict_types=1);

$project = $project ?? [
    'title' => '',
    'category' => '',
    'short_description' => '',
    'description' => '',
    'technologies' => '',
    'project_url' => '',
    'github_url' => '',
    'image_path' => '',
    'is_featured' => 0,
    'is_active' => 1,
    'sort_order' => 0,
];
?>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?= e($project['title']) ?>" required maxlength="180">
            </div>
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <input type="text" class="form-control" name="category" value="<?= e($project['category']) ?>" required maxlength="100" list="categoryOptions">
                <datalist id="categoryOptions">
                    <option value="Web App">
                    <option value="Dashboard">
                    <option value="Ecommerce">
                    <option value="Brand Website">
                    <option value="API">
                </datalist>
            </div>
            <div class="col-12">
                <label class="form-label">Short Description</label>
                <input type="text" class="form-control" name="short_description" value="<?= e($project['short_description']) ?>" required maxlength="255">
            </div>
            <div class="col-12">
                <label class="form-label">Full Description</label>
                <textarea class="form-control" name="description" rows="6" required><?= e($project['description']) ?></textarea>
            </div>
            <div class="col-12">
                <label class="form-label">Technologies</label>
                <input type="text" class="form-control" name="technologies" value="<?= e($project['technologies']) ?>" aria-describedby="techHelp<?= e((string) ($project['id'] ?? 'new')) ?>">
                <small id="techHelp<?= e((string) ($project['id'] ?? 'new')) ?>" class="text-muted">Separate technologies with commas, for example PHP, MySQL, Bootstrap, JavaScript.</small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Live URL</label>
                <input type="url" class="form-control" name="project_url" value="<?= e($project['project_url']) ?>">
            </div>
            <div class="col-md-6">
                <label class="form-label">GitHub URL</label>
                <input type="url" class="form-control" name="github_url" value="<?= e($project['github_url']) ?>">
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="upload-panel">
            <label class="form-label">Project Image</label>
            <?php if (!empty($project['image_path'])): ?>
                <img src="<?= url($project['image_path']) ?>" alt="Current project image" class="current-image">
            <?php endif; ?>
            <input type="file" class="form-control image-preview-input" name="image" accept="image/png,image/jpeg,image/webp,image/gif">
            <small>PNG, JPG, WEBP, or GIF. Max 4 MB.</small>
        </div>
        <div class="row g-3 mt-1">
            <div class="col-6">
                <label class="form-label">Sort Order</label>
                <input type="number" class="form-control" name="sort_order" value="<?= (int) $project['sort_order'] ?>">
            </div>
            <div class="col-6 d-flex align-items-end">
                <div class="form-check form-switch admin-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="featured<?= e((string) ($project['id'] ?? 'new')) ?>" name="is_featured" value="1" <?= !empty($project['is_featured']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="featured<?= e((string) ($project['id'] ?? 'new')) ?>">Featured</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-check form-switch admin-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="active<?= e((string) ($project['id'] ?? 'new')) ?>" name="is_active" value="1" <?= !empty($project['is_active']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="active<?= e((string) ($project['id'] ?? 'new')) ?>">Published on public portfolio</label>
                </div>
            </div>
        </div>
    </div>
</div>
