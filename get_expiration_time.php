<?php
// Include the database connection file
include 'includes/conn.php';

// Include the session file to access session variables
include 'includes/session.php';

// Query to fetch expiration time based on the user's code
$sql = "SELECT expiration_time FROM codes WHERE user_id = :user_id"; // Adjust table and column names as per your database structure
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id']); // Assuming you have a user_id stored in the session
$stmt->execute();

// Fetch the expiration time from the database
$expiration_time = $stmt->fetchColumn();

// Echo the expiration time as the response
echo $expiration_time;
?>
