<?php
	// Set the default timezone to Manila, Philippines
	date_default_timezone_set('Asia/Manila');

	// Get the current time in the Philippine timezone
	$current_time = date('h:i:s A');

	// Return the current time as a response
	echo $current_time;
?>
