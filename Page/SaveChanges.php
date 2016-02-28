<?php
$servername = "eu-cdbr-azure-west-d.cloudapp.net";
$username = "bc9daf64ff34a2";
$password = "e7404ad2";
$dbname = "EparkMySQLDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$CarParkName = $_POST['CarParkName'];
$CarParkAddress = $_POST['CarParkAddress'];
$Resolution= $_POST['Resolution'];
$Frequency= $_POST['Frequency'];
$ImageName= $_POST['ImageName'];


// $sql = "INSERT INTO CarParkDetails (CarParkName, CarParkAddress, Resolution, Frequency, ImageName)
// VALUES ('Test', 'Test', 'Test', '123', 'Test')";

$sql = "INSERT INTO CarParkDetails (CarParkName, CarParkAddress, Resolution, Frequency, ImageName)
VALUES ('$CarParkName',  '$CarParkAddress' , '$Resolution', '$Frequency', '$ImageName')";

if ($conn->query($sql) === TRUE) {
	$last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
