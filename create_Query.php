<?php
include_once("api.php");
include_once("functions.php");
$username = "rmt564";
// $password =  "6TzD7#j!n&2CGwRt";
$password = "6TzD7jn2CGwRt";

$sid = createSession($username, $password);
$files = queryFiles($sid, $username);
if ($files != null) {
    sendToDatabase($files);
}
closeSession($sid, $username);

?>