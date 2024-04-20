<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Custom Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      z-index: 100;
      padding-top: 56px;
      padding-bottom: 20px;
      width: 250px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      background-color: #343a40;
      color: #fff;
    }
    .sidebar .nav-link {
      color: #fff;
    }
    .sidebar .nav-link i {
      margin-right: 10px;
    }
    .sidebar .nav-link.active {
      background-color: #23272b;
    }
    .main-content {
      margin-left: 250px;
      padding: 20px;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link active" href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i>Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="account_settings.php">
        <i class="fas fa-users"></i>Account Settings
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="project_settings.php">
        <i class="fas fa-cogs"></i>Project Settings
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="my_info.php">
      <i class="fas fa-user"></i>My info
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="my_skills.php">
      <i class="fas fa-chart-bar"></i>Skills
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="messages.php">
      <i class="fas fa-chart-bar"></i>Messages
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logout.php">
        <i class="fas fa-sign-out-alt"></i>Logout
      </a>
    </li>
  </ul>
</div>

<!-- Main Content -->
<div class="main-content">
  <h1>Dashboard</h1>
  <p>Welcome to the admin dashboard.</p>
</div>

<!-- Bootstrap JS and jQuery (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
