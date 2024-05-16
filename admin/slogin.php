<?php
session_start();
include 'includes/conn.php'; // Include database connection

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in the superadmin table
    $sql_superadmin = "SELECT * FROM superadmin WHERE username = ?";
    $stmt_superadmin = $conn->prepare($sql_superadmin);
    $stmt_superadmin->bind_param("s", $username);
    $stmt_superadmin->execute();
    $result_superadmin = $stmt_superadmin->get_result();

    if (!$result_superadmin) {
        die("Error in SQL query: " . $conn->error);
    }

    if ($result_superadmin->num_rows > 0) {
        $row = $result_superadmin->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['super_admin'] = $row['id'];
            header('Location: superadmin.php');
            exit();
        } else {
            $_SESSION['error'] = 'Incorrect password for superadmin';
            header('Location: superadmin_login.php');
            exit();
        }
    }

    // If no matching username is found in the superadmin table
    $_SESSION['error'] = 'Cannot find account with the username';
    header('Location: superadmin_login.php');
    exit();
} else {
    $_SESSION['error'] = 'Please input superadmin credentials';
    header('Location: superadmin_login.php');
    exit();
}
?>
