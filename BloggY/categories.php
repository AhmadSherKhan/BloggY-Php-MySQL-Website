<?php
include ("auth.php");
authenticate();

require ("connect.php");

if ($_SESSION["is_admin"] != 1) {
  // If user is not admin, redirect to access denied page
  header('Location: index.php');
  exit;
}

$sql="SELECT * FROM categories";
$result=mysqli_query($conn,$sql);


if(mysqli_num_rows($result) == 0){
  $success = "no categories found";
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
      <Style>
        @media screen and (max-width:450px){
        .table td, .table th {
        border-left: 1px solid #e8e8e8;
        padding: 0.2rem !important;
            }
        }
   
    </Style>
</head>
<body>
<section style="background-color: #eee;height:100vh; width:100%;">
  <div class="container py-5">

  <div class="row">
      <div class="col">
        <nav  class="bg-light rounded-3 p-3 mb-4">
          <ul class=" d-flex mb-0">
            <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="index.php">Home</a></li>
            <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="user-profile.php">Profile</a></li>
            <li class="mr-2 list-unstyled"><a href="categories.php" class="active text-light btn btn-dark">Categories</a></li>
            <li class="mr-2 list-unstyled"><a href="posts.php" class="text-light btn btn-dark">My Post</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="mb-4">Categories</h5>
                <a href="add-category.php" class="btn btn-dark mb-4">Add Category</a>
            </div>
          <table class="table">

          <?php if(!empty($success)): ?>
                        <div class="alert alert-danger mb-4" role="alert">
                            <p><?php echo ($success); ?></p>
                        </div>
                    <?php endif; ?>

  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
        <?php
        while($row=mysqli_fetch_assoc($result)){

            $id=$row['id'];
            $title=$row['name'];
            $description=$row['description'];
        ?>
      <td><?php echo $title; ?></td>
      <td><?php echo $description; ?></td>
      <td>
        <a href="edit-category.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
        <a href="delete-category.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a>
      </td>
    </tr>
    <?php 
        }
    ?>
  </tbody>
</table>
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