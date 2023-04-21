<?php
include_once("functions.php");
include_once("api.php");
// login
$username = "rmt564";
$password = "6TzD7jn2CGwRt";
$sid = createSession($username, $password);
// get files


for ($i = 0; $i < 50; $i++) {

    $id = getLineNumber();

    if ($id == -1) {
        closeSession($sid, $username);
        die("No more Files\r\n");
    }

    $info = getLine($id);
    if (strcmp($info, "No new files found") != 0 && $info != null) {
        $finfo = partLine($info);

        $fid = $finfo["fid"];
        // echo "$fid\r\n";
        $content = requestFile($sid, $username, $fid);
        uploadFile($content, $finfo);
    }
    if ($info != null) {
        deleteJust($id);
    }
}

closeSession($sid, $username);
?>