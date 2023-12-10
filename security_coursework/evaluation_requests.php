<?php
// This is a simplified example. In a real application, you'd have a proper authentication system and user roles.

// Check if the user is logged in. If not, redirect to the login page.
// You should replace this with your actual authentication logic.
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user has the administrator role. You should adjust this based on your actual role system.
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'administrator';

// If the user is not an administrator, display an error message and exit.
if (!$isAdmin) {
    echo "Access denied. You do not have permission to view this page.";
    exit();
}

// Establish a database connection (replace these credentials with your actual database credentials)
$servername = "your_database_host";
$username = "your_database_username";
$password = "your_database_password";
$dbname = "your_database_name";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch evaluation requests from the database
$sql = "SELECT user_id, comment, contact_method, file_path FROM evaluation_requests";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Requests</title>
    <!-- Add your stylesheets and scripts here -->
</head>
<body>
    <h1>Evaluation Requests</h1>

    <?php
    // Display the evaluation requests
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>User ID: " . $row["user_id"] . "</p>";
            echo "<p>Comment: " . $row["comment"] . "</p>";
            echo "<p>Contact Method: " . $row["contact_method"] . "</p>";
            echo "<p>File Path: " . $row["file_path"] . "</p>";
            echo "<hr>";
        }
    } else {
        echo "No evaluation requests found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
