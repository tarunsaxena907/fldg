<?php
include '../db.php';
if(isset($_POST['submit'])) {
    session_start();
    $email      = mysqli_real_escape_string($con, $_POST["loginID"]);
    $password   = mysqli_real_escape_string($con,$_POST["loginPassword"]);
    if(empty($email) || empty($password)){
        if(empty($email)) {
            $err_email = true;
          }
          if(empty($password)) {
            $err_password = true;
          }
    }
    else{
        $query1     = "select * from user_details where username='$email'";
        $result1     = $con->query($query1);
        if($result1->num_rows){
            $query      = "select * from user_details where username='$email' AND password='$password'";
            $result     = $con->query($query);
            $_SESSION["user_id"] = $email;
            if($result->num_rows){
                $_SESSION['success']  = 'Login Successfully.';    
                header('location:../employee-application.php');
            }
            else{
                $_SESSION['error']  = 'User id and Password not match';
                header('location:../login.php');    
            }
        }
        else{
             $_SESSION['error']  = 'User id does not exits';
             header("location:../login.php");  
        }
    }
   
   
}

?>