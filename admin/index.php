<?php
    session_start();
    if(isset($_SESSION['admin'])){
        header('location:home.php');
    }
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition login-page" style="background-image: url('slides_3.jpg'); color: #fff;"> <!-- Change background image URL and text color -->
<div class="login-box">
    <div style="position: absolute; top: 10px; left: 10px;">
        <img src="pics/Picture5.jpg" alt="University Logo 1" style="max-width: 150px; border-radius: 50%;"> <!-- Adjust max-width to make the logo bigger and apply border-radius -->
    </div>
    <div style="position: absolute; top: 10px; right: 10px;">
        <img src="pics/logo.jpg" alt="University Logo 2" style="max-width: 150px; border-radius: 50%;"> <!-- Adjust max-width to make the logo bigger and apply border-radius -->
    </div>
    <div class="login-logo" style="text-align: center;">
        <b>Mindoro State University Online Voting System</b> <!-- Remove text color to match the theme -->
    </div>
  
    <div class="login-box-body">
        <p class="login-box-msg">Sign in as an administrator</p> <!-- Change text color to Mantis -->

        <form action="login.php" method="POST">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button> <!-- Change button color to green -->
                </div>
            </div>
        </form>
    </div>
    <?php
        if(isset($_SESSION['error'])){
            echo "
                <div class='callout callout-danger text-center mt20'>
                    <p>".$_SESSION['error']."</p> 
                </div>
            ";
            unset($_SESSION['error']);
        }
    ?>
    <div class="text-center">
        <a href="../index.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Homepage</a>
    </div>
</div>
    
<?php include 'includes/scripts.php' ?>
</body>
</html>
