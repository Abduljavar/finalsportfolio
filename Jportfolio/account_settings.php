<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$servername = "sql213.infinityfree.com"; // Replace with your server name
$username = "if0_36393238"; // Replace with your database username
$password = "ZW53mSHbHGLo"; // Replace with your database password
$dbname = "if0_36393238_javierportfoliodb"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch the user's information
$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $_SESSION["email"]);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Close prepared statement
$stmt->close();

// Handle form submission for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Prepare the update SQL query
  $sql_update = "UPDATE users SET username=?, email=?, password=?, age=? WHERE email=?";
  $types = "sssis"; // Types for the parameters
  $params = array($_POST["username"], $_POST["email"], $_POST["password"], $_POST["age"], $_SESSION["email"]);

  // Prepare and execute the update statement
  $stmt_update = $conn->prepare($sql_update);
  $stmt_update->bind_param($types, ...$params);
  $stmt_update->execute();

  // Update session variable if email is changed
  $_SESSION["email"] = $_POST["email"];

  // Redirect to account settings page after update
  header("Location: account_settings.php");
  exit();
}

// Close database connection
$conn->close();
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
      <a class="nav-link" href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i>Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="account_settings.php">
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
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Account Settings</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user["username"]; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user["email"]; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $user["password"]; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="number" class="form-control" id="age" name="age" value="<?php echo $user["age"]; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Bootstrap JS and jQuery (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
