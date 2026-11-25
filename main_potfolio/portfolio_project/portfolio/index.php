<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section id="hero" class="hero-section d-flex align-items-center">
    <div id="particles-js"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7" data-aos="fade-up">
                <h5 class="text-primary mb-3">Welcome to my portfolio</h5>
                <h1 class="display-3 fw-bold mb-4">I'm <span class="text-primary"><?php echo $profile['name']; ?></span>
                </h1>
                <h2 class="h3 mb-4"><span class="typed-text"></span></h2>
                <p class="lead mb-5"><?php echo $profile['title']; ?> based in
                    <?php echo $profile['address'] ?? 'Earth'; ?>.</p>
                <div class="hero-btns">
                    <a href="#projects" class="btn btn-primary btn-lg me-3">View Projects</a>
                    <a href="#contact" class="btn btn-outline-primary btn-lg">Hire Me</a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block" data-aos="zoom-in">
                <div class="hero-img-wrapper">
                    <img src="assets/images/profile/<?php echo $profile['profile_image'] ?? 'default.png'; ?>"
                        alt="Profile" class="img-fluid rounded-circle shadow-lg">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                <div class="about-img position-relative">
                    <img src="assets/images/profile/<?php echo $profile['profile_image'] ?? 'default.png'; ?>"
                        alt="About Me" class="img-fluid rounded shadow">
                    <div class="experience-badge bg-primary text-white p-4 rounded shadow">
                        <h3 class="fw-bold mb-0">5+</h3>
                        <p class="mb-0">Years of Experience</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h6 class="text-primary text-uppercase fw-bold mb-2">About Me</h6>
                <h2 class="fw-bold mb-4">Passionate Developer Creating Digital Experiences</h2>
                <p class="mb-4"><?php echo nl2br($profile['about_me']); ?></p>
                <div class="row mb-5">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> <strong>Name:</strong>
                                <?php echo $profile['name']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> <strong>Email:</strong>
                                <?php echo $profile['email']; ?></li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> <strong>Phone:</strong>
                                <?php echo $profile['phone']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-primary me-2"></i> <strong>Address:</strong>
                                <?php echo $profile['address']; ?></li>
                        </ul>
                    </div>
                </div>
                <a href="resume-download.php" class="btn btn-primary btn-lg">Download CV</a>
            </div>
        </div>
    </div>
</section>

<!-- Skills Section -->
<section id="skills" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">My Skills</h6>
            <h2 class="fw-bold">Professional Expertise</h2>
        </div>
        <div class="row">
            <?php 
            $skills = getSkills($pdo);
            foreach($skills as $skill): ?>
            <div class="col-md-6 mb-4" data-aos="fade-up">
                <div class="skill-item">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold"><?php echo $skill['skill_name']; ?></span>
                        <span><?php echo $skill['percentage']; ?>%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%"
                            data-width="<?php echo $skill['percentage']; ?>%"
                            aria-valuenow="<?php echo $skill['percentage']; ?>" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Services Section -->
