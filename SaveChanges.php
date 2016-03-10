<?php
$servername = "eu-cdbr-azure-west-d.cloudapp.net";
$username = "b2d171ae38f795";
$password = "ad220908";
$dbname = "EparkDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$Name = $_POST['Name'];
$GPS = $_POST['GPS'];
$Location = $_POST['Location'];
$Resolution = $_POST['Resolution'];
$Frequency = $_POST['Frequency'];
$ImageName = $_POST['ImageName'];
$FullAddress = $_POST['FullAddress'];

$sql1 = "SELECT ID FROM locations Where County = '$Location'";
$result1 = $conn->query($sql1);

while ($row = $result1->fetch_assoc()) {
    $id = $row["ID"];
}

$sql = "INSERT INTO CarParks (Name, GPS, Location, Resolution, Frequency, ImageName, Address, FreeSpaces)
		VALUES ('$Name', '$GPS', '$id' , '$Resolution', '$Frequency', '$ImageName', '$FullAddress', 0)";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo $last_id;
} else {
    echo NULL;
}

$conn->close();
?>
