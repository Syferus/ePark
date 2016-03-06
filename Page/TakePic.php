<?php
$r= $_POST['r'];
$n= $_POST['n'];
//$message = "Picture Resolution: ".$r;
$old = $n -1;
exec("sudo rm Content/carpark$old.jpg");
exec("fswebcam -r $r --no-banner Content/carpark$n.jpg");
sleep(2);
//echo $message;
?>