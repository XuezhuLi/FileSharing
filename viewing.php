<?php

    $filename = $_GET["file_name"];     //filename 
    session_start();
    $username = $_SESSION["user"];        //should generate fro session but tis time default
    //check if file exists
    $full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);

    if (! file_exists ( $full_path )) {  
        echo "Cannot find the file";  
        exit ();  
    } else {  

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($full_path);
 
        // Finally, set the Content-Type header to the MIME type of the file, and display the file.
        header("Content-Type: ".$mime);
        readfile($full_path);
    }  
?> 