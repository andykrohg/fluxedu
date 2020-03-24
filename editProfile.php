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
		
		<!--fileUpload-->
		<link href="Utilities/kartik-v-bootstrap-fileinput-02a16d8/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
        <script src="Utilities/kartik-v-bootstrap-fileinput-02a16d8/js/fileinput.min.js"></script>
		<script>
			$(document).ready(function(){
				setInterval($('.fileinput-remove').click(function() {
					$('#keepPhoto').val(0);
				}), 800);
			});
		</script>
	</head>

    <body>
		<div class="content">
		<?php require_once 'money/navbar.php'; ?>
			<div class= "container text-center" style="font-family:Asap;margin-bottom:70px">
				<h1 style="margin-bottom:50px">Edit Profile</h1>
				
				<form method="post" action="money/processProfileEdit.php" enctype="multipart/form-data">
					<div class= "row">
						<div class = "col-xs-1"></div>
						<div class = "col-xs-4">
							<input type="file" class="file file-preview-image" name="photo" id="photo" accept="image/*" 
							data-show-caption="false" data-show-upload="false" data-show-remove="false"data-initial-preview="<img src=
							'<?php
								if ($userInfo['photoID'])
									echo "images/profilePhotos/".$userID."/".$userInfo['photoID'];
								else
									echo "images/defaultUser.png";
							?>' alt='User Photo' class='file-preview-image' style='width:200px;height:200px'>"
							data-max-image-width="50px" data-browse-label="Change Photo..." data-browse-class="btn">
							
							<!--Should we keep the current photo on blank input?-->
							<input type="number" id="keepPhoto" name="keepPhoto" hidden value="1">
						</div>
						<div class="col-xs-6" style="font-size: 16px">
							<div class="row">
								<div class="col-xs-6">
									<b>First Name</b><br>
									<input type="text" name = "first" id="first" value="<?php echo $userInfo['firstName']; ?>" style="text-align:center" class="form-control">
								</div>
								<div class="col-xs-6">
									<b>Last Name</b><br>
									<input type="text" name="last" id="last" value="<?php echo $userInfo['lastName']; ?>" style="text-align:center" class="form-control">
								</div>
							</div>
							<div class="row" style="margin-top:30px">
								<div class="col-xs-6">
									<b>Phone Number</b><br>
									<input type="text" name="phone" id="phone" value="<?php echo $userInfo['phone']; ?>" style="text-align:center" class="form-control">
								</div>
								<div class="col-xs-6">
									<b>Email Address</b><br><input type="text" name="phone" id="phone" value="<?php echo $userInfo['email']; ?>" style="text-align:center" disabled class="form-control">
								</div>
							</div>
							
							<div class="row" style="margin-top:30px">
								<div class="col-xs-6">
									<b>Change Password</b><br>
									<input type="password" name="password" id="password" pattern="[a-zA-Z0-9]{4,}" style="text-align:center" class="form-control">
								</div>
								<div class="col-xs-6">
									<b>Confirm Password</b><br>
									<input type="password" name="confirm" id="confirm" style="text-align:center" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-xs-1"></div>
					</div>
					<button type="button" id = "cancel" class="btn btn-default" style="margin-top:50px" onclick="window.location.href='profile.php'">Cancel</button>
					<button type="submit" class="btn btn-primary" style="margin-top:50px;margin-left:10px"><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
				</form>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
	</body>
</html>