<?php    
    session_start();
	
    //connect
    require_once 'money/dbconnect.php';
                
    $email=mysqli_escape_string($conn, $_GET['email']);
    $query="SELECT active, id FROM users WHERE email = '".$email."'";
    $result=mysqli_query($conn,$query);     
    if ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        if (!$row['active']) {
            if(md5($email.'andy is cool')==$_GET['key']) {
                mysqli_query($conn, "UPDATE users SET active=1 WHERE email='$email'");
                $_SESSION["userID"] = $row['id'];
                $_SESSION['LAST_ACTIVITY']=time();
                header('Location: chooseRole.php');        
            } else echo "Mismatched key. Please ensure that you copied the address correctly.";
        } else echo "User is already active.";
    } else echo "User does not exist.";       
?>
