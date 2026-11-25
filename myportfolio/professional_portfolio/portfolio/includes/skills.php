<section id="skills" class="section-padding">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">My Skills</h2>
            <div class="line mx-auto"></div>
        </div>
        <div class="row">
            <?php foreach ($skills as $skill): ?>
            <div class="col-md-6 mb-4" data-aos="fade-up">
                <div class="skill-item">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold"><?php echo $skill['name']; ?></span>
                        <span><?php echo $skill['percentage']; ?>%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $skill['percentage']; ?>%"></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
