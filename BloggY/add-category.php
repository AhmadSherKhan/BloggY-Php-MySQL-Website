<?php
include ("auth.php");
authenticate();

$title="";
$description="";
$success="";

$titleErr="";
$descriptionErr="";


require ("connect.php");

if ($_SESSION["is_admin"] != 1) {
  // If user is not admin, redirect to access denied page
  header('Location: index.php');
  exit;
}

if(isset($_POST['submit'])){

  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


  if(empty($_POST['title'])){
    $titleErr="please enter catgeory title";
  }else{
    $title=test_input($_POST['title']);

    if(!preg_match("/^[a-zA-Z ]*$/",$title)){
      $titleErr="Only Characters and whitespaces are allowed in title";
    }
  }

  if(empty($_POST['description'])){
    $descriptionErr="please enter description";
  }else{
    $description=test_input($_POST['description']);

    if(!preg_match("/^[a-zA-Z ]*$/",$description)){
      $descriptionErr="Only Characters and whitespaces are allowed in description";
    }
  }

  if(empty($titleErr) && empty($descriptionErr)){

        $sql="INSERT INTO categories(name,description) VALUES('$title','$description')";
        $result=mysqli_query($conn,$sql);
        if($result){
          $success="Category Added successfully!";
          header("location: categories.php");
        }else{
          $success="Category not added!";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>BloggY</title>
</head>
<body>
<section style="background-color: #eee; height:100vh; width:100%;">
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav  class="bg-light rounded-3 p-3 mb-4">
          <ul class=" d-flex mb-0">
          <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="index.php">Home</a></li>
          <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="user-profile.php">Profile</a></li>
            <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="categories.php">Categories</a></li>
            <li class="mr-2 list-unstyled"><a href="#" class="text-light btn btn-dark">My Post</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <form action="add-category.php" method="post">
              <h5 class="text-center">Add New Category</h5>

            <?php if(!empty($success)): ?>
                        <div class="alert alert-success " role="alert">
                            <p><?php echo ($success); ?></p>
                        </div>
                    <?php endif; ?>

              <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" placeholder="enter category title" value="<?php echo $title; ?>" class="form-control">
                <span style="color:red;"><?php echo $titleErr; ?></span>
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <textarea style="height:150px !important;" name="description" class="form-control" placeholder="enter description" value="<?php echo $description; ?>"></textarea>
                <span style="color:red;"><?php echo $descriptionErr; ?></span>
              </div>
              <input type="submit" value="Post" name="submit" class="btn btn-primary">
 
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