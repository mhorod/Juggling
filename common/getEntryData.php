<?php
/*
    Features connecting to database and loading Entry data.
    
    Functions:
        getEntryData($entryID) - returns row returned by SQL SELECT query
        getEntryCount() - returns row returned by SQL COUNT query
        sendEntryData($entryID, $trickOnly = false) - echo Entry data in JSON
        sendPreview($trickID, $date, $entry) - echo formatted HTML preview of entry
*/


//Return Entry row from database
function getEntryData($entryID)
{
    require("connectDB.php");
    $table = "trickposts";
    $query = "SELECT * FROM $table WHERE id=$entryID";
    $result = mysqli_query($mysqli, $query);
    $resultCount = mysqli_num_rows($result);
    if($resultCount == 1) //There should be exactly one trick with this ID
    {
        $query_row =  mysqli_fetch_assoc($result);
    }
    else
    {
        $query_row = null;
    }
    $mysqli -> close();
    return $query_row;
    
}

//Count current number of entries
//TODO: Check what exactly is returned by SQL
function getEntryCount()
{
    require("connectDB.php");
    $table = "trickposts";
    $query = "SELECT COUNT('id') FROM `$table`";
    $result = mysqli_query($mysqli, $query);
    $resultCount = mysqli_num_rows($result);
    if($resultCount == 1) //There should be exactly one trick with this ID
    {
        $query_row =  mysqli_fetch_assoc($result);
    }
    else
    {
        $query_row = null;
    }
    $mysqli -> close();
    return $query_row;
}


//Send JSON data of Entry
//If trickOnly is false : The content and date of Entry will be sent
//Otherwise : Only trick connected with that entry will be sent
function sendEntryData($entryID, $trickOnly = false)
{
    
    require_once("getTrickData.php");
    
    $query_row = getEntryData($entryID);
        
    if($query_row != null)
    {
        $trickID = $query_row["trickID"];
        $entry = $query_row["entry"];
        $date = $query_row["date"];
        
        $trickData = getTrickDataJSON($trickID);
        if($trickOnly)
            {echo $trickData; return;}
        
        //Send JSON back
        echo "['$entry', '$date']";
    }
    else
    {
        if(!$trickOnly)
            echo '["Entry not found", "-"]';
        else
            echo '["Trick not found", "-", "-"]';

    }
}

//Send formatted preview of given entry data
function sendPreview($trickID, $date, $entry)
{
    require_once("getTrickData.php");
    echo loadBlogPreview($trickID, $date, $entry);
}

//Handle GET requests
if(isset($_GET["entryID"]))
{
    $entryID = $_GET["entryID"];
    unset($_GET["entryID"]);
    
    $trickOnly = false;
    if(isset($_GET["trickOnly"]))
       $trickOnly = true;
    
    sendEntryData($entryID, $trickOnly);
}

?>