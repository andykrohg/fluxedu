<?php
    session_start();
    if (!isset($_SESSION['LAST_ACTIVITY']) || ($expired = (time() - $_SESSION['LAST_ACTIVITY'] > 900))) {
        // last request was more than 15 minutes ago
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_unset(); 
            session_destroy();
        }
		if ($expired)
			header('Location: login.php?expired');
		else
			header('Location: index.php');
    }
    $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } else if (time() - $_SESSION['CREATED'] > 900) {
        // session started more than 15 minutes ago
        session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
        $_SESSION['CREATED'] = time();  // update creation time
    }
?>