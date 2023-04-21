<?php

include_once("functions.php");
function createSession($username, $password)
{

	$data = "username=$username&password=$password";
	echo "Data: $data\r\n";
	$ch = curl_init('https://cs4743.professorvaladez.com/api/create_session');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: ' . strlen($data)
		)
	);
	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start) / 60;
	curl_close($ch);
	$cinfo = json_decode($result, true);
	if ($cinfo[0] == "Status: OK" && $cinfo[1] == "MSG: Session Created") {
		$sid = $cinfo[2];
		echo "\r\nSession Created Sucessfully!\r\n";
		echo "SID: $sid\r\n";
		echo "Create Session Execution Time: $execution_time\r\n";
		return ($sid);
	} else if ($cinfo[0] == "Status: ERROR" && $cinfo[1] == "MSG: Previous Session Found") {
		killSession($username, $password);
		return createSession($username, $password);
	} else {
		foreach ($cinfo as $talk) {
			echo $talk;
			echo "\r\n";
		}
	}

}
function closeSession($sid, $apiuser)
{
	$data = "sid=$sid&uid=$apiuser";
	$ch = curl_init('https://cs4743.professorvaladez.com/api/close_session');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: ' . strlen($data)
		)
	);
	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start) / 60;
	curl_close($ch);
	$cinfo = json_decode($result, true);
	if ($cinfo[0] == "Status: OK") {
		$sid = $cinfo[2];
		echo "\r\nSession Closed Sucessfully!\r\n";
		echo "Close Session Execution Time: $execution_time\r\n";
	}
}

function queryFiles($sid, $apiuser)
{
	$data = "sid=$sid&uid=$apiuser";
	$ch = curl_init('https://cs4743.professorvaladez.com/api/query_files');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: ' . strlen($data)
		)
	);
	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start) / 60;

	curl_close($ch);
	$cinfo = json_decode($result, true);
	if ($cinfo[0] == "Status: OK") {
		if ($cinfo[1] == "Action: None") {
			echo "\r\n No new files found\r\n";
			echo "Sid: 							$sid\r\n";
			echo "Username: 					$apiuser\r\n";
			echo "Query Files Execution Time: 	$execution_time\r\n";

		} else {
			$tmp = explode(":", $cinfo[1]);
			$files = explode(",", $tmp[1]);
			echo "Number of files: " . count($files) . "\r\n";
			echo "Files: \r\n";

			foreach ($files as $key => $value) {
				echo $value . "\r\n";
			}
			echo "Query Files Execution Time: 	$execution_time\r\n";
			return $files;
		}

	}
}



function requestFile($sid,$apiuser, $fid)
{

	$data = "sid=$sid&uid=$apiuser&fid=$fid";
	echo "\r\nGetting File $fid";
	$ch = curl_init('https://cs4743.professorvaladez.com/api/request_file');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: ' . strlen($data)
		)
	);
	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start) / 60;
	$content = $result;
	echo "\r\nFile Retrieved Sucessfully!\r\n";
	echo "File Retrieved Execution Time: $execution_time\r\n";
	curl_close($ch);
	return $content;
}
function killSession($user, $pass)
{
	$data = "username=$user&password=$pass";
	$ch = curl_init('https://cs4743.professorvaladez.com/api/clear_session');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt(
		$ch,
		CURLOPT_HTTPHEADER,
		array(
			'content-type: application/x-www-form-urlencoded',
			'content-length: ' . strlen($data)
		)
	);
	$time_start = microtime(true);
	$result = curl_exec($ch);
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start) / 60;
	curl_close($ch);
	$cinfo = json_decode($result, true);
	if ($cinfo[0] == "Status: OK") {
		echo "\r\nSession Killed Sucessfully!\r\n";
		echo "Kill Session Execution Time: $execution_time\r\n";
	}

}


?>