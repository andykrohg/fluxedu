<?php
	require_once 'money/session.php';
	
	//connect
	require_once 'money/dbconnect.php';
	
	$user = $_SESSION['userID'];
	$recipient = null;
	$listingID = null;
	$noMessages = false;
	
	//check for get variables
	if (isset($_GET['recipient']) && isset($_GET['listing'])) {
		$recipient = mysqli_escape_string($conn, $_GET['recipient']);
		$listingID = mysqli_escape_string($conn, $_GET['listing']);
		
		//check to see if a conversation exists with the specified user/listing combo
		$query = "SELECT COUNT(1) FROM messages WHERE (listingID = $listingID AND ((fromUser = $user && toUser = $recipient) OR (fromUser = $recipient && toUser = $user)))";
		if (mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_NUM)[0] == 0) {
			//the specified combo does not exist
			header('Location: badContent.php');
		} else {
			$markRead = "UPDATE `messages` SET `read` = 1 WHERE `listingID` = ".$listingID." AND `toUser` = ".$user;
			mysqli_query($conn, $markRead);
		}
	} else {
		//pick the most recently updated conversation of which this user is a participant
		$query = "SELECT * FROM messages WHERE fromUser = $user OR toUser = $user ORDER BY timeCreated DESC";
		$result = mysqli_query($conn, $query);
		
		if ($subMessage = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			if ($subMessage['fromUser']==$user)
				$recipient = $subMessage['toUser'];
			else
				$recipient = $subMessage['fromUser'];
			$listingID = $subMessage['listingID'];
		} else {
			$noMessages = true;
			goto end;
		}
	}
	
	//find everybody I'm talking to
	$query = "SELECT DISTINCT users.id, users.firstName, users.lastName FROM users WHERE EXISTS ".
		"(SELECT id FROM messages WHERE (messages.toUser = $user AND messages.fromUser = users.id) OR (messages.fromUser = $user AND messages.toUser = users.id))";
	$allRecipients = mysqli_query($conn, $query);
	
	//find the name of the recipient
	$query = "SELECT firstName, lastName FROM users WHERE id = $recipient";
	$names = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC);
	
	//select all messages that match the recipient and the listing
	$query = "SELECT * FROM messages WHERE ((fromUser = $user AND toUser = $recipient) OR (toUser = $user AND fromUser = $recipient)) AND listingID = $listingID ORDER BY timeCreated ASC";
	$conversation = mysqli_query($conn, $query);
	
	//select all listings regarding which the recipient has begun a conversation
	$query = "SELECT DISTINCT listings.id, addresses.line1 FROM listings JOIN addresses ON listings.addressID = addresses.id WHERE EXISTS (SELECT id FROM messages WHERE ".
	"((fromUser = $user AND toUser = $recipient) OR (toUser = $user AND fromUser = $recipient)) AND listingID = listings.id)";
	$listings = mysqli_query($conn, $query);
	
	end:
	
?>

