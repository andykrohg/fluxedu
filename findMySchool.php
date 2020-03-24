<!DOCTYPE html>
<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	  
	  <!--bootstrap select-->
      <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/css/bootstrap-select.min.css">
      <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.5/js/bootstrap-select.min.js"></script>
	</head>
	
	<body>
		<div class="content">
			<div class = "container text-center" style = "margin-top:70px;font-family:Asap">
				<h1 class = "text-center">What University Are We Talking Here?</h1>
				<br>
				<form action="emailMe.php" method="post" style="margin-top: 50px">
					<select class="selectpicker" multiple data-max-options="1" title="Find Your School" onchange="this.form.submit()" name="school">
						<option value="umd">University of Maryland</option>
						<option value="rutgers">Rutgers University</option>
						<option value="mail.montclair">Montclair State University</option>
					</select>
				</form>

				<div style="margin-top: 70px;margin-bottom: 10px">Already done this?</div>
				<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='login.php'">Login</button>
			</div>
		</div>
		<?php require_once "money/footer.php"; ?>
	</body>
</html>