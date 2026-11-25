<?php 
require_once 'includes/config.php'; 

// Fetch Projects
$stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
$projects = $stmt->fetchAll();

// Fetch Skills
$stmt = $pdo->query("SELECT * FROM skills ORDER BY category, proficiency DESC");
$skills = $stmt->fetchAll();

// Handle Contact Form Submission
$message_status = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    if (validate_csrf($_POST['csrf_token'])) {
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $subject = sanitize($_POST['subject']);
        $message = sanitize($_POST['message']);

        if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $email, $subject, $message])) {
                $message_status = "success";
            } else {
                $message_status = "error";
            }
        } else {
            $message_status = "invalid";
        }
    } else {
        $message_status = "csrf_fail";
    }
}

include 'includes/header.php'; 
?>

<!-- Hero Section -->
<section id="home" class="hero-section d-flex align-items-center">
    <div class="container text-center">
        <h1 class="display-1 fw-bold text-white animate-up">Creative <span class="text-gradient">Developer</span></h1>
        <p class="lead text-white-50 mb-5 animate-up delay-1">Building digital experiences with passion and precision.</p>
        <div class="animate-up delay-2">
            <a href="#projects" class="btn btn-primary btn-lg px-5 rounded-pill me-3">View My Work</a>
            <a href="#contact" class="btn btn-outline-light btn-lg px-5 rounded-pill">Contact Me</a>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section id="about" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white">My Expertise</h2>
            <div class="underline mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php if (empty($skills)): ?>
                <div class="col-12 text-center text-white-50">
                    <p>No skills added yet. Add some in the admin panel!</p>
                </div>
            <?php else: ?>
                <?php foreach ($skills as $skill): ?>
                <div class="col-md-3">
                    <div class="skill-card glass-card p-4 text-center">
                        <i class="<?php echo $skill['icon']; ?> fa-3x mb-3 text-primary"></i>
                        <h4 class="text-white"><?php echo $skill['name']; ?></h4>
                        <div class="progress mt-3" style="height: 10px; background: rgba(255,255,255,0.1);">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $skill['proficiency']; ?>%"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Projects Section -->
<section id="projects" class="py-5 bg-dark-soft">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-white">Featured Projects</h2>
            <div class="underline mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php if (empty($projects)): ?>
                <div class="col-12 text-center text-white-50">
                    <p>No projects showcased yet. Check back soon!</p>
                </div>
            <?php else: ?>
                <?php foreach ($projects as $project): ?>
                <div class="col-md-4">
                    <div class="project-card glass-card overflow-hidden">
                        <div class="project-img-wrapper">
                            <img src="assets/images/<?php echo $project['image']; ?>" class="img-fluid" alt="<?php echo $project['title']; ?>">
                        </div>
                        <div class="p-4">
                            <h5 class="text-white fw-bold"><?php echo $project['title']; ?></h5>
                            <p class="text-white-50 small"><?php echo $project['description']; ?></p>
                            <div class="mb-3">
                                <?php 
                                $tags = explode(',', $project['tech_stack']);
                                foreach($tags as $tag): 
                                ?>
                                <span class="badge bg-secondary me-1"><?php echo trim($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="<?php echo $project['link']; ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">View Project</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="glass-card p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-white">Get In Touch</h2>
                        <p class="text-white-50">Have a project in mind? Let's talk!</p>
                    </div>

                    <?php if ($message_status === 'success'): ?>
                        <div class="alert alert-success">Message sent successfully! I will get back to you soon.</div>
                    <?php elseif ($message_status === 'error'): ?>
                        <div class="alert alert-danger">Something went wrong. Please try again later.</div>
                    <?php elseif ($message_status === 'invalid'): ?>
                        <div class="alert alert-warning">Please fill all fields correctly.</div>
                    <?php endif; ?>

                    <form action="index.php#contact" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control glass-input" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control glass-input" placeholder="Your Email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control glass-input" placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <textarea name="message" rows="5" class="form-control glass-input" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" name="send_message" class="btn btn-primary btn-lg px-5 rounded-pill">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
