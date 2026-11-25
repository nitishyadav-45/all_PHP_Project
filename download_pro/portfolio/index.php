<?php
require_once 'config.php';

// Get all data from database
$user = getUserData() ?? [];
$services = getAllServices();
$skills = getAllSkills();
$projects = getAllProjects();
$testimonials = getAllTestimonials();
$categories = getAllCategories();

// Set default values if user data not available
$user_name = $user['name'] ?? 'John Doe';
$user_title = $user['title'] ?? 'Creative Web Developer & Designer';
$user_description = $user['description'] ?? 'A Creative Web Developer & Designer passionate about creating beautiful, functional, and user-centered digital experiences.';
$user_about_short = $user['about_content_short'] ?? 'Creative Developer Based in New York';
$user_about_long = $user['about_content_long'] ?? 'I\'m a passionate web developer and designer with over 5 years of experience in creating digital solutions. I specialize in building responsive websites, web applications, and creating stunning user interfaces.';
$user_profile_image = $user['profile_image'] ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&h=600&fit=crop';
$user_about_image = $user['about_image'] ?? 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&h=700&fit=crop';
$projects_done = $user['projects_done'] ?? 150;
$happy_clients = $user['happy_clients'] ?? 80;
$years_experience = $user['years_experience'] ?? 5;
$user_location = $user['location'] ?? 'New York, NY 10001';
$user_phone = $user['phone'] ?? '+1 (555) 123-4567';
$user_working_hours = $user['working_hours'] ?? 'Mon - Fri: 9AM - 6PM';



$hero_image_src = 'https://via.placeholder.com/500'; // डिफ़ॉल्ट इमेज (Fallback)

if (!empty($user['profile_image'])) {
    $potential_path = 'uploads/' . $user['profile_image'];
    // अगर फ्रंटएंड फ़ाइल फोल्डर स्ट्रक्चर के हिसाब से एक स्टेप बाहर है
    if (file_exists($potential_path)) {
        $hero_image_src = $potential_path;
    } elseif (file_exists('uploads/' . $user['profile_image'])) {
        $hero_image_src = 'uploads/' . $user['profile_image'];
    }
}

// नाम और डिस्क्रिप्शन को वैरिएबल्स में सुरक्षित करना
$display_name = !empty($user['name']) ? htmlspecialchars($user['name']) : 'My Name';
$display_desc = !empty($user['description']) ? htmlspecialchars($user['description']) : 'Welcome to my portfolio website.';


// 1. About Showcase Banner इमेज का सही पाथ सेट करना
$about_image_src = 'https://via.placeholder.com/600x400'; // डिफ़ॉल्ट इमेज (Fallback)

if (!empty($user['about_image'])) {
    $potential_about_path = 'uploads/' . $user['about_image'];
    
    if (file_exists($potential_about_path)) {
        $about_image_src = $potential_about_path;
    } elseif (file_exists('uploads/' . $user['about_image'])) {
        $about_image_src = 'uploads/' . $user['about_image'];
    }
}

// 2. टेक्स्ट वैरिएबल्स को डेटाबेस रिकॉर्ड के अनुसार सुरक्षित सेट करना
$about_short_text = !empty($user['about_content_short']) ? htmlspecialchars($user['about_content_short']) : 'My Professional Journey';
$about_long_text  = !empty($user['about_content_long']) ? htmlspecialchars($user['about_content_long']) : 'I am a dedicated developer focused on building high-quality digital products.';

