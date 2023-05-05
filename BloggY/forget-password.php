<?php
session_start();
require ("connect.php");
$emailErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // retrieve the email from the form submission
    $email = $_POST['email'];

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if($conn){
    $sql = "SELECT * FROM users WHERE email= '$email'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_array($result);

  
            $verification_code = rand(100000, 999999);

            mysqli_query($conn,"UPDATE users SET verification_code = $verification_code WHERE email = '$email'");

            $to = $email;
            $subject = "Verification Code";
            $message = "Your verification code is: $verification_code";
            $headers = "From: ahmdshrkhnn@gmail.com";

            $_SESSION['forgot_password_email'] = $email;
            
            mail($to, $subject, $message, $headers);
        
            // redirect the user to a page where they can enter the verification code
            header('Location: enter-verification-code.php');
            exit;

            $msg = "The verification code has sent to your email";
        }else{
        $emailErr = "email not exist";  
    }
}


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mystyle.css">
    <title>Document</title>
</head>
<body>

        <div class="container">
            <div class="form login">
                <span class="title">Forget Password</span>
                    <form action="forget-password.php" method="post">

                        <div class="input-field">
                            <input type="text" placeholder="Enter your email" name="email" >
                            <span style="color:red;"><?php echo $emailErr; ?></span>
                        </div>

                        <div class="input-field button">
                            <input type="submit" value="Reset Password">
                        </div>
    
                    </form>
            </div>
        </div>
 
</body>
</html>