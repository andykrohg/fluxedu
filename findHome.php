<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <h1>Let's find a home.</h1>
            <h3 style="margin-top: 60px">Provide a time frame:</h3>
            <form role ="form" method="post" action="viewHomes.php">
                <div class = "form-group">
					<div class = "row">
						<div class = "col-sm-1"></div>
						<div class = "col-sm-4">
                            <label for "start">From:</label>
							<input type = "date" class ="btn-block" id="start">
						</div>
                        <div class="col-sm-2"></div>
						<div class = "col-sm-4">
                            <label for "end">To:</label>
							<input type="date" class ="btn-block"id="end">
						</div>
						<div class = "col-sm-1"></div>
					</div>
				</div>
                <input type="submit" class="btn btn-success btn-lg" value="Go!" style="margin-top: 30px">
            </form>
        </div>
	<?php require_once "money/footer.php"; ?>		
    </body>
</html>
