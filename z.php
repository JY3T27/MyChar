<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-stats div {
            text-align: center;
        }
        .section-header {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <!-- Profile Header -->
        <div class="row align-items-center bg-light p-4 rounded">
            <div class="col-md-auto text-center text-md-start">
                <img src="charity-logo.jpg" alt="Charity Logo" class="profile-img">
            </div>
            <div class="col">
                <h2 class="mb-0">Charity Name</h2>
                <p class="text-muted mb-0">Charity Mission Statement or Tagline</p>
            </div>
            <div class="col-md-auto mt-3 mt-md-0">
                <div class="d-flex justify-content-between">
                    <div class="me-3">
                        <strong>120</strong>
                        <p class="mb-0">Projects</p>
                    </div>
                    <div class="me-3">
                        <strong>5,000</strong>
                        <p class="mb-0">Donors</p>
                    </div>
                    <div>
                        <strong>$1M</strong>
                        <p class="mb-0">Funds Raised</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <div class="section-header">
            <h4>About Us</h4>
        </div>
        <div class="row">
            <!-- Mission -->
            <div class="col-md-6">
                <h5>Our Mission</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non libero vel nisi facilisis venenatis.</p>
            </div>
            <!-- Vision -->
            <div class="col-md-6">
                <h5>Our Vision</h5>
                <p>Praesent at orci eget ligula sollicitudin feugiat. Integer volutpat justo nec lorem tincidunt auctor.</p>
            </div>
        </div>

        <!-- History -->
        <div class="section-header">
            <h4>Our History</h4>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nec orci vel arcu cursus sollicitudin. Fusce in lectus et turpis auctor tristique at vitae ligula. Sed malesuada justo sed eros convallis, eget vehicula massa interdum.</p>

        <!-- Achievements -->
        <div class="section-header">
            <h4>Achievements</h4>
        </div>
        <ul>
            <li>Raised over $1M for global healthcare projects.</li>
            <li>Completed 120+ community service projects worldwide.</li>
            <li>Partnered with 200+ organizations to improve education access.</li>
        </ul>

        <!-- Team -->
        <div class="section-header">
            <h4>Meet Our Team</h4>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="team-member1.jpg" alt="Team Member" class="profile-img mb-2">
                <h6>John Doe</h6>
                <p class="text-muted">Founder & CEO</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="team-member2.jpg" alt="Team Member" class="profile-img mb-2">
                <h6>Jane Smith</h6>
                <p class="text-muted">Project Manager</p>
            </div>
            <div class="col-md-4 text-center">
                <img src="team-member3.jpg" alt="Team Member" class="profile-img mb-2">
                <h6>Michael Brown</h6>
                <p class="text-muted">Volunteer Coordinator</p>
            </div>
        </div>

        <!-- Contact Information -->
         
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
