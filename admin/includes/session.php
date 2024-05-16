<?php
	session_start();
	include 'includes/conn.php';

	if(!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
		header('location: index.php');
		exit(); // Make sure to exit after redirecting
	}
	 else {
		// For regular admins, continue fetching user information
		$sql = "SELECT * FROM admin WHERE id = '".$_SESSION['admin']."'";
		$query = $conn->query($sql);
		$user = $query->fetch_assoc();
	}
?>
