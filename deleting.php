<?php
    //Get the parameters
    session_start();
    $username = $_SESSION['user'];
    $file_name = $_GET["file_name"];
    
    //Delete the file using absolute path
    $fullpath = sprintf("/srv/uploads/%s/%s", $username, $file_name);
    unlink($fullpath);
    
    //Return to the main page after deleting
    header("Location: userpage.php");
    exit;
?>