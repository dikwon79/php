<?php
$jsonStr = file_get_contents("config_common.json");
$config = json_decode($jsonStr); // if you put json_decode($jsonStr, true), it will convert the json string to associative array

?>

 