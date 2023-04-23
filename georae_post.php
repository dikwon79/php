<?php

$request = file_get_contents("php://input");

$array = json_decode($request, true);


//var_dump($array);
//print_r($array);


include 'dbconn.php';
$datetoday = date("Y-m-d");


foreach ($array as $row) {

	    
	    $sql = "insert into geoinfo(geocode, geoname, geobunryu, geogubun, geoboss ,businessNum,tel,fax,posnum,address,yeop,jongmok ,gita ,account1 ,account2 ,account3,recharger1 ,recharger2,recharger3,startdate) VALUES('".addslashes($row[geocode])."','".addslashes($row[geoname])."','".addslashes($row[geobunryu])."','".addslashes($row[geogubun])."','".addslashes($row[geoboss])."','".addslashes($row[businessNum])."','".addslashes($row[tel])."',
		'".addslashes($row[fax])."','".addslashes($row[postnum])."','".addslashes($row[address])."','".addslashes($row[yeop])."','".addslashes($row[jongmok])."','".addslashes($row[gita])."',
		'".addslashes($row[account1])."','".addslashes($row[account2])."','".addslashes($row[account3])."','".addslashes($row[recharger1])."','".addslashes($row[recharger2])."','".addslashes($row[recharger3])."',
		'".addslashes($datetoday)."')";
	              

        mysqli_query($connect,$sql);
	
	
	
	}
    echo "success";


	$connect->close();

   


?>