<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	  <script>
		//scrolls to bottom of conversation div
		function scrollToBottom() {
			var div = document.getElementById("scroller");
			div.scrollTop = div.scrollHeight;
		}
		
		$(document).ready(function() {
			$('#message').bind('keydown keyup focus blur',function() {
				if ($(this).val().trim()!='')
					$('#send').removeAttr('disabled');
				else
					$('#send').attr('disabled', 'disabled');
			});
		});
	  </script>
	</head>

    <body onLoad="scrollToBottom()">
		<div class="content">
			<?php require_once 'money/navbar.php'; ?>
			<div class="container text-center" style="margin-top:20px;margin-bottom:120px;font-family:Asap">
				<?php
						if ($noMessages) {
							echo "<h1>You don't have any messages!!! You are such a tool.</h1>";
							return;
						}
				?>
				<h2 style="margin-bottom:20px"><?php echo $names['firstName']." ".$names['lastName']; ?> &nbsp;<span class="glyphicon glyphicon-comment"></span></h2>
				<div class="row" style="margin-bottom:5px">
					<div class="col-sm-4">
						<h4>Conversations</h4>
					</div>
					<div class="col-sm-8">
					<!--tabs for each listing this person is talking about-->
						<ul class="nav nav-pills nav-justified" id="myTab" style="text-align:center">
							<?php
								while ($listing = mysqli_fetch_array($listings)) {
							?>
									<li class="<?php if ($listing['id'] == $listingID) echo "active";?> tabswitch" id="listing<?php echo $listing['id']; ?>">
										<a href = "messages.php?recipient=<?php echo $recipient; ?>&listing=<?php echo $listing['id']; ?>">
											<span class="glyphicon glyphicon-home"></span>
											<?php
												echo " ".$listing['line1'];
											?>
										</a>
									</li>
							<?php
								}
							?>
						</ul>
					</div>
				</div>
				<div class = "row">
					<div class="col-xs-4" style="height:405px;overflow-y:auto">
						<table class="table table-hover">
							<tbody>
							</tbody>
							<?php
								if ($otherRecip=mysqli_fetch_array($allRecipients)) {
									do {
										//select details for the latest message in my conversation with this person
										$query = "SELECT b.id, b.fromUser, b.toUser, b.timeCreated, b.content, b.read, b.listingID FROM messages b JOIN ".
											"(SELECT MAX(timeCreated) AS tc FROM messages WHERE (fromUser = $user AND toUser = ".$otherRecip['id'].") OR (toUser = $user AND fromUser = ".$otherRecip['id'].")) a".
											" ON a.tc = b.timeCreated";
										$latestMessage = mysqli_fetch_array(mysqli_query($conn, $query));
							?>
										<tr style="cursor:pointer">
											<td onclick="window.location.href='messages.php?recipient=<?php echo $otherRecip['id']; ?>&listing=<?php echo $latestMessage['listingID']; ?>'" 
												<?php if ($otherRecip['id']==$recipient) echo "style='background-color:#E6F0FA'"; ?>>										
												<?php
													echo "<b>".$otherRecip['firstName']." ".$otherRecip['lastName']."</b>";
													
													echo "<br>";
													echo str_replace("<br />", " ", substr($latestMessage['content'], 0, 50))."...<br>";
													echo "<i>".timediff($latestMessage['timeCreated'])." ago</i>";
												?>
											</td>
										</tr>
							<?php
									} while ($otherRecip=mysqli_fetch_array($allRecipients));
								} else {
							?>	
								<h1>You don't have any messages!!!! You SUCK</h1>
							<?php	
								}
							?>
						</table>
					</div>
					<div class="col-xs-8">
						<div style="background-color:#EEEEEE;height:300px;text-align:left;padding:10px;overflow-y:auto" id="scroller">
							<?php
								while ($details = mysqli_fetch_array($conversation, MYSQLI_ASSOC)) {
									if ($details['fromUser']!=$user) {
							?>
										<div>
											<div style="background-color:white;width:65%; margin-bottom:10px;float:left;border-radius:8px">
												<div style="margin:10px">
													<b><?php echo $names['firstName']." ".$names['lastName']; ?></b><br>
													<?php echo $details['content']; ?><br>
													<p style="font-size:12px"><?php echo $details['timeCreated']; ?></p>
												</div>
											</div>
										</div>
										<br>
							<?php
									} else {
							?>
										<div>
											<div style="background-color:white;width:65%; margin-bottom:10px;float:right;border-radius:8px">
												<div style="margin:10px">
													<b>Me</b><br>
													<?php echo $details['content']; ?><br>
													<p style="font-size:12px"><?php echo $details['timeCreated']; ?></p>
												</div>
											</div>
										</div>
										<br>
							<?php
									}
								}
							?>
						</div>
						<form method = "post" action="money/processMessage.php">
							<input type = "text" hidden name="toUser" value="<?php echo $recipient; ?>">
							<input type = "text" hidden name="listingID" value="<?php echo $listingID; ?>">
							<textarea class="form-control" maxlength="500" rows="4" id="message" name="message" placeholder= "Say something..."style="margin-top:10px;resize:none"></textarea>
							<button type="submit" id= "send"class="btn btn-primary" style="float:right;margin-top:10px" disabled>Send</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
	</body>
</html>