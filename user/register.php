<?php
/*
    Receive data and attempt creating new user
*/

//Validate user-provided data
function validate($login, $name, $password, $repeat)
{
    $error = "";
    if(strlen($login) < 3 || strlen($login) > 20)
    {
        //Login has incorrect length
        $error = "Niepoprawna długość loginu";
    }
    else if(strlen($name) < 3 || strlen($name) > 20)
    {
        //Username has incorrect length
        $error = "Niepoprawna długość nazwy użytkownika";
    }
    else if(strlen($password) < 8)
    {
        //Password is too short
        $error = "Hasło musi mieć minimum 8 znaków";
    }
    else if($password != $repeat)
    {
        //Passwords don't match
        $error = "Hasła nie są identyczne"; 
    }
    return $error;
}

//File should only be accessed via POST request
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

//Save data to further refill if register failed
$_SESSION["login"] = $login;
$_SESSION["username"] = $name;

$ok = false;
$error = validate($login, $name, $password, $repeat);

if($error != "")
{
    //Validation passed
    //Now check if that login is occupied or register a new user

    $path = "../common";
    require("$path/connectDB.php");
    $usersTable = "users";  
    
    //Assure that those data are code-harmless
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
        $query = sprintf("SELECT * FROM `$usersTable` WHERE `username` = '%s'", $name);
        $result = mysqli_query($mysqli, $query);
        $isOccupied = mysqli_num_rows($result);
        if($isOccupied) {$error = "Nazwa użytkownika zajęta.";}
        else
        {
            //Add new user to database
            $password_hash = md5($password);
            $query = sprintf("INSERT INTO `$usersTable` (`id`, `login`, `username`, `password`) VALUES (NULL, '$login', '$name', '$password_hash')");
            $result = mysqli_query($mysqli, $query);
            
            //Get back information about what was inserted
            $query = sprintf("SELECT * FROM `$usersTable` WHERE `login` = '%s' AND `password` = '%s'", $login, $password_hash);
            $result = mysqli_query($mysqli, $query);
            $userData = mysqli_fetch_assoc($result);
            
            //Log in = save user in current session
            $_SESSION["userID"] = $userData["id"];
            $_SESSION["userName"] = $userData["username"];
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