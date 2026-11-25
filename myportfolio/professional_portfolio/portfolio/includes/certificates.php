<section id="certificates" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Certificates</h2>
            <div class="line mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php foreach ($certificates as $cert): ?>
            <div class="col-md-4" data-aos="zoom-in">
                <div class="cert-card bg-white p-4 rounded shadow-sm h-100 text-center">
                    <?php if($cert['image']): ?>
                    <img src="uploads/certificates/<?php echo $cert['image']; ?>" alt="<?php echo $cert['title']; ?>" class="img-fluid mb-3 rounded">
                    <?php endif; ?>
                    <h5 class="fw-bold"><?php echo $cert['title']; ?></h5>
                    <p class="text-primary mb-1"><?php echo $cert['issuer']; ?></p>
                    <p class="text-muted small"><?php echo $cert['date']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
