<?php

	include "../dbcon.php";

	header("Content-type: application/json");
						      
	
	
    $deaddate = '2023-01-01';//$_GET['date1'];
    $nowdate = '2023-01-01';//$_GET['date2'];
    
	$expireDate = str_replace('-', '', $deaddate);  

	$selectname = isset($_GET['inventory']) ? $_GET['inventory'] : '강원진품센터';
    
	
	if ($selectname=='전체'){
		 $selectbox ='';

	}
	else{
		 $selectbox =" and georae = '$selectname' ";
	} 

	//print_r($test);

	$sql = "SELECT *  FROM (SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,if(a.ipgoprice='','999999',a.ipgoprice) AS 'asort',a.ipsu, SUM(if(B.list='기초',B.surang,0))- SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0))+ SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0)) AS '전일재고'
									FROM iteminfo a,(
									SELECT '기초' AS 'list', '' AS 'idate', '' AS 'companyname',b.itemcode AS 'mappingcode', SUM(surang) AS 'surang','EA' AS 'unit'
									FROM Deadline b
									WHERE idate='$deaddate'
									GROUP BY b.itemcode
									UNION ALL
									SELECT '총입고' AS 'list','' AS 'idate','' AS 'companyname', e.mappingcode, SUM(if(e.surang='',0,e.surang)) AS 'surang','EA' AS 'unit'
									FROM ipgo e
									WHERE e.ipgodate >= '$deaddate' AND e.ipgodate <='$nowdate'
									GROUP BY e.mappingcode 
									UNION ALL
									SELECT '총출고' AS 'list',idate,companyname, mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
									FROM labelmain f
									WHERE f.idate >= '$deaddate' AND f.idate <= '$nowdate'
									GROUP BY f.idate,f.mappingcode,f.unit,f.companyname 
									UNION ALL
									SELECT '총출고' AS 'list',idate,companyname, g.mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
									FROM labelXmain g
									WHERE g.idate >= '$deaddate' AND g.idate <= '$nowdate'
									GROUP BY g.idate,g.mappingcode,g.unit,g.companyname
									)B
									WHERE a.itemcode = B.mappingcode AND labelY='Y'".$selectbox."  
									GROUP BY B.mappingcode)V
									LEFT JOIN (SELECT c.ipgodate,c.itemcode AS 'ipgoitem',c.mappingcode AS 'ipgomapping',c.surang,c.expiration,REPLACE(c.ipgodate,'-','-') AS 'date1' ,REPLACE(c.expiration,'.','-') AS 'date2' from ipgo c 
									WHERE  REPLACE(c.expiration,'.','') >= '$expireDate' AND c.expiration LIKE '2%'
									ORDER BY c.ipgodate desc)M ON V.mappingcode = M.ipgomapping
									ORDER BY V.mappingcode asc,M.ipgodate DESC";
                                  
	
	


    //echo $sql;
	$listvalue=array();
	$stmt = $con->prepare($sql);
									
	$stmt->execute();
   
    $datacount=0;
	if ($stmt->rowCount() > 0)
	{
		    

			$basic_itemcode = '000000';
			$basic_surang = 0;

							
			$nRow = 0; //배열 
			$i = 0;//처음인지 아닌지....
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		    {
				extract($row);
		        if($surang == NULL) {
					$surang = 0;
				}
				if ($basic_itemcode != $mappingcode){
					$basic_itemcode = $mappingcode;
					$basic_surang = $전일재고;
					
                    if($i !=0){
						for($j= $nRow; $j < 5; $j++){
                          $list[$j.'expire'] = "";
					      $list[$j.'ipgodate'] = "";
					      $list[$j.'surang'] = "";
						}
						array_push($listvalue,$list);	
					}
					$i++;

                    $list['id'] = $i;
					$list['itemcode'] = $mappingcode;
				    $list['itemname'] = $itemname;
				    $list['lek'] = $lek;
					$list['ipsu'] = $ipsu;
					$list['now'] = $전일재고;
					$nRow = 0;
				
				}
					 


				if($basic_surang <= 0){ //총재고가 마이너스 인 경우
											
					continue;
				}
				else if($basic_surang > $surang){ //총재고가 입고수량보다 클경우

					$list[$nRow.'expire'] = $date2;
					$list[$nRow.'ipgodate'] = $date1;
					$list[$nRow.'surang'] = $surang;
					$nRow++; 
				
			  
					
				} 
				
				else{ //총재고가 0보다 크고 입고수량보다 작을경우
					$list[$nRow.'expire'] = $date2;
					$list[$nRow.'ipgodate'] = $date1;
					$list[$nRow.'surang'] = $basic_surang;
					$nRow++; 
					
				
			  

				}
				$basic_surang -= $surang;


			 
			    //print_r($list);
				

		        
			}
	}

	?>

	
	<?=json_encode($listvalue)?>
	
	
	
	