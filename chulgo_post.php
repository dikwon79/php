<?  
  $ipgodata = file_get_contents("php://input");
  $array = json_decode($ipgodata, true);


  include 'dbconn.php';

  $ipgo_date = $array['ipgodate'];//입고입력날짜
  $charger = $array['charger']; //담당자
  $georae = $array['georae']; //거래처
  $georaeN = $array['georaeN']; //거래처
  $warehouse = $array['warehouse']; //창고코드
  $warehouseN = $array['warehouseN']; //창고코드
  $invencol = $array['invencol']; //창고코드
   
	    
  $u1 = date("Y"); 
  // 순번....순서.........................................................................
  $sql = "select * from labelmain where substr(id,1,4)='$u1' order by id desc";

  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);


  $row = mysqli_fetch_assoc($result);
  if ($count > 0) 
  {           
		  $smx= $row['id'];
		
  }
  else
  {
		$smx= $u1."000000000";

  }

  //전표 순서 
  $sql = "select * from labelmain where idate ='$ipgo_date' and chulgonum !='' order by chulgonum desc"; 

  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);


  $row = mysqli_fetch_assoc($result);
  if ($count > 0) 
  {           
		$num= $row['chulgonum']+1;
	
		
  }
  else
  {
		$num= 1;

  }
  
 

  foreach ($array['maindata'] as $row) {

		
			$center = $warehouse.'/'.$warehouseN;

			$sql = "insert into labelmain (idate,chulgonum, worker, companyname, geocode,geoname,center, itemcode ,mappingcode,itemname,chaivalue,unit,customer,special) VALUES('".addslashes($ipgo_date)."','".addslashes($num)."',
'".addslashes($charger)."','".addslashes($invencol)."','".addslashes($georae)."','".addslashes($georaeN)."','".addslashes($center)."',
'".addslashes($row['itemcode'])."','".addslashes($row['mappingcode'])."','".addslashes($row['itemname'])."','".addslashes($row['itemsurang'])."','".addslashes('EA')."','".addslashes($row['itemrule'])."','".addslashes($row['itemetc'])."')";
          
		  
			mysqli_query($connect,$sql);
		    
		 
		
  }//입력끝...

  echo $num.'/';
  echo "success";

?>