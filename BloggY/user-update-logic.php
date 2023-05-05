<?php
include ("auth.php");
authenticate();


require ("connect.php");

if(isset($_POST['submit'])){
 
    function test_input($data){
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
  }
  
    // validate username
    if(empty($_POST['username'])){
      $usernameErr="username is required";
  }else{
      $username = test_input($_POST['username']);
  
      if(!preg_match("/^[a-zA-Z ]*$/", $username)){
          $usernameErr="Only Characters and whitespaces are allowed in name";
      }
  }
  
   // validate email
   if(empty($_POST['email'])){
    $emailErr = "email is required";
  }else{
    $email = test_input($_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = "enter valid email";
    }
  }
    $phone=$_POST['phone'];
    $address=$_POST['address'];
  
  if(empty($usernameErr) && empty($emailErr)){

    if($_POST['email'] != $_SESSION['email']) {
        // update email in database
        $sql2 = "UPDATE users SET email='$email' WHERE email='{$_SESSION['email']}'";
        $result2 = mysqli_query($conn, $sql2);
        if($result2) {
          // update old email with new email in current session
          $_SESSION['email'] = $email;
        } else {
          // handle error
          echo "Error updating email: " . mysqli_error($conn);
        }
      }

    $sql1="UPDATE users SET username='$username',email='$email',phone='$phone',address='$address' WHERE email='$email'";
    $result1=mysqli_query($conn,$sql1);
    if($result1){
        header("location: user-profile.php");
        exit();
    }else {
      // handle error
      echo "Error updating user: " . mysqli_error($conn);
    }
  }
  
  
  }
  

?>