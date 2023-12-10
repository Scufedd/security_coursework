<?php
include 'includes/utils.php';  // Include the utility functions file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $contactNumber = $_POST["contact_number"];

    // Check password strength
    $strength = checkPasswordStrength($password);

    // Process registration if password is strong enough
    if ($strength > 2) {
        // Add your database connection and registration logic here
        // ...

        // Redirect to a success page or display a success message
        header("Location: registration_success.php");
        exit();
    } else {
        // Password is not strong enough, provide feedback to the user
        $passwordError = "Password is too weak. Please choose a stronger password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register</h1>
    <?php if (isset($passwordError)) { echo "<p class='error'>$passwordError</p>"; } ?> <!-- Display password error message -->
    <form method="POST" action="register.php"> <!-- Updated action to the current file -->
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Contact Number:</label>
        <input type="tel" name="contact_number" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
