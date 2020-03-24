<!DOCTYPE html>
<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>
	<body>
		<div class = "content">
			<div class = "container text-center" style = "font-family:Asap">
				<div class="row">
					<div class="col-sm-4"></div>
					<h1 class="col-sm-4" style="font-size:80px;font-family: Asap;margin-top:70px" >flux<span style="color:#0066CC">edu</span></h1>
					<!--img class="col-sm-1" src = "images/lightbulb.png" alt="lightbulb" style="width:100px;height:auto"-->
					<div class="col-sm-4"></div>
				</div>
				<h4>
					So you've chosen to live off campus, and already your plans have fallen through?
				</h4>
				<h4><b>We've got your back.</b></h4>

				<div style = "margin-top:50px">
					<button type="button" class="btn btn-primary" onclick = "window.location.href='findMySchool.php'"><h4>Let's Get Started<h4></button>
					<h4>Or</h4>
					<button type="button" class="btn btn-default text-center" onclick="window.location.href='login.php'"><b>Login</b></button>
				</div>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
	</body>
</html>