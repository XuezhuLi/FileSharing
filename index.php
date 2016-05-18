<!DOCTYPE html>
<html>
<head>
	<title>File Manager</title>
	<link rel="stylesheet" type="text/css" href="./css/frontpage.css">
</head>
<body>
<?php
//Initialize variables
$err = $user = "";
//Check if this page has been submitted, if so, go on processing
if(isset($_POST["submit"])){
	//Use the session part to store the username
	session_start();
	$user = $_POST["user"];
	$_SESSION["user"] = $user;
	
	//Check if this user is valid.
	//If username is empty, that is, user submits without inputting anything, record error.
	if($user == ""){
		$err = "*Username cannot be empty.";
	}
	else{
		//Get the userlists
		$userpath = sprintf("/srv/userlists.txt");
		$f = fopen($userpath, "r");
		while(!feof($f)){
			$temp = trim(fgets($f));
			//If there exists this user, go to the userpage.
			if ($user == $temp){
				header("Location: userpage.php");
				exit;
			}
		}
		//If no such user, record error.
		$err = "*Illegal username.";
		fclose($f);
	}
	session_destroy();
}
?>
	
	<div class="login">
	<div class="formstyle">
	<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
		<div class="textstyle">
			Username: <input type="text" name="user" size="20" class="text">
			<input type="hidden" name="submit" value="ok"><br>
			<span class="error"><?php echo htmlentities($err)?></span>
		</div>
		<div class="buttonstyle">
			<button type="submit" class="button">login</button>
			<button type="submit" class="button" formaction="signup.php">signup</button>
		</div>
	</form>
	</div>
	</div>
</body>
</html>