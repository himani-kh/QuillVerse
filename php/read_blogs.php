<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reading Blog</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .hero {
      background-image: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
      background-size: cover;
      background-position: center;
      height: 500px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .blog-post {
      padding: 30px;
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      flex: 0 0 auto;
      width: 300px; /* Set a fixed width for each blog post */
      margin-right: 20px; /* Add some spacing between blog posts */
    }

    .blog-post:hover {
      transform: translateY(-10px);
    }

    .blog-post img {
      max-width: 100%;
      height: auto;
      border-radius: 10px;
    }

    .blog-container {
      display: flex;
      overflow-x: auto; /* Enable horizontal scrolling */
      padding-bottom: 20px; /* Add some space at the bottom for clarity */
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Read</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>

  <!-- Hero Section -->
  <div class="hero">
    <div class="container">
      <h1 class="display-4"><b>Discover Your Next Read</b></h1>
      <p class="lead"><b>Uncover captivating stories and insightful musings</b></p>
    </div>
  </div>

  <!-- Blog Posts -->
  <div class="container my-5">
    <h2 class="mb-4 text-center">Latest Blog Posts</h2>
    <div class="blog-container">
    <?php
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

      // Query to fetch all blogs from the database
      $sql = "SELECT * FROM blogs ORDER BY blog_id DESC";
      $result = $conn->query($sql);

      // Array of image filenames (you should upload these images to your server)
      $image_files = [
          'cover1.jpg', 'cover2.jpg', 'cover3.jpg', 'cover4.jpg', 'cover5.jpg','cover6.jpg'
      ];

      $image_index = 0;  // Start with the first image

      if ($result->num_rows > 0) {
          // Output data of each row
          while ($row = $result->fetch_assoc()) {
              // Get the title for the image
              $title = $row["title"];
              
              // Get the image URL (cycling through the 10 images)
              $image_url = '../assets/covers/' . $image_files[$image_index];
              
              // Update image index (loop back to 0 after 10 images)
              $image_index = ($image_index + 1) % count($image_files);

              echo '<div class="blog-post mr-4">';
              echo '<img src="' . $image_url . '" alt="Blog Post Image">';
              echo '<div class="blog-post-content">';
              echo '<h3 class="mt-1">' . $row["title"] . '</h3>';
              
              // Display only beginning few words with overflow hidden
              $content = $row["content"];
              $word_limit = 50; // Adjust the number of words to display
              $content_words = explode(' ', $content);
              $short_content = implode(' ', array_slice($content_words, 0, $word_limit));
              echo '<p style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $short_content . '</p>';
              
              echo '<a href="read_blog1.php?title=' . urlencode($row["title"]) . '&content=' . urlencode($row["content"]) . '" class="btn btn-primary">Read More</a>';
              echo '</div></div>';
          }
      } else {
          echo "No blogs found";
      }
      $conn->close();
    ?>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>