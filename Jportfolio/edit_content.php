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

// Fetch content based on ID
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $content_id = $_GET["id"];
    $sql = "SELECT * FROM content WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $content_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Content details retrieved, you can use these values to populate form fields for editing
        $title = $row["title"];
        $date = $row["date"];
        $description = $row["description"];
        $website_link = $row["website_link"];
        $languages_used = $row["languages_used"];
        // You can continue with other fields as needed
    } else {
        // Content with provided ID not found
        echo "Content not found.";
        exit();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Content</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Edit Content</h2>
                </div>
                <div class="card-body">
                    <!-- Edit form -->
<form method="post" action="update_content.php" enctype="multipart/form-data">
    <input type="hidden" name="content_id" value="<?php echo $content_id; ?>">
    <div class="form-group">
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $description; ?></textarea>
    </div>
    <div class="form-group">
        <label for="website_link">Website Link:</label>
        <input type="text" class="form-control" id="website_link" name="website_link" value="<?php echo $website_link; ?>">
    </div>
    <div class="form-group">
        <label for="languages_used">Language Used:</label>
        <input type="text" class="form-control" id="languages_used" name="languages_used" value="<?php echo $languages_used; ?>">
    </div>
    <div class="form-group">
        <label for="photo">Photo:</label>
        <?php if (!empty($row["file_photo"])): ?>
            <img src="uploads/<?php echo htmlspecialchars($row["file_photo"]); ?>" alt="Current Photo" style="max-width: 200px; display: block; margin-bottom: 10px;">
        <?php endif; ?>
        <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
        <small class="form-text text-muted">Leave blank if you don't want to update the photo.</small>
    </div>
    <div class="form-group">
        <label for="system_file">System File:</label>
        <?php if (!empty($row["system_file"])): ?>
            
        <?php endif; ?>
        <input type="file" class="form-control-file" id="system_file" name="system_file">
        <small class="form-text text-muted">Leave blank if you don't want to update the system file.</small>
    </div>
    <button type="submit" class="btn btn-primary" name="update">Update</button>
    <button type="button" class="btn btn-secondary"onclick="goBack()">Go Back</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>


<script>
function goBack() {
  window.location.href = 'project_settings.php'; // Set the URL of project_settings.php
}
</script>
<!-- Bootstrap JS and jQuery (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
