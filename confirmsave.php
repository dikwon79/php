<?php
	$confirmkey = file_get_contents("php://input");
	$array = json_decode($confirmkey, true);


    include 'dbconn.php';
   
   

    //---------------------------------------------------------------------------------------------------------------
   
   
  
	foreach ($array['confirm'] as $row) {

		

			$sql = "update labelmain set type='".$row[mtype]."', itemcode='".$row[mcode]."',mappingcode ='".$row[mmap]."',itemname ='".$row[mname]."',customer ='".$row[mcus]."',surang2 ='".$row[msu2]."',unit ='".$row[munit]."',confirmsu ='".$row[mconf]."',chaivalue ='".($row[mconf]-$row[msu1])."',modalreason ='".$row[modalreason]."' where id='".addslashes($row[mid])."'"; 
			
			
			echo $sql;
		
           
			$result = mysqli_query($connect,$sql);
		    
		   
		
		}//엑셀데이타 입력 끝
		if ($result) { 
			echo '저장하였습니다.';
		}else{

			echo("Errormessage:". $conn -> error);


		}
        
?>
