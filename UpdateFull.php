<?php
$servername = "eu-cdbr-azure-west-d.cloudapp.net";
$username = "b2d171ae38f795";
$password = "ad220908";
$dbname = "EparkDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$JSONpoints = $_POST['JSONpoints'];

$spaces = json_decode($JSONpoints);

$amount = count($spaces);

$x = 0;
while ($x < $amount) {
    $id = $spaces[$x]->SpaceID;
    $s = $spaces[$x]->full;
    $sql = "UPDATE spaces SET Stat=$s WHERE ID=$id";
    $result = $conn->query($sql);
    $x++;
}
$conn->close();
?>