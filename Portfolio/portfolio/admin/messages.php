<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../config/db.php';

$messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row min-h-screen">
        <div class="w-full md:w-64 bg-gray-900 text-white">
            <div class="p-6 text-2xl font-bold border-b border-gray-800">Admin Panel</div>
            <nav class="mt-6">
                <a href="dashboard.php" class="block py-3 px-6 hover:bg-gray-800 transition">Dashboard</a>
                <a href="messages.php" class="block py-3 px-6 bg-blue-600 text-white">Messages</a>
                <a href="logout.php" class="block py-3 px-6 hover:bg-red-600 transition mt-10">Logout</a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-8">Messages</h1>

            <div class="space-y-6">
                <?php foreach($messages as $msg): ?>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-bold text-lg"><?php echo $msg['subject']; ?></h3>
                            <p class="text-sm text-gray-500">From: <?php echo $msg['name']; ?> (<?php echo $msg['email']; ?>)</p>
                        </div>
                        <span class="text-xs text-gray-400"><?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></span>
                    </div>
                    <p class="text-gray-700 leading-relaxed"><?php echo nl2br($msg['message']); ?></p>
                </div>
                <?php endforeach; ?>

                <?php if(empty($messages)): ?>
                <div class="bg-white p-10 rounded-xl shadow-sm text-center text-gray-500">
                    No messages yet.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
