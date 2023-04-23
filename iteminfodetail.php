<? 
  $iteminfo = file_get_contents("php://input");
  $array = json_decode($iteminfo, true);


  include 'dbconn.php';

  $itemcode = $array['itemcode'];//입고입력날짜
 
  
  // 순번....순서.........................................................................
  $sql = "select * from iteminfo where itemcode='$itemcode' ";
  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);


  $row = mysqli_fetch_assoc($result);
  extract($row); 
  if ($count > 0) 
  {          
		  $data= $id.','.$itemcode.','.$mappingcode.','.$itemname.','.$geocode.','.$georae.','.$lek.','.$dan.','.$ipsu.','.$packsu.','.$inventory.','.$productiondate.','.$expire
			   .','.$printoption.','.$itemblack.','.$usingY.','.$labelY.','.$ipgoprice.','.$sellprice.','.$printgubun;
          echo $data;		
  }
  else
  {
		echo '데이타가 없습니다. 관리자에게 문의하세요.';

  }


  ?>