<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
		<link rel="stylesheet" type="text/css" href="./css/frontpage.css">
    </head>
    <body>
<?php
    $err = "";
    $check = 0;
    //Check if the page has been submitted. If so, go on processing.
    if(isset($_POST["sign"])){
        $user = $_POST["newuser"];
        
        //Do the sign up part.
		//If username is empty, that is, user submits without inputting anything, record error.
        if($user == ""){
            $err = "*Username cannot be empty.";
        }
		//If username is invalid, record error.
		else if(!preg_match('/^[\w_\-]+$/', $user)){
            $err = "*Invalid username";
        }
        else{
            //Check if this username exists. If so, record error.
            $userpath = sprintf("/srv/userlists.txt");
            $f = fopen($userpath, "r");
            while(!feof($f)){
                $temp = trim(fgets($f));
                if ($user == $temp){
                    $err = "*Sorry, this username already exists.";
                    $check = 1;
                }
            }
            fclose($f);
			//If there is no such username in the userlist
            if(!$check){
				//Add a directory for new user.
                $userdir = sprintf("/srv/uploads/%s",$user);
                if(!mkdir($userdir)){
                    //Add a directory for a user.
                    $err = "Sorry! Cannot make a directory for you.";
                }
                else{
                    //Add this username to user list.
                    $f = fopen($userpath, "a");
                    if(fwrite($f, $user)){
                        fwrite($f,"\r\n");
                        header("Location: index.php");
                        exit;
                    }
                    else{
                        $err = "*Sorry! Cannot add the user";
                    }
                    fclose($f);
                }
            }
        }
    }
?>
    <div class="sign">
	<div class="formstyle">
	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
		<div class="textstyle">
			Username:<input type="text" name="newuser" size="20" class="text">
			<input type="hidden" name="sign" value="ok"><br>
			<span class="error"><?php echo htmlentities($err)?></span>
		</div>
		<div class="buttonstyle">
			<button type="submit" class="button2">OK</button>
			<button type="submit" formaction="index.php" class="button2">Return</button>
		</div>
	</form>
	</div>
	</div>
    </body>
</html>