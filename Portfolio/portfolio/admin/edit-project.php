<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../config/db.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header('Location: dashboard.php');
    exit;
}

$success = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $image = $project['image']; // Default to old image

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/projects/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, image = ?, link = ? WHERE id = ?");
    if ($stmt->execute([$title, $description, $image, $link, $id])) {
        $success = "Project updated successfully!";
        // Refresh project data
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        $project = $stmt->fetch();
    } else {
        $error = "Failed to update project.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col md:flex-row min-h-screen">
        <div class="w-full md:w-64 bg-gray-900 text-white">
            <div class="p-6 text-2xl font-bold border-b border-gray-800">Admin Panel</div>
            <nav class="mt-6">
                <a href="dashboard.php" class="block py-3 px-6 hover:bg-gray-800 transition">Dashboard</a>
                <a href="logout.php" class="block py-3 px-6 hover:bg-red-600 transition mt-10">Logout</a>
            </nav>
        </div>

        <div class="flex-1 p-8">
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm p-8">
                <h2 class="text-2xl font-bold mb-6">Edit Project</h2>

                <?php if ($success): ?>
                    <div class="bg-green-100 text-green-700 p-4 rounded mb-6"><?php echo $success; ?></div>
                <?php endif; ?>

                <form action="edit-project.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Title</label>
                        <input type="text" name="title" value="<?php echo $project['title']; ?>" required class="mt-1 block w-full border rounded-md p-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4" required class="mt-1 block w-full border rounded-md p-2"><?php echo $project['description']; ?></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Image</label>
                        <img src="../uploads/projects/<?php echo $project['image']; ?>" class="w-32 h-20 object-cover rounded mt-2 mb-2">
                        <label class="block text-sm font-medium text-gray-700">Change Image (Optional)</label>
                        <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Project Link</label>
                        <input type="url" name="link" value="<?php echo $project['link']; ?>" class="mt-1 block w-full border rounded-md p-2">
                    </div>
                    <div class="flex justify-between">
                        <a href="dashboard.php" class="text-gray-600 py-2">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700 transition">Update Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
