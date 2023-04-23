<?php
$jsonStr = file_get_contents("config_common.json");
$config = json_decode($jsonStr); // if you put json_decode($jsonStr, true), it will convert the json string to associative array
//echo var_dump($config);
 


if (in_array("(K)(화성)시립동탄파크푸르지오어린이집_급식", $config->common->yeop)){

   echo "존재합니다";

}

//echo $config->a->yeop[0];

 /*
$con = mysqli_connect(
    $config->database->host, 
    $config->database->user, 
    $config->database->password,
    $config->database->dbname
    );
if (mysqli_connect_errno())
{
  echo "Failed to connect to the database: ".$config->database->dbname. mysqli_connect_error()."\n";
}
else
{
    echo "connected to database ".$config->database->dbname."\n";
}
exit("done");