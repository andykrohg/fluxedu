<?php
	require_once 'money/session.php';

	//connect
	require_once 'money/dbconnect.php';
	
	date_default_timezone_set("America/New_York");

	$sort = $_POST['sort'];
	
	$query="SELECT listings.id, listings.user, listings.startDate, listings.endDate, listings.photoID, addresses.line1, addresses.line2,".
		"addresses.city, addresses.state, addresses.zip FROM listings LEFT JOIN addresses ON listings.addressID = addresses.id";
	
	if (isset($_POST['sort'])) {
		$query.=" ORDER BY ".$sort; 
	}
		
	$listings=mysqli_query($conn,$query) or die(mysqli_error($conn));
?>

<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	  
	  <!--bootstrap select-->
      <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css">
      <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>
	</head>

    <body>
		<div class="content">
		<?php require_once 'money/navbar.php'; ?>
			<div class="container text-center" style="font-family:Asap;margin-bottom:100px">
				<h1>We got one, Jim!</h1> 
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<h4>Check out the matches we found for you.</h4>
					</div>
					
					<!--search filters and sorts-->
					<div class="col-sm-3">
						<form action = "viewHomes.php" method="post">
							<select class="selectpicker" multiple data-max-options="1" title="Sort" onchange="this.form.submit()" name="sort">
								<option value="startDate ASC" <?php if ($sort == 'startDate ASC') echo "selected"; ?>>Start Date, Ascending</option>
								<option value="startDate DESC" <?php if ($sort == 'startDate DESC') echo "selected"; ?>>Start Date, Descending</option>
								<option value="endDate ASC" <?php if ($sort == 'endDate ASC') echo "selected"; ?>>End Date, Ascending</option>
								<option value="endDate DESC" <?php if ($sort == 'endDate DESC') echo "selected"; ?>>End Date, Descending</option>
							</select>
						</form>
					</div>
				</div>
				<table class="table table-hover" style="margin-top: 30px">
					<thead>
						<tr>
							<th></th>
							<th style="text-align:center">Address</th>
							<th style="text-align:center">Term</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
							while($listing=mysqli_fetch_array($listings, MYSQLI_ASSOC)) { 
						?>
								<tr onclick ="window.document.location='viewHomeDetails.php?id=<?php echo $listing['id']?>'" style="cursor:pointer">
									<td><img src="images/<?php 
															if ($listing['photoID'] !=null ) {
																echo "client/".$listing['id']."/".$listing['photoID'];
															} else echo "defaultHouse.png";
														?>" alt ="house photo"style="width:150px;height:100px"></td>
									<td><?php echo $listing['line1'].", ".$listing['line2']."<br>".$listing['city'].", ".$listing['state']." ".$listing['zip']; ?></td>
									<td><?php echo date_format(date_create($listing['startDate']), "F jS, Y") .
									" - ". date_format(date_create($listing['endDate']), "F jS, Y"); ?></td>
									<td>
										<?php if ($listing['user']==$_SESSION['userID']) { ?>
											<button type = 'button' disabled class="btn btn-primary">My Post</button>
										<? } ?>
									</td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
