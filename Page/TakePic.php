<?php
	
	$r= $_POST['r']; //The data that is passed from tha ajax function
	$message = "The Resolution you have entered is ".$r;
	echo $message;//This will be obtained in the ajax response.
	
	
	
	//exec("sudo fswebcam -r 1280x720 --no-banner Content/carpark.jpg");
?>