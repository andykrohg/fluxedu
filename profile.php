<?php
	require_once 'money/session.php';
	require_once 'money/dbconnect.php';
	
	$userID = $_SESSION['userID'];
	$query = "SELECT * FROM users WHERE id = $userID";
	$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$userInfo = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
		<div class="content">
			<?php require_once 'money/navbar.php'; ?>
			<div class= "container text-center" style="font-family:Asap">
				<h1 style="margin-bottom:50px">My Profile</h1>
				<div class= "row">
					<div class = "col-xs-2"></div>
					<div class = "col-xs-3">
						<div>
							<img src = "<?php
											if ($userInfo['photoID'])
												echo "images/profilePhotos/".$user."/".$userInfo['photoID']; 
											else
												echo "images/defaultUser.png";
										?>" alt="Profile Photo" style="width:200px;height:200px">
						</div>
					</div>
					<div class="col-xs-5" style="font-size: 16px">
						<div class="row" style="margin-top:20px">
							<div class="col-xs-6">
								<b>First Name</b><br><?php echo $userInfo['firstName']; ?>
							</div>
							<div class="col-xs-6">
								<b>Last Name</b><br><?php echo $userInfo['lastName']; ?>
							</div>
						</div>
						<div class="row" style="margin-top:70px">
							<div class="col-xs-6">
								<b>Phone Number</b><br><?php echo $userInfo['phone']; ?>
							</div>
							<div class="col-xs-6">
								<b>Email Address</b><br><?php echo $userInfo['email']; ?>
							</div>
						</div>
					</div>
					<div class="col-xs-2"></div>
				</div>
				<button type="button" name="userID" class="btn btn-primary" style="margin-top:40px" onclick="window.location.href='editProfile.php'"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
	</body>
</html>