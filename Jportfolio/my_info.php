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

// Fetch user information
$sql = "SELECT * FROM myinfo";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "0 results";
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process input fields
    $full_name = $_POST["full_name"];
    $long_description = $_POST["long_description"];
    $short_description = $_POST["short_description"];
    $linkedin_link = $_POST["linkedin_link"];
    $twitter_link = $_POST["twitter_link"];
    $github_link = $_POST["github_link"];
    $instagram_link = $_POST["instagram_link"];
    $email_link = $_POST["email_link"];
    $facebook_link = $_POST["facebook_link"];

    // Handle uploaded profile picture
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        // Move uploaded file to desired directory
        move_uploaded_file($file_tmp_name, 'uploads/' . $file_name);
        $profile_picture = 'uploads/' . $file_name;
    } else {
        // Use existing profile picture from database
        $profile_picture = isset($row['profile_picture']) ? $row['profile_picture'] : '';
    }

    // Handle uploaded profile picture 1
    $profile_picture1 = '';
    if (isset($_FILES['profile_picture1']) && $_FILES['profile_picture1']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name1 = $_FILES['profile_picture1']['tmp_name'];
        $file_name1 = $_FILES['profile_picture1']['name'];
        // Move uploaded file to desired directory
        move_uploaded_file($file_tmp_name1, 'uploads/' . $file_name1);
        $profile_picture1 = 'uploads/' . $file_name1;
    } else {
        // Use existing profile picture 1 from database
        $profile_picture1 = isset($row['profile_picture1']) ? $row['profile_picture1'] : '';
    }

    // Update user information in the database
    $update_sql = "UPDATE myinfo SET full_name='$full_name', long_description='$long_description', short_description='$short_description', linkedin_link='$linkedin_link', twitter_link='$twitter_link', github_link='$github_link', instagram_link='$instagram_link', email_link='$email_link', facebook_link='$facebook_link', profile_picture='$profile_picture', profile_picture1='$profile_picture1' WHERE id=" . $row['id'];

    // Execute the SQL UPDATE statement
    if ($conn->query($update_sql) === TRUE) {
        echo "Record updated successfully";
        // Reload the page to reflect changes
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input My Info</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
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

<!-- Sidebar -->
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
            <a class="nav-link active" href="my_info.php">
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

<!-- HTML form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title text-center">Input My Info</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <!-- Input fields for user information -->
                        <div class="form-group">
                            <label for="full_name">Full Name:</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo isset($row['full_name']) ? htmlspecialchars($row['full_name']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="long_description">Long Description:</label>
                            <textarea class="form-control" id="long_description" name="long_description" rows="5"><?php echo isset($row['long_description']) ? htmlspecialchars($row['long_description']) : ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="short_description">Short Description:</label>
                            <input type="text" class="form-control" id="short_description" name="short_description" value="<?php echo isset($row['short_description']) ? htmlspecialchars($row['short_description']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="linkedin_link">LinkedIn Link:</label>
                            <input type="text" class="form-control" id="linkedin_link" name="linkedin_link" value="<?php echo isset($row['linkedin_link']) ? htmlspecialchars($row['linkedin_link']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="twitter_link">Twitter Link:</label>
                            <input type="text" class="form-control" id="twitter_link" name="twitter_link" value="<?php echo isset($row['twitter_link']) ? htmlspecialchars($row['twitter_link']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="github_link">GitHub Link:</label>
                            <input type="text" class="form-control" id="github_link" name="github_link" value="<?php echo isset($row['github_link']) ? htmlspecialchars($row['github_link']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="instagram_link">Instagram Link:</label>
                            <input type="text" class="form-control" id="instagram_link" name="instagram_link" value="<?php echo isset($row['instagram_link']) ? htmlspecialchars($row['instagram_link']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email_link">Email Link:</label>
                            <input type="text" class="form-control" id="email_link" name="email_link" value="<?php echo isset($row['email_link']) ? htmlspecialchars($row['email_link']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="facebook_link">Facebook Link:</label>
                            <input type="text" class="form-control" id="facebook_link" name="facebook_link" value="<?php echo isset($row['facebook_link']) ? htmlspecialchars($row['facebook_link']) : ''; ?>">
                        </div>
                        <!-- Profile picture upload -->
                        <div class="form-group">
                            <label for="profile_picture">Profile Picture:</label>
                            <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                            <!-- Display the uploaded profile picture if it exists -->
                            <?php if (isset($row['profile_picture'])): ?>
                                <img src="<?php echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile Picture" class="img-fluid profile-image">
                            <?php endif; ?>
                        </div>
                        <!-- Profile picture 1 upload -->
                        <div class="form-group">
                            <label for="profile_picture1">Profile Picture 1:</label>
                            <input type="file" class="form-control-file" id="profile_picture1" name="profile_picture1">
                            <!-- Display the uploaded profile picture 1 if it exists -->
                            <?php if (isset($row['profile_picture1'])): ?>
                                <img src="<?php echo htmlspecialchars($row['profile_picture1']); ?>" alt="Profile Picture 1" class="img-fluid profile-image">
                            <?php endif; ?>
                        </div>
                        <!-- Other input fields for your information -->
                        <div class="form-group">
                            <!-- Add your other input fields here -->
                        </div>
                        <!-- Update button -->
                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
