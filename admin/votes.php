<?php
include 'includes/session.php';

if(isset($_POST['clear'])){
    $sql = "TRUNCATE TABLE votes"; // This will delete all rows in the 'votes' table
    if($conn->query($sql)){
        $_SESSION['success'] = 'All votes cleared successfully';
    }
    else{
        $_SESSION['error'] = $conn->error;
    }
    header('location: votes.php');
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
        Votes
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Votes</li>
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
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Position</th>
                  <th>Candidate</th>
                  <th>Voter ID</th>
                </thead>
                <tbody>
                  <?php
                    $sql = "SELECT votes.*, positions.description AS position, CONCAT(candidates.firstname, ' ', candidates.lastname) AS candidate_name, voters.voters_id FROM votes
                            LEFT JOIN positions ON votes.position_id = positions.id
                            LEFT JOIN candidates ON votes.candidate_id = candidates.id
                            LEFT JOIN voters ON votes.voters_id = voters.id";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".$row['position']."</td>
                          <td>".$row['candidate_name']."</td>
                          <td>".$row['voters_id']."</td>
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
            <div class="box-footer">
              <button type="button" id="clearAllButton" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i> Clear All</button>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/votes_modal.php'; ?>
  <form action="" method="post" id="clearForm" style="display: none;">
    <input type="hidden" name="clear">
  </form>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  // Handle Clear All button click
  $('#clearAllButton').on('click', function(e){
    e.preventDefault();
    if(confirm("Are you sure you want to clear all votes?")) {
      $('#clearForm').submit();
    }
  });
});
</script>
</body>
</html>
