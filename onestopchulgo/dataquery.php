<?php

	include "../dbcon.php";

	header("Content-type: application/json");
						      
	
	
    $deaddate = $_GET['date1'];
    $deaddate2 = $_GET['date2'];


	//print_r($test);

	$sql = "select idate,itemcode, itemname, chaivalue, unit, companyname from labelXmain where idate>='$deaddate' and idate<='$deaddate2'";
	
	
	


    //echo $sql;
	$listvalue=array();
	$stmt = $con->prepare($sql);
									
	$stmt->execute();

	if ($stmt->rowCount() > 0)
	{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		    {
				extract($row);
		   
		        
			  
				// 결과 부분 
				//$list=array(trim(addslashes($itemcode)),trim(addslashes($itemname)),trim(addslashes($CJ)));
			    $list['idate'] =trim(addslashes($idate));
				$list['itemcode'] =trim(addslashes($itemcode));
				$list['itemname'] =trim(addslashes($itemname));
				$list['chaivalue'] =trim(addslashes($chaivalue));
				$list['unit'] =trim(addslashes($unit));
				$list['companyname'] =trim(addslashes($companyname));
		
	
			    //print_r($list);
				array_push($listvalue,$list);

		        
			}
	}

	?>

	{
	  "result": true,
	  "data": {
		"contents": <?=json_encode($listvalue)?>
		
	  }
	}
	
	
	