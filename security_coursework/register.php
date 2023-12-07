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
    <form method="POST" action="process_registration.php">
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
