<section id="about" class="section-padding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-up">
                <img src="<?php echo $profile['image'] ? 'uploads/profile/'.$profile['image'] : 'assets/images/default-profile.png'; ?>" alt="About Me" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-7 ps-lg-5" data-aos="fade-up" data-aos-delay="200">
                <div class="section-title">
                    <h2 class="fw-bold">About Me</h2>
                    <div class="line"></div>
                </div>
                <p class="mb-4"><?php echo $profile['bio'] ?? 'Write something about yourself here.'; ?></p>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <p><strong>Name:</strong> <?php echo $profile['name'] ?? ''; ?></p>
                        <p><strong>Email:</strong> <?php echo $profile['email'] ?? ''; ?></p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>Phone:</strong> <?php echo $profile['phone'] ?? ''; ?></p>
                        <p><strong>Address:</strong> <?php echo $profile['address'] ?? ''; ?></p>
                    </div>
                </div>
                <a href="resume-download.php" class="btn btn-primary px-4 py-2"><i class="fas fa-download me-2"></i> Download CV</a>
            </div>
        </div>
    </div>
</section>
