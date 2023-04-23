<?  
  $ipgodata = file_get_contents("php://input");
  $array = json_decode($ipgodata, true);


  include 'dbconn.php';

  $ipgo_date = $array['ipgodate'];//입고입력날짜
  $old_date = $array['olddate'];//날짜 변경 여부를 위해 
  
  $oldnum = $array['numbering'];//날짜 변경 여부를 위해 
  $num = $oldnum;
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
  
  // 기존 전표를 삭제 한다. 
  $sql = "delete from ipgo where ipgodate ='$old_date' and ipgonum = '$oldnum' ";
 
  mysqli_query($connect,$sql);


  $u1 = date("Y"); 
  // 순번....순서.........................................................................
  $sql = "select * from ipgo where substr(pid,1,4)='$u1' order by pid desc";

  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);


  $row = mysqli_fetch_assoc($result);
  if ($count > 0) 
  {           
		  $smx= $row['pid'];
		
  }
  else
  {
		$smx= $u1."000000000";

  }


  foreach ($array['maindata'] as $row) {

		
			

			$sql = "insert into ipgo(pid,ipgodate,ipgonum, charger, geocode,geoname,changocode,changoname, itemcode ,mappingcode,itemname,itemrule,ipsu, itembox,itemea,surang ,buyprice,supplyprice,tax,hap,expiration,etc) VALUES('".addslashes($smx+1)."','".addslashes($ipgo_date)."','".addslashes($num)."','".addslashes($charger)."','".addslashes($georae)."','".addslashes($georaeN)."','".addslashes($warehouse)."','".addslashes($warehouseN)."','".addslashes($row['itemcode'])."','".addslashes($row['mappingcode'])."','".addslashes($row['itemname'])."','".addslashes($row['itemrule'])."','".addslashes($row['ipsu'])."',
			'".addslashes($row['itembox'])."','".addslashes($row['itemea'])."','".addslashes($row['itemsurang'])."','".addslashes($row['itemprice'])."','".addslashes($row['itemsupply'])."','".addslashes($row['itemtax'])."','".addslashes($row['itemhap'])."','".addslashes($row['itemexpire'])."','".addslashes($row['itemetc'])."')";
           
			mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...
  echo $num.'/';
  echo "success";
 
?>