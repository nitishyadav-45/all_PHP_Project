<!-- <section class="hero-section">


    <div class="container">

        <div id="particles-js"></div>

        <div class="row align-items-center">


            <div class="col-lg-6">

                <h1 class="hero-title">

                    Hi, I'm

                    <span class="gradient-text">
                        <?php echo $profile['name'] ?? 'Nitish Kumar Yadav'; ?>
                    </span>

                </h1> -->

                <!-- <h3 class="h4 mb-4 text-secondary"><?php echo $profile['title'] ?? 'FullStack Developer'; ?><span id="typed"></span></h3> -->
                
                
                <!-- <h3 class="  mb-4 text-secondary"><span id="typed"></span></h3>

                <p class="lead mb-5"><?php echo $profile['bio'] ?? 'I build high-quality websites and applications.'; ?>
                </p>


                <a href="#contact" class="btn btn-gradient btn-lg">

                    Hire Me

                </a>

                <a href="#project" class="btn btn-outline-light btn-lg ms-2">

                    View Work

                </a>

            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-img-wrapper">
                    <img src="<?php echo $profile['image'] ? 'uploads/profile/'.$profile['image'] : 'assets/images/default-profile.png'; ?>"
                        alt="Profile" class="img-fluid rounded-circle shadow-lg border border-5 border-primary">
                </div>
            </div>

        </div>

    </div>

</section>

<hr> -->



<section class="hero-section d-flex align-items-center position-relative">

    <div id="particles-js" class="position-absolute w-100 h-100 top-0 start-0" style="z-index: 0;"></div>

    <div class="container position-relative" style="z-index: 1;">

        <div class="row align-items-center text-center text-lg-start">

            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="hero-title fw-bold">
                    Hi, I'm
                    <span class="gradient-text">
                        <?php echo $profile['name'] ?? 'Nitish Kumar Yadav'; ?>
                    </span>
                </h1>

                <h3 class="mb-4 text-secondary">
                    <span id="typed"></span>
                </h3>

                <p class="lead mb-5">
                    <?php echo $profile['bio'] ?? 'I build high-quality websites and applications.'; ?>
                </p>

                <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                    <a href="#contact" class="btn btn-primary btn-lg">
                        Hire Me
                    </a>
                    <a href="#project" class="btn btn-outline-light btn-lg">
                        View Work
                    </a>
                </div>
            </div>

            <div class="col-lg-6 text-center">
                <div class="hero-img-wrapper">
                    <img src="<?php echo $profile['image'] ? 'uploads/profile/'.$profile['image'] : 'assets/images/default-profile.png'; ?>"
                        alt="Profile"
                        class="img-fluid rounded-circle shadow-lg border border-5 border-primary custom-profile-img">
                </div>
            </div>

        </div>
    </div>
</section>

<hr>