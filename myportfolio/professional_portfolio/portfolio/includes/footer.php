<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <h4 class="fw-bold mb-0"><?php echo $profile['name'] ?? 'Portfolio'; ?></h4>
                <p class="mb-0 text-secondary"><?php echo $settings['footer_text'] ?? '&copy; ' . date('Y') . ' All Rights Reserved.'; ?></p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="social-links">
                    <?php if($profile['facebook']): ?><a href="<?php echo $profile['facebook']; ?>" class="text-white me-3"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if($profile['twitter']): ?><a href="<?php echo $profile['twitter']; ?>" class="text-white me-3"><i class="fab fa-twitter"></i></a><?php endif; ?>
                    <?php if($profile['linkedin']): ?><a href="<?php echo $profile['linkedin']; ?>" class="text-white me-3"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                    <?php if($profile['github']): ?><a href="<?php echo $profile['github']; ?>" class="text-white"><i class="fab fa-github"></i></a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/main.js"></script>


<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

<script src="https://cdn.jsdelivr.net/npm/typed.js@2.1.0/dist/typed.umd.js"></script>


<script>
    AOS.init();

new Typed('#typed', {
    strings: [
        'PHP Developer',
        'Web Developer',
        'Fronted Developer',
        'Full Stack Developer',
        'Web Designer',
        'Android Developer',
        'Freelancer'
        
    ],
    typeSpeed: 80,
    backSpeed: 50,
    loop: true
});

particlesJS("particles-js", {

    particles: {
        number: {
            value: 80
        },
        size: {
            value: 3
        },
        move: {
            speed: 2
        }
        
    }

});
</script>


</body>
</html>
