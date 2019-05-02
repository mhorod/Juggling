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


//Send JSON formatted data
function sendEntryData($entryID)
{
    
    $query_row = getEntryData($entryID);
        
    if($query_row != null)
    {
        $trickID = $query_row["trickID"];
        $entry = $query_row["entry"];
        $date = $query_row["date"];
        
        //Send JSON back
        echo<<<END
        [$trickID, "$entry", "$date"]
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
    sendEntryData($_GET["entryID"]);


?>