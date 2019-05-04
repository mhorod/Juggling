<html>
    <head>
        <?php require_once("common/commonHead.php"); ?>
        <style>
            /* Override defaults for the sake of suwajka */
            :root
            {
                --main-font-size: 20px;
                --trick-width: 240px;
                --trick-height: 300px;
                --trick-padding: 5px;
            }
            .slider-wrapper
            {
                border-top: var(--anim-border);
            }
        </style>
        <title>Trik tygodnia</title>
        <script src = "scripts/mainPage.js"></script>
    </head>
    
    <body onload = "main()">
        <?php require_once("common/userMenu.php"); ?>
        <div id = "page-wrapper">
            <nav id="suwajka"><section></section><?php require_once("common/getEntryData.php");  echo implode(",",getEntryCount()); ?></nav>
            <br/>
            
            <!-- Slider and Current Trick Description begin -->
            <div style = "width:100%">
                 <div class = "slider-wrapper">
                    <span class = "anim-button"><i class="fas fa-pause"></i></span>
                    <input type = "range" min="1" max="1000" value="500" class = "anim-slider"/>
                </div>
                <div id = "blog-entry">
                    <section class = "post-wrapper" id = "$trickID">
                        <div class = "post-body">
                            <div class = "post-text-wrapper">
                                <h3 class = "post-title">Trik tygodnia loading..</h3>
                                <span class = "post-text">loading..</span>
                            </div>
                        </div>
                        <div class = "reaction-wrapper"> 
                            <div class = "reaction-buttons">
                                <span class = "reaction-button reaction-heart"> <i class="fas fa-heart"></i> </span>
                                <span class = "reaction-button reaction-comment"> <i class="fas fa-comments"></i> </span>
                            </div>
                        </div>
                        
                        <div class = "comments-wrapper"></div>
                    </section>
                </div>
            </div>
        </div>
        <!-- Slider and Current Trick Description end -->
        
        <footer> Made by: Pichał and Hichał &copy; 2019; </footer>
    </body>
</html>
