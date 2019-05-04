<?php
//Logout = reset session. 
//Probably in the future it may cause a problem
session_start();
session_unset();
header("Location:../");
?>