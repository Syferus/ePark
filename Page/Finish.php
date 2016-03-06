<?php 
// $x = "'It Worked' > /var/www/html/foo.txt ";
// exec("echo $' #!/bin/bash \n echo $x ' > /var/www/html/foo.sh");
// sleep(1);
// exec("sh foo.sh");
// sleep(1);

//epiphany --display=:0 http://www.google.com &

$CarPark= $_POST['CarPark'];
// $ImageName= $_POST['ImageName'];
// $Frequency= $_POST['Frequency'];
// $Resolution= $_POST['Resolution'];



// $query_string = "carparkid={$CarPark}&imagename={$ImageName}&frequency={$Frequency}&resolution={$Resolution}";
// //$url = "http://www.example.com?" . $query_string;

//exec("epiphany --display=:0 127.0.0.1/Comparison.php?$query_string &");

exec("epiphany --display=:0 127.0.0.1/Comparison.php?id=$CarPark &");

 
// $fields = array('carparkid' => $CarPark,
                // 'imagename' => $ImageName,
				// 'frequency' => $Frequency,
                // 'resolution' => $Resolution);
 
// $url = "127.0.0.1/Comparison.php?" . http_build_query($fields, '', "&");

// exec("epiphany --display=:0 $url");




?>