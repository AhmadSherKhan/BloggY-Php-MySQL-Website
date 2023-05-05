<?php
include ("auth.php");
authenticate();


require ('connect.php');

if ($_SESSION["is_admin"] != 1) {
  // If user is not admin, redirect to access denied page
  header('Location: index.php');
  exit;
}


$cat_id=$_SESSION['id'];

$titleErr="";
$descriptionErr="";


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
  
          $sql="UPDATE categories SET name='$title',description='$description' WHERE id=$cat_id;";
          $result=mysqli_query($conn,$sql);
          if($result){
            $success="Category update successfully!";
            header("location: categories.php");
            exit();
          }else{
            $success="Category not added!";
          }
    }
  }
  
  


?>