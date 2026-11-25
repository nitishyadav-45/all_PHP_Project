<section id="projects" class="section-padding bg-light">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold">Latest Projects</h2>
            <div class="line mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php foreach ($projects as $project): ?>
            <div class="col-md-4" data-aos="flip-left">
                <div class="project-card position-relative overflow-hidden rounded shadow">
                    <img src="uploads/projects/<?php echo $project['image']; ?>" alt="<?php echo $project['title']; ?>" class="img-fluid w-100">
                    <div class="project-overlay d-flex flex-column justify-content-center align-items-center text-white text-center p-4">
                        <h4 class="fw-bold"><?php echo $project['title']; ?></h4>
                        <p><?php echo $project['category']; ?></p>
                        <a href="<?php echo $project['link']; ?>" target="_blank" class="btn btn-light btn-sm rounded-pill px-4">View Project</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
