<!DOCTYPE html>
<html>
<head>
	<title>My File</title>
	<link rel="stylesheet" type="text/css" href="./css/userpage.css">
</head>
<body>
<?php
	//Upload the file
	$err = "";
	
	session_start();
	if(isset($_SESSION['user'])){
		$username = $_SESSION['user'];
		echo "<div class = \"title\">".htmlentities($username)."</div>";

		if(isset($_POST["MAX_FILE_SIZE"])){
			// Get the filename and make sure it is valid
			$filename = basename($_FILES['uploadedfile']['name']);
 
			// Get the username and make sure it is valid
			if( !preg_match('/^[\w_\-]+$/', $username) ){
				$err = "*Invalid username";
			}
		
			//Upload the file to the user directory.
			$full_path = sprintf("/srv/uploads/%s/%s", $username, $filename);
			if( !move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
				$err = "*Upload error.";
			}
		}
	}
	else{
		echo "Illegal access!";
		exit;
	}
?>
	<div class="logout">
		<a href="logout.php">log out</a>
	</div>
<?php
	if(isset($_SESSION['user'])){
		$username = $_SESSION['user'];
		//View the file list of the user.
		//Open the directory
		$dirpath = sprintf("/srv/uploads/%s", $username);
		$dir = opendir($dirpath);
		//lists all the file in the directory
		$file = readdir($dir);
		echo "<div class=\"liststyle\">";
		echo "<table>";
		echo "<tr>";
		echo "<th>Filename</th>";
		echo "<th>Download</th>";
		echo "<th>Viewing</th>";
		echo "<th>Deleting</th>";
		echo "</tr>";
		while ($file !== false){
			if(($file !== ".") && ($file !== "..")){
				echo "<tr>";
				echo "<td class=\"style1\">$file</td>";
				echo "<td><a href='download.php?file_name=$file'>Download</a></td>";
				echo "<td><a href='viewing.php?file_name=$file' target=_blank>Viewing</a></td>";
				echo "<td><a href='deleting.php?file_name=$file'>Deleting</a></td>";
				echo "</tr>";
			}
			$file = readdir($dir);
		}
		echo "</table>";
		echo "</div>";
		closedir($dir);
	}
?>
	<div class="upload">
		<form enctype="multipart/form-data" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
			<label for="uploadfile_input">Choose a file to upload:&nbsp;&nbsp;</label><input name="uploadedfile" type="file" id="uploadfile_input"/>
			<button type="submit" class = "button">Upload File</button>
			<span class="error"><?php echo htmlentities($err)?></span>
		</form>
	</div>
</body>
</html>