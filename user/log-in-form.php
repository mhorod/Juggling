<?php

function displayForm($login, $error)
{
    echo<<<END
    <span class = "error">$error</span>
    <br>
    <div>
    <span class = "form-input"> Login </span> <input value = "$login" type = "text" name = "login"/>
    </div>
    <div>
    <span class = "form-input"> Hasło </span> <input type = "password" name = "password"/>
    </div>
    <br>
END;
    
}
?>



<html>
    <head>
       <?php require_once("../common/commonHead.php"); ?>
        <title>Logowanie</title>
    </head>
    <body>
       <?php require_once("../common/userMenu.php"); ?>
        <div id = "page-wrapper">

            <div class = "form" >
                <h2>Logowanie</h2>
                <form action = "log-in.php" method = "post">
                    
<?php
    session_start();
    $login = "";
    $password = "";
    $error = "";
    if(isset($_SESSION["logInError"]))
    {
        $error = $_SESSION["logInError"];
        unset($_SESSION["logInError"]);
    }
                    
    if(isset($_SESSION["login"]))
    {
        $login = $_SESSION["login"];
    }
                    
    displayForm($login, $error);
                    
                    

?>
                    <input type = "submit" value = "Loguj"/>
                 </form>
            </div>
        </div>
        
        <footer>Made by: Pichał and Hichał &copy; 2019;</footer>
    </body>
    
</html>
