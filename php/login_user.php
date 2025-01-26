<?php
session_start();

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

// Retrieve user input
$email = $_POST['email'];
$password = $_POST['password'];

// Query to fetch user data based on email
$sql = "SELECT * FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    echo $row['password'];
    if (!strcmp($password, $row['password'])) {
        // Password is correct, set up session
        $_SESSION['user_id'] = $row['user_id'];

        // Set session cookie to expire after 30 days
        $expire = time() + (30 * 24 * 3600);
        setcookie('user_id', $row['user_id'], $expire, '/');

        // Redirect to dashboard or any other page
        header("Location: ../index.php");
        exit();
    } else {
        // Password is incorrect
        echo "Incorrect password. Please try again.";
    }
} else {
    // User not found
    echo "User not found. Please register first.";
}

$conn->close();
?>
