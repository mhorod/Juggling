<?php
$db_username = "root";
$db_password = "";
$database = "tricks";
$mysqli = new mysqli("localhost", $db_username, $db_password, $database);
$mysqli -> select_db($database) or die( "Unable to select database");
mysqli_query($mysqli, "SET NAMES 'utf8'");
mysqli_query($mysqli,"SET CHARACTER SET 'utf8'");
?>