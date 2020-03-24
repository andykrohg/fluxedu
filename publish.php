<?php
	require_once 'money/session.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require_once "money/styling.php"; ?>
    </head>

    <body>
        <?php
            //connect
            require_once 'money/dbconnect.php';
			
			$userID = $_SESSION['userID'];
			
			//escape address fields
			$line1 = mysqli_escape_string($conn, $_POST['line1']);
			$line2 = mysqli_escape_string($conn, $_POST['line2']);
			$city = mysqli_escape_string($conn, $_POST['city']);
			$state = mysqli_escape_string($conn, $_POST['state']);
			$zip = mysqli_escape_string($conn, $_POST['zip']);
			
			//escape listing fields
			$start = mysqli_escape_string($conn, $_POST['start']);
			$end = mysqli_escape_string($conn, $_POST['end']);
			$rent = mysqli_escape_string($conn, $_POST['rent']);
			$photoID = null;
			if (basename($_FILES['photo']['name']) != null) {
				$extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
				$photoID = mysqli_escape_string($conn, uniqid().".$extension");
			}

            //perform the address insert
            $address = "INSERT INTO addresses (line1, line2, city, state, zip) VALUES ('$line1',";
            if (trim($line2)!='')
                $address.="'$line2',";
            else
                $address.="null,";
            $address.="'$city', '$state', '$zip')";
            mysqli_query($conn, $address) or die(mysqli_error($conn));

            //perform the listing insert
            $listing = "INSERT INTO listings (user, startDate, endDate, rent, photoID, addressID) VALUES ($userID,'$start','$end', $rent,'$photoID',".mysqli_insert_id($conn).")";
            mysqli_query($conn, $listing);

			if ($photoID != null) {
				//create photo directory
				mkdir("images/client/".mysqli_insert_id($conn));
				
				//upload the image file
				$filename = $photoID;
				$target_dir = "images/client/".mysqli_insert_id($conn)."/";
				$target_file = $target_dir . $filename;
				$uploadOk = 1;
				
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
					$check = getimagesize($_FILES["photo"]["tmp_name"]);
					if($check !== false) {
						//echo "File is an image - " . $check["mime"] . ".";
						$uploadOk = 1;
					} else {
						echo "File is not an image.";
						$uploadOk = 0;
					}
				}

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
						//echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
					} else {
						echo "Sorry, there was an error uploading your file.";
					}
				}
			}
        ?>
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <h1>Success!</h1>
            <h4>Your post was successfully published.</h4>
            <button class="btn btn-primary btn-lg" type="button" onclick="window.location.href='viewHomeDetails.php?id=<?php echo mysqli_insert_id($conn); ?>'">Take Me There</button>
        </div>
		<?php require_once "money/footer.php"; ?>
    </body>
</html>
