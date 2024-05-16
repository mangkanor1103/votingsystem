<?php
session_start();
include 'includes/conn.php'; // Include database connection

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in the admin table
    $sql_admin = "SELECT * FROM admin WHERE username = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $username);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if (!$result_admin) {
        die("Error in SQL query: " . $conn->error);
    }

    if ($result_admin->num_rows > 0) {
        $row = $result_admin->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Check if it's a super admin
            $_SESSION['admin'] = $row['id'];
            header('Location: home.php');
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password for admin';
            header('Location: index.php');
            exit();
        }
    }

    // If no matching username is found in the admin table
    $_SESSION['error'] = 'Cannot find account with the username';
    header('Location: index.php');
    exit();
} else {
    $_SESSION['error'] = 'Please input admin credentials';
    header('Location: index.php');
    exit();
}
?>
