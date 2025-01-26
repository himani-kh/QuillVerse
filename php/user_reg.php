<?php
session_start();
var_dump($_POST);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "sql111.infinityfree.com";
$username = "if0_38173944";
$password = "FB8x4t55Kgsg6K";
$dbname = "if0_38173944_quillverse";

// Add debugging statement
echo "Connecting to database...<br>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the latest user ID from the database
// Retrieve the maximum user ID from the database
$sql = "SELECT MAX(user_id) AS max_id FROM users";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $latest_user_id = $row["max_id"];

    // Extract numeric part of the user ID and convert to integer
    $numeric_part = intval(substr($latest_user_id, 2)); // Assuming "QV" prefix

    // Increment the numeric part
    $new_numeric_part = $numeric_part + 1;

    // Generate the new user ID with the formatted prefix and padded numeric part
    $formatted_user_id = "QV" . str_pad($new_numeric_part, 5, "0", STR_PAD_LEFT);
} else {
    // If no existing user IDs found, start with a default value
    $formatted_user_id = "QV00001";
}

// Prepare data for insertion
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$bio = $_POST['bio'];
$dob = $_POST['date'];
$doj = date("Y-m-d"); // Set Date of Joining to current date
$gender = $_POST['gender'];

// Insert data into the database
$sql = "INSERT INTO users (user_id, username, email, password, name, bio, dob, doj, gender)
VALUES ('$formatted_user_id', '$username', '$email', '$password', '$name', '$bio', '$dob', '$doj', '$gender')";

// Add debugging statement
echo "Executing SQL query: $sql<br>";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";

    // Set number of blogs written to 0 for the new user
    $sql_update = "UPDATE users SET num_blogs = 0 WHERE user_id = '$formatted_user_id'";

    // Add debugging statement
    echo "Executing SQL query: $sql_update<br>";

    $conn->query($sql_update);

    // Redirect to theme_choice.html after successful registration
    $_SESSION['user_id'] = $formatted_user_id;
    header("Location: ../html/theme_choice.html");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

