<?php

function displayForm($login, $username, $error)
{
    echo<<<END
    <span class = "error">$error</span>
    <br/>
    <span class = "form-input">Login</span> <input value = "$login" type = "text" name = "login"/>
    <br/>
    <span class = "form-input">Nazwa użytkownika</span> <input value = "$username" type = "text" name = "username"/>
    <br/>
    <span class = "form-input">Hasło</span> <input type = "password" name = "password"/>
    <br/>
    <span class = "form-input">Powtórz hasło</span> <input type = "password" name = "repeat"/>
    <input type = "hidden" name = "register"/>
    <br/>
END;
}

?>



<html>
    <head>
        <?php require_once("../common/commonHead.php"); ?>
        <title>Rejestracja</title>
    </head>
    <body>
        <?php require_once("../common/userMenu.php"); ?>
        <div id = "page-wrapper">

            
            <div class = "form-wrapper">
                <div class = "form" >
                    <h2>Rejestracja</h2>
                    <form action = "register.php" method = "post">
<?php
    session_start();
    $username = "";
    $login = "";
    $error = "";
    if(isset($_SESSION["registerError"]))
    {
        $error = $_SESSION["registerError"];
        unset($_SESSION["registerError"]);
    }
    if(isset($_SESSION["username"]))
    {
        $username = $_SESSION["username"];
        $login = $_SESSION["login"];
    }
                        
    displayForm($login, $username, $error);
    
?>
                        <input type = "submit" value = "Zarejestruj"/>
                     </form>
                </div>
            </div>
        </div>
        
        <footer>Made by: Pichał and Hichał &copy; 2019;</footer>
    </body>
    
</html>
