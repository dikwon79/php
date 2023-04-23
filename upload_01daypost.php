<?  
  $blacklist = file_get_contents("php://input");
  $array = json_decode($blacklist, true);


  include 'dbconn.php';
  $firstday = trim($array['maindata'][0]['firstday']);
  
  	  
  $u1 = date("Y"); 
  // 순번....순서.........................................................................
  $sql = "delete from Deadline where idate='$firstday' ";

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

		
	if (trim($row['firstday'])=="") continue;		
    $day = substr($row['firstday'],0,10);
	$sql = "insert into Deadline(idate,itemcode,surang) VALUES('".addslashes($day)."','".addslashes($row['itemcode'])."','".addslashes($row['surang'])."')";
           
	mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...

  echo "success";

?>