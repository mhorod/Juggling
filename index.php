<!-- Main page - The Blog -->

<html>
    <head>
        <?php include("common/commonHead.php"); ?>
        <title>JBWŻ</title>
        <script src = "scripts/blog.js"></script>
    </head>
    <body onload = "initBlogJugglers()">
        <?php include("common/userMenu.php"); ?>
        <?php include("common/blogEntry.php"); ?>
        <div id = "page-wrapper">
        <?php
            require_once("common/getEntryData.php");
            $count = implode(",", getEntryCount());
            for($i = $count - 1; $i >= 0; $i--)
                {loadBlogEntry($i);}
        ?>
        </div>
   
    <footer> Made by: Pichał and Hichał &copy; 2019; </footer>
    </body>
</html>
