<?php

$requestPayload = file_get_contents("php://input");

$array = json_decode($requestPayload, true);


//var_dump($object);
$connect = mysqli_connect("localhost","dikwon79","ab0612abcD!@","dikwon79");
$datetoday = date(Ymd);
foreach($array as $row)
{

    $sql = "insert into tbl_funenglish(youtubeid,title,sortof,number,second,script,inputday) VALUES('".addslashes ($row[youtubeID])."','".addslashes ($row[title])."','".$row[sortof]."','".$row[number]."','".$row[seconds]."','".addslashes ($row[write])."','".$datetoday."')";
  
    mysqli_query($connect,$sql);
}


echo "all data inserted";



   



?>