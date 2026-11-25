<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-gray-50 text-gray-900 font-sans">

    <!-- Navigation -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-blue-600">Portfolio</a>
            <div class="hidden md:flex space-x-8">
                <a href="#home" class="hover:text-blue-600 transition">Home</a>
                <a href="#about" class="hover:text-blue-600 transition">About</a>
                <a href="#projects" class="hover:text-blue-600 transition">Projects</a>
                <a href="contact.php" class="hover:text-blue-600 transition">Contact</a>
                <a href="admin/login.php" class="text-gray-500 hover:text-blue-600"><i class="fas fa-user-lock"></i></a>
            </div>
            <button class="md:hidden text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="py-20 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Hi, I'm a Professional Developer</h1>
            <p class="text-xl mb-8">I build beautiful, responsive, and functional websites.</p>
            <div class="flex justify-center space-x-4">
                <a href="#projects" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">View My Work</a>
                <a href="download-resume.php" class="border-2 border-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition">Download CV</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <img src="assets/images/Made_with_insMind--removebg-preview.png" height="500px" alt="Profile" class="rounded-2xl shadow-2xl mx-auto ">
                </div>
                <div class="md:w-1/2 md:pl-12">
                    <h2 class="text-3xl font-bold mb-6">About Me</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        I am a passionate web developer with expertise in PHP, MySQL, and modern frontend technologies. I love solving complex problems and turning ideas into reality through code.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-lg shadow-sm border-l-4 border-blue-500">
                            <h4 class="font-bold">Experience</h4>
                            <p class="text-sm text-gray-500">3+ Years</p>
                        </div>
                        <div class="p-4 bg-white rounded-lg shadow-sm border-l-4 border-indigo-500">
                            <h4 class="font-bold">Projects</h4>
                            <p class="text-sm text-gray-500">50+ Completed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20 bg-gray-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Featured Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
                    while ($row = $stmt->fetch()) {
                        echo '
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition">
                            <img src="uploads/projects/'.$row['image'].'" alt="'.$row['title'].'" class="w-full h-48 object-cover" onerror="this.src=\'https://via.placeholder.com/400x250\'">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">'.$row['title'].'</h3>
                                <p class="text-gray-600 mb-4">'.substr($row['description'], 0, 100).'...</p>
                                <a href="'.$row['link'].'" target="_blank" class="text-blue-600 font-semibold hover:underline">View Project <i class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>';
                    }
                } catch (Exception $e) {
                    echo '<p class="text-center col-span-full">No projects found yet.</p>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <div class="flex justify-center space-x-6 mb-8">
                <a href="#" class="text-2xl hover:text-blue-400"><i class="fab fa-github"></i></a>
                <a href="#" class="text-2xl hover:text-blue-400"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-2xl hover:text-blue-400"><i class="fab fa-twitter"></i></a>
            </div>
            <p>&copy; <?php echo date('Y'); ?> My Portfolio. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
