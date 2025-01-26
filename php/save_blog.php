<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: ../html/login_page.html");
    exit();
}

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

// Retrieve blog data from the form
$title = $_POST['title'];
$content = $_POST['content'];
$author_id = $_SESSION['user_id']; // Get the author's ID from the session

$sql_max_id = "SELECT MAX(blog_id) AS max_id FROM blogs";
$result_max_id = $conn->query($sql_max_id);
$row_max_id = $result_max_id->fetch_assoc();
$max_id = $row_max_id["max_id"];
echo $max_id;

// Increment the numeric part of the blog_id
$new_numeric_part = intval(substr($max_id, 1)) + 1;
echo $new_numeric_part;
$formatted_blog_id = "B" . str_pad($new_numeric_part, 8, "0", STR_PAD_LEFT);

// Prepare and execute SQL statement using prepared statement
$sql_insert = "INSERT INTO blogs (blog_id, title, author, content, date_created) 
               VALUES (?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("ssss", $formatted_blog_id, $title, $author_id, $content);

if ($stmt->execute()) {
    // Increment num_blogs value in users table
    $sql_update = "UPDATE users SET num_blogs = num_blogs + 1 WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("s", $author_id);
    $stmt_update->execute();
    header("Location: ../index.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
