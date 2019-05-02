<!--Goal is that this is the main page instead of mainPage.php -->


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
            <?php loadBlogEntry(2); ?>
            <?php loadBlogEntry(1); ?>
            
        </div>
   
    <footer>
        Made by: Pichał and Hichał &copy; 2019;
    </footer>
    </body>
    
</html>
