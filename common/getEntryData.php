<?php
//File responsible for loading blog entries
//Fetch data from Database

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

function getEntryCount()
{
    require("connectDB.php");
    $table = "trickposts";
    $query = 'SELECT COUNT("id") FROM `trickposts`';
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


//Send JSON formatted data
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
        echo<<<END
        ["$entry", "$date"]
END;
    }
    else
    {
        echo<<<END
        ["Entry not found"]
END;
    }

}

if(isset($_GET["entryID"]))
{
    if(isset($_GET["trickOnly"]))
        sendEntryData($_GET["entryID"], true);
    else
        sendEntryData($_GET["entryID"]);
}
else if(isset($_GET["entryCount"]))
{
    echo implode(",", getEntryCount());
}

?>