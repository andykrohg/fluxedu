<?php
	require_once 'money/session.php';
	require_once 'money/navbar.php';
?>


<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
		<div class="content">
			<div class="container" style="font-family:Asap">
				<h1 class="text-center" style="margin-top: 70px;">Shoot a Message to the Host</h1>
				<form method="post" style="margin-top: 50px" action="sendMessageToHost.php">
					<div class="form-group">
					  <label for="message">Message:</label>
					  <textarea style="resize:none" class="form-control" maxlength="500" rows="6" id="message" name="message"></textarea>
					</div>
					<button type="submit" class="btn btn-primary" name="listingID" value="<?php echo $_POST['listingID']; ?>">Send</button>
					<button type="button" class="btn btn-default" onclick="window.location.href='viewHomeDetails.php?id=<?php echo $_POST['listingID']; ?>'">Back</button>
				 </form>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>		
    </body>
</html>
