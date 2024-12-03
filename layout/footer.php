<?php
$sql = "SELECT * FROM `admin` WHERE admin_id = '1' LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$name = $row['admin_name'];
$address1 = $row['website_address1'];
$address2 = $row['website_address2'];
$phone = $row['website_phoneNo'];
$email = $row['website_email'];

echo '<footer id="footer" class="footer mt-auto">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="index.php" class="logo d-flex align-items-center">
                        <span class="sitename">MyChar</span>
                    </a>
                    <p>MyChar is a charity fundraising website designed to facilitate donations and allow charity organizations to share their news and activities they conducted. </p>
                </div>
                <div class="col-lg-2 col-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="index.php#about">About us</a></li>
                        <li><a href="charitylist.php">Charity</a></li>
                        <li><a href="fundraising.php">Fundraising</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-6 footer-contact">
                    <h4>Contact Us</h4>
                    <p>' . $name . '</p>
                    <p>' . $address1 . '</p>
                    <p>' . $address2 . '</p>
                    <p class="mt-4"><strong>Phone:</strong> <span>' . $phone . '</span></p>
                    <p><strong>Email:</strong> <span>' . $email . '</span></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>'
?>