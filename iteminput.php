<?php

$request = file_get_contents("php://input");

$array = json_decode($request, true);


//var_dump($array);
//print_r($array);


include 'dbconn.php';
$datetoday = date("Y-m-d");
$year = date("Y");
 
$sql = "select * from iteminfo where substr(id,1,4)='$year' order by id desc";
$result = mysqli_query($connect,$sql);
$count = mysqli_num_rows($result);


$row = mysqli_fetch_assoc($result);
if ($count > 0) 
{           
	  $smx= $row['id']+1;
	
}
else
{
	$smx= $year."00000001";

}

if($array['type']=='input')
{
	

	foreach ($array['additem'] as $row) {

					$sql = "select * from iteminfo where itemcode='$row[itemcode]' ";
					$result = mysqli_query($connect,$sql);
					$count = mysqli_num_rows($result);

					if ($count > 0){
						echo '품목코드 중복입니다. 확인하여주세요';
						exit;

					}
					$sql = "insert into iteminfo(id, idate, mappingcode, itemcode, itemname, geocode, georae, lek, dan, ipsu, packsu ,inventory,productiondate,expire,printoption,itemblack,usingY,labelY ,ipgoprice ,sellprice ,printgubun) 
					VALUES('".$smx."','".addslashes($datetoday)."','".addslashes($row[mappingcode])."','".addslashes($row[itemcode])."','".addslashes($row[itemname])."','".addslashes($row[geocode])."','".addslashes($row[georae])."','".addslashes($row[lek])."',
					'".addslashes($row[dan])."','".addslashes($row[ipsu])."','".addslashes($row[packsu])."','".addslashes($row[inventory])."','".addslashes($row[productiondate])."','".addslashes($row[expire])."',
					'".addslashes($row[printoption])."','".addslashes($row[itemblack])."','".addslashes($row[usingY])."','".addslashes($row[labelY])."','".addslashes($row[ipgoprice])."','".addslashes($row[sellprice])."',
					'".addslashes($row[printgubun])."')";
							  

					$result = mysqli_query($connect,$sql);
				  
				
				}
}
else if($array['type']=='del'){

        foreach ($array['additem'] as $row) {

					$sql = "delete from iteminfo where itemcode='$row[itemcode]' ";
					$result = mysqli_query($connect,$sql);
                    echo '삭제';
		}
}
else{
    foreach ($array['additem'] as $row) {

    $sql = "update iteminfo set mappingcode='".addslashes($row[mappingcode])."', itemcode='".addslashes($row[itemcode])."', itemname='".addslashes($row[itemname])."', 
	        geocode='".addslashes($row[geocode])."', georae='".addslashes($row[georae])."', lek='".addslashes($row[lek])."', dan='".addslashes($row[dan])."', 
	        ipsu='".addslashes($row[ipsu])."', packsu='".addslashes($row[packsu])."' ,inventory='".addslashes($row[inventory])."',productiondate='".addslashes($row[productiondate])."',
			expire='".addslashes($row[expire])."',printoption='".addslashes($row[printoption])."',itemblack='".addslashes($row[itemblack])."',usingY='".addslashes($row[usingY])."',
			labelY='".addslashes($row[labelY])."' ,ipgoprice='".addslashes($row[ipgoprice])."',sellprice='".addslashes($row[sellprice])."' ,printgubun='".addslashes($row[printgubun])."'
			 where id='".addslashes($row[id])."'";
					
     
	       $result = mysqli_query($connect,$sql);
	}

}
if($result === false){
    echo mysqli_error($connect);
}
else{

   echo "success";

}
$connect->close();

   


?>