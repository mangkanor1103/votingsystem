<?php
    include 'includes/session.php';

    // Handle form submission to generate codes
    if(isset($_POST['generate'])){
        $quantity = intval($_POST['quantity']); // Assuming you have a field in your form to input the quantity of codes

        for ($i = 0; $i < $quantity; $i++) {
            // Generate voter ID
            $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $voter = substr(str_shuffle($set), 0, 15);

            $sql = "INSERT INTO voters (voters_id) VALUES ('$voter')";
            if($conn->query($sql)){
                $_SESSION['success'] = 'Codes generated successfully';
            }
            else{
                $_SESSION['error'] = $conn->error;
            }
        }
        header('location: voters.php');
        exit(); // Terminate script execution after redirection
    }

    // Handle form submission to clear all voters
    if(isset($_POST['clear'])){
        $sql = "DELETE FROM voters";
        if($conn->query($sql)){
            $_SESSION['success'] = 'All voters cleared successfully';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }
        header('location: voters.php');
        exit(); // Terminate script execution after redirection
    }
?>

<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-green sidebar-mini"> <!-- Change skin-blue to skin-green -->
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Voters List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Voters</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <form action="" method="post" id="generateForm">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label>Generate Codes:</label>
                      <input type="number" name="quantity" class="form-control" placeholder="Enter quantity">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" name="generate" class="btn btn-primary" style="margin-top: 25px;">Generate</button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="button" id="clearAllButton" class="btn btn-danger" style="margin-top: 25px;">Clear All</button>
                    </div>
                  </div>
                </div>
              </form>
              <form action="" method="post" id="clearForm" style="display: none;">
                <input type="hidden" name="clear">
              </form>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Voters ID</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    // Retrieve voters from the database
                    $sql = "SELECT * FROM voters";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                        echo "
                          <tr>
                            <td>".$row['voters_id']."</td>
                            <td>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-voter='".$row['voters_id']."'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                          </tr>
                        ";
                      }
                    } else {
                      echo "<tr><td colspan='2'>No voters found</td></tr>";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/voters_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    var voterToDelete = $(this).data('voter');
    if(confirm("Are you sure you want to delete this voter?")) {
      $.ajax({
        type: 'POST',
        url: 'voters_delete.php', // create this file to handle deletion
        data: {voter: voterToDelete},
        success: function(response){
          window.location.reload();
        }
      });
    }
  });

  // Remove the "Show Entries" text box
  $('.dataTables_length').hide();

  // Handle Clear All button click
  $('#clearAllButton').on('click', function(e){
    e.preventDefault();
    if(confirm("Are you sure you want to clear all voters?")) {
      $('#clearForm').submit();
    }
  });
});
</script>
</body>
</html>
