<?php
session_start();
require ("connect.php");

$email = "";
$password = "";
$success= "";

$emailErr = "";
$passwordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  // Validate email
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }
  
  // Validate password
  if (empty($_POST["password"])) {
    $passwordErr = "Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  // If there are no errors, connect to database and check if user exists
  if (empty($emailErr) && empty($passwordErr)) {

    if ($conn) {
      $sql = "SELECT * FROM users WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
          
          $_SESSION["user-id"] = $row["id"];
          $_SESSION["username"] = $row["username"];
          $_SESSION["email"] = $row["email"];
          $_SESSION["is_admin"] = $row["is_admin"];
          $success = "Login Successful";

          header("Location: index.php");   //header is used to redirect after login
          exit();
        } else {
          $passwordErr = "Incorrect password";
        }
      } else {
        $emailErr = "Email not found";
      }
    } else {
      echo "Error connecting to database: " . mysqli_connect_error();
    }
  } 
}

?>




<!DOCTYPE html>
<!-- === Coding by CodingLab | www.codinglabweb.com === -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="mystyle.css">
         
    <title>Login Form</title>
</head>
<body>
    
    <div class="container">
            <div class="form login">
                <span class="title">Login</span>

                <form action="login.php" method="post">

                <?php if(!empty($success)): ?>
                        <div class="alert" role="alert">
                            <p><?php echo ($success); ?></p>
                        </div>
                <?php endif; ?>

                    <div class="input-field">
                        <input type="text" placeholder="Enter your email" name="email" value="<?php echo htmlspecialchars($email); ?>" >
                        <span style="color:red;"><?php echo $emailErr; ?></span>
                    </div>

                    <div class="input-field">
                        <input type="password" class="password" name="password" placeholder="Enter your password" >
                        <span style="color:red;"><?php echo $passwordErr; ?></span>
                        <i class="uil uil-eye-slash showHidePw"></i>
                    </div>

                    <div class="input-field button">
                        <input type="submit" value="Login">
                    </div>

                </form>

                <div class="login-signup">
                <a href="forget-password.php" class="text">Forgot password?</a><br>
                    <span class="text">Not a member?
                        <a href="signup.php" class="text">Signup Now</a>
                    </span>
                </div>
            </div>
        </div>
 

    <!--<script src="script.js"></script>-->
    <script src="script.js"></script>
</body>
</html>

