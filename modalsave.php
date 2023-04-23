<?php
	$expireinformaion = file_get_contents("php://input");
	$array = json_decode($expireinformaion, true);


    include 'dbconn.php';
   
   

    //---------------------------------------------------------------------------------------------------------------
   
   
  
	foreach ($array['expireinfo'] as $row) {

		

			$sql = "update iteminfo set productiondate='".$row[productiondate]."', expire='".$row[duration]."',etc ='".$row[etc]."' where itemcode='".addslashes($row[itemcode])."'"; 
			
			
			echo $sql;
		
           
			mysqli_query($connect,$sql);
		    
		   
		
		}//엑셀데이타 입력 끝
		echo '저장하였습니다.';
        
?>
