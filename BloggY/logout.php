<?php



session_start(); // start the session

if(isset($_POST['logout'])) { // check if the logout button has been clicked
    session_destroy(); // destroy all session data
    header('Location: index.php'); // redirect the user to the login page
    exit(); // stop the script from executing further
}
?>
