<?php

$conn=mysqli_connect('localhost','root','','blog');

if(!$conn){
    echo "connection error" . mysqli_error($conn);
}

?>