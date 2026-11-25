<?php
require_once '../config.php';
if (!isLoggedIn()) redirect('../admin_login.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // (वैकल्पिक) यहाँ आप चाहें तो डेटाबेस से इमेज का नाम निकालकर `unlink()` की मदद से इमेज फाइल भी फोल्डर से डिलीट कर सकते हैं।
    $conn->query("DELETE FROM projects WHERE id = $id");
}
redirect('dashboard.php');
?>