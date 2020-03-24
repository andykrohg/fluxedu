<html>
	<head>
	  <?php require_once "money/styling.php"; ?>
	</head>

    <body>
        
        <div class="container text-center" style="margin-top: 70px;font-family:Asap">
            <h1>We shot you a message.</h1>
            <h4>Check your email so we can confirm you're you.</h4>
            <button type="button" class="btn btn-primary" style="margin-top: 70px" onclick="window.location.href='sendConfirmationEmail.php'">Resend</button>
        </div>
        <?php
            require 'Utilities/PHPMailer/PHPMailerAutoload.php';

            $email=$_POST['email'];

            //hash the password with MD5
            $password=md5($_POST['pwd']);

            //create a confirm key
            $key=$email . 'andy is cool';
            $key=md5($key);

            $mail = new PHPMailer;

            //$mail->SMTPDebug = 3;                               // Enable verbose debug output

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.verizon.net';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'homelyhugobro24';                 // SMTP username
            $mail->Password = 'output88';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            $mail->From = 'noreply@student2student.com';
            $mail->FromName = 'Student 2 Student';
            $mail->addAddress('andykrohg@gmail.com');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('andykrohg@gmail.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Welcome to Student 2 Student!';
            //$mail->msgHTML(file_get_contents('utilities/phpmailer/examples/contents.html'), dirname(__FILE__));
            $mail->msgHTML(    
                'Hey there!<br><br>
                Thanks for confirming this email for us. Please click the link below to confirm your account. If the link is not clickable, please copy and paste it into your browser.<br><br>
                <a href="http://student2student.co.nf/confirmUser.php?email='.$email.'&key='.$key.'">localhost:4783/confirmUser.php?email='.$email.'&key='.$key.'</a><br><br> 
                Thanks!<br>
                Student 2 Student');
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            
            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                //echo 'Message has been sent';
            }

            //After sending the email, add the user to the database.
            
            //connect
            require_once 'money/dbconnect.php';

            //add user to the database
            $email=mysqli_escape_string($conn,$email);
            $password=mysqli_escape_string($conn,$password);
            $insert = "INSERT INTO users(email,password) VALUES ('$email','$password')";
            mysqli_query($conn, $insert);
        ?>

    </body>
</html>
