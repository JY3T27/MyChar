<?php 
session_start();
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include 'layout/header.php';
    ?>
</head>
<body class="index-page">
    <?php
    include 'layout/nav.php';
    ?>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in" class="">

            <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2>Get to know MyChar</h2>
                        <p>We gather the charities in Malaysia</p>
                        <a href="#about" class="btn-get-started">Get Started</a>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container py-5">
                <div class="row pt-5 gy-4">
                    <div class="col-lg-6 position-relative align-self-start order-lg-last order-first" data-aos="fade-up" data-aos-delay="200">
                        <img src="assets/img/about.jpg" class="img-fluid" alt="">
                        <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn"></a>
                    </div>
                    <div class="col-lg-6 content order-last  order-lg-first" data-aos="fade-up" data-aos-delay="100">
                        <h3>About Us</h3>
                        <p>
                            Dolor iure expedita id fuga asperiores qui sunt consequatur minima. Quidem voluptas deleniti. Sit quia molestiae quia quas qui magnam itaque veritatis dolores. Corrupti totam ut eius incidunt reiciendis veritatis asperiores placeat.
                        </p>
                        <ul>
                            <li>
                                <i class="bi bi-diagram-3"></i>
                                <div>
                                    <h5>Ullamco laboris nisi ut aliquip consequat</h5>
                                    <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
                                </div>
                            </li>
                            <li>
                                <i class="bi bi-fullscreen-exit"></i>
                                <div>
                                    <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                                    <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
                                </div>
                            </li>
                            <li>
                                <i class="bi bi-broadcast"></i>
                                <div>
                                    <h5>Voluptatem et qui exercitationem</h5>
                                    <p>Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime veniam</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <?php 
        include 'layout/footer.php';
        ?>
    </main>
</body>
</html>