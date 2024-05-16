<?php
include 'includes/conn.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $adminId = $_GET['id'];

    // Delete the admin record from the database
    $sql = "DELETE FROM admin WHERE id=$adminId";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = 'Admin deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting admin: ' . $conn->error;
    }
}

// Redirect back to the page
header("Location: superadmin.php");
exit();
?>
