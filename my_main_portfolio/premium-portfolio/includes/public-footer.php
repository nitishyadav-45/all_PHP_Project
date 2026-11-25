</main>
<footer class="site-footer">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-6">
                <p class="mb-0">&copy; <?= date('Y') ?> <?= e($profile['full_name'] ?? APP_NAME) ?>. All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <div class="social-links justify-content-md-end">
                    <?php if (!empty($profile['github_url'])): ?>
                        <a href="<?= e($profile['github_url']) ?>" target="_blank" rel="noopener" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($profile['linkedin_url'])): ?>
                        <a href="<?= e($profile['linkedin_url']) ?>" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($profile['x_url'])): ?>
                        <a href="<?= e($profile['x_url']) ?>" target="_blank" rel="noopener" aria-label="X"><i class="fa-brands fa-x-twitter"></i></a>
                    <?php endif; ?>
                    <?php if (!empty($profile['instagram_url'])): ?>
                        <a href="<?= e($profile['instagram_url']) ?>" target="_blank" rel="noopener" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<button class="scroll-top" id="scrollTop" type="button" aria-label="Back to top">
    <i class="fa-solid fa-arrow-up"></i>
</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="<?= asset('js/main.js') ?>"></script>
</body>
</html>

