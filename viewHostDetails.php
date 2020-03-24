<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <h1>Meet your roomies.</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Major</th>
                        <th>Social Security #</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="http://www.lfpn.ds.mpg.de/turbulence/images/bewley.jpg" alt="Greg photo" style="width: 130px;height: 150px"></td>
                        <td><div>Greg (Host)</div><button type="button" class="btn btn-primary" onclick="window.location.href='contactHost.php'">Contact</button></td>
                        <td>Junior</td>
                        <td>Economics</td>
                        <td>3568279857</td>
                    </tr>
                    <tr>
                        <td><img src="http://people.csail.mit.edu/rcm/headshot-hires.jpg" alt="Rob photo" style="width: 130px;height: 150px"></td>
                        <td>Rob</td>
                        <td>Senior</td>
                        <td>Finance</td>
                        <td>9587302759</td>
                    </tr>
                    <tr>
                        <td><img src="http://brandnewdaydesigns.com/wp-content/uploads/2012/07/mm.jpeg" alt="Mike photo" style="width: 130px;height: 150px"></td>
                        <td>Mike</td>
                        <td>Senior</td>
                        <td>Finance</td>
                        <td>8737492675</td>
                    </tr>
                </tbody>
            </table>
        </div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
