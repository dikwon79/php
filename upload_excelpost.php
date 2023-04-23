<?  
  $blacklist = file_get_contents("php://input");
  $array = json_decode($blacklist, true);


  include 'dbconn.php';

      
  $u1 = date("Y"); 
  // 순번....순서.........................................................................

  $sql = "delete from chulgoupload";

  $result = mysqli_query($connect,$sql);

 /*
  $sql = "select * from black_list where substr(pid,1,4)='$u1' order by pid desc";

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

  */

  $smx = 0;
  foreach ($array['maindata'] as $row) {

			
    $smx = $smx+1;
	$sql = "insert into chulgoupload(pid,excelname,kind, etc) VALUES('".addslashes($smx)."','".addslashes($row['엑셀명칭'])."','".addslashes($row['대분류'])."','".addslashes($row['비고'])."')";
    echo $sql;      
	mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...

  echo "success";

?>