<?php
include 'includes/session.php';

if(isset($_POST['voter'])){
  $voter = $_POST['voter'];
  $sql = "DELETE FROM voters WHERE voters_id = '$voter'";
  if($conn->query($sql)){
    $_SESSION['success'] = 'Voter deleted successfully';
  }
  else{
    $_SESSION['error'] = $conn->error;
  }
}
?>
