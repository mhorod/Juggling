
<?php
$username = "root";
$password = "";
$database = "tricks";
$mysqli = new mysqli("localhost", $username, $password, $database);
$mysqli -> select_db($database) or die( "Unable to select database");
mysqli_query($mysqli, "SET NAMES 'utf8'");
mysqli_query($mysqli,"SET CHARACTER SET 'utf8'");
?>