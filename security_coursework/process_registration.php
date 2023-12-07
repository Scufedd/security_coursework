<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $name = $_POST["name"];
    $contactNumber = $_POST["contact_number"];

    // Perform registration logic (insert into database, etc.)

    echo "Registration successful!";
} else {
    echo "Invalid request.";
}
?>
