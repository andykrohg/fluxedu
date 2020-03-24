<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <h1>Your Current Roommates</h1>
            <h4>Add details about your roommates here, so your new guest has the scoop on his or her situation.</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Major</th>
                        <th>Mother's Maiden</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="http://www.lfpn.ds.mpg.de/turbulence/images/bewley.jpg" alt="Greg photo" style="width: 130px;height: 150px"></td>
                        <td>Greg (Host)</td>
                        <td>Junior</td>
                        <td>Economics</td>
                        <td>Jones</td>
                        <td><button type="button" class="btn btn-primary">Edit</button><button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td><img src="http://people.csail.mit.edu/rcm/headshot-hires.jpg" alt="Rob photo" style="width: 130px;height: 150px"></td>
                        <td>Rob</td>
                        <td>Senior</td>
                        <td>Finance</td>
                        <td>Schultz</td>
                        <td><button type="button" class="btn btn-primary">Edit</button><button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                    <tr>
                        <td><img src="http://brandnewdaydesigns.com/wp-content/uploads/2012/07/mm.jpeg" alt="Mike photo" style="width: 130px;height: 150px"></td>
                        <td>Mike</td>
                        <td>Senior</td>
                        <td>Finance</td>
                        <td>Loesser</td>
                        <td><button type="button" class="btn btn-primary">Edit</button><button type="button" class="btn btn-danger">Delete</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-primary" onclick="window.location.href='enterRoommateDetails.php'">Add a roommate</button>
            <button type="button" class="btn btn-success" onclick="window.location.href='uploadHousePhoto.php'">Continue</button>
        </div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
