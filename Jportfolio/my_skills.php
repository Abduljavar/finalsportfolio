<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
// Initialize variables
$formSubmitted = false;
$mainSkillId = 1; // Example main skill ID to edit

// Database connection variables
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
try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Update logic here (similar to insert, but with UPDATE SQL command)
        $mainSkill = htmlspecialchars($_POST['main-skill']);
        $stmt = $conn->prepare("UPDATE main_skills SET skill_name = :skill_name WHERE id = :id");
        $stmt->bindParam(':skill_name', $mainSkill);
        $stmt->bindParam(':id', $mainSkillId);
        $stmt->execute();

        // Assuming subskills are completely replaced for simplicity
        // First, delete existing subskills
        $stmt = $conn->prepare("DELETE FROM subskills WHERE main_skill_id = :main_skill_id");
        $stmt->bindParam(':main_skill_id', $mainSkillId);
        $stmt->execute();

        // Insert new subskills
        foreach ($_POST['subskill'] as $subskill) {
            $subskillClean = htmlspecialchars($subskill);
            $stmt = $conn->prepare("INSERT INTO subskills (main_skill_id, subskill_name) VALUES (:main_skill_id, :subskill_name)");
            $stmt->bindParam(':main_skill_id', $mainSkillId);
            $stmt->bindParam(':subskill_name', $subskillClean);
            $stmt->execute();
        }

        $formSubmitted = true;
    }

    // Fetch existing main skill and subskills to display
    $stmt = $conn->prepare("SELECT skill_name FROM main_skills WHERE id = :id");
    $stmt->bindParam(':id', $mainSkillId);
    $stmt->execute();
    $mainSkillName = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT subskill_name FROM subskills WHERE main_skill_id = :main_skill_id");
    $stmt->bindParam(':main_skill_id', $mainSkillId);
    $stmt->execute();
    $subskills = $stmt->fetchAll(PDO::FETCH_COLUMN);

} catch(PDOException $e) {
    echo "<script>alert('Connection failed: " . $e->getMessage() . "');</script>";
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
      <a class="nav-link active" href="my_skills.php">
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


<div class="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h2 class="text-center">Project Settings</h2></div>
                    <div class="card-body">
                        <?php if ($formSubmitted): ?>
                            <div class="alert alert-success" role="alert">Skills updated successfully!</div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="main-skill" class="form-label">Main Skill:</label>
                                <input type="text" class="form-control" id="main-skill" name="main-skill" placeholder="Enter your main skill" value="<?php echo htmlspecialchars($mainSkillName); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Subskills:</label>
                                <div id="subskills-container">
                                    <?php foreach ($subskills as $subskill): ?>
                                        <input type="text" class="form-control mt-2" name="subskill[]" placeholder="Enter a subskill" value="<?php echo htmlspecialchars($subskill); ?>">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="addSubskill()">Add Subskill</button>
                            <br><br>
                            <button type="submit" class="btn btn-success mt-3">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addSubskill() {
        var container = document.getElementById("subskills-container");
        var newInput = document.createElement("input");
        newInput.setAttribute("type", "text");
        newInput.setAttribute("name", "subskill[]");
        newInput.setAttribute("placeholder", "Enter a subskill");
        newInput.setAttribute("class", "form-control mt-2");
        container.appendChild(newInput);
    }
</script>

</body>
</html>