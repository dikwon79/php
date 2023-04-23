<?php
 //DB연결
    include('dbcon.php');

    $itemcode=$_GET['itemcode']; 
    $itemname=$_GET['itemname'];
  
    $sql = "SELECT * from iteminfo where  labelY='Y' and (itemnameGeo like '%$itemcode%' or itemname  like '%$itemcode%' or itemcode like '%$itemcode%' or georae like '%$itemcode%')   ";
	     
   
	
	  $stmt = $con->prepare($sql);
	  $stmt->execute();
	  if ($stmt->rowCount() > 0)
	  {
		 if($stmt->rowCount() > 1)
		 {
		    echo 'EOF';	 
		 }
		 else{

		   $row=$stmt->fetch(PDO::FETCH_ASSOC);
		   
		   extract($row); 
		     
		   echo $itemcode."ㅁㅁ".$mappingcode."ㅁㅁ".$itemnameGeo."ㅁㅁ".$ipsu."ㅁㅁ".$ipgoprice."ㅁㅁ".$georae;
				      
					
		   
		 }
	  }
    
  
		 
	?>