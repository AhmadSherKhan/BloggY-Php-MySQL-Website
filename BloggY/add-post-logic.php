<?php
include ("auth.php");
authenticate();


require ("connect.php");


$title="";
$description="";
$success="";

$titleErr="";
$descriptionErr="";
$thumbnailErr="";




if(isset($_POST['submit'])){



    $author_id=$_SESSION["user-id"];

    $title=$_POST['title'];
    $description=filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description=mysqli_real_escape_string($conn,$description);
  $category_id=$_POST['category'];
  $thumbnail=$_FILES['thumbnail'];
  $is_featured = $_POST['is_featured'];

  //if is_featured unchecked we saved 0 then in database
  $is_featured = $is_featured == 1? : 0;


  if(empty($titleErr) && empty($descriptionErr)){

    $time=time();
    $thumbnail_name=$time.$thumbnail['name'];
    $thumbnail_tmp_name = $thumbnail['tmp_name'];   
    $thumbnail_destination = "postimages/" . $thumbnail_name;

    //make sure file is an image
    $allowed_file = ["png","jpg","jpeg"];
    $extention = explode(".",$thumbnail_name);
    $extention = end($extention);

  
    if (in_array($extention, $allowed_file)) {
      if ($thumbnail['size'] < 5000000) {
          if(move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination)){
              // If we want to make only one post feature at a time
              if ($is_featured == 1) {
                  $zero_all_is_featured = "UPDATE posts SET is_featured=0";
                  $zero_all_result = mysqli_query($conn, $zero_all_is_featured);
              }

              $sql = "INSERT INTO posts(title,body,thumbnail,category_id,author_id,is_featured) VALUES('$title','$description','$thumbnail_name',$category_id,$author_id,$is_featured)";
              $result = mysqli_query($conn, $sql);
              if ($result) {
                  $success = "Post Added successfully!";
                  header("location: posts.php");
                  exit();
              } else {
                  $success = "Category not added!";
              }
          }else{
              echo "Error uploading file";
          }
      } else {
          $thumbnailErr = "File size is too big, should be less than 1mb";
      }
  } else {
      $thumbnailErr = "File should be jpg, png or jpeg";
  }

        $sql="INSERT INTO posts(title,body,thumbnail,category_id,author_id,is_featured) VALUES('$title','$description','$thumbnail_name',$category_id,$author_id,$is_featured)";
        $result=mysqli_query($conn,$sql);
        if($result){
          $success="Post Added successfully!";
          header("location: posts.php");
          exit();
        }else{
          $success="Category not added!";
        }
  }
}

?>