// 3. स्टेटिस्टिक्स काउंटर्स (डेटाबेस से डायनामिक वैल्यू)
$stat_projects   = isset($user['projects_done']) ? (int)$user['projects_done'] : 0;
$stat_clients    = isset($user['happy_clients']) ? (int)$user['happy_clients'] : 0;
$stat_experience = isset($user['years_experience']) ? (int)$user['years_experience'] : 0;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Portfolio | <?php echo $user_name; ?></title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/inde.css">

    <style>

    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader" id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">Nitish Kumar Yadav</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#skills">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <!-- <section class="hero" id="home">
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-right">
                    <h1>Hi, I'm <span><?php echo $user_name; ?></span></h1>
                    <p><?php echo $user_description; ?></p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#portfolio" class="btn btn-custom">View My Work</a>
                        <a href="#contact" class="btn btn-outline-custom">Contact Me</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image" data-aos="fade-left">
                    <img src="<?php echo $user_profile_image; ?>" alt="Profile">
                </div>
            </div>
        </div>
    </section> -->
    <section class="hero" id="home">
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content" data-aos="fade-right">
                    <!-- सुरक्षित रूप से नाम प्रिंट करना -->
                    <h1>Hi, I'm <span><?php echo $display_name; ?></span></h1>
                    <!-- सुरक्षित रूप से बायोग्राफी टैगलाइन प्रिंट करना -->
                    <p><?php echo $display_desc; ?></p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#portfolio" class="btn btn-custom">View My Work</a>
                        <a href="#contact" class="btn btn-outline-custom">Contact Me</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image" data-aos="fade-left">
                    
                    <!-- <img src="<?php echo $hero_image_src; ?>" alt="<?php echo $display_name; ?>" class="img-fluid"
                        style="max-width: 100%; height: auto; object-fit: cover; border-radius: 20px;"> -->

                        <img src="uploads/<?php echo $data['profile_image']; ?>  class="img-fluid"
                        style="max-width: 100%; height: auto; object-fit: cover; border-radius: 20px;">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <!-- <section class="about" id="about">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>About Me</h2>
                <p>Get to know more about me and my journey</p>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6 about-image mb-4 mb-lg-0" data-aos="fade-right">
                    <img src="<?php echo $user_about_image; ?>" alt="About">
                </div>
                <div class="col-lg-6 about-content" data-aos="fade-left">
                    <h3><?php echo $user_about_short; ?></h3>
                    <p><?php echo $user_about_long; ?></p>
                    <p>My journey in web development started with a curiosity about how websites work, and it has evolved into a career that I truly love. I believe in continuous learning and staying updated with the latest technologies.</p>
                    <div class="about-stats">
                        <div class="stat-item">
                            <h4 class="counter" data-target="<?php echo $projects_done; ?>">0</h4>
                            <p>Projects Done</p>
                        </div>
                        <div class="stat-item">
                            <h4 class="counter" data-target="<?php echo $happy_clients; ?>">0</h4>
                            <p>Happy Clients</p>
                        </div>
                        <div class="stat-item">
                            <h4 class="counter" data-target="<?php echo $years_experience; ?>">0</h4>
                            <p>Years Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <section class="about" id="about">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>About Me</h2>
                <p>Get to know more about me and my journey</p>
            </div>
            <div class="row align-items-center">
                <!-- <div class="col-lg-6 about-image mb-4 mb-lg-0" data-aos="fade-up">
                   
                    <img src="<?php echo $about_image_src; ?>" alt="About Me Image" class="img-fluid"
                        style="width: 100%; height: auto; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                </div> -->
                <div class="col-lg-6 about-image mb-5 mb-lg-0" data-aos="fade-up">
                    <img src="<?php echo $about_image_src; ?>" alt="About Me Image"
                        class="img-fluid rounded-4 shadow-lg">
                </div>
                <div class="col-lg-6 about-content" data-aos="fade-up">
                    <!-- डेटाबेस से डायनामिक सब-हेडर -->
                    <h3><?php echo $about_short_text; ?></h3>

                    <!-- डेटाबेस से डायナमिक मुख्य विवरण -->
                    <p><?php echo $about_long_text; ?></p>

                    <p>My journey in web development started with a curiosity about how websites work, and it has
                        evolved into a career that I truly love. I believe in continuous learning and staying updated
                        with the latest technologies.</p>

                    <!-- स्टेटिस्टिक्स काउंटर्स ब्लॉक -->
                    <div class="about-stats">
                        <div class="stat-item">
                            <!-- data-target में डेटाबेस की रियल वैल्यू जाएगी जिससे आपका जावास्क्रिप्ट काउंटर एनीमेशन काम करेगा -->
                            <h4 class="counter" data-target="<?php echo $stat_projects; ?>">0</h4>
                            <p>Projects Done</p>
                        </div>
                        <div class="stat-item">
                            <h4 class="counter" data-target="<?php echo $stat_clients; ?>">0</h4>
                            <p>Happy Clients</p>
                        </div>
                        <div class="stat-item">
                            <h4 class="counter" data-target="<?php echo $stat_experience; ?>">0</h4>
                            <p>Years Experience</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>My Services</h2>
                <p>What I can do for you</p>
            </div>
            <div class="row g-4">
                <?php 
                $icons = ['bi-code-slash', 'bi-palette', 'bi-phone', 'bi-cart3', 'bi-graph-up', 'bi-cloud'];
                foreach ($services as $index => $service): 
                    $icon_class = isset($icons[$index]) ? $icons[$index] : 'bi-star';
                    $service_icon_class = 'service-icon-' . (($index % 6) + 1);
                ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($index * 100); ?>">
                    <div class="service-card">
                        <div class="service-icon <?php echo $service_icon_class; ?>">
                            <i class="bi <?php echo $icon_class; ?>"></i>
                        </div>
                        <h3><?php echo $service['name']; ?></h3>
                        <p><?php echo $service['description']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="skills" id="skills">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>My Skills</h2>
                <p>Technologies and tools I work with</p>
            </div>
            <div class="row">
                <?php 
                $left_skills = array_slice($skills, 0, ceil(count($skills) / 2));
                $right_skills = array_slice($skills, ceil(count($skills) / 2));
                ?>
                <div class="col-lg-6" data-aos="fade-up">
                    <?php foreach ($left_skills as $skill): ?>
                    <div class="skill-item">
                        <div class="skill-header">
                            <h4><?php echo $skill['name']; ?></h4>
                            <span><?php echo $skill['percentage']; ?>%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?php echo $skill['percentage']; ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-lg-6" data-aos="fade-up">
                    <?php foreach ($right_skills as $skill): ?>
                    <div class="skill-item">
                        <div class="skill-header">
                            <h4><?php echo $skill['name']; ?></h4>
                            <span><?php echo $skill['percentage']; ?>%</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?php echo $skill['percentage']; ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <!-- <section class="portfolio" id="portfolio">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>My Project</h2>
                <p>Check out my recent work</p>
            </div>
            <div class="portfolio-filter" data-aos="fade-up">
                <button class="filter-btn active" data-filter="all">All</button>
                <?php foreach ($categories as $category): ?>
                <button class="filter-btn" data-filter="<?php echo $category['slug']; ?>"><?php echo $category['name']; ?></button>
                <?php endforeach; ?>
            </div>
            <div class="portfolio-grid">
                <?php foreach ($projects as $index => $project): ?>
                <div class="portfolio-item" data-category="<?php echo $project['category_name'] ? strtolower(str_replace(' ', '-', $project['category_name'])) : 'all'; ?>" data-aos="zoom-in" data-aos-delay="<?php echo ($index * 100); ?>">
                    <img src="<?php echo $project['image'] ?? 'https://via.placeholder.com/600x450'; ?>" alt="<?php echo $project['title']; ?>">
                    <div class="portfolio-overlay">
                        <h3><?php echo $project['title']; ?></h3>
                        <p><?php echo $project['category_name'] ?? 'Project'; ?></p>
                        <div class="links">
                            <?php if ($project['live_link']): ?>
                            <a href="<?php echo $project['live_link']; ?>" target="_blank"><i class="bi bi-link"></i></a>
                            <?php endif; ?>
                            <?php if ($project['github_link']): ?>
                            <a href="<?php echo $project['github_link']; ?>" target="_blank"><i class="bi bi-github"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section> -->

    <section class="portfolio" id="portfolio">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>My Project</h2>
                <p>Check out my recent work</p>
            </div>

            <div class="portfolio-filter" data-aos="fade-up">
                <button class="filter-btn active" data-filter="all">All</button>
                <?php foreach ($categories as $category): ?>
                <button class="filter-btn" data-filter="<?php echo $category['slug']; ?>">
                    <?php echo $category['name']; ?>
                </button>
                <?php endforeach; ?>
            </div>

            <div class="portfolio-grid">
                <?php foreach ($projects as $index => $project): 
                // 1. कैटेगरी स्लग सेट करें (अगर प्रोजेक्ट की कोई कैटेगरी नहीं है तो 'all' रखें)
                // यह आपके डेटाबेस की कैटेगरीज के 'slug' से मैच करेगा
                $project_filter = isset($project['category_slug']) ? $project['category_slug'] : (isset($project['slug']) ? $project['slug'] : 'all');
                
                // 2. इमेज पाथ सही करें (add_project.php में हमने इमेज को ../uploads/projects/ में सेव किया था)
                // फ्रंटएंड (Main Website) के हिसाब से यह पाथ 'uploads/projects/' होना चाहिए
                $image_src = 'https://via.placeholder.com/600x450'; // डिफ़ॉल्ट इमेज
                if (!empty($project['image'])) {
                    $image_path = 'uploads/projects/' . $project['image'];
                    // अगर फ्रंटएंड फोल्डर के बाहर है तो आप '../uploads/projects/' भी चेक कर सकते हैं
                    if (file_exists($image_path)) {
                        $image_src = $image_path;
                    } elseif (file_exists('../uploads/projects/' . $project['image'])) {
                        $image_src = '../uploads/projects/' . $project['image'];
                    }
                }
            ?>

                <div class="portfolio-item" data-category="<?php echo $project_filter; ?>" data-aos="zoom-in"
                    data-aos-delay="<?php echo ($index * 100); ?>">
                    <img src="<?php echo $image_src; ?>" alt="<?php echo htmlspecialchars($project['title']); ?>"
                        style="width: 100%; height: auto; object-fit: cover;">

                    <div class="portfolio-overlay">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p><?php echo htmlspecialchars($project['category_name'] ?? 'Project'); ?></p>
                        <div class="links">
                            <?php if (!empty($project['live_link'])): ?>
                            <a href="<?php echo $project['live_link']; ?>" target="_blank"><i
                                    class="bi bi-link"></i></a>
                            <?php endif; ?>
                            <?php if (!empty($project['github_link'])): ?>
                            <a href="<?php echo $project['github_link']; ?>" target="_blank"><i
                                    class="bi bi-github"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Testimonials</h2>
                <p>What clients say about me</p>
            </div>
            <div class="row g-4">
                <?php foreach ($testimonials as $index => $testimonial): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?php echo ($index * 100); ?>">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <div class="testimonial-stars">
                                <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                <i class="bi bi-star-fill"></i>
                                <?php endfor; ?>
                            </div>
                            <p>"<?php echo $testimonial['quote']; ?>"</p>
                            <div class="testimonial-author">
                                <img src="<?php echo $testimonial['client_image'] ?? 'https://via.placeholder.com/100'; ?>"
                                    alt="<?php echo $testimonial['client_name']; ?>">
                                <div>
                                    <h4><?php echo $testimonial['client_name']; ?></h4>
                                    <span><?php echo $testimonial['client_title']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Contact Me</h2>
                <p>Let's work together</p>
            </div>
            <div class="contact-info" data-aos="fade-up">
                <div class="contact-item">
                    <i class="bi bi-geo-alt"></i>
                    <h4>Location</h4>
                    <p><?php echo $user_location; ?></p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope"></i>
                    <h4>Email</h4>
                    <p><?php echo $user['email'] ?? 'john.doe@email.com'; ?></p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-phone"></i>
                    <h4>Phone</h4>
                    <p><?php echo $user_phone; ?></p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-clock"></i>
                    <h4>Working Hours</h4>
                    <p><?php echo $user_working_hours; ?></p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <form class="contact-form" id="contactForm" method="POST" action="contact_handler.php">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                            </div>
                        </div>
                        <input type="text" class="form-control" name="subject" placeholder="Subject">
                        <textarea class="form-control" name="message" placeholder="Your Message" required></textarea>
                        <button type="submit" class="btn btn-custom w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-about">
                    <h3>Portfolio</h3>
                    <p><?php echo $user_description; ?></p>
                    <!-- <div class="footer-social">
                        <?php if ($user['facebook_link']): ?><a href="<?php echo $user['facebook_link']; ?>" target="_blank"><i class="bi bi-facebook"></i></a><?php endif; ?>
                        <?php if ($user['twitter_link']): ?><a href="<?php echo $user['twitter_link']; ?>" target="_blank"><i class="bi bi-twitter"></i></a><?php endif; ?>
                        <?php if ($user['instagram_link']): ?><a href="<?php echo $user['instagram_link']; ?>" target="_blank"><i class="bi bi-instagram"></i></a><?php endif; ?>
                        <?php if ($user['linkedin_link']): ?><a href="<?php echo $user['linkedin_link']; ?>" target="_blank"><i class="bi bi-linkedin"></i></a><?php endif; ?>
                        <?php if ($user['github_link']): ?><a href="<?php echo $user['github_link']; ?>" target="_blank"><i class="bi bi-github"></i></a><?php endif; ?>
                    </div> -->
                    <div class="footer-social">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-github"></i></a>
                    </div>


                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#portfolio">Portfolio</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Services</h4>
                    <ul>
                        <?php foreach (array_slice($services, 0, 5) as $service): ?>
                        <li><a href="#services"><?php echo $service['name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Newsletter</h4>
                    <p style="color: #aaa; margin-bottom: 15px;">Subscribe to get latest updates</p>
                    <form method="POST" action="subscribe.php" style="display: flex; gap: 10px;">
                        <input type="email" class="form-control" name="email" placeholder="Your Email" required
                            style="flex: 1;">
                        <button class="btn btn-custom" style="padding: 15px 20px;">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Portfolio. All Rights Reserved. Designed with <i class="bi bi-heart-fill"
                        style="color: var(--accent-color);"></i> by <?php echo $user_name; ?></p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    // Preloader
    window.addEventListener('load', () => {
        const preloader = document.getElementById('preloader');
        setTimeout(() => {
            preloader.classList.add('hidden');
        }, 1000);
    });

    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true,
        offset: 100
    });

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        const backToTop = document.getElementById('backToTop');

        if (window.scrollY > 100) {
            navbar.classList.add('scrolled');
            backToTop.classList.add('visible');
        } else {
            navbar.classList.remove('scrolled');
            backToTop.classList.remove('visible');
        }
    });

    // Back to top button
    document.getElementById('backToTop').addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                // Close mobile menu after clicking
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                }
            }
        });
    });

    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animateCounters, 10);
            } else {
                counter.innerText = target + '+';
            }
        });
    };

    // Trigger counter animation when about section is visible
    const aboutSection = document.querySelector('.about');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    observer.observe(aboutSection);

    // Portfolio filter
    const filterBtns = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            btn.classList.add('active');

            const filter = btn.getAttribute('data-filter');

            portfolioItems.forEach(item => {
                if (filter === 'all' || item.getAttribute('data-category') === filter) {
                    item.style.display = 'block';
                    item.style.animation = 'zoomIn 0.5s ease';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Contact form submission
    document.getElementById('contactForm').addEventListener('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        fetch('contact_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    e.target.reset();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Add zoomIn animation keyframes
    const style = document.createElement('style');
    style.textContent = `
            @keyframes zoomIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        `;
    document.head.appendChild(style);

    // Parallax effect for hero shapes
    window.addEventListener('scroll', () => {
        const scrolled = window.scrollY;
        const shapes = document.querySelectorAll('.shape');

        shapes.forEach((shape, index) => {
            const speed = (index + 1) * 0.5;
            shape.style.transform = `translateY(${scrolled * speed}px)`;
        });
    });
    </script>
</body>

</html>