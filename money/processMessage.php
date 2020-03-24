<?php
	session_start();
	
	//connect
	require_once 'dbconnect.php';
	date_default_timezone_set("America/New_York");
	
	$fromUser = $_SESSION['userID'];
	$toUser = $_POST['toUser'];
	$listingID = $_POST['listingID'];
	$timeCreated = date('Y-m-d H:i:s');
	$content = mysqli_escape_string($conn, nl2br($_POST['message']));
	
	$query = "INSERT INTO messages (fromUser, toUser, listingID, timeCreated, content) VALUES ($fromUser, $toUser, $listingID, '$timeCreated', '$content')";
	
	//echo $query;
	
	mysqli_query($conn, $query) or die(mysqli_error($conn));
	
	header('Location: ../messages.php?recipient='.$toUser.'&listing='.$listingID);
?>