<section id="contact" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Contact Me</h2>
            <div class="line mx-auto"></div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4" data-aos="fade-up">
                <div class="contact-info-card p-4 bg-white shadow-sm rounded mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-map-marker-alt text-primary fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Location</h5>
                            <p class="mb-0 text-muted"><?php echo $profile['address'] ?? ''; ?></p>
                        </div>
                    </div>
                </div>
                <div class="contact-info-card p-4 bg-white shadow-sm rounded mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-envelope text-primary fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Email</h5>
                            <p class="mb-0 text-muted"><?php echo $profile['email'] ?? ''; ?></p>
                        </div>
                    </div>
                </div>
                <div class="contact-info-card p-4 bg-white shadow-sm rounded">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-phone text-primary fa-2x me-3"></i>
                        <div>
                            <h5 class="mb-0 fw-bold">Phone</h5>
                            <p class="mb-0 text-muted"><?php echo $profile['phone'] ?? ''; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-form p-4 bg-white shadow-sm rounded">
                    <form action="contact-submit.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control p-3" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control p-3" placeholder="Your Email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control p-3" placeholder="Subject" required>
                            </div>
                            <div class="col-12">
                                <textarea name="message" class="form-control p-3" rows="5" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
