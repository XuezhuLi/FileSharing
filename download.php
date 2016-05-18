<?php

    $file_name = $_GET["file_name"];     //Get the file name
    session_start();
    $username = $_SESSION["user"];
    $file_dir = sprintf("/srv/uploads/%s/%s",$username,$file_name);        //Get the path
    //Check if the file exists
    if (! file_exists ( $file_dir )) {  
        echo "Cannot find the file";  
        exit ();  
    } else {  
        //Open the file 
        $file = fopen ( $file_dir, "r" );  
        //Input the file label
        Header ( "Content-type: application/octet-stream" );  
        Header ( "Accept-Ranges: bytes" );  
        Header ( "Accept-Length: " . filesize ( $file_dir ) );  
        Header ( "Content-Disposition: attachment; filename=" . $file_name );  
        //Output the content 
        //Read and output to the browser 
        echo fread ( $file, filesize ( $file_dir ) );  
        fclose ( $file );  
        exit ();  
    }  
?> 