<!-- <section id="services" class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">What I Offer</h6>
            <h2 class="fw-bold">Professional Services</h2>
        </div>
        <div class="row">
            <?php 
            $services = getServices($pdo);
            foreach($services as $service): ?>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
                <div class="service-card p-5 text-center shadow-sm h-100">
                    <div class="service-icon mb-4">
                        <i class="<?php echo $service['icon']; ?> fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3"><?php echo $service['service_name']; ?></h4>
                    <p class="text-muted"><?php echo $service['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section> -->/

<section id="services" class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">What I Offer</h6>
            <h2 class="fw-bold">Professional Services</h2>
        </div>
        <div class="row">
            <?php 
            $services = getServices($pdo);
            foreach($services as $service): ?>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
                <div class="service-card p-5 text-center shadow-sm h-100">

                    <div class="service-icon mb-4">
                        <?php 
                        $icon_data = $service['icon'];
                        $img_src = '';
                        
                        // Check karte hain ki URL hai ya uploaded file ka naam
                        if (filter_var($icon_data, FILTER_VALIDATE_URL)) {
                            $img_src = htmlspecialchars($icon_data); // Direct Image Link
                        } else {
                            // Agar local file hai, toh uploads folder ka path. 
                            // Dhyan dein: Agar ye page aapki main website par hai, toh path 'uploads/services/' hoga.
                            $img_src = 'assets/images/services/' . htmlspecialchars($icon_data);
                        }
                        ?>

                        <img src="<?php echo $img_src; ?>"
                            alt="<?php echo htmlspecialchars($service['service_name']); ?>"
                            style="width: 70px; height: 70px; object-fit: contain;">
                    </div>
                    <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($service['service_name']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($service['description']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- new project section -->

<section id="projects" class="section-padding bg-light py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Portfolio</h6>
            <h2 class="fw-bold mb-4">Latest Projects</h2>

            <div class="project-filters mb-4">
                <button class="btn btn-outline-primary active filter-btn" data-filter="all">All Projects</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Web">Web</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Mobile">Mobile</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Design">Design</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Branding">Branding</button>
            </div>
        </div>

        <div class="row g-4" id="project-grid">
            <?php 
            $projects = getProjects($pdo);
            $modalIndex = 0; // Modal ki unique ID banne ke liye ek counter add kiya hai
            foreach($projects as $project): 
                $itemCategory = htmlspecialchars($project['category']);
                $modalIndex++; 
            ?>
            <div class="col-lg-4 col-md-6 project-item <?php echo $itemCategory; ?>" data-aos="fade-up">
                <div class="project-card position-relative overflow-hidden rounded shadow-sm">

                    <?php 
                        // Check if image exists in DB, otherwise use default.jpg
                        $imageName = !empty($project['image']) ? $project['image'] : 'default.jpg'; 
                    ?>
                    <img src="assets/images/projects/<?php echo htmlspecialchars($imageName); ?>"
                        alt="<?php echo htmlspecialchars($project['title']); ?>" class="img-fluid w-100"
                        style="height: 250px; object-fit: cover;">

                    <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center text-white p-4"
                        style="background: rgba(0,0,0,0.7); opacity: 0; transition: opacity 0.3s ease;">

                        <!-- <span class="badge bg-primary mb-2"><?php echo $itemCategory; ?></span> -->
                        <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($project['title']); ?></h4>

                        <div class="project-links mt-2">
                            <?php if(!empty($project['link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank"
                                class="btn btn-light btn-sm mx-1 rounded-circle"
                                style="width: 35px; height: 35px; line-height: 23px;">
                                <i class="fas fa-link"></i>
                            </a>
                            <?php endif; ?>

                            <button type="button" class="btn btn-light btn-sm mx-1 rounded-circle" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $modalIndex; ?>" style="width: 35px; height: 35px; line-height: 23px;">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="imageModal<?php echo $modalIndex; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content bg-transparent border-0">
                        <div class="modal-header border-0 pb-1 justify-content-end">
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center p-0">
                            <img src="assets/images/projects/<?php echo htmlspecialchars($imageName); ?>" 
                                 class="img-fluid rounded shadow-lg mb-3" 
                                 alt="<?php echo htmlspecialchars($project['title']); ?>"
                                 style="max-height: 80vh; object-fit: contain;">
                            
                            <?php if(!empty($project['link'])): ?>
                            <div>
                                <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" class="btn btn-primary rounded-pill px-4 shadow">
                                    Visit Project <i class="fas fa-external-link-alt ms-2"></i>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            projectItems.forEach(item => {
                if (filterValue === 'all') {
                    item.style.display = 'block';
                } else {
                    if (item.classList.contains(filterValue)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
});
</script>

<style>
.project-card:hover .project-overlay {
    opacity: 1 !important;
}

.project-filters .btn.active {
    background-color: #0d6efd;
    color: white;
}

.project-item {
    transition: all 0.4s ease-in-out;
}

/* Modal Styling Improvements */
.modal-backdrop.show {
    opacity: 0.85; /* Thoda dark background achhe focus ke liye */
}
</style>


<!-- project section -->

<section id="projects" class="section-padding bg-light py-5">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Portfolio</h6>
            <h2 class="fw-bold mb-4">Latest Projects</h2>

            <div class="project-filters mb-4">
                <button class="btn btn-outline-primary active filter-btn" data-filter="all">All Projects</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Web">Web</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Mobile">Mobile</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Design">Design</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="Branding">Branding</button>
            </div>
        </div>

        <div class="row g-4" id="project-grid">
            <?php 
            $projects = getProjects($pdo);
            foreach($projects as $project): 
                // Admin se aayi category ko class me daal rahe hain taaki filter ho sake
                $itemCategory = htmlspecialchars($project['category']);
            ?>
            <div class="col-lg-4 col-md-6 project-item <?php echo $itemCategory; ?>" data-aos="fade-up">
                <div class="project-card position-relative overflow-hidden rounded shadow-sm">

                    <?php 
                        // Check if image exists in DB, otherwise use default.jpg
                            $imageName = !empty($project['image']) ? $project['image'] : 'default.jpg'; 
                                            ?>
                    <img src="assets/images/projects/<?php echo htmlspecialchars($imageName); ?>"
                        alt="<?php echo htmlspecialchars($project['title']); ?>" class="img-fluid w-100"
                        style="height: 250px; object-fit: cover;">

                    <div class="project-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center text-white p-4"
                        style="background: rgba(0,0,0,0.7); opacity: 0; transition: opacity 0.3s ease;">

                        <span class="badge bg-primary mb-2"><?php echo $itemCategory; ?></span>
                        <h4 class="fw-bold mb-3"><?php echo htmlspecialchars($project['title']); ?></h4>

                        <div class="project-links mt-2">
                            <?php if(!empty($project['link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank"
                                class="btn btn-light btn-sm mx-1 rounded-circle"
                                style="width: 35px; height: 35px; line-height: 23px;">
                                <i class="fas fa-link"></i>
                            </a>
                            <?php endif; ?>

                            <a href="<?php echo htmlspecialchars($project['github_link']); ?>" target="_blank"
                                class="btn btn-light btn-sm mx-1 rounded-circle"
                                style="width: 35px; height: 35px; line-height: 23px;">
                                <i class="fab fa-github"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectItems = document.querySelectorAll('.project-item');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            projectItems.forEach(item => {
                if (filterValue === 'all') {
                    item.style.display = 'block';
                } else {
                    if (item.classList.contains(filterValue)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        });
    });
});
</script>

<style>
.project-card:hover .project-overlay {
    opacity: 1 !important;
}

.project-filters .btn.active {
    background-color: #0d6efd;
    /* Your primary color */
    color: white;
}

.project-item {
    transition: all 0.4s ease-in-out;
}
</style>

<!-- Projects Section -->
<!-- <section id="projects" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Portfolio</h6>
            <h2 class="fw-bold">Latest Projects</h2>
        </div>
        <div class="row g-4">
            <?php 
            $projects = getProjects($pdo);
            foreach($projects as $project): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="project-card position-relative overflow-hidden rounded">
                    <img src="assets/images/projects/<?php echo $project['image'] ?? 'default.jpg'; ?>"
                        alt="<?php echo $project['title']; ?>" class="img-fluid w-100">
                    <div
                        class="project-overlay d-flex flex-column align-items-center justify-content-center text-center text-white p-4">
                        <span class="badge bg-primary mb-2"><?php echo $project['category']; ?></span>


                        
                    </div>
                    <h4 class="fw-bold"><?php echo $project['title']; ?></h4>
                    <div class="project-links mt-3">
                        <a href="<?php echo $project['link']; ?>" target="_blank" class="btn btn-light btn-sm mx-1"><i
                                class="fas fa-link"></i></a>
                        <?php if($project['github_link']): ?>
                        <a href="<?php echo $project['github_link']; ?>" target="_blank"
                            class="btn btn-light btn-sm mx-1"><i class="fab fa-github"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>
</section> -->



<!-- Experience & Education -->
<section id="experience" class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right">
                <h3 class="fw-bold mb-4"><i class="fas fa-briefcase text-primary me-2"></i> Experience</h3>
                <div class="timeline">
                    <?php 
                    $experiences = getExperiences($pdo);
                    foreach($experiences as $exp): ?>
                    <div class="timeline-item pb-4 position-relative ps-4">
                        <div class="timeline-dot bg-primary position-absolute start-0"></div>
                        <h5 class="fw-bold"><?php echo $exp['position']; ?></h5>
                        <p class="text-primary mb-1"><?php echo $exp['company']; ?> |
                            <?php echo format_date($exp['start_date']); ?> -
                            <?php echo $exp['is_current'] ? 'Present' : format_date($exp['end_date']); ?></p>
                        <p class="text-muted"><?php echo $exp['description']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h3 class="fw-bold mb-4"><i class="fas fa-graduation-cap text-primary me-2"></i> Education</h3>
                <div class="timeline">
                    <?php 
                    $education = getEducation($pdo);
                    foreach($education as $edu): ?>
                    <div class="timeline-item pb-4 position-relative ps-4">
                        <div class="timeline-dot bg-primary position-absolute start-0"></div>
                        <h5 class="fw-bold"><?php echo $edu['degree']; ?></h5>
                        <p class="text-primary mb-1"><?php echo $edu['institution']; ?> |
                            <?php echo format_date($edu['start_date']); ?> -
                            <?php echo format_date($edu['end_date']); ?></p>
                        <p class="text-muted"><?php echo $edu['description']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section id="testimonials" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Testimonials</h6>
            <h2 class="fw-bold">What Clients Say</h2>
        </div>
        <div class="swiper testimonial-slider" data-aos="fade-up">
            <div class="swiper-wrapper">
                <?php 
                $testimonials = getTestimonials($pdo);
                foreach($testimonials as $testi): ?>
                <div class="swiper-slide">
                    <div class="testimonial-card p-5 bg-white rounded shadow-sm text-center">
                        <img src="assets/images/testimonials/<?php echo $testi['client_image'] ?? 'default.png'; ?>"
                            alt="<?php echo $testi['client_name']; ?>" class="rounded-circle mb-4 shadow-sm"
                            width="100">
                        <p class="fst-italic mb-4">"<?php echo $testi['feedback']; ?>"</p>
                        <h5 class="fw-bold mb-1"><?php echo $testi['client_name']; ?></h5>
                        <span class="text-primary"><?php echo $testi['client_title']; ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary text-uppercase fw-bold mb-2">Contact Me</h6>
            <h2 class="fw-bold">Get In Touch</h2>
        </div>
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info">
                    <div class="d-flex mb-4">
                        <div class="contact-icon bg-primary-light text-primary p-3 rounded-circle me-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Email Me</h5>
                            <p class="text-muted mb-0"><?php echo $profile['email']; ?></p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="contact-icon bg-primary-light text-primary p-3 rounded-circle me-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Call Me</h5>
                            <p class="text-muted mb-0"><?php echo $profile['phone']; ?></p>
                        </div>
                    </div>
                    <div class="d-flex mb-4">
                        <div class="contact-icon bg-primary-light text-primary p-3 rounded-circle me-3">
                            <i class="fas fa-location-dot"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold">Location</h5>
                            <p class="text-muted mb-0"><?php echo $profile['address']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <form action="contact-submit.php" method="POST" class="contact-form bg-light p-5 rounded shadow-sm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>
                        <div class="col-12">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
                        <div class="col-12">
                            <textarea name="message" class="form-control" rows="5" placeholder="Message"
                                required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>