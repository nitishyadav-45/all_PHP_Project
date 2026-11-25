<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';
checkLogin();

// --- AJAX MARK AS READ LOGIC ---
if (isset($_GET['read'])) {
    $id = intval($_GET['read']);
    $stmt = $pdo->prepare("UPDATE contacts SET is_read = 1 WHERE id = ?");
    $stmt->execute([$id]);
    exit; // AJAX call ke liye yahi script rok dete hain
}

// --- SINGLE DELETE LOGIC ---
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// --- BULK DELETE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bulk_delete'])) {
    if (!empty($_POST['selected_ids'])) {
        // Sanitize and convert array of IDs to comma-separated string
        $ids = implode(',', array_map('intval', $_POST['selected_ids']));
        $pdo->exec("DELETE FROM contacts WHERE id IN ($ids)");
    }
    header("Location: index.php");
    exit;
}

// --- BLOCK / UNBLOCK LOGIC ---
if (isset($_GET['block'])) {
    $id = intval($_GET['block']);
    $stmt = $pdo->prepare("UPDATE contacts SET is_blocked = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

if (isset($_GET['unblock'])) {
    $id = intval($_GET['unblock']);
    $stmt = $pdo->prepare("UPDATE contacts SET is_blocked = 0 WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// Fetch all messages
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card { border: none; border-radius: 12px; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; transition: 0.3s; }
        .unread-msg { background-color: #f0f8ff !important; font-weight: 600; } /* Light blue for unread */
        .blocked-msg { opacity: 0.6; background-color: #fce8e6 !important; } /* Light red for blocked */
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <h2 class="fw-bold text-dark mb-0"><i class="fas fa-envelope text-primary me-2"></i>Inbox Messages</h2>
            <a href="../dashboard.php" class="btn btn-outline-secondary px-4 rounded-pill">Back to Dashboard</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <form method="POST" id="messagesForm">
                    
                    <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center rounded-top-3">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold" for="selectAll">Select All</label>
                        </div>
                        <button type="submit" name="bulk_delete" class="btn btn-sm btn-danger px-4 rounded-pill shadow-sm" onclick="return confirm('Are you sure you want to delete selected messages?');">
                            <i class="fas fa-trash me-1"></i> Delete Selected
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40px;" class="ps-3">#</th>
                                    <th>Date</th>
                                    <th>Sender Info</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($messages)): ?>
                                    <?php foreach($messages as $msg): 
                                        // Set row class based on read/blocked status
                                        $rowClass = '';
                                        if ($msg['is_blocked']) $rowClass = 'blocked-msg';
                                        elseif (!$msg['is_read']) $rowClass = 'unread-msg';
                                    ?>
                                    <tr class="<?php echo $rowClass; ?>" id="row-<?php echo $msg['id']; ?>">
                                        <td class="ps-3">
                                            <input class="form-check-input msg-checkbox" type="checkbox" name="selected_ids[]" value="<?php echo $msg['id']; ?>">
                                        </td>
                                        <td class="text-nowrap text-muted small">
                                            <?php echo date('d M Y, h:i A', strtotime($msg['created_at'])); ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($msg['name']); ?></div>
                                            <div class="small text-muted"><i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($msg['email']); ?></div>
                                            <?php if(!empty($msg['mobile'])): ?>
                                                <div class="small text-muted"><i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($msg['mobile']); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($msg['subject']); ?></td>
                                        <td>
                                            <?php if($msg['is_blocked']): ?>
                                                <span class="badge bg-danger">Blocked</span>
                                            <?php elseif($msg['is_read']): ?>
                                                <span class="badge bg-secondary badge-status-<?php echo $msg['id']; ?>">Read</span>
                                            <?php else: ?>
                                                <span class="badge bg-primary badge-status-<?php echo $msg['id']; ?>">New</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4 text-nowrap">
                                            
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="viewMessage(<?php echo $msg['id']; ?>)" data-bs-toggle="modal" data-bs-target="#msgModal<?php echo $msg['id']; ?>">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            
                                            <?php if($msg['is_blocked']): ?>
                                                <a href="?unblock=<?php echo $msg['id']; ?>" class="btn btn-sm btn-warning mx-1" title="Unblock User"><i class="fas fa-unlock"></i></a>
                                            <?php else: ?>
                                                <a href="?block=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-warning mx-1" onclick="return confirm('Block messages from this user?');" title="Block User"><i class="fas fa-ban"></i></a>
                                            <?php endif; ?>

                                            <a href="?delete=<?php echo $msg['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this message?');" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                            <div class="modal fade" id="msgModal<?php echo $msg['id']; ?>" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content text-start border-0 shadow">
                                                        <div class="modal-header bg-light">
                                                            <div>
                                                                <h5 class="modal-title fw-bold text-dark mb-1"><?php echo htmlspecialchars($msg['subject']); ?></h5>
                                                                <div class="small text-muted">From: <?php echo htmlspecialchars($msg['name']); ?> (<?php echo htmlspecialchars($msg['email']); ?>)</div>
                                                            </div>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body p-4">
                                                            <p class="text-dark" style="white-space: pre-wrap; line-height: 1.6;"><?php echo htmlspecialchars($msg['message']); ?></p>
                                                        </div>
                                                        <div class="modal-footer border-0">
                                                            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                                            <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>" class="btn btn-primary rounded-pill px-4"><i class="fas fa-reply me-2"></i>Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="fas fa-inbox fa-3x mb-3 text-light"></i><br>
                                            No messages found.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Select All Checkbox Logic
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.msg-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // AJAX function to mark message as read without reloading page
        function viewMessage(id) {
            // Background fetch to update database
            fetch('?read=' + id);
            
            // Update UI instantly
            const row = document.getElementById('row-' + id);
            if(row && row.classList.contains('unread-msg')) {
                row.classList.remove('unread-msg');
                const badge = document.querySelector('.badge-status-' + id);
                if(badge) {
                    badge.classList.remove('bg-primary');
                    badge.classList.add('bg-secondary');
                    badge.innerHTML = 'Read';
                }
            }
        }
    </script>
</body>
</html>