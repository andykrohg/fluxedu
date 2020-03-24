<html>
	<head>
	  <?php require_once "money/styling.php"; ?>

        <script>
            function passwordMatch() {
                if (document.getElementById('pwd').value == document.getElementById('confirm').value)
                    return true;
                else {
                    document.getElementById('mismatch').setAttribute('hidden', 'false')
                    alert("Entered passwords do not match!");
                    return false;
                }
            }

        </script>
	</head>

	<body>
		<div class="content">
			<div class = "container text-center" style = "margin-top:70px;font-family:Asap">
				<h1 class = "text-center">Enter your school email address.</h1>
				<h4 class ="text-center">Just the basic stuff now. We'll grab more details later.</h4>
				
				<div class = "container text-center" style="margin-top:70px">
					<form role="form"  onsubmit="return passwordMatch()" action="sendConfirmationEmail.php" method="post">
						<div class = "form-group">
							<div class = "row">
								<div class = "col-sm-3"></div>
								<div class = "col-sm-6">
									<label for="email">School Email</label>
									<input type = "text" class = "form-control" id = "email" name="email" autofocus="true" placeHolder="john.doe@<?php echo $_POST['school'];?>.edu"
										   pattern="[a-z0-9._%+-]+@+(([a-z0-9._%+-]+.<?php echo $_POST['school'];?>.edu)|(<?php echo $_POST['school'];?>.edu))" title="The domain name must end in <?php echo $_POST['school'];?>.edu.">
								</div>
								<div class = "col-sm-3"></div>
							</div>
						</div>
						<div class = "form-group">
							<div class = "row">
								<div class = "col-sm-3"></div>
								<div class = "col-sm-6">
									<label for="pwd">Create Password</label>
									<input type = "password" class = "form-control" id = "pwd" name="pwd" pattern="[a-zA-Z0-9]{4,}" title="Passwords must contain at least 4 characters.">
								</div>
								<div class = "col-sm-3"></div>
							</div>
						</div>
						<div class = "form-group">
							<div class = "row">
								<div class = "col-sm-3"></div>
								<div class = "col-sm-6">
									<label for="confirm">Confirm Password</label>
									<input type = "password" class = "form-control" id = "confirm" name="confirm">
								</div>
								<div class = "col-sm-3"></div>
							</div>
						</div>
						<button style="margin-right: 30px"type="button" class="btn btn-default" onclick="window.location.href='findMySchool.php'">Back</button>
						<input type="submit" value = "Let's Go!"class="btn btn-primary">
					</form>

					<div style="margin-top: 70px;margin-bottom: 10px">Already done this?</div>
					<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='login.php'">Login</button>
				</div>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
	</body>
</html>