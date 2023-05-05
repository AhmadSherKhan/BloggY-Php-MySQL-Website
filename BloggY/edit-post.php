<?php
include ("auth.php");
authenticate();

require ("connect.php");

$_SESSION['post-id']=$_GET['id'];

if(isset($_GET['id'])){
    $post_id = $_GET['id'];

    $post_data_query = "SELECT * FROM posts WHERE id=$post_id";
    $post_data_query_result = mysqli_query($conn,$post_data_query);
    $post=mysqli_fetch_assoc($post_data_query_result);

    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Blog</title>
</head>
<body style="background-color: #eee;">
<section>
  <div class="container py-5">
    <div class="row">
      <div class="col">
        <nav  class="bg-light rounded-3 p-3 mb-4">
          <ul class=" d-flex mb-0">
          <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="index.php">Home</a></li>
          <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="user-profile.php">Profile</a></li>
            <li class="mr-2 list-unstyled"><a class="text-light btn btn-dark" href="categories.php">Categories</a></li>
            <li class="mr-2 list-unstyled"><a href="posts.php" class="text-light btn btn-dark">My Post</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-body">
            <form action="update-post-logic.php" method="post" enctype="multipart/form-data">
              <h5 class="text-center">Add New Post</h5>

            <?php if(!empty($success)): ?>
                        <div class="alert alert-success " role="alert">
                            <p><?php echo ($success); ?></p>
                        </div>
                    <?php endif; ?>

              <div class="form-group">
                <label for="">Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?>" class="form-control">
              </div>
              <input type="hidden" name="previous_thumbnail_name" value="<?php echo $post['thumbnail'];  ?>">
              <div class="form-group">
                <label for="">Body</label>
                <textarea style="height:150px !important;" name="body" class="form-control" placeholder="body">
                <?php echo htmlspecialchars($post['body'], ENT_QUOTES); ?>
            </textarea>
              </div>
              <div class="form-group">
                <label for="">Add Thumbnail</label>
                <input type="file" name="thumbnail" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Select Category</label>
                <select name="category" class="form-control">
                    <option value="">--Select Category--</option>

                <?php
                    $sql="SELECT * FROM categories";
                    $result=mysqli_query($conn,$sql);
                    while($row=mysqli_fetch_assoc($result)){
                    $categories = $row['name']; 
                ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $categories; ?></option>
                <?php 
                }
                ?>
                </select>
                
              </div>
              <div class="form-group">
                  <input type="checkbox" name="is_featured"  checked value="1">
                  <label for="">Featured</label>
              </div>
              <input type="submit" value="Post" name="submit" class=" btn btn-primary">
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