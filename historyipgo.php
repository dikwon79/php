<?php
 //DB연결
    include('dbcon.php');

    $geocode=$_GET['geocode'];
 
 
    $sql = "SELECT itemcode,itemname,buyprice,ipgodate from(select * from ipgo where (itemcode) in (select itemcode from ipgo where geocode='$geocode' group by itemcode)
	order by ipgodate desc)t group by t.itemcode";		 

	
	  $stmt = $con->prepare($sql);
	  $stmt->execute();
	  if ($stmt->rowCount() > 0)
	  {
		 
		   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		   {
		   extract($row); 
		     
			    echo "<tr>
			           <td>".$itemcode."</td>
				       <td>".$itemname."</td>
					   <td>".$buyprice."</td>
					   <td>".$ipgodate."</td>
					  </tr>";

		   }
	  }
      $stmt->close();
  
		 
	?>