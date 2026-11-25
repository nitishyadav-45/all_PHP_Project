<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../config/db.php';

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    
    // Handle Image Upload
    $image = $_FILES['image']['name'];
    $target = "../uploads/projects/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, image, link) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $description, $image, $link])) {
            $success = "Project added successfully!";
        } else {
            $error = "Failed to add project to database.";
        }
    } else {
        $error = "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row min-h-screen">
        <div class="w-full md:w-64 bg-gray-900 text-white">
            <div class="p-6 text-2xl font-bold border-b border-gray-800">Admin Panel</div>
            <nav class="mt-6">
                <a href="dashboard.php" class="block py-3 px-6 hover:bg-gray-800 transition">Dashboard</a>
                <a href="add-project.php" class="block py-3 px-6 bg-blue-600 text-white">Add Project</a>
                <a href="messages.php" class="block py-3 px-6 hover:bg-gray-800 transition">Messages</a>
                <a href="logout.php" class="block py-3 px-6 hover:bg-red-600 transition mt-10">Logout</a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-bold mb-6">Add New Project</h2>

                <?php if ($success): ?>
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-6"><?php echo $success; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="bg-red-100 text-red-700 p-4 rounded mb-6"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="add-project.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Title</label>
                        <input type="text" name="title" required class="mt-1 block w-full border rounded-md p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4" required class="mt-1 block w-full border rounded-md p-2"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Image</label>
                        <input type="file" name="image" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Link (Optional)</label>
                        <input type="url" name="link" class="mt-1 block w-full border rounded-md p-2" placeholder="https://...">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Save Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
