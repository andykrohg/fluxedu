<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
		<div class="content">
			<div class="container text-center" style="margin-top: 70px; font-family: Asap">
				<h1 style="margin-bottom: 40px">Login</h1>
				<?php 
					if (isset($_GET['error'])) {
						echo "<h4>WHOOo0o0o0o0PS! We didn't recognize that login.</h4>";
					} else if (isset($_GET['expired'])) {
						echo "<h4>You have been logged out due to inactivity.</h4>";
					}
				?>
				<form role="form" class="form-horizontal" method="post" name="form" id="form" action="authenticateLogin.php">
					<div class="form-group">
						<div class="col-sm-1"></div>
						<label for="email" class="control-label col-sm-2">School Email:</label>
						<div class="col-sm-6">
							<input type="text" required class="form-control" name="email" id="email">
						</div>
						<div class="col-sm-3"></div>
					</div>
					<div class="form-group">
						<div class="col-sm-1"></div>
						<label for="password" class="control-label col-sm-2">Password:</label>
						<div class="col-sm-6">
							<input type="password" required class="form-control" name="password" id="password">
						</div>
						<div class="col-sm-3"></div>
					</div>
					<button type="button" class="btn btn-default btn-sm" style="margin-right: 30px; margin-top: 20px">Forgot Password?</button>
					<button type="submit" class="btn btn-primary btn-lg" style="margin-top: 20px">Go</button>
				</form>

				<h4 style="margin-top: 70px">New Here?</h4>
				<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='findMySchool.php'">Create an Account</button>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
