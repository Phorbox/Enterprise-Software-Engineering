<?php

function db_connect($db)
{
    $hostname = "localhost";
    $username = "webuser";
    $password = "jNs)gNasif6q6gs@";
    //    $db="docStorage";
    $dblink = new mysqli($hostname, $username, $password, $db);
    if (mysqli_connect_errno()) {
        die("Error connecting to database: " . mysqli_connect_error());
    }
    return $dblink;
}

function redirect($uri)
{ ?>
<script type="text/javascript">
    document.location.href="<?php echo $uri; ?>";
</script>
<?php die;
}

function sendToDatabase($files)
{
    // connect to db
    $dblink = db_connect("ese");
    if (mysqli_connect_errno()) {
        die("Error connecting to database: " . mysqli_connect_error());
    }
    foreach ($files as $key => $value) {
        $mrClean = addslashes(trim($value));
        $sql = "Insert into `New_Files_Table` (`Info`) values ('$mrClean')";
        $dblink->query($sql) or
            die("Something went wrong with $sql<br>" . $dblink->error);

    }

}

function getLine($lineNum)
{
    $dblink = db_connect("ese");
    if (mysqli_connect_errno()) {
        die("Error connecting to database: " . mysqli_connect_error());
    }

    $sql="Select * from `New_Files_Table` where `ID`='$lineNum'";
    $result=$dblink->query($sql) or
	    die("Something went wrong with $sql<br>".$dblink->error);
    $data=$result->fetch_array(MYSQLI_ASSOC);
	// echo $data['Info'];
	return $data['Info'];
}

function getLineNumber()
{
    $dblink = db_connect("ese");
    if (mysqli_connect_errno()) {
        die("Error connecting to database: " . mysqli_connect_error());
    }

    $sql = "SELECT MIN(ID) FROM `New_Files_Table`";
    
    
    $results = $dblink->query($sql) or
    die("Something went wrong with $sql<br>" . $dblink->error);
    
    $gross = mysqli_fetch_array($results);

    $id = $gross[0];
    if ($id == null) {
        return -1;
    }
    return $id;

}

function partLine($input)
{
    $slashes = explode("/", $input);
    $returner["path"] = "/$slashes[1]/$slashes[2]/$slashes[3]/";
    $returner["fid"] = $slashes[4];
    $unders = explode("_", $slashes[4]);
    $a = $unders[1];
    $b = $unders[2];
    $dots = explode(".", $unders[3]);
    $c = $dots[0];
    $returner["fileType"] = $dots[1];
    $dashes = explode("-", $unders[0]);
    $returner["id"] = $dashes[0];
    $returner["docType"] = $dashes[1];
    $day = $dashes[2];
    $returner["subTime"] = correctDate($day,$a,$b,$c);
    
    return $returner;
}

function correctDate($d, $a,$b,$c){
    $year=intval(substr($d,0,4));
    $month=intval(substr($d,4,2));
    $day=intval(substr($d,6,2));
    $hour=intval($a);
    $minute=intval($b);
    $second=intval($c);
    return date("Y-m-d H:i:s",mktime($hour,$minute,$second,$month,$day,$year));
}
function uploadFile($content,$fmap)
{
    $dblink=db_connect("ese");
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }
    $uploadDate=date("Y-m-d H:i:s");
    $subDate=
	$uploadBy="apiUser";
	$fileName=$fmap["fid"];
	$fileType=$fmap["fileType"];
	$contentsClean=addslashes($content);
	

    $sql = "INSERT INTO `DOCUMENT_TABLE` 
                ( `FILETYPE`,    `ARCHIVESTATUS`,   `CREATEDATE`,   `NAME`,         `CONTENT`,          `UPLOADBY`, `CID`, `submitDate`, `docType`) 
                VALUES 
                ('$fileType',    'active',          '$uploadDate',  '$fileName',    '$contentsClean',   '$uploadBy', '{$fmap["id"]}', '{$fmap["subTime"]}', '{$fmap["docType"]}')";
	$dblink->query($sql) 	or
		die("Something went wrong with $sql<br>".$dblink->error);
}

function deleteJust($id){

    $dblink=db_connect("ese");
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }
    $sql = "DELETE FROM `New_Files_Table` WHERE `New_Files_Table`.`ID` = '$id'";
    $dblink->query($sql) 	or
		die("Something went wrong with $sql<br>".$dblink->error);

}

?> 