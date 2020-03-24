<?php
	require_once 'money/session.php';
	require_once 'money/dbconnect.php';
	require_once 'money/timediff.php';
	
	$user = $_SESSION['userID'];
	$name = $_SESSION['firstName']." ".$_SESSION['lastName'];
	
	//find everybody I'm talking to
	$query = "SELECT DISTINCT users.id, users.firstName, users.lastName, users.photoID FROM users WHERE EXISTS ".
		"(SELECT id FROM messages WHERE (messages.toUser = $user AND messages.fromUser = users.id) OR (messages.fromUser = $user AND messages.toUser = users.id))";
	$navRecipients = mysqli_query($conn, $query);
	
	//number of unread messages
	$query = "SELECT COUNT(1) FROM messages INNER JOIN listings ON messages.listingID = listings.id WHERE listings.user='$user' AND messages.read=0 AND messages.toUser=$user";
	$unread = mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_NUM);
?>

<!DOCTYPE html>
<link href='http://fonts.googleapis.com/css?family=Asap:400' rel='stylesheet' type='text/css'>
	<nav class="navbar navbar-default" style="font-family:Asap">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="mySpace.php">
					<span style = "color:#0066CC"class="glyphicon glyphicon-knight"></span>
				</a>
			</div>

			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="viewHomes.php"><span class="glyphicon glyphicon-edit"></span> Posts</a></li>
					<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-envelope"></span>
							<?php
								if ($unread[0] > 0) echo "<b> Messages (".$unread[0].")</b>";
								else echo " Messages";
							?>
							<span class="caret"></span>
						</a>
						
						<ul class="dropdown-menu" name = "messageID">
							<?php
								$numMessages = 0;
								while ($numMessages < 5 && $navRecip=mysqli_fetch_array($navRecipients, MYSQLI_ASSOC)) {
									$numMessages++;
									//select details for the latest message in my conversation with this person
									$query = "SELECT b.id, b.fromUser, b.toUser, b.timeCreated, b.content, b.read, b.listingID FROM messages b JOIN ".
										"(SELECT MAX(timeCreated) AS tc FROM messages WHERE (fromUser = $user AND toUser = ".$navRecip['id'].") OR (toUser = $user AND fromUser = ".$navRecip['id'].")) a".
										" ON a.tc = b.timeCreated";
									$navMessage = mysqli_fetch_array(mysqli_query($conn, $query));
							?>
								<li <?php if (!$navMessage['read'] && $navMessage['toUser']==$user) echo "style='background-color:#E6F0FA'"; ?>>
									<a href = "messages.php?recipient=<?php echo $navRecip['id']; ?>&listing=<?php echo $navMessage['listingID']; ?>">											
										<?php
											if ($navMessage['firstName'])
												echo "<b>".$navMessage['firstName']." ".$navMessage['lastName']."</b>";
											else
												echo "<b>".$navRecip['firstName']." ".$navRecip['lastName']."</b>";
											echo "&nbsp;<span style='font-size:12px'><i>".timediff($navMessage['timeCreated'])." ago</i></span><br>";
											$image = "<img alt ='Profile Photo' style='width:30px;height:30px;margin-right:5px;margin-top:5px;margin-bottom:5px' src='images/";
											if ($navRecip['photoID'])
												$image.="profilePhotos/".$navRecip['id']."/".$navRecip['photoID']."'>";
											else
												$image.="defaultUser.png'>";
											echo $image;
											$content = substr(str_replace("<br />", " ", $navMessage['content']), 0, 40);
											echo $content."...<br>";
										?>
									</a>
								</li>
								<hr style='margin-top:0px;margin-bottom:0px'>
							<?php
								}
							?>
							<li style="text-align:center"><a href = "messages.php">View All Messages</a></li>
						</ul>
					</li>
					<li><a href="createListing.php"><span class="glyphicon glyphicon-plus"></span> Create Post</a></li>
					<li><a href="money/logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
					<li><a href="#">Logged in as <?php echo $name; ?></a></li>
				</ul>
			</div>
		</div>
	</nav>