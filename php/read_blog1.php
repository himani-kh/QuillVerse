<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Read a Blog</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('https://source.unsplash.com/800x600/?writing');
      background-size: cover;
      background-position: center;
      font-family: Arial, sans-serif;
      color: #333;
    }

    .blog-post {
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      margin: 50px auto;
      max-width: 800px;
    }

    .blog-post-title {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 20px;
      text-align: center;
    }

    .blog-post-text {
      font-size: 1.2rem;
      line-height: 1.8;
    }
  </style>
</head>
<body>

<?php
// Retrieve the blog post title and content from the URL parameters
$title = $_GET['title'];
$content = $_GET['content'];

// Database connection parameters
$servername = "sql111.infinityfree.com";
$username = "if0_38173944";
$password = "FB8x4t55Kgsg6K";
$dbname = "if0_38173944_quillverse";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve author's name from the database based on the author ID
$sql = "SELECT author FROM blogs WHERE title='{$_GET['title']}'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $author_id = $row["author"];

    // Retrieve author's name from the database based on the author ID
    $sql_author = "SELECT name FROM users WHERE user_id = '$author_id'";
    $result_author = $conn->query($sql_author);

    if ($result_author->num_rows > 0) {
        $row_author = $result_author->fetch_assoc();
        $author_name = $row_author["name"];
    } else {
        $author_name = "Unknown";
    }
} else {
    // No blog post found with the specified ID
    $author_name = "Unknown";
}

$conn->close();
?>

<div class="blog-post">
  <h2 class="blog-post-title"><?php echo $title; ?></h2>
  <div class="blog-post-content">
    <p class="blog-post-text"><?php echo $content; ?></p>
  </div>
  <div class="blog-post-author"><b>Written by: </b><?php echo $author_name; ?></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>