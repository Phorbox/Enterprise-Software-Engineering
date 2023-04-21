<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<?php
include_once("functions.php");
include_once("reporting_functions.php");
$dblink=db_connect("ese");
echo '<div id="page-inner">';
echo '<h1 class="page-head-line">Reports from Files on DB</h1>';
echo '<div class="panel-body">';
if (!isset($_POST['submit']))
{
	echo '<form action="" method="post">';
	// echo '<div class="form-group">';
	// echo '<label>Report String:</label>';
	// echo '<input type="text" class="form-control" name="reportString">';
	// echo '</div>';
	echo '<select name="reportType">';
	echo '<option value="Total Info">Total Quantities</option>';
	echo '<option value="Average Uploads">Average Uploads</option>';
	echo '<option value="Complete Records">Complete Accounts</option>';
	echo '<option value="Partial Records">Partial Accounts</option>';
	echo '<option value="Submission Counts">Submissions</option>';
	echo '</select>';
	echo '<hr>';
	echo '<button type="submit" name="submit" value="submit">Report</button>';
	echo '</form>';
}
if (isset($_POST['submit']))
{
	$reportType=$_POST['reportType'];
	$selectSpan="WHERE `CREATEDATE` BETWEEN '2022-11-14 00:00:00' AND '2022-11-30 23:59:59'";
	$docTable="`DOCUMENT_TABLE`";
	switch($reportType)
	{
		case "Total Info":
			$sql=getTotals();
			$headers = array('Name','Value');
            break;
		case "Complete Records":
			$headers = array('ID','Credit','Closing','Title','Financial','Personal','Internal','Legal','Other');
			$sql=getCompleteSQL();
			break;
		case "Partial Records":
			$headers = array('ID','Missing1','Missing2','Missing3','Missing4','Missing5','Missing6','Missing7','Missing8');
			$docTypes = array('','Credit','Closing','Title','Financial','Personal','Internal','Legal','Other');
			$sql=getPartialSQL();
			$flip = true;
			break;
		case "Submission Counts":
			$headers = array('ID','Credit','Closing','Title','Financial','Personal','Internal','Legal','Other');
			$sql=getCountsSQL();
			break;
		case "Average Uploads":
			$headers = array('ID','Files Uploaded','Average Uploaded','Comparison');
			$sql=getAvg();
			break;
		default:
			redirect("search.php?msg=searchTypeError");
			break;
	}
	$result=$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
		echo "<h1>$reportType</h1>";
	echo '<table>';
		echo '<tr>';
		foreach ($headers as $key => $value) {
			echo "<td>|</td><td>".$value."</td><td>";
		}
		echo '|</tr>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
	{
		echo '<tr>';
		foreach ($data as $key => $value) {

			if($key == 'CID'){
				echo "<td>|</td><td>".$value."</td><td>";
			}elseif($value == null && $flip == true){
				echo "<td>|</td><td>".$key."</td><td>";
			} elseif ($flip == false) {
				echo "<td>|</td><td>".$value."</td><td>";
			}
		}
		echo '|</tr>';
	}
	echo '</table>';
}
echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>