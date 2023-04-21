<link href="assets/css/bootstrap.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<?php
include_once("functions.php");
$dblink=db_connect("ese");
$autoid=$_REQUEST['fid'];
echo '<div id="page-inner">';
echo '<h1 class="page-head-line">View Files on DB</h1>';
echo '<div class="panel-body">';
$sql="Select * from `DOCUMENT_TABLE` where `DID`='$autoid'";
$result=$dblink->query($sql) or
	die("Something went wrong with $sql<br>".$dblink->error);
$data=$result->fetch_array(MYSQLI_ASSOC);
//if ($data['path']!=NULL)
//	echo '<p>File: <a href="uploads/'.$data['name'].'" target="_blank">'.$data['name'].'</a></p>';
//else
	echo $data;
	$content=$data['CONTENT'];
	$fname=date("Y-m-d_H:i:s")."-userid-file.pdf";
	if (!($fp=fopen("/var/www/html/uploads/$fname","w")))
		echo "<p>File could not be loaded at this time</p>";
	else
	{
		fwrite($fp,$content);
		fclose($fp);
		echo '<p>File: <a href="uploads/'.$fname.'" target="_blank">'.$data['NAME'].'</a></p>';
	}

echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>