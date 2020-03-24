<?php
	require_once 'money/session.php';
	//connect
	require_once 'money/dbconnect.php';

	date_default_timezone_set("America/New_York");

	$id = mysqli_escape_string($conn,$_GET['id']);
	$query="SELECT * FROM listings WHERE id = $id";
	$listing=mysqli_fetch_array(mysqli_query($conn,$query), MYSQLI_ASSOC);
	$address=NULL;     
	if ($listing) {
		$query="SELECT * FROM addresses WHERE id = ".$listing['addressID'];
		$address=mysqli_fetch_array(mysqli_query($conn,$query), MYSQLI_ASSOC);
	}

?>

<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
		<div class="content">
		<?php require_once 'money/navbar.php'; ?>
			<div class="container text-center" style="margin-top: 70px;margin-bottom:50px;font-family:Asap">
				<h1>Information</h1>
				<div class="row" style="margin-top: 40px">
					<div class="col-sm-4">
						<img alt="display photo" src="images/<?php 
															if ($listing['photoID'] !=null ) {
																echo "client/".$listing['id']."/".$listing['photoID'];
															} else echo "defaultHouse.png"; 
														?>" style="width:400px;height:300px">
					</div>
					<div class="col-sm-8">
						<h3><?php echo $address['line1'].", ".$address['line2']."<br><small>".
								$address['city'].", ".$address['state']." ".$address['zip']; ?></small></h3>
						<div class="row" style="margin-top: 30px">
							<div class="col-sm-2"></div>
							<div class="col-sm-2">
								<h4><small>Rent:</small> $<?php echo $listing['rent'];?></h4>
							</div>
							<div class="col-sm-8">
								<h4><small>Term:</small> <?php echo date_format(date_create($listing['startDate']), "F jS, Y") .
									" - ". date_format(date_create($listing['endDate']), "F jS, Y"); ?></h4>
							</div>
							<div class="col-sm-0"></div>
						</div>
						<div class="row" style="margin-top: 40px">
							<div class="col-sm-3"></div>
							<div class="col-sm-3">
								<button class="btn btn-primary" type="button" onclick="window.location.href='viewHostDetails.php'">
									<span class='glyphicon glyphicon-sunglasses'></span> View Roommates</button>
							</div>
							<div class="col-sm-3">
								<form method="post" action = "contactHost.php">
									<button class="btn btn-primary" <?php if ($listing['user']==$_SESSION['userID']) echo "disabled"; ?> 
									type="submit" value="<?php echo $listing['id']; ?>" name="listingID">
									<span class='glyphicon glyphicon-comment'></span> Contact Host</button>
								</form>	
							</div>
							<div class="col-sm-3"></div>
						</div>
						<?php if ($listing['user']==$_SESSION['userID']) { ?>
							<form method = "post" action = "editPost.php">
								<button class="btn btn-default" style="margin-top:30px" type="submit" name="id" value="<?php echo $listing['id']; ?>"><span class='glyphicon glyphicon-pencil'></span> Edit</button>
							</form>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
