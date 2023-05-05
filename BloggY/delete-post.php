<?php
include ("auth.php");
authenticate();

require ("connect.php");

if(isset($_GET['id'])){
    $post_id=$_GET['id'];

    $sql="DELETE FROM posts WHERE id=$post_id";
    $result=mysqli_query($conn,$sql);
    if($result){
        header("location: posts.php");
        exit();
    }
}


?>