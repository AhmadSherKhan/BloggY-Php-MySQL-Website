<?php
function authenticate() {
  // Check if the user is logged in
  session_start();
  if (!isset($_SESSION["username"])) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
  }
}
?>