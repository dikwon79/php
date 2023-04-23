<?  
  $blacklist = file_get_contents("php://input");
  $array = json_decode($blacklist, true);


  include 'dbconn.php';

      
  $u1 = date("Y"); 
  // 순번....순서.........................................................................

  $sql = "delete from black_list";

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
	$sql = "insert into black_list(pid,center,kind, name) VALUES('".addslashes($smx)."','".addslashes($row['업체'])."','".addslashes($row['분류'])."','".addslashes($row['이름'])."')";
    echo $sql;      
	mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...

  echo "success";

?>