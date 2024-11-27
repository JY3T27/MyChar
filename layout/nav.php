<?php
if (isset($_SESSION["UID"])) {
    if ($_SESSION['role'] == "charity") {
        echo '<header id="header" class="header d-flex align-items-center fixed-top">
                <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">
                    <a href="index.php" class="logo d-flex align-items-center me-auto">
                        <!-- Uncomment the line below if you also wish to use an image logo -->
                        <!-- <img src="assets/img/logo.png" alt=""> -->
                        <h1 class="sitename">MyChar</h1>
                    </a>
                    <nav id="navmenu" class="navmenu">
                        <ul>
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="index.php#about">About</a></li>
                            <li><a href="charitylist.php">Charity</a></li>
                            <li><a href="fundraising.php">Fundraising</a></li>
                            <li class="dropdown"><a href="#"><span>User</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="profile.php">Profile</a></li>
                                    <li><a href="report.php">Report</a></li>
                                    <li><a href="logout.php" onClick="return confirm(\'Confirm log out?\')">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </div>
            </header>';
    } elseif ($_SESSION['role'] == "donor") {
        echo '<header id="header" class="header d-flex align-items-center fixed-top">
                <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">
                    <a href="index.php" class="logo d-flex align-items-center me-auto">
                        <!-- Uncomment the line below if you also wish to use an image logo -->
                        <!-- <img src="assets/img/logo.png" alt=""> -->
                        <h1 class="sitename">MyChar</h1>
                    </a>
                    <nav id="navmenu" class="navmenu">
                        <ul>
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="index.php#about">About</a></li>
                            <li><a href="charitylist.php">Charity</a></li>
                            <li><a href="fundraising.php">Fundraising</a></li>
                            <li class="dropdown"><a href="#"><span>User</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="profile.php">Profile</a></li>
                                    <li><a href="history_donor.php">History</a></li>
                                    <li><a href="feedback.php">Feedback</a></li>
                                    <li><a href="report.php">Report</a></li>
                                    <li><a href="logout.php" onClick="return confirm(\'Confirm log out?\')">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </div>
            </header>';
    } else {
        echo '<header id="header" class="header d-flex align-items-center fixed-top">
                <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">
                    <a href="index.php" class="logo d-flex align-items-center me-auto">
                        <!-- Uncomment the line below if you also wish to use an image logo -->
                        <!-- <img src="assets/img/logo.png" alt=""> -->
                        <h1 class="sitename">MyChar</h1>
                    </a>
                    <nav id="navmenu" class="navmenu">
                        <ul>
                            <li><a href="index.php" class="active">Home</a></li>
                            <li><a href="index.php#about">About</a></li>
                            <li><a href="charitylist.php">Charity</a></li>
                            <li><a href="fundraising.php">Fundraising</a></li>
                            <li class="dropdown"><a href="#"><span>Admin</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                                <ul>
                                    <li><a href="profile.php">Profile</a></li>
                                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                                    <li><a href="logout.php" onClick="return confirm(\'Confirm log out?\')">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </div>
            </header>';
    }
} else {
    echo '<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-end">
        <a href="index.php" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename">MyChar</h1>
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="charitylist.php">Charity</a></li>
                <li><a href="fundraising.php">Fundraising</a></li>
            </ul>
        </nav>
        <a class="btn-getstarted" href="login.php">Get Started</a>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </div>
</header>';
}
