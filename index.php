<?php
  session_start();
  if(isset($_SESSION['admin'])){
    header('location: admin/home.php');
  }

  if(isset($_SESSION['voter'])){
    header('location: home.php');
  }
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition login-page" style="background-image: url('slides_1.jpg'); color: #fff;"> <!-- Change background image URL and text color -->
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
        <p class="login-box-msg">Sign in to start your session</p> <!-- Remove text color to match the theme -->

        <form action="login.php" method="POST">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="voter" placeholder="Voter's ID" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat" name="login"> <!-- Change button color to green -->
                        <i class="fa fa-sign-in"></i> Sign In
                    </button>
                </div>
            </div>
        </form>
    </div>
    <?php
        if(isset($_SESSION['error'])){
            echo "
                <div class='callout callout-danger text-center mt20' style='background-color: #e74c3c;'> <!-- Change callout background color to red -->
                    <p>".$_SESSION['error']."</p> 
                </div>
            ";
            unset($_SESSION['error']);
        }
    ?>
    <div class="text-center">
        <a href="admin/index.php" class="btn btn-default btn-block"><i class="fa fa-lock"></i> Admin</a>
    </div>
    <div class="text-center mt20"> <!-- Remove text color to match the theme -->
        <p>If you want to create your own election, please <a href="https://www.facebook.com/kianr873" style="color: #fff; text-decoration: underline;">contact us</a>.</p> <!-- Change text color to white and add underline -->
    </div>
</div>
    
<?php include 'includes/scripts.php' ?>
</body>
</html>
