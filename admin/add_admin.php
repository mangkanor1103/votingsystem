<?php
include 'includes/conn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST['username'];
    $password = $_POST['password']; // You should hash the password before storing it in the database
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into the database
    $sql = "INSERT INTO admin (username, password, firstname, lastname) VALUES ('$username', '$hashed_password', '$firstname', '$lastname')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = 'Admin added successfully';
    } else {
        $_SESSION['error'] = 'Error adding admin: ' . $conn->error;
    }
}

// Redirect back to the page
header("Location: superadmin.php");
exit();
?>
