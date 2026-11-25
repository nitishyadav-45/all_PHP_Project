<section id="services" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">My Services</h2>
            <div class="line mx-auto"></div>
            <p class="text-muted">What I offer to my clients</p>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $service): ?>
            <div class="col-md-4" data-aos="zoom-in">
                <div class="service-card text-center p-5 bg-white shadow-sm rounded h-100">
                    <div class="service-icon mb-4">
                        <i class="<?php echo $service['icon']; ?> fa-3x text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3"><?php echo $service['title']; ?></h4>
                    <p class="text-muted mb-0"><?php echo $service['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
