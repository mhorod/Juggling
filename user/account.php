<!--User account page. Need to think about purpose of it. -->


<html>
    <head>
        <?php 
        include("../common/commonHead.php"); ?>
        <?php 
            if(!isset($_SESSION["userID"])) header("location:../");
            $username = $_SESSION["userName"];
            echo "<title>$username</title>";
        ?>

    </head>
    <body>
        <?php include("../common/userMenu.php"); ?>
        <?php include("../common/blogEntry.php"); ?>
        <div id = "page-wrapper">
            <?php
                echo "<h1> Witaj $username </h1>";
            ?>
            
        </div>
   
    <footer>
        Made by: Pichał and Hichał &copy; 2019;
    </footer>
    </body>
    
</html>
