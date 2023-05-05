<?php

require "connect.php";

$name="";
$email="";
$password="";
$confirm_password="";

$nameErr="";
$emailErr="";
$passwordErr="";
$confirm_passwordErr="";
$avatarErr="";

$uppercaseErr ="";
$lowercaseErr ="";
$numberErr ="";
$symbolsErr ="";
$lenErr ="";


if(isset($_POST['submit'])){

    
    $avatar=$_FILES['avatar'];  


    function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // validate username
    if(empty($_POST['name'])){
        $nameErr="username is required";
    }else{
        $name = test_input($_POST['name']);

        if(!preg_match("/^[a-zA-Z ]*$/", $name)){
            $nameErr="Only Characters and whitespaces are allowed in name";
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

    // validate password
    if(empty($_POST['password'])){
        $passwordErr = "password is required";
    }else{
        $password = test_input($_POST['password']);

        //check password criteria
        $uppercase = preg_match("@[A-Z]@",$password);
        $lowercase = preg_match("@[a-z]@",$password);
        $number = preg_match("@[0-9]@", $password);
        $regex = '/[!@#$%^&*()_+\-=\[\]{};\'\\:"|,.<>\/?]/';
        $symbols = preg_match($regex,$password);

        if(!$uppercase){
            $uppercaseErr = "enter atleast one uppercase letter";
        }else if(!$lowercase){
            $lowercaseErr = "enter atleast one lowercase letter";
        }else if(!$number){
            $numberErr =  "password must be contain one number";
        }else if (!$symbols){
            $symbolsErr = "password must be contain one symbol";
        }else if(strlen($password) < 8){
            $lenErr = "Password must be at least 8 characters long";
        }
    }


    //validate confirm password
    if(empty($_POST['confirm_password'])){
        $confirm_passwordErr = "confirm password is required";
    }else{
        $confirm_password = test_input($_POST['confirm_password']);

        if($confirm_password != $password){
            $confirm_passwordErr="Password do not match";
        }
    }


    //if not any error is occured connect to database and insert form data
    if(empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirm_passwordErr) && empty($uppercaseErr) && empty($lowercaseErr) && empty($numberErr) && empty($symbolsErr) && empty($lenErr) && empty($avatarErr)){

       

        if($conn){
            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($result) > 0){
                $emailErr = "email already exist";
            }else{
                $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

                //rename and path avatar
               
                $time=time(); //to make image name unique
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = "images/" . $avatar_name;

                //make sure file is an image
                $allowed_files=['png','jpg','jpeg'];
                $extention=explode('.',$avatar_name);
                $extention=end($extention);
                if(in_array($extention,$allowed_files)){
                    //make sure image is not too large
                    if($avatar['size'] < 5000000){
                        //upload avatar
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    }else{
                        $avatarErr = "File size is too big, should be less than 1mb";
                    }
                }else{
                    $avatarErr="file should be jpg,png and jpeg";
                }

                
                $sql = "INSERT INTO users(username,email,password,avatar,is_admin) VALUES ('$name','$email','$hashedpassword','$avatar_name',0)";
                if(mysqli_query($conn,$sql)){

                    $success = "SignUp successfully!";
                    $name = "";
                    $email = "";
                    $password = "";
                    $confirm_password = "";
                    header("location: index.php");
                    exit();
                }else{
                    echo "Error" . $sql . "<br>" . mysqli_error($con);
                }
            }
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
    
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">


    <link rel="stylesheet" href="mystyle.css">
         
    <title>Registration Form</title>
</head>
<body>
    
    <div class="container">
            <div class="form signup">
                <span class="title">Registration</span>

                <form action="signup.php" method="post" enctype="multipart/form-data">
                    
                    <?php if(!empty($success)): ?>
                        <div class="alert" role="alert">
                            <p><?php echo ($success); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="input-field">
                        <input type="text" name="name" placeholder="Enter your name" 
                        value="<?php echo htmlspecialchars($name); ?>" >
                        <p style="color:red"><?php echo ($nameErr); ?></p>
                        
                    </div>
                    <div class="input-field">
                        <input type="email" name="email" placeholder="Enter your email"
                        value="<?php echo htmlspecialchars($email); ?>"  >
                        <p style="color:red"><?php echo ($emailErr); ?></p>
                        
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" class="password" placeholder="Create a password"
                        value="<?php echo htmlspecialchars($password); ?>"  >
                        <p style="color:red"><?php echo ($passwordErr); ?></p>
                        <p style="color:red"><?php echo ($uppercaseErr); ?></p>
                        <p style="color:red"><?php echo ($lowercaseErr); ?></p>
                        <p style="color:red"><?php echo ($numberErr); ?></p>
                        <p style="color:red"><?php echo ($symbolsErr); ?></p>
                        <p style="color:red"><?php echo ($lenErr); ?></p>
                    </div>
                    <div class="input-field">
                        <input type="password" name="confirm_password" class="password" placeholder="Confirm a password" 
                        value="<?php echo htmlspecialchars($confirm_password); ?>" >
                        <p style="color:red"><?php echo ($confirm_passwordErr); ?></p>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>
                    <div class="input-field">
                        <label for="avatar" class="avatar">Profile Image</label>
                        <input type="file" name="avatar">
                        <p style="color:red"><?php echo ($avatarErr); ?></p>
                    </div>

                    <div class="input-field button">
                        <input type="submit" name="submit" value="Signup">
                    </div>

                </form>

                <div class="login-signup">
                    <span class="text">Already a member?
                        <a href="login.php" class="text">Login Now</a>
                    </span>
                </div>
            </div>
        </div>

    <!--<script src="script.js"></script>-->
    <script src="script.js"></script>
</body>
</html>

