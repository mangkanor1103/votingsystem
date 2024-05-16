<?php
session_start();

// Include the database connection file
include 'includes/conn.php';

// Handle admin sign-up form submission
if(isset($_POST['signup'])){
    // Sanitize input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);

    // Handle file upload for photo
    $photo = '';
    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
        $photo_dir = 'uploads/';
        $photo_name = time() . '_' . $_FILES['photo']['name'];
        $target_file = $photo_dir . $photo_name;
        if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)){
            $photo = $target_file;
        }
    }

    // Prepare and execute SQL query to insert admin data into database
    $sql = "INSERT INTO admin (username, password, firstname, lastname, photo, created_on) VALUES ('$username', '$password', '$firstname', '$lastname', '$photo', CURDATE())";
    if($conn->query($sql) === TRUE){
        $_SESSION['success'] = "Admin account created successfully!";
        header('location: index.php'); // Redirect to index.php after sign-up
        exit(); // Ensure script stops executing after redirection
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Include header
include 'includes/header.php';
?>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Voting System</b>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg">Sign up as Admin</p>

        <!-- Admin sign-up form -->
        <form action="signup.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
            </div>
            <div class="form-group">
                <label for="photo">Upload Photo:</label>
                <input type="file" class="form-control" name="photo" accept="image/*">
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" name="signup"><i class="fa fa-user-plus"></i> Sign Up</button>
                </div>
            </div>
        </form>

        <!-- Display success or error message -->
        <?php
        if(isset($_SESSION['success'])){
            echo "
                <div class='callout callout-success text-center mt20'>
                    <p>".$_SESSION['success']."</p> 
                </div>
            ";
            unset($_SESSION['success']); // Clear the success message
        }
        if(isset($_SESSION['error'])){
            echo "
                <div class='callout callout-danger text-center mt20'>
                    <p>".$_SESSION['error']."</p> 
                </div>
            ";
            unset($_SESSION['error']); // Clear the error message
        }
        ?>
    </div>
</div>

<!-- Back button -->
<div class="text-center mt-20">
    <a href="index.php" class="btn btn-default btn-block btn-flat"><i class="fa fa-arrow-left"></i> Back to Login</a>
</div>

<?php include 'includes/scripts.php' ?>
</body>
</html>
