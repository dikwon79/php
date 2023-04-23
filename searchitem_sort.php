<?php
 //DB연결
    include('dbcon.php');

   
    $itemsearch = $_GET['item'];
	$num = $_GET['num'];
	$menu = $_GET['menu'];
    $sort1 = $_GET['sort1'];
    $sort2 = $_GET['sort2'];
    $sort3 = $_GET['sort3'];
	$sort4 = $_GET['sort4'];

	$tablecount = $_GET['count'];
    $tablecount = "1";
    $menu = "1";
    

 
    $sql = "SELECT * from iteminfo where labelY='Y' and (itemnameGeo like '%$itemsearch%' or itemname like '%$itemsearch%' or itemcode like '%$itemsearch%' or georae like '%$itemsearch%')    ";
	    
		
		$sql .= "order by ";
		
		if($sort1 > 0) $sql .="georae asc,"; 
		if($sort1 == "1"){
		    $sql .= " itemcode asc";
		}else if($sort1 == "2"){
            $sql .= " itemcode desc";
		}
        
		if($sort2 > 0) $sql .="georae asc,"; 
        if($sort2 == "1"){
		    $sql .= " itemname asc";
		}else if($sort2 == "2"){
            $sql .= " itemname desc";
		}
        if($sort3 > 0) $sql .="georae asc,"; 
		if($sort3 == "1"){
		    $sql.= " itemnameGeo asc";
		}else if($sort3 == "2"){
            $sql.= " itemnameGeo desc";
		}
		//if($sort4 > 0) $sql .=","; 
		if($sort4 == "1"){
		    $sql.= " georae asc";
		}else if($sort4 == "2"){
            $sql.= " georae desc";
		}
		$sql =  rtrim($sql,','); 
        
		

	
	  $stmt = $con->prepare($sql);
	  $stmt->execute();
	  $number =0;
      ?>
	  <thead>  
        <tr>  
		    <th style="width :25%">다중선택</th> 
           
			<th style="width :30%">업체명<select id="sortinfo4" onchange="sorting('<?=$itemsearch?>','<?=$num?>','4')">
				<option value="0" <? if ($sort4=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort4=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort4=="2") echo "selected" ?>>▼</option></select></th>  
			
			<th style="width :50%">거래처품목명<select id="sortinfo3" onchange="sorting('<?=$itemsearch?>','<?=$num?>','3')">
				<option value="0" <? if ($sort3=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort3=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort3=="2") echo "selected" ?>>▼</option></select></th>  
			
			<th style="width :25%">품목코드<select id="sortinfo1" onchange="sorting('<?=$itemsearch?>','<?=$num?>','1')">
				<option value="0" <? if ($sort1=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort1=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort1=="2") echo "selected" ?>>▼</option>
				</select></th>
			<th style="width :20%">맵핑</th> 
			<th style="width :50%">품목명<select id="sortinfo2" onchange="sorting('<?=$itemsearch?>','<?=$num?>','2')">
				<option value="0" <? if ($sort2=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort2=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort2=="2") echo "selected" ?>>▼</option></select></th>
			
			<th style="width :10%">단위</th>  
            <th style="width :10%">입수</th>
			<th style="width :20%">구매가</th> 
            <input type="hidden" id="numValue" value="<?=$num?>">          
			
        </tr>  
       </thead>  


	  <?





	  if ($stmt->rowCount() > 0)
	  {
		 
		   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		   {
		    extract($row); 
		    $number++;
            if (trim($mappingcode)=="#N/A"){

                    $mappingcode = $itemcode;
			}
			else if (trim($mappingcode)==""){

                    $mappingcode = $itemcode;
			}
			?> 

			
			<tr>
			<td><a href='#a<?=$itemcode?>' onClick="goAction('<?=$itemcode?>','<?=$mappingcode?>','<?=$itemnameGeo?>','<?=$ipsu?>','<?=$ipgoprice?>','<?=$num?>','','<?=$tablecount?>','<?=$georae?>')">선택</a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$georae?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$itemnameGeo?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$itemcode?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$mappingcode?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$itemname?></a></td>
			
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$unit?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$ipsu?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$ipgoprice?></a></td>
			
			</tr>

			<?

		   }
		   echo "</table>";
	  }
      $stmt->close();
  
	
		 
    

	  
        
	?>
  
	
		 
    


		
  