<?php
    $servername = "localhost";
    $database = "test";
    $username = "test";
    $password = "test";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
//Set charset
mysqli_set_charset($conn, "utf8");
// Check connection
if (!$conn) {
    die("Connection failed: " . 
mysqli_connect_error());
}
echo "Connected successfully \n";
// mysqli_close($conn);
?>