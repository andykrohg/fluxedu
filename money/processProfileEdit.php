<?php
	session_start();
	require_once 'dbconnect.php';
	
	//delete directory
	function deleteDir($dirPath) {
		if (! is_dir($dirPath)) {
			echo "$dirPath must be a directory";
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	$user=$_SESSION['userID'];
	$firstName=mysqli_escape_string($conn,$_POST['first']);
	$lastName=mysqli_escape_string($conn,$_POST['last']);
	$phone=mysqli_escape_string($conn,$_POST['phone']);
	$password=null;
	if (trim($_POST['password'])!="")
		$password = md5($password);	
	
	$photoID=null;
	if (basename($_FILES['photo']['name']) != null) {
		$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		$photoID = mysqli_escape_string($conn, uniqid().".$extension");
	}
	
	$keepPhoto=$_POST['keepPhoto'];
	
	if (!$keepPhoto) {
		if(is_dir("../images/profilePhotos/".$user)) {
			deleteDir("../images/profilePhotos/".$user);
		}
	}
	
	if ($photoID!=null) {		
		//create photo directory
		if(!is_dir("../images/profilePhotos/".$user)) {
			mkdir("../images/profilePhotos/".$user);
		}
		
		//upload the image file
		$filename = $photoID;
		$target_dir = "../images/profilePhotos/".$user."/";
		$target_file = $target_dir . $filename;
		$uploadOk = 1;
		
		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			$check = getimagesize($_FILES["photo"]["tmp_name"]);
			if($check !== false) {
				//echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
				//echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	
	$query="UPDATE users SET firstName = '$firstName', lastName = '$lastName', phone = '$phone'";
	if ($password)
		$query.=", password = '$password'";
	if ($photoID)
		$query.=", photoID = '$photoID'";
	else if (!$keepPhoto)
		$query.=", photoID = null";
	$query.=" WHERE id = $user";
	
	mysqli_query($conn, $query) or die(mysqli_error($conn));
	header('Location: ../profile.php');
?>