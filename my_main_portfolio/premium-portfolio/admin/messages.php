<?php
declare(strict_types=1);

require_once __DIR__ . '/../includes/admin-auth.php';

db()->exec('UPDATE messages SET is_read = 1 WHERE is_read = 0');
$messages = db()->query('SELECT * FROM messages ORDER BY created_at DESC')->fetchAll();

$adminPageTitle = 'Messages';
$activeMenu = 'messages';
include __DIR__ . '/../includes/admin-header.php';
?>

<section class="admin-card">
    <div class="card-heading">
        <div>
            <span>Contact Form</span>
            <h2>Received Messages</h2>
        </div>
    </div>

    <div class="message-list">
        <?php foreach ($messages as $message): ?>
            <article class="message-card">
                <div class="message-head">
                    <div>
                        <h3><?= e($message['subject']) ?></h3>
                        <span><?= e($message['name']) ?> · <a href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></span>
                    </div>
                    <time><?= e(date('M d, Y h:i A', strtotime($message['created_at']))) ?></time>
                </div>
                <p><?= nl2br(e($message['message'])) ?></p>
                <div class="message-actions">
                    <span><i class="fa-solid fa-location-crosshairs"></i> <?= e($message['ip_address']) ?></span>
                    <form action="<?= url('actions/message_delete.php') ?>" method="post" class="confirm-delete">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= (int) $message['id'] ?>">
                        <button class="btn btn-sm btn-danger-soft" type="submit">
                            <i class="fa-solid fa-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
        <?php if (!$messages): ?>
            <div class="empty-state">
                <i class="fa-regular fa-envelope-open"></i>
                <h3>No messages yet</h3>
                <p>New contact submissions will appear here automatically.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/../includes/admin-footer.php'; ?>

