<?php

const DOMAIN = 'http://localhost/restaurant-pistache/';

$firstName = isset($_POST['firstName']) ? $_POST['firstName'] : null;
$lastName = isset($_POST['lastName']) ? $_POST['lastName'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$phone = isset($_POST['phone']) ? $_POST['phone'] : null;
$message = isset($_POST['message']) ? $_POST['message'] : null;

// Check for missing required fields
if (!$firstName || !$lastName || !$email || !$phone || !$message) {
    die('Please fill in all required fields.');
}

// Database connection
$conn = new mysqli('localhost', 'root', '@NtLYa130580', 'restaurant-pistache');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
} else {
    // Insert form data into the database
    $stmt = $conn->prepare("INSERT INTO contact (firstName, lastName, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $message);
    $stmt->execute();
    
    // Close the statement and connection before redirecting
    $stmt->close();
    $conn->close();

    // Redirect back to contact.php with a success message
    header("Location: " . DOMAIN . "public/contact.php?success=1");
    exit();
}

