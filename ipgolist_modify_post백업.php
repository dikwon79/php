<?  
  $ipgodata = file_get_contents("php://input");
  $array = json_decode($ipgodata, true);


  include 'dbconn.php';

  $ipgo_date = $array['ipgodate'];//입고입력날짜
  $old_date = $array['olddate'];//날짜 변경 여부를 위해 
  $num = $array['numbering'];//날짜 변경 여부를 위해 
  $charger = $array['charger']; //담당자
  $georae = $array['georae']; //거래처
  $georaeN = $array['georaeN']; //거래처
  $warehouse = $array['warehouse']; //창고코드
  $warehouseN = $array['warehouseN']; //창고코드
  
  $idatechange=false;
  if($ipgo_date!=$old_date) {
  
  $idatechange=true;
	  
  //전표 순서 //전표 날짜 변경시 전표순서가 바뀌어야 한다. 
  $sql = "select * from ipgo where ipgodate ='$ipgo_date' order by ipgonum desc"; 

  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);


  $row = mysqli_fetch_assoc($result);
  if ($count > 0) 
  {           
		$num= $row['ipgonum']+1;
	
		
  }
  else
  {
		$num= 1;

  }
  
  }

  foreach ($array['maindata'] as $row) {

		
		

            $sql = "update ipgo set 
			ipgodate='".addslashes($ipgo_date)."',
			ipgonum='".addslashes($num)."',
			charger='".addslashes($charger)."', 
			geocode='".addslashes($georae)."',
			geoname='".addslashes($georaeN)."',
			changocode='".addslashes($warehouse)."',
			changoname='".addslashes($warehouseN)."', 
			itemcode='".addslashes($row['itemcode'])."',
			itemname='".addslashes($row['itemname'])."',
			itemrule='".addslashes($row['itemrule'])."',
			itembox='".addslashes($row['itembox'])."',
			itemea='".addslashes($row['itemea'])."',
			surang='".addslashes($row['itemsurang'])."',
			buyprice='".addslashes($row['itemprice'])."',
			supplyprice='".addslashes($row['itemsupply'])."',
			tax='".addslashes($row['itemtax'])."',
			hap='".addslashes($row['itemhap'])."',
			expiration='".addslashes($row['itemexpire'])."',
			etc='".addslashes($row['itemetc'])."'
			where pid='".addslashes($row['pid'])."'";
			
			mysqli_query($connect,$sql);
		      
		
  }//입력끝...
  echo $num.'/';
  echo "success";

?>