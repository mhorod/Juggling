<?php
//File used to load trick from database

function getTrickData($trickNumber)
{
    $path = $_SERVER['DOCUMENT_ROOT']."/dev/common/";
    require("$path/connectDB.php");
    $table = "tricksdata";
    $query = "SELECT * FROM $table WHERE id=$trickNumber";
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

function sendTrickData($trickNumber)
{
    
    $row = getTrickData($trickNumber);
        
    if($row != null)
    {
        $id = $row["id"];
        $name = $row["name"];
        $difficulty = $row["difficulty"];
        $siteswap = $row["siteswap"];
        $desc = $row["description"];
        $code = $row["code"];

        //Send JSON back
        echo<<<END
        ["$name", "$difficulty", "$siteswap", "$desc", $code]
END;
    }
    else
    {
        echo<<<END
        ["Trick not found", "", "", "", ""]
END;
    }

}

if(isset($_GET["trickID"])) 
    sendTrickData($_GET["trickID"]);

if(isset($_POST["trickID"]))
    sendTrickData($_POST["trickID"]);
?>
