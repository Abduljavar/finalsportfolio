<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="styles.css" rel="stylesheet">
  <title>Portfolio Website</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-<hash>" crossorigin="anonymous" />

</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">Javier.dev</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="#home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#projects">Projects</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#about">About Me</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php
session_start();

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

// Fetch the user's information

$messageSent = false;
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your MySQL connection code here
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

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sss", $name, $email, $message);

    // Set parameters and execute
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $stmt->execute();

    // Close statement
    $stmt->close();

    // Close MySQL connection
    $conn->close();

    // Redirect to a thank you page or display a success message
    $messageSent = true;
  }

?>

<?php
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


// Fetch the first row from the database
$sql = "SELECT * FROM myinfo LIMIT 1";
$result = $conn->query($sql);

// Close database connection
$conn->close();
?>
<?php
// Check if there are rows returned from the query
if ($result->num_rows > 0) {
  // Fetch the first row
  $row = $result->fetch_assoc();
  ?>
  <!-- Homepage Sections -->
  <section id="home" class="jumbotron text-left">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <p class="lead"><?php echo htmlspecialchars($row["short_description"]); ?>
        </div>
        <div class="col-md-6">
          <?php if (isset($row['profile_picture1'])): ?>
            <img src="<?php echo htmlspecialchars($row['profile_picture1']); ?>" alt="Profile Picture 1" class="img-fluid profile-image">
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
<?php
} else {
  echo "No homepage details found.";
}
?>




<?php
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


// Fetch all content from the database
$sql = "SELECT * FROM content";
$result = $conn->query($sql);

// Close database connection
$conn->close();
?>

<style>
.card.project-card {
  overflow: hidden; /* Hide overflow content */
  height: 650px; /* Adjust based on your content */
  transition: height 0.3s ease; /* Optional: Smooth height transition */
}

.card-text.overflow-hidden {
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2; /* Adjust line clamp as needed */
  -webkit-box-orient: vertical;
}

.full-description {
  display: none; /* Hidden by default */
}

.show-more {
  cursor: pointer;
  color: blue;
  text-decoration: underline;
}
</style>

<section id="projects" class="feature-box">
  <h1 class="mb-4">My Projects</h1>
  <div class="row">
    <?php
    // Check if there are rows returned from the query
    if ($result->num_rows > 0) {
      // Loop through each row of data
      while($row = $result->fetch_assoc()) {
    ?>
     <div class="col-md-4">
    <div class="card project-card">
      
        <img src="uploads/<?php echo htmlspecialchars($row["file_photo"]); ?>" class="card-img-top" alt="Project Photo">
        <div class="card-body">
            <h5 class="card-title">Title: <?php echo htmlspecialchars($row["title"]); ?></h5>
            <p class="card-text">Date: <?php echo htmlspecialchars($row["date"]); ?></p>
            <p class="card-text">Languages Used: <?php echo htmlspecialchars($row["languages_used"]); ?></p>
            <p class="card-text">Website Link: <a href="<?php echo htmlspecialchars($row["website_link"]); ?>" target="_blank"><?php echo htmlspecialchars($row["website_link"]); ?></a></p>
            <p class="card-text overflow-hidden"><?php echo htmlspecialchars($row["description"]); ?></p>
            <p class="show-more">See More</p>
            <p class="card-text full-description"><?php echo htmlspecialchars($row["description"]); ?></p>
            <!-- Hidden full description -->
            <!-- Add more project details here if needed -->
        </div>
    </div>
</div>

    <?php
        }
    } else {
        echo "No projects found.";
    }
    ?>
  </div>
</section>






<?php
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

$sql = "SELECT * FROM myinfo limit 1";
$result = $conn->query($sql);

// Close database connection
$conn->close();
?>

<?php
// Check if there are rows returned from the query
if ($result->num_rows > 0) {
  // Loop through each row of data
  while($row = $result->fetch_assoc()) {
    ?>
    <section id="about" class="jumbotron text-left">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="about-section text-center">
            <img src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture" class="img-fluid1">
            <h2 class="mb-3 mt-25"><?php echo $row['full_name']; ?></h2>
            <p><?php echo $row['long_description']; ?></p>
          </div>
        </div>
      </div>
    </section>
    <?php
  }
} else {
  echo "No about me found.";
}
?>





<section id="contact" class="feature-box bg-light py-5">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="contact-section">
          <h2 class="text-center mb-4">Contact Me</h2>
          <?php if ($messageSent): ?>
    <div class="alert alert-success">Your message has been sent!</div>
<?php endif; ?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
  </div>
  <div class="form-group">
    <label for="message">Message</label>
    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message"></textarea>
  </div>
  <button type="submit" class="btn btn-primary btn-block">Send Message</button>
</form>

          
        </div>
      </div>
    </div>
  </div>
</section>




<script>
document.querySelectorAll('.show-more').forEach(item => {
  item.addEventListener('click', function() {
    const card = this.closest('.project-card');
    const cardBody = card.querySelector('.card-body');
    const overflowDescription = cardBody.querySelector('.card-text.overflow-hidden');
    const fullDescription = cardBody.querySelector('.full-description');

    overflowDescription.style.display = 'none';
    fullDescription.style.display = 'block';
    card.style.height = 'auto'; // Let the card expand to fit the full content

    // Hide the "See More" button
    item.style.display = 'none';

    // Set a timeout to revert to original state after 1 minute (60000 milliseconds)
    setTimeout(() => {
      overflowDescription.style.display = 'block';
      fullDescription.style.display = 'none';
      card.style.height = ''; // Reset height
      // Show the "See More" button again
      item.style.display = 'block';
    }, 60000); // 1 minute
  });
});
</script>
<!-- Bootstrap JS and jQuery (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
