 <? 
    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
 

                     
	//$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	//$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';
    $start = $_POST['start'];
	$list = $_POST['list'];
    $company = $_POST['company'];
	$search = $_POST['search'];
    


    
	$where = " where usingY = 'Y'";
	if($company) $where .= " and georae like '%$company%' ";
	
    if($search) $where .= " and (itemcode like '%$search%' or itemname like '%$search%' or mappingcode like '%$search%' or printgubun like '%$search%') ";
	

 
	$sql = "SELECT * FROM iteminfo ".$where." ORDER BY lek asc ";
    
	
	$sql .="limit {$start},{$list}";
    //echo $sql;

	$stmt = $con->prepare($sql);


	$stmt->execute();

		if ($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
		extract($row);
   
	?>  
		<tr>
		<input type='hidden' value='<?=$id?>'>
		
		<td><?php echo $georae; ?></td>
		<td NOWRAP><?php echo $itemcode;  ?></td>
		<td NOWRAP><?php echo $mappingcode;  ?></td>
		<td><?php echo $itemname;  ?></td>
		<td class="noshow"><?php echo $itemnameGeo;  ?></td>
		<td><?php echo $lek;  ?></td>
		<td><?php echo $ipsu;  ?></td>
		<td><?php echo $packsu;  ?></td>
		<td><?php echo $printoption;  ?></td>
		<td><?php echo $itemblack;  ?></td>
		<td><?php echo $usingY; ?></td>
		<td><?php echo $printgubun;  ?></td>
		
		

		</tr>
	
	<?php
		
			}
		 }
	?>  
	

								
						 









