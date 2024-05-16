<?php
    include 'includes/session.php';

    if(isset($_POST['add'])){
        $number_of_voters = intval($_POST['number_of_voters']); // Assuming you have a field in your form to input the number of voters
        for ($i = 0; $i < $number_of_voters; $i++) {
            // Generate voter ID
            $set = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $voter = substr(str_shuffle($set), 0, 15);

            $sql = "INSERT INTO voters (voters_id) VALUES ('$voter')";
            if($conn->query($sql)){
                $_SESSION['success'] = 'Voters added successfully';
            }
            else{
                $_SESSION['error'] = $conn->error;
            }
        }
        header('location: voters.php');
        exit(); // Terminate script execution after redirection
    }
    else{
        $_SESSION['error'] = 'Fill up add form first';
        header('location: voters.php');
        exit(); // Terminate script execution after redirection
    }
?>
