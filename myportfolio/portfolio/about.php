<?php

include 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';

$skills = mysqli_query(
$conn,
"SELECT * FROM skills ORDER BY percentage DESC"
);

$education = mysqli_query(
$conn,
"SELECT * FROM education ORDER BY id DESC"
);

$experience = mysqli_query(
$conn,
"SELECT * FROM experience ORDER BY id DESC"
);

?>



<section class="py-5 mt-5">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-5 text-center" data-aos="fade-right">

                <img src="assets/images/nitish.png" class="img-fluid rounded-circle shadow-lg" width="350">

            </div>

            <div class="col-lg-7" data-aos="fade-left">

                <h2 class="section-title text-start">
                    About Me
                </h2>

                <p class="lead">

                    Hello, I'm Nitish Kumar Yadav.

                    I am a passionate PHP Developer,
                    Web Developer and Android Developer
                    who loves creating modern,
                    responsive and scalable applications.

                </p>

                <p>

                    I specialize in PHP, MySQL,
                    Bootstrap, JavaScript and
                    Android Development.

                </p>

            </div>

        </div>

    </div>

</section>


<section class="py-5">

    <div class="container">

        <h2 class="section-title">
            My Skills
        </h2>

        <div class="row">

            <?php while($skill=mysqli_fetch_assoc($skills)): ?>

            <div class="col-md-6 mb-4">

                <div class="card-glass p-4">

                    <div class="d-flex justify-content-between">

                        <strong>
                            <?= $skill['skill_name'] ?>
                        </strong>

                        <span>
                            <?= $skill['percentage'] ?>%
                        </span>

                    </div>

                    <div class="progress mt-3" style="height:10px;">

                        <div class="progress-bar" style="
                            width:<?= $skill['percentage'] ?>%;
                            background:linear-gradient(
                                45deg,
                                #7c3aed,
                                #06b6d4
                                );
                            ">

                        </div>

                    </div>

                </div>

            </div>

            <?php endwhile; ?>

        </div>

    </div>

</section>


<section class="py-5">

    <div class="container">

        <h2 class="section-title">
            Education
        </h2>

        <div class="timeline">

            <?php while($edu=mysqli_fetch_assoc($education)): ?>

            <div class="timeline-item card-glass p-4 mb-4">

                <h4>
                    <?= $edu['degree'] ?>
                </h4>

                <h6>
                    <?= $edu['institute'] ?>
                </h6>

                <p>
                    <?= $edu['start_year'] ?>
                    -
                    <?= $edu['end_year'] ?>
                </p>

                <p>
                    <?= $edu['description'] ?>
                </p>

            </div>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <h2 class="section-title">
            Experience
        </h2>

        <?php while($exp=mysqli_fetch_assoc($experience)): ?>

        <div class="card-glass p-4 mb-4">

            <h4>
                <?= $exp['designation'] ?>
            </h4>

            <h6>
                <?= $exp['company_name'] ?>
            </h6>

            <p>

                <?= $exp['start_date'] ?>

                -

                <?= $exp['end_date'] ?>

            </p>

            <p>

                <?= $exp['description'] ?>

            </p>

        </div>

        <?php endwhile; ?>

    </div>

</section>



<?php include 'includes/footer.php'; ?>