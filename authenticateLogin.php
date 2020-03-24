<?php
    session_start();
    
    require_once 'money/dbconnect.php';
    
    //escape entries
    $email=mysqli_escape_string($conn, $_POST['email']);
    $password=mysqli_escape_string($conn, $_POST['password']);
    $password=md5($password);
     
    //check values
    $query="SELECT id, firstName, lastName FROM users WHERE email = '$email' AND password = '$password'";
    if ($row=mysqli_fetch_array(mysqli_query($conn, $query), MYSQLI_ASSOC)) {
        $_SESSION['userID']=$row['id'];
		$_SESSION['firstName']=$row['firstName'];
		$_SESSION['lastName']=$row['lastName'];
		
        $_SESSION['LAST_ACTIVITY']=time();
        header('Location: mySpace.php');
    } else {
        header('Location: login.php?error');
    }
?>

