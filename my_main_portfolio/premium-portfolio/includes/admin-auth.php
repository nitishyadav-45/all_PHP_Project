<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';
require_admin();

$admin = current_admin(db());
if (!$admin) {
    session_destroy();
    redirect('admin/login.php');
}

