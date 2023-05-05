<?php
include ("auth.php");
authenticate();



$title="";
$body="";
$success="";

$titleErr="";
$bodyErr="";
$thumbnailErr="";

require ("connect.php");

$post_id = $_SESSION['post-id'];

if(isset($_POST['submit'])){

    $author_id=$_SESSION["user-id"];
    $previous_thumbnail_name = $_POST['previous_thumbnail_name'];
    $title=$_POST['title'];
    $body=$_POST['body'];
    $category_id=$_POST['category'];
    $thumbnail=$_FILES['thumbnail'];
    $is_featured = $_POST['is_featured'];

  //if is_featured unchecked we saved 0 then in database
  $is_featured = $is_featured == 1? : 0;


    if($thumbnail['name']){
        $previous_thumbnail_path ="postimages/".$previous_thumbnail_name;
        if($previous_thumbnail_path){
            unlink($previous_thumbnail_path);
        }
    

    $time=time();
    $thumbnail_name=$time . $thumbnail['name'];
    $thumbnail_tmp_name = $thumbnail['tmp_name'];   
    $thumbnail_destination = "postimages/" . $thumbnail_name;

    //make sure file is an image
    $allowed_file = ["png","jpg","jpeg"];
    $extention = explode(".",$thumbnail_name);
    $extention = end($extention);

    if(in_array($extention, $allowed_file)){
        if($thumbnail['size'] < 1000000){
            move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination);
        }else{
            $thumbnailErr = "File size is too big, should be less than 1mb";
        }
    }else{
        $thumbnailErr = "file should be jpg, png or jpeg";
    }
}

    //if we want to make only one post feature at a time
    if($is_featured==1){
        $zero_all_is_featured = "UPDATE posts SET is_featured=0";
        $zero_all_result = mysqli_query($conn,$zero_all_is_featured);
    }

    $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $sql="UPDATE posts SET title='$title',body='$body',thumbnail='$thumbnail_to_insert',category_id=$category_id,is_featured=$is_featured WHERE id=$post_id LIMIT 1";
        $result=mysqli_query($conn,$sql);
        if($result){
          $success="Post Added successfully!";
          header("location: posts.php");
          exit();
        }else{
          $success="Category not added!";
        }
}

?>