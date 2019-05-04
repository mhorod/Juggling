<?php
/*
    This file provides a function for loading formatted blog post.
    
    Functions:
        formatTrickData($trickID, $name, $difficulty, $siteswap, $code) - Inserts provided Trick information into HTML template
        formatEntryData($trickText, $date, $entry) - Inserts provided Entry information into HTML template
        
        loadTrick($trickID) -
        loadBlogEntry($entryID) - echoes whole Blog Entry
*/

//Inserts provided Trick information into HTML template
function formatTrickData($trickID, $name, $difficulty, $siteswap, $code)
{
    $text = <<<EOS
    <div class = "post-trick-wrapper" id = "trickWrapper_$trickID">    
        <div class = "animation-wrapper">
            <canvas class = "mainCanvas"></canvas>
         </div>
        <div class = "slider-wrapper">
            <span class = "anim-button"><i class="fas fa-pause"></i></span>
            <input type = "range" min="1" max="1000" value="500" class = "anim-slider"/>
        </div>

        <div class = "trick-desc" style = "font-size:15px">
            <span class = "desc-item">$name</span>
            <span class = "desc-item">Difficulty: $difficulty</span> 
            <span class = "desc-item">Siteswap: $siteswap</span>
        </div>
        <span class = "trickData" style = "display:none">$code</span>
    </div>
EOS;
    return $text;
    
}

//Inserts provided Entry information into HTML template
function formatEntryData($trickText, $date, $entry)
{
    $entryText = <<<EOS
    <section class = "post-wrapper">
        <div class = "post-body">
            $trickText
            <div class = "post-text-wrapper">
            <h3 class = "post-title">Trik tygodnia $date</h3>
            $entry
            </div>
        </div>
        <div class = "reaction-wrapper"> 
        <div class = "reaction-buttons">
            <span class = "reaction-button reaction-heart"><i class="fas fa-heart"></i></span>
            <span class = "reaction-button reaction-comment"><i class="fas fa-comments"></i></span>
        </div>
        </div>
        <div class = "comments-wrapper"> </div>
    </section>
EOS;
    echo $entryText;
}


//Returns text containing HTML data that describes Frame
//Formats even if trick is not found
function loadTrick($trickID)
{
    require_once("getTrickData.php");
    $query_row = getTrickData($trickID);
    
    if($query_row === null)
    {
        $name = "Trick not found";
        $difficulty = "-";
        $siteswap = "-";
        $code = "";
    }
    else
    {
        $name = $query_row["name"];
        $difficulty = $query_row["difficulty"];
        $siteswap = $query_row["siteswap"];
        $code = $query_row["code"];
    }
    
    return formatTrickData($trickID, $name, $difficulty, $siteswap, $code);

}

//Return preview of hand-provided entry
function loadBlogPreview($trickID, $date, $entry)
{
    $trickText = loadTrick($trickID);
    return formatEntryData($trickText, $date, $entry);
}


//Returns text containing HTML data that describes Blog Entry
//Formats even if entry is not found
function loadBlogEntry($entryID)
{
    require_once("getEntryData.php");

    $query_row = getEntryData($entryID);
    if($query_row === null)
    {
        $trickID = -1;
        $entry = "Error. Entry not found.";
        $date = "-";
    }
    else
    {
        $trickID = $query_row["trickID"];
        $entry = $query_row["entry"];
        $date = $query_row["date"];
    }

    require_once("getTrickData.php");
    $trickText = "";
    $trickText = loadTrick($trickID);
    
    return formatEntryData($trickText, $date, $entry);
}



?>