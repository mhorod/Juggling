<?php
/*
    Features connecting to database and loading Trick data.
    
    Functions:
        getTrickData($trickID) - returns row returned by SQL SELECT query
        getTrickDataJSON($trickID) - returns Trick data in JSON format
        sendTrickData($trickID) - echoes Trick data in JSON format
       
*/

//Load SQL row from database
function getTrickData($trickID)
{
    require("connectDB.php");
    $table = "tricksdata";
    $query = "SELECT * FROM $table WHERE id=$trickID";
    $result = mysqli_query($mysqli, $query);
    $resultCount = mysqli_num_rows($result);
    if($resultCount == 1) //There should be exactly one trick with this ID
    {
        $data =  mysqli_fetch_assoc($result);
    }
    else
    {
        $data = null;
    }
    $mysqli -> close();
    return $data;
    
}

//Format SQL row to JSON format
function getTrickDataJSON($trickID)
{
    $row = getTrickData($trickID);
        
    if($row != null)
    {
        $id = $row["id"];
        $name = $row["name"];
        $difficulty = $row["difficulty"];
        $siteswap = $row["siteswap"];
        $desc = $row["description"];
        $code = $row["code"];

        $text = "['$name', '$difficulty', '$siteswap', '$desc', $code]";
    }
    else
    {
        $text = '["Trick not found", "-", "-", "", ""]';
    }
    return $text;
}

function sendTrickData($trickID)
{
    echo getTrickDataJSON($trickID);
}


//Handle GET requests
if(isset($_GET["trickID"])) 
    sendTrickData($_GET["trickID"]);

?>
