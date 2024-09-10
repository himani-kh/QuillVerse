<?php
session_start();

// Database connection parameters
$servername = "localhost"; // Change this if your MySQL server is hosted elsewhere
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "quillverse"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user ID from session
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve selected themes from the form
    if(isset($_POST['themes']) && is_array($_POST['themes'])) {
        // Prepare an array to store the themes
        $themes = array();

        // Loop through each selected theme and sanitize it
        foreach($_POST['themes'] as $theme) {
            $themes[] = $conn->real_escape_string($theme);
        }

        // Update the database with the selected themes
        $sql_update = "UPDATE users SET theme1 = '{$themes[0]}', theme2 = '{$themes[1]}', theme3 = '{$themes[2]}', theme4 = '{$themes[3]}', theme5 = '{$themes[4]}' WHERE user_id = '$user_id'";

        // Execute the update query
        if ($conn->query($sql_update) === TRUE) {
            // Redirect to index.html
            header("Location: ../html/login_page.html");
            exit; // Ensure that no further code is executed after redirection
        } else {
            echo "Error updating themes: " . $conn->error;
        }
    } else {
        echo "No themes selected";
    }
} else {
    echo "User ID not found in session";
}

// Close the database connection
$conn->close();
?>
