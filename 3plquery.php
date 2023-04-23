<?php
   
	include "dbcon.php";

	header("Content-type: application/json");
						      
    $nowdate = $_POST['date'];
	$t = substr($nowdate,0,7);
	
	$deaddate = $t."-01";
    
	$timestamp = strtotime("-2 months");
    $deaddate22 = date("Y-m-d", $timestamp);
	
	$expireDate = str_replace('-', '', $deaddate22); 
	
	$option = $_POST['option'];

    
	if ($option == '2'){
		$optionSelect = "M.ipgodate DESC, M.expiration DESC";
        $jejo= " (REPLACE(substring(c.expiration,1,10),'.','') >= '$expireDate' OR c.expiration LIKE '%제조%') ";
		
	}else { 

        $optionSelect = "M.ipgodate desc,M.expiration DESC";
		$jejo =" REPLACE(substring(c.expiration,1,10),'.','') >= '$expireDate' and c.expiration NOT LIKE '%제조%' ";
	}

	 

	$selectname = isset($_POST['inventory']) ? $_POST['inventory'] : '전체';
         
    
	if ($selectname=='전체'){
		 $selectbox ='';

	}
	else{
		 $selectbox =" and a.georae = '$selectname' ";
	} 

	//print_r($test);

	$sql = "SELECT * from(SELECT *  FROM (SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,if(a.ipgoprice='','999999',a.ipgoprice) AS 'asort',a.ipsu, SUM(if(B.list='기초',B.surang,0))- SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0))+ SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0)) AS 'test'
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
									GROUP BY B.mappingcode)V where test > 0)i
									LEFT JOIN (SELECT c.ipgodate,c.itemcode AS 'ipgoitem',c.mappingcode AS 'ipgomapping',c.surang,c.expiration,REPLACE(c.ipgodate,'-','-') AS 'date1' ,REPLACE(c.expiration,'.','-') AS 'date2' from ipgo c 
									WHERE ";
									
	$sql .= $jejo;
	$sql .= " and c.ipgodate <= '$nowdate' AND c.expiration LIKE '2%'
									ORDER BY c.ipgodate desc)M ON i.mappingcode = M.ipgomapping
									ORDER BY i.mappingcode asc,".$optionSelect;
									
                                  
	
	


   //echo $sql;
	$listvalue=array();
	$stmt = $con->prepare($sql);
									
	$stmt->execute();
   
    $datacount=(int)$stmt->rowCount();
	if ($stmt->rowCount() > 0)
	{
		  

			$basic_itemcode = '000000';
			$basic_surang = 0;

							
			$nRow = 0; //배열 
			$i = 0;//처음인지 아닌지....
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		    {
				extract($row);
                $datacount--;

				$nSurang = (int)$surang;
		        
				if($nSurang == NULL) {
					$nSurang = 0;
				}
				if ($basic_itemcode != $mappingcode){
					$basic_itemcode = $mappingcode;
					$basic_surang = (int)$test;
					
                    if($i !=0){
						
                        $val = $nRow-1;
                         //로직 수정해야함...
                          for($j= 0; $j < $val/2; $j++){
                          
                          $val2= $val-$j;
						  
						  $tempExpire = $list[$j.'expire'];
                          $tempIpgodate = $list[$j.'ipgodate'];
                          $tempSurang = $list[$j.'surang'];
                          
						  $list[$j.'expire'] = $list[$val2.'expire']; 
					      $list[$j.'ipgodate'] = $list[$val2.'ipgodate'];
					      $list[$j.'surang'] = $list[$val2.'surang'];
						  
						  $list[$val2.'expire'] = $tempExpire;
                          $list[$val2.'ipgodate']=  $tempIpgodate;
                          $list[$val2.'surang']= $tempSurang;
						
						}
                       

						for($j= $nRow; $j < 10; $j++){
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
					$list['now'] = $test;
					$nRow = 0;
				
				}
					 
                   

				if($basic_surang <= 0){ //총재고가 마이너스 인 경우
					if($datacount!=0){						
					continue;}
				}
				else if($basic_surang > $nSurang){ //총재고가 입고수량보다 클경우

					$list[$nRow.'expire'] = $date2;
					$list[$nRow.'ipgodate'] = $date1;
					$list[$nRow.'surang'] = $nSurang;
					$nRow++; 
				
			  
					
				} 
				
				else{ //총재고가 0보다 크고 입고수량보다 작을경우
					$list[$nRow.'expire'] = $date2;
					$list[$nRow.'ipgodate'] = $date1;
					$list[$nRow.'surang'] = $basic_surang;
					$nRow++; 
					
				
			  

				}
				$basic_surang -= $nSurang;


			 
			    //print_r($list);
				if($datacount==0){
					$basic_itemcode = $mappingcode;
					$basic_surang = (int)$test;
					
                    if($i !=0){
						
                        $val = $nRow-1;
                         //로직 수정해야함...
                          for($j= 0; $j < $val/2; $j++){
                          
                          $val2= $val-$j;
						  
						  $tempExpire = $list[$j.'expire'];
                          $tempIpgodate = $list[$j.'ipgodate'];
                          $tempSurang = $list[$j.'surang'];
                          
						  $list[$j.'expire'] = $list[$val2.'expire']; 
					      $list[$j.'ipgodate'] = $list[$val2.'ipgodate'];
					      $list[$j.'surang'] = $list[$val2.'surang'];
						  
						  $list[$val2.'expire'] = $tempExpire;
                          $list[$val2.'ipgodate']=  $tempIpgodate;
                          $list[$val2.'surang']= $tempSurang;
						
						}
                       

						for($j= $nRow; $j < 10; $j++){
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
					$list['now'] = $test;
					$nRow = 0;
				
				
				}

		        
			}
	}

	?>

	
	<?=json_encode($listvalue)?>
	
	
	
	