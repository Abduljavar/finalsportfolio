<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Include the MySQL connection code here
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

// Function to sanitize user inputs
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle CRUD operations
// Handle CRUD operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["create"])) {
      // Create operation
      $title = sanitizeInput($_POST["title"]);
      $date = sanitizeInput($_POST["date"]);
      $description = sanitizeInput($_POST["description"]);
      $website_link = sanitizeInput($_POST["website_link"]);
      $languages_used = sanitizeInput($_POST["languages_used"]);

      // Handle file upload for photo
      $photo_name = $_FILES["photo"]["name"];
      $photo_tmp = $_FILES["photo"]["tmp_name"];
      move_uploaded_file($photo_tmp, "uploads/" . $photo_name);

      // Handle file upload for system file
      $system_file_name = $_FILES["system_file"]["name"];
      $system_file_tmp = $_FILES["system_file"]["tmp_name"];
      move_uploaded_file($system_file_tmp, "uploads/" . $system_file_name);

      // Insert new content into the database
      $stmt = $conn->prepare("INSERT INTO content (title, date, description, website_link, languages_used, file_photo, system_file) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", $title, $date, $description, $website_link, $languages_used, $photo_name, $system_file_name);
      $stmt->execute();
      $stmt->close();
  } elseif (isset($_POST["update"])) {
      // Update operation
      $title = sanitizeInput($_POST["title"]);
      $date = sanitizeInput($_POST["date"]);
      $description = sanitizeInput($_POST["description"]);
      $website_link = sanitizeInput($_POST["website_link"]);
      $languages_used = sanitizeInput($_POST["languages_used"]);
      $content_id = $_POST["content_id"];

      // Update content in the database
      $stmt = $conn->prepare("UPDATE content SET title=?, date=?, description=?, website_link=?, languages_used=? WHERE id=?");
      $stmt->bind_param("sssssi", $title, $date, $description, $website_link, $languages_used, $content_id);
      $stmt->execute();
      $stmt->close();
  } elseif (isset($_POST["delete"])) {
      // Delete operation
      $content_id = $_POST["content_id"];

      // Delete content from the database
      $stmt = $conn->prepare("DELETE FROM content WHERE id=?");
      $stmt->bind_param("i", $content_id);
      $stmt->execute();
      $stmt->close();
  } elseif (isset($_POST["edit"])) {
      // Edit operation: Redirect to edit page
      $content_id = $_POST["content_id"];
      header("Location: edit_content.php?id=" . $content_id);
      exit();
  }
}


// Fetch all content from the database
$sql = "SELECT * FROM content";
$result = $conn->query($sql);

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

<div class="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link" href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i>Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="account_settings.php">
        <i class="fas fa-users"></i>Account Settings
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="project_settings.php">
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Project Settings</h2>
                </div>
                <div class="card-body">
                    <!-- Create form -->
                 <!-- Create form -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
    </div>
    <div class="form-group">
        <label for="website_link">Website Link:</label>
        <input type="url" class="form-control" id="website_link" name="website_link" required>
    </div>
    <div class="form-group">
        <label for="languages_used">Languages Used:</label>
        <input type="text" class="form-control" id="languages_used" name="languages_used" required>
    </div>
    <div class="form-group">
        <label for="photo">Photo:</label>
        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" required>
    </div>
    <div class="form-group">
        <label for="system_file">System File:</label>
        <input type="file" class="form-control-file" id="system_file" name="system_file" required>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="create">Create</button>
    </div>
</form>

                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
    <div class="col-md-15">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Content List</h2>
            </div>
            <!-- Content List Table -->
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Website Link</th>
                            <th>Languages Used</th>
                            <th>Photo</th> <!-- New column for Photo -->
                            <th>System File</th> <!-- New column for System File -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["website_link"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["languages_used"]) . "</td>";
                                // Display photo if available
                                $photoPath = !empty($row["file_photo"]) ? "uploads/" . htmlspecialchars($row["file_photo"]) : "No photo available";
                                echo "<td>";
                                if ($photoPath != "No photo available") {
                                    echo "<img src='" . $photoPath . "' style='width: 100px;'>";
                                } else {
                                    echo $photoPath;
                                }
                                echo "</td>";
                                // Display system file name if available
                                $systemFilePath = !empty($row["system_file"]) ? htmlspecialchars($row["system_file"]) : "No file available";
                                echo "<td>" . $systemFilePath . "</td>";
                                // Actions
                                echo "<td>";
                                echo "<form method='post' action=''>";
                                echo "<input type='hidden' name='content_id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' class='btn btn-sm btn-info' name='edit'>Edit</button>";
                                echo "<button type='submit' class='btn btn-sm btn-danger ml-1' name='delete'>Delete</button>";
                                echo "</form>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8'>No content available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>