<?php
    require_once 'money/session.php';
?>

<html>
	<head>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	</head>

    <body>
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <div class="jumbotron">
                <h1>Success!</h1>
                <h3>You passed the test.</h3>
            </div>
            <h3>Now choose your status:</h3>
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-primary btn-block" onclick="window.location.href='createListing.php'"><h3>My roommate bailed on me.</h3></button>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary btn-block" onclick="window.location.href='findHome.php'"><h3>I'm homeless.</h3></button>
                </div>
            </div>
            <div style="margin-top: 70px;margin-bottom: 10px">Not Ready Yet?</div>
            <button type="button" class="btn btn-default btn-sm" onclick="window.location.href='mySpace.php'">My Space</button>
        </div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>