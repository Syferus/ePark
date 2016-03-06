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
		
		$id = $_POST['id'];
		
		$sql = "SELECT * FROM spaces Where CarPark = $id";
		$result = $conn->query($sql);
		
		
		
		$outp = '{"space" : [';
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		if ($outp != '{"space" : [') {$outp .= ",";}
		
		$outp .= '{"CarPark":'  .  $rs["CarPark"] . ',';
		$outp .= '"SpaceID":'   . $rs["ID"]        . ',';
		$outp .= '"x1":'   . $rs["x1"]        . ',';
		$outp .= '"y1":'   . $rs["y1"]        . ',';
		$outp .= '"x2":'   . $rs["x2"]        . ',';
		$outp .= '"y2":'   . $rs["y2"]        . ',';
		$outp .= '"x3":'   . $rs["x3"]        . ',';
		$outp .= '"y3":'   . $rs["y3"]        . ',';
		$outp .= '"x4":'   . $rs["x4"]        . ',';
		$outp .= '"y4":'   . $rs["y4"]        . ',';
		$outp .= '"full":'.  $rs["Stat"]    . '}'; 
		}
		
		$outp .="]}";
		
		echo($outp);
		
		//return($outp);
		
		
		$conn->close();
?>

