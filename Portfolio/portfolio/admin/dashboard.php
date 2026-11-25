<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../config/db.php';

// Get counts for dashboard
$projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$messageCount = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();

$projects = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <div class="w-full md:w-64 bg-gray-900 text-white">
            <div class="p-6 text-2xl font-bold border-b border-gray-800">Admin Panel</div>
            <nav class="mt-6">
                <a href="dashboard.php" class="block py-3 px-6 bg-blue-600 text-white">Dashboard</a>
                <a href="add-project.php" class="block py-3 px-6 hover:bg-gray-800 transition">Add Project</a>
                <a href="messages.php" class="block py-3 px-6 hover:bg-gray-800 transition flex justify-between items-center">
                    Messages
                    <?php if($messageCount > 0): ?>
                        <span class="bg-red-500 text-xs px-2 py-1 rounded-full"><?php echo $messageCount; ?></span>
                    <?php endif; ?>
                </a>
                <a href="logout.php" class="block py-3 px-6 hover:bg-red-600 transition mt-10">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <div class="text-gray-600">Welcome back, Admin</div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm uppercase font-bold">Total Projects</div>
                    <div class="text-3xl font-bold"><?php echo $projectCount; ?></div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm uppercase font-bold">New Messages</div>
                    <div class="text-3xl font-bold"><?php echo $messageCount; ?></div>
                </div>
            </div>

            <!-- Projects Table -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b flex justify-between items-center">
                    <h2 class="text-xl font-bold">Manage Projects</h2>
                    <a href="add-project.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Add New</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                            <tr>
                                <th class="px-6 py-4">Image</th>
                                <th class="px-6 py-4">Title</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach($projects as $project): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <img src="../uploads/projects/<?php echo $project['image']; ?>" class="w-12 h-12 object-cover rounded" onerror="this.src='https://via.placeholder.com/50'">
                                </td>
                                <td class="px-6 py-4 font-medium"><?php echo $project['title']; ?></td>
                                <td class="px-6 py-4 text-gray-500 text-sm"><?php echo date('M d, Y', strtotime($project['created_at'])); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <a href="edit-project.php?id=<?php echo $project['id']; ?>" class="text-blue-600 hover:text-blue-800"><i class="fas fa-edit"></i></a>
                                        <a href="delete-project.php?id=<?php echo $project['id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($projects)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500">No projects added yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
