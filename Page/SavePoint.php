<?php

$servername = "eu-cdbr-azure-west-d.cloudapp.net";
$username = "b2d171ae38f795";
$password = "ad220908";
$dbname = "EparkDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// $CarPark = $_POST['CarPark'];
// $x1 = $_POST['x1'];
// $y1 = $_POST['y1'];
// $x2 = $_POST['x2'];
// $y2 = $_POST['y2'];
// $x3 = $_POST['x3'];
// $y3 = $_POST['y3'];
// $x4 = $_POST['x4'];
// $y4 = $_POST['y4'];

// $sql = "INSERT INTO spaces (CarPark, Stat, x1, y1, x2, y2, x3, y3, x4, y4) VALUES ('$CarPark', 0, '$x1', '$y1', '$x2', '$y2', '$x3', '$y3', '$x4', '$y4')";


// if ($conn->query($sql) === TRUE) {
	// $last_id = $conn->insert_id;
    // echo "New record created successfully. Last inserted ID is: " . $last_id;
// } else {
    // echo "Error: " . $sql . "<br>" . $conn->error;
// }


$JSONpoints = $_POST['JSONpoints'];
$CarPark = $_POST['CarPark'];

$spaces = json_decode($JSONpoints);
		
$count = count($spaces);

$x = 0;	
while($x < $count) {
	$x1 = $spaces[$x]->x1;
	$y1 = $spaces[$x]->y1;
	$x2 = $spaces[$x]->x2;
	$y2 = $spaces[$x]->y2;
	$x3 = $spaces[$x]->x3;
	$y3 = $spaces[$x]->y3;
	$x4 = $spaces[$x]->x4;
	$y4 = $spaces[$x]->y4;
	
	$sql = "INSERT INTO spaces (CarPark, Stat, x1, y1, x2, y2, x3, y3, x4, y4) VALUES ('$CarPark', 0, '$x1', '$y1', '$x2', '$y2', '$x3', '$y3', '$x4', '$y4')";
	$result = $conn->query($sql);
	$x++;
}

$conn->close();

?>