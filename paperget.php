<?php

	include "dbcon.php";

	header("Content-type: application/json");
						      
	
	
    $test = $_GET['date'];

	//print_r($test);
    /* sum(CASE WHEN B.companyname = 'CJ' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'CJ', 
	sum(CASE WHEN B.companyname = 'SPC' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'SPC', 
	sum(CASE WHEN B.companyname = '신세계' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'shinsegye',
	sum(CASE WHEN B.companyname = '동원' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'dongwon', 
	*/
	

	$selectname = '전체';
	
	if ($selectname=='전체'){
		 $selectbox ='';

	}
	else{
		 $selectbox =" and inventory = '$selectname' ";
	}
     

	$sql = "SELECT idate FROM Deadline ORDER BY idate desc limit 1";
	$stmt = $con->prepare($sql);
	$stmt->execute();

	$row = $stmt->fetch();  
	$deaddate = $row['idate'];
	//$deaddate = "2021-11-01";
	$value = $test;
	//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
	$sql = "SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,a.ipsu,
	sum(if(B.list='기초',B.surang,0))-SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.ipsu,B.surang),0))+SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.ipsu,B.surang),0)) AS '전일재고',
	sum(if(B.list='입고',B.surang,0)) AS '입고',
	sum(CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS '출고', 
	SUM(if(B.list='실사',B.surang,0)) AS '실사'
	FROM iteminfo a,(
	SELECT '기초'AS 'list', '' AS 'companyname',itemcode as 'mappingcode',surang,'EA' AS 'unit' from Deadline b WHERE idate='$deaddate'
	UNION ALL 
	SELECT '입고' AS 'list', '' AS 'companyname',mappingcode,sum(surang) as 'surang','EA' AS 'unit' from ipgo c WHERE ipgodate='$value' GROUP BY mappingcode
	UNION ALL 
	SELECT '출고' AS 'list', companyname,mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain d WHERE idate ='$value' GROUP BY mappingcode,unit
	UNION ALL 
	SELECT '출고' AS 'list', companyname,mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelXmain e WHERE idate ='$value' GROUP BY mappingcode,unit
	UNION ALL
	SELECT '총입고' AS 'list','' AS 'companyname', e.mappingcode,sum(if(e.surang='',0,e.surang)) AS 'surang','EA' AS 'unit' from ipgo e WHERE ipgodate > '$deaddate' and ipgodate <'$value' GROUP BY mappingcode
	UNION ALL
	SELECT '총출고' AS 'list','' AS 'companyname', mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain f WHERE idate > '$deaddate' and idate < '$value' GROUP BY mappingcode,unit
	UNION ALL
	SELECT '총출고' AS 'list','' AS 'companyname', mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain g WHERE idate > '$deaddate' and idate < '$value' GROUP BY mappingcode,unit
	UNION ALL
	SELECT '실사' AS 'list', '' AS 'companyname',itemcode as 'mappingcode',SURANG AS 'surang', 'EA' AS 'unit' from dailycounting g WHERE g.idate='$value'
	)B WHERE a.itemcode = B.mappingcode AND labelY='Y' ".$selectbox." GROUP BY B.mappingcode";
	
	
	$sql.=" order by a.lek asc ";


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
			    $list['mappingcode'] =trim(addslashes($mappingcode));
				$list['itemname'] =trim(addslashes($itemname));
				$list['lek'] =trim(addslashes($lek));
				$list['unit'] =trim(addslashes($unit));
				$list['전일재고'] =trim(addslashes($전일재고));
				$list['입고'] =trim(addslashes($입고));
				//$list['출고'] =trim(addslashes($CJ+$SPC+$shinsegye));
				$list['출고'] =trim(addslashes($출고));
				$list['현재고'] =trim(addslashes($전일재고+$입고-($CJ+$SPC+$shinsegye)));
				$list['georae'] =trim(addslashes($georae));
	
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
	
	
	