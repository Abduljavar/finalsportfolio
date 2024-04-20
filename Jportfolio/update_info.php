<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
// Database connection parameters
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


// Retrieve form data
$long_description = htmlspecialchars($_POST['long_description']);
$short_description = htmlspecialchars($_POST['short_description']);
$linkedin_link = htmlspecialchars($_POST['linkedin_link']);
$twitter_link = htmlspecialchars($_POST['twitter_link']);
$github_link = htmlspecialchars($_POST['github_link']);
$instagram_link = htmlspecialchars($_POST['instagram_link']);
$email_link = htmlspecialchars($_POST['email_link']);
$facebook_link = htmlspecialchars($_POST['facebook_link']);

// Update the database
$sql = "UPDATE myinfo SET long_description=?, short_description=?, linkedin_link=?, twitter_link=?, github_link=?, instagram_link=?, email_link=?, facebook_link=? WHERE id=1"; // Assuming you're updating a specific row with id=1
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $long_description, $short_description, $linkedin_link, $twitter_link, $github_link, $instagram_link, $email_link, $facebook_link);

if ($stmt->execute()) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
