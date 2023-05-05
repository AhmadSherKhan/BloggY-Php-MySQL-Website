<?php
include ("auth.php");
authenticate();

$username="";
$email="";

$usernameErr="";
$emailErr="";


require ("connect.php");


$useremail="";

if(isset($_SESSION['email'])){
   $useremail=$_SESSION['email'];
  
   $sql="SELECT * FROM users WHERE email='$useremail'";
   $result=mysqli_query($conn,$sql);
   if(mysqli_num_rows($result) > 0){
    $row=mysqli_fetch_assoc($result);
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>BloggY</title>
</head>
<body>
<section style="background-color: #eee;height:100vh; width:100%;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav  class="bg-light rounded-3 p-3 mb-4">
          <ul class=" d-flex mb-0">
            <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="index.php">Home</a></li>
            <li class="mr-2 list-unstyled"><a class="active text-light btn btn-dark" href="user-profile.php">Profile</a></li>
            <?php 
                // Check if user is admin
                if ($_SESSION['is_admin'] == 1) {
                  echo '<li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="categories.php">Categories</a></li>';
                }
            ?>
            <li class="mr-2 list-unstyled"><a href="posts.php" class="text-light btn btn-dark">My Post</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4">
        <div class="card mb-4">
          <div class="card-body text-center">
            <img src="<?php echo 'images/'.$row['avatar']; ?>" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3"><?php echo $row['username']; ?></h5>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <form action="user-update-logic.php" method="post">
            <h5 class="text-center">Profile</h5>  
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" value="<?php echo $row['username']; ?>" name="username" class="form-control">
                <span style="color:red;"><?php echo $usernameErr; ?></span>
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" value="<?php echo $row['email']; ?>" name="email" class="form-control">
                <span style="color:red;"><?php echo $emailErr; ?></span>
              </div>
              <div class="form-group">
                <label for="">Phone</label>
                <input type="text" value="<?php echo $row['phone']; ?>" name="phone" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Address</label>
                <input type="text" value="<?php echo $row['address']; ?>" name="address" class="form-control">
              </div>
              <input type="submit" value="Update" name="submit" class="btn btn-primary">
 
            </form>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>