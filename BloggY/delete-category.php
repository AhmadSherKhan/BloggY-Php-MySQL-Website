<?php
include ("auth.php");
authenticate();

require ("connect.php");

if(isset($_GET['id'])){
    $id=$_GET['id'];

    $sql="DELETE FROM categories WHERE id=$id";
    $result = mysqli_query($conn,$sql);
    if($result){
        header("location: categories.php");
        exit();
    }
}


?>