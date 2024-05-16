<?php
include 'includes/conn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $adminId = $_POST['edit_admin_id'];
    $username = $_POST['edit_admin_username'];
    $password = $_POST['edit_admin_password']; // You should hash the password before storing it in the database
    $firstname = $_POST['edit_admin_firstname'];
    $lastname = $_POST['edit_admin_lastname'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the corresponding admin record in the database
    $sql = "UPDATE admin SET username='$username', password='$hashed_password', firstname='$firstname', lastname='$lastname' WHERE id=$adminId";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = 'Admin updated successfully';
    } else {
        $_SESSION['error'] = 'Error updating admin: ' . $conn->error;
    }
}

// Redirect back to the page
header("Location: superadmin.php");
exit();
?>
