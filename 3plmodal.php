<?php
 //DB연결
    include 'dbconn.php';

    $item=$_POST['itemcode'];
    $itemname=$_POST['itemname'];

	$idate=$_POST['idate1']."-".$_POST['idate2']."-".$_POST['idate3'];

	
    /*
	$sql = "SELECT B.companyname, a.itemcode,B.mappingcode, a.itemname, 
	SUM(CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END) AS 'surang',unit FROM iteminfo a,(
	SELECT '라벨' AS 'list', idate, center AS 'companyname',mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
	FROM labelmain b
	WHERE idate ='$idate' AND mappingcode='$item'
	GROUP BY b.center,b.unit
	UNION ALL
	SELECT '출고' AS 'list', idate, companyname,mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
	FROM labelXmain c
	WHERE idate ='$idate' AND mappingcode='$item'
	GROUP BY c.companyname,c.unit)B
	WHERE a.itemcode=B.mappingcode AND labelY='Y' GROUP BY B.companyname";
    
	*/

	$sql ="SELECT * FROM (SELECT B.companyname, B.idate, a.itemcode,B.mappingcode, a.itemname,B.customer, SUM(CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END) AS 'surang'
FROM iteminfo a,(
SELECT '라벨' AS 'list', deaddate AS 'idate', center AS 'companyname',mappingcode,customer, SUM(chaivalue) AS 'surang',unit AS 'unit'
FROM labelmain b
WHERE idate ='$idate' AND mappingcode='$item'
GROUP BY b.customer,b.unit UNION ALL
SELECT '출고' AS 'list', idate, companyname,mappingcode, customer, SUM(chaivalue) AS 'surang',unit AS 'unit'
FROM labelXmain c
WHERE idate ='$idate' AND mappingcode='$item'
GROUP BY c.companyname,c.unit)B
WHERE a.itemcode=B.mappingcode AND labelY='Y'
GROUP BY customer
ORDER BY companyname)C
LEFT JOIN
(
SELECT  SUM(CASE WHEN F.unit = 'BOX' THEN a.packsu*F.surang ELSE F.surang END) AS 'surang2',companyname
FROM iteminfo a,(
SELECT '라벨' AS 'list', idate, center AS 'companyname',mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
FROM labelmain b
WHERE idate ='$idate' AND mappingcode='$item'
GROUP BY b.center,b.unit UNION ALL
SELECT '출고' AS 'list', idate, companyname,mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
FROM labelXmain c
WHERE idate ='$idate' AND mappingcode='$item'
GROUP BY c.companyname,c.unit)F
WHERE a.itemcode=F.mappingcode AND labelY='Y'
GROUP BY F.companyname)M 
on C.companyname = M.companyname";

	//echo $sql;
    $result = mysqli_query($connect,$sql);
    $count = mysqli_num_rows($result);
	
	  if ($count > 0)
	  {
		 
		   echo '['.$item.']   '.$itemname;
		   echo " <span onclick='closemodal()' class="."close".">&times</span><table id='table' class='table table-bordered'>
		   <tr style='background-color:#c5d0ed'><td>센터</td><td>센터총수량</td><td>업장명</td><td>수량</td><td>출고날짜</td><tr>";   
           
		   //$sql2 = select *		
		   while ($row = $result->fetch_assoc()) 
		   {
		  
                
               /*
			   <td>".$row['itemcode']."</td>
					   <td>".$row['mappingcode']."</td>
				       <td>".$row['itemname']."</td>

					   */

                
				echo "
					   <tr>
			           <td>".$row['companyname']."</td>
				       
					   
					  
					   <td>".$row['surang2']."</td>
					   <td>".$row['customer']."</td>
					    <td>".$row['surang']."</td>
					   
					   <td>".$row['idate']."</td>
					   </tr>";

		   }
		   echo "</table>";
		  
	  }
	  else{
          echo " <span onclick='closemodal()' class="."close".">&times.</span>"; 


	  }
      
  
		 
	?>