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

// Handle content update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $content_id = $_POST["content_id"];
    $title = sanitizeInput($_POST["title"]);
    $date = sanitizeInput($_POST["date"]);
    $description = sanitizeInput($_POST["description"]);

    // Check if new photo file is uploaded
    if ($_FILES["photo"]["size"] > 0) {
        $photo_name = $_FILES["photo"]["name"];
        $photo_tmp = $_FILES["photo"]["tmp_name"];
        move_uploaded_file($photo_tmp, "uploads/" . $photo_name);

        // Update photo file in database
        $sql_photo = "UPDATE content SET file_photo = '$photo_name' WHERE id = $content_id";
        $conn->query($sql_photo);
    }

    // Check if new system file is uploaded
    if ($_FILES["system_file"]["size"] > 0) {
        $system_file_name = $_FILES["system_file"]["name"];
        $system_file_tmp = $_FILES["system_file"]["tmp_name"];
        move_uploaded_file($system_file_tmp, "uploads/" . $system_file_name);

        // Update system file in database
        $sql_system_file = "UPDATE content SET system_file = '$system_file_name' WHERE id = $content_id";
        $conn->query($sql_system_file);
    }

    // Update other content details in database
    $sql_content = "UPDATE content SET title = '$title', date = '$date', description = '$description' WHERE id = $content_id";
    $conn->query($sql_content);

    // Redirect to content list page after update
    header("Location: project_settings.php");
    exit();
}

// Close database connection
$conn->close();
?>
