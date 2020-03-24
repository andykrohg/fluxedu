<?php
	//connect
    $conn = mysqli_connect('fdb13.biz.nf','1894494_s2s','andyiscool1','1894494_s2s');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>