<?php

if(!isset($_POST["register"]))
{
    $path = "http://i-be-jugglin.000webhostapp.com/dev/mainPage.php";
    header("location:$path");
}

session_start();
unset($_SESSION["registerError"]);

$login = $_POST["login"];
$name = $_POST["username"];
$password = $_POST["password"];
$repeat = $_POST["repeat"];


$_SESSION["login"] = $login;
$_SESSION["username"] = $name;

$ok = false;
$error = "";



if(strlen($login) < 3 || strlen($login) > 20)
{
    $error = "Niepoprawna długość loginu";
    //Login has incorrect length
}
else if(strlen($name) < 3 || strlen($name) > 20)
{
    $error = "Niepoprawna długość nazwy użytkownika";
    //Username has incorrect length
}
else if(strlen($password) < 8)
{
    $error = "Hasło musi mieć minimum 8 znaków";
    //Password is too short
}
else if($password != $repeat)
{
    $error = "Hasła nie są identyczne";
    //Passwords don't match
}
else
{
    
    //Now check if that login is occupied
    //Or register new user

    $path = "../common";
    require("$path/connectDB.php");
    $table = "users";  

    $login = htmlentities($login,ENT_QUOTES,"UTF-8");
    $login = mysqli_real_escape_string($mysqli,$login);

    $name =  htmlentities($name,ENT_QUOTES,"UTF-8");
    $name = mysqli_real_escape_string($mysqli,$name);

    //Check if login is occupied
    $query = sprintf("SELECT * FROM users WHERE login = '%s'", $login);
    $result = mysqli_query($mysqli, $query);
    $isOccupied = mysqli_num_rows($result);
    
    if($isOccupied) {$error = "Login zajęty.";}
    else
    {
        
        //Check if username is occupied
        $query = sprintf("SELECT * FROM `$table` WHERE `username` = '%s'", $name);
        $result = mysqli_query($mysqli, $query);
        $isOccupied = mysqli_num_rows($result);
        if($isOccupied) {$error = "Nazwa użytkownika zajęta.";}
        else
        {
            //Register
            $password_hash = md5($password);
            $query = sprintf("INSERT INTO `$table` (`id`, `login`, `username`, `password`) VALUES (NULL, '$login', '$name', '$password_hash')");
            $result = mysqli_query($mysqli, $query);
            
            $query = sprintf("SELECT * FROM `$table` WHERE `login` = '%s' AND `password` = '%s'", $login, $password_hash);
            $result = mysqli_query($mysqli, $query);
            
            $userData = mysqli_fetch_assoc($result);
            $_SESSION["userID"] = $userData["id"];
            $_SESSION["userName"] = $userData["username"];

            unset($_SESSION["registerError"]);
            $ok = true;
        }
    }

    $mysqli -> close();
}



if(!$ok)
{
    $_SESSION["registerError"] = $error;
    header("location:register-form.php");
}
else
    header("location:account.php");
?>