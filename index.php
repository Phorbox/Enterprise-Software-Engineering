<?php
echo '<p>Hello World i am php!</p>';
echo '<p>Hello World i too am php!</p>';
$hostname="localhost";
$username="webuser";
$password="jNs)gNasif6q6gs@";
$db="temp";
$mysqli=new mysqli($hostname,$username,$password,$db);
if(mysqli_connect_errno()){
	die("Error connecting to database: ".mysqli_connect_error());
}	

$sql="Insert into `user_input` (`input`,`user_id`) values ('input from web','webuser@mail.com')";
$mysqli->query($sql) or
	die("Something went wrong with $sql ".$mysqli->error);
echo "<p>Executed $sql</p>";
?>
	