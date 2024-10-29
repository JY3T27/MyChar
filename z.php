<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Card with Tabs</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="card">
  <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" id="card-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="tab-home" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab-profile" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="tab-contact" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
      </li>
    </ul>
  </div>
  <div class="card-body">
    <div class="tab-content" id="card-tabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="tab-home">
        <h5 class="card-title">Home</h5>
        <p class="card-text">Content for Home tab.</p>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="tab-profile">
        <h5 class="card-title">Profile</h5>
        <p class="card-text">Content for Profile tab.</p>
      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="tab-contact">
        <h5 class="card-title">Contact</h5>
        <p class="card-text">Content for Contact tab.</p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
