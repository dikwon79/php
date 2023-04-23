<?  
  $blacklist = file_get_contents("php://input");
  $array = json_decode($blacklist, true);


  include 'dbconn.php';

      
  $u1 = date("Y"); 
  // 순번....순서.........................................................................
  $sql = "delete from chulgocheck";

  $result = mysqli_query($connect,$sql);
  

  


  foreach ($array['maindata'] as $row) {

		
			

	//$sql = "insert into print_info(companyname,center,centername,grouping,printinfo) VALUES('".addslashes($row['companyname'])."','".addslashes($row['center'])."','".addslashes($row['centername'])."','".addslashes($row['grouping'])."','".addslashes($row['printinfo'])."')";
           
	mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...

  echo "success";

?>