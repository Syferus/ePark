<?php
$CarPark = $_POST['CarPark'];
exec("epiphany --display=:0 127.0.0.1/Comparison.php?id=$CarPark &");
?>