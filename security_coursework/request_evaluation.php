<?php
// This is a simplified example. In a real application, you'd have a proper authentication system.

// Check if the user is logged in. If not, redirect to the login page.
// You should replace this with your actual authentication logic.
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user input
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
    $contactMethod = mysqli_real_escape_string($conn, $_POST["contact_method"]);

    // Handle file upload
    $targetDirectory = "uploads/";  // Create a directory named "uploads" in the same directory as this script
    $targetFile = $targetDirectory . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image or a fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, the file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 2 MB in this example)
    if ($_FILES["file"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, move the file to the target directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO evaluation_requests (user_id, comment, contact_method, file_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $_SESSION['user_id'], $comment, $contactMethod, $targetFile);
    $stmt->execute();

    // Close the statement
    $stmt->close();

    // For demonstration purposes, let's just display a success message
    echo "Request submitted successfully!";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Evaluation</title>
    <!-- Add your stylesheets and scripts here -->
</head>
<body>
    <h1>Request Evaluation</h1>
    <form method="POST" action="request_evaluation.php" enctype="multipart/form-data">
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="4" cols="50" required></textarea><br>

        <label for="contact_method">Preferred Contact Method:</label>
        <select name="contact_method" id="contact_method">
            <option value="phone">Phone</option>
            <option value="email">Email</option>
        </select><br>

        <label for="file">Upload Photo:</label>
        <input type="file" name="file" id="file" accept="image/*" required><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
