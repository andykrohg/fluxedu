<?php
	date_default_timezone_set("America/New_York");
	
	function timediff($then) {
		$now = strtotime("now");
		$then = strtotime($then);
		$diffSeconds = $now - $then;
		
		if ($diffSeconds < 60) {
			if ($diffSeconds<=1)
				return "1 second";
			else
				return $diffSeconds." seconds";
		}
		
		$diffMinutes = intval($diffSeconds/60);
		
		if ($diffMinutes < 60){
			if ($diffMinutes>1)
				return $diffMinutes." minutes";
			else
				return $diffMinutes." minute";
		}
			
		$diffHours = intval($diffSeconds/(60*60));
		
		if ($diffHours < 24){
			if ($diffHours>1)
				return $diffHours." hours";
			else
				return $diffHours." hour";
		}
			
		$diffDays = intval($diffSeconds/(60*60*24));
		
		if ($diffDays < 30){
			if ($diffDays>1)
				return $diffDays." days";
			else
				return $diffDays." day";
		}
	}
?>