<section id="experience" class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Experience & Education</h2>
            <div class="line mx-auto"></div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-5" data-aos="fade-right">
                <h3 class="mb-4"><i class="fas fa-briefcase text-primary me-2"></i> Experience</h3>
                <div class="timeline">
                    <?php foreach ($experience as $exp): ?>
                    <div class="timeline-item border-start border-primary border-3 ps-4 pb-4 position-relative">
                        <div class="dot bg-primary position-absolute rounded-circle" style="width: 15px; height: 15px; left: -9px; top: 0;"></div>
                        <h5 class="fw-bold mb-1"><?php echo $exp['role']; ?></h5>
                        <h6 class="text-primary mb-2"><?php echo $exp['company']; ?> | <?php echo $exp['duration']; ?></h6>
                        <p class="text-muted mb-0"><?php echo $exp['description']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-6" data-aos="fade-left">
                <h3 class="mb-4"><i class="fas fa-graduation-cap text-primary me-2"></i> Education</h3>
                <div class="timeline">
                    <?php foreach ($education as $edu): ?>
                    <div class="timeline-item border-start border-primary border-3 ps-4 pb-4 position-relative">
                        <div class="dot bg-primary position-absolute rounded-circle" style="width: 15px; height: 15px; left: -9px; top: 0;"></div>
                        <h5 class="fw-bold mb-1"><?php echo $edu['degree']; ?></h5>
                        <h6 class="text-primary mb-2"><?php echo $edu['institution']; ?> | <?php echo $edu['year']; ?></h6>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
