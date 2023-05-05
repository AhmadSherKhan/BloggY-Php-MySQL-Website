<?php 
session_start();

require ("connect.php");

$passErr="";
$cnfrmpassErr="";
$success="";
// If the user has submitted the new password form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user ID is set in the session
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User ID not found.";
        exit;
    }
    // Retrieve the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Retrieve the new password and confirmation password from the form
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($new_password)){
        $passErr = "password is required";
    }

    if(empty($confirm_password)){
        $cnfrmpassErr = "password is required";
    }

    // Validate the passwords match
    if ($new_password !== $confirm_password) {
        echo "Error: New password and confirmation password do not match.";
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the database

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE users SET password = '$hashed_password' WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if ($result && !empty($new_password) && !empty($confirm_password)) {
        $success = "Password updated successfully, Login now";
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="mystyle.css">
    <title>Change Password</title>
</head>
<body>
   
    <div class="container">
            <div class="form login">
                    <span class="title">Enter New Password</span>
                    
                        <form action="reset-password.php" method="post">

                        <?php if(!empty($success)): ?>
                            <div class="alert" role="alert">
                                <p><?php echo ($success); ?></p>
                            </div>
                        <?php endif; ?>

                            <div class="input-field">
                                <input type="password" placeholder="Enter your code" name="new_password" >
                                <span style="color:red;"><?php echo $passErr ?></span>
                            </div>

                            <div class="input-field">
                                <input type="password" placeholder="Enter your code" name="confirm_password" >
                                <span style="color:red;"><?php echo $cnfrmpassErr ?></span>
                            </div>

                            <div class="input-field button">
                                <input type="submit" value="Reset Password">
                            </div>

                            <div class="login-signup">
                                <span class="text">
                                    <a href="index.php" class="text">Login Now</a>
                                </span>
                            </div>
        
                        </form>
            </div>
        </div>


</body>
</html>
