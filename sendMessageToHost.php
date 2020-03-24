<?php
	require_once 'money/session.php';
	require_once 'money/navbar.php';
	
	//connect
	require_once 'money/dbconnect.php';

	date_default_timezone_set("America/New_York");
	
	$fromUser = $_SESSION['userID'];
	$listingID = $_POST['listingID'];
	$timeCreated = date('Y-m-d H:i:s');
	$content = mysqli_escape_string($conn, nl2br($_POST['message']));
	
	//get the recipient
	$query = "SELECT user FROM listings WHERE id = $listingID";
	$toUser = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)['user'];
	
	$query = "INSERT INTO messages (fromUser, toUser, listingID, timeCreated, content) VALUES ($fromUser, $toUser, $listingID, '$timeCreated', '$content')";
	
	mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <h1 class="text-center">Your Message Has Been Sent!</h1>
            <button class="btn btn-lg btn-primary" style="margin-top: 60px" type="button" onclick="window.location.href='viewHomes.php'">Back to Results</button>
        </div>
		<?php require_once "money/footer.php"; ?>		
    </body>
</html>
