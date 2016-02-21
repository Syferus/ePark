<?php
	
	$r= $_POST['r']; //The data that is passed from tha ajax function
	$n= $_POST['n'];
	$message = "This Pictures Resolution is ".$r;
	$old = $n -1;
	exec("sudo rm Content/carpark$old.jpg");
	exec("fswebcam -r $r --no-banner Content/carpark$n.jpg");
	sleep(2);
	echo $message;//This will be obtained in the ajax response.
	
	//exec("sudo fswebcam -r 1280x720 --no-banner Content/carpark.jpg");
?>