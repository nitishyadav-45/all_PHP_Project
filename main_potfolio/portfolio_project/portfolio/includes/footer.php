    <!-- Footer -->
    <footer class="footer py-5 mt-5">
        <div class="container text-center">
            <div class="social-links mb-4">
                <?php if($profile['facebook']): ?><a href="<?php echo $profile['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                <?php if($profile['twitter']): ?><a href="<?php echo $profile['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a><?php endif; ?>
                <?php if($profile['instagram']): ?><a href="<?php echo $profile['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a><?php endif; ?>
                <?php if($profile['linkedin']): ?><a href="<?php echo $profile['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
                <?php if($profile['github']): ?><a href="<?php echo $profile['github']; ?>" target="_blank"><i class="fab fa-github"></i></a><?php endif; ?>
            </div>
            <p class="mb-0">&copy; <?php echo date('Y'); ?> <?php echo $profile['name']; ?>. <?php echo $settings['footer_text'] ?? 'All Rights Reserved.'; ?></p>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></a>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/particles.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/swiper.js"></script>
    <script src="assets/js/typed.js"></script>
</body>
</html>
