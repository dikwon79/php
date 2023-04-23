<?php

    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
    include('headitem.php');



	
	$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
	$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';

	?>

<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 재고장</h1><hr>
    </div>
    <div id="navhead">
    <form class="navbar" role="search" method="post" action="paperofinventory.php">
       
       <div class="col-sm-3">
	   
	   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
       <div class="col-sm-2">	        
			<select name="stype" class="form-control">
			  <option value='0' <? if($stype =='0') echo "selected"; ?>>전체</option>
			  <option value='1' <? if($stype =='1') echo "selected"; ?>>품목코드</option>
			  <option value='2' <? if($stype =='2') echo "selected"; ?>>품목명</option>
			  <option value='3' <? if($stype =='3') echo "selected"; ?>>업체명</option>
			  <option value='4' <? if($stype =='4') echo "selected"; ?>>재고조사담당</option>
			</select>
		   
	   </div>
	   <div class="col-sm-4"><input type="text" name="itext" class="form-control" placeholder="Search" value="<? if($searchtext) echo $searchtext  ?>"></div>
	   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '재고장')">엑셀저장</button></div>
     </form>           
   </div>
   
   <div class="row">
   

	
    <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th>업체명</th> 
			<th>품목코드</th>  
            <th style=width:300px>품목명</th>
            <th>렉번호</th>
            <th>입수</th>
            <th>출고량</th>
			<th>현재고</th>
        
			<th>실사</th>
			<th>차이</th>
			<th id="boxea">BOX</th>
			<th id="boxea">EA</th>
			<th>재고담당</th>
			
        </tr>  
        </thead>  
  
        <?php  
	    //$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
	    $sql = "SELECT a.georae,a.itemcode,a.itemname,a.lek,a.ipsu,b.outstock,b.nowstock,a.inventory,c.SURANG,(c.SURANG-b.nowstock) as chai, (b.nowstock div a.ipsu) as ibox,
		        MOD(b.nowstock,a.ipsu) as iea FROM iteminfo a
               LEFT JOIN nowinven b ON a.itemcode=b.itemcode and b.idate=:var_idate
               LEFT JOIN dailycounting c ON a.itemcode= c.itemcode and c.idate=:var_idate ";
		
			   
			   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		
		
		if ($stype==1){
           $sql.= " where a.itemcode like :var_condition";
		}
		else if ($stype==2){
           $sql.= " where a.itemname like :var_condition";
		}
		else if ($stype==3){
           $sql.= " where a.georae like :var_condition";
		}
		else if ($stype==4){
           $sql.= " where a.inventory like :var_condition";
		}
		
        $sql.=" order by a.lek asc ";
		$stmt = $con->prepare($sql);
	
		$stmt->bindParam(':var_idate',$value);

		if ($stype > 0){
		  $searchtext = '%'.$searchtext.'%';	 

          $stmt->bindParam(':var_condition',$searchtext);
		}
		
 
		
	    $stmt->execute();
 
	    if ($stmt->rowCount() > 0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	        {
		    extract($row);
       
		if ($username != 'admin'){
		?>  
			<tr>  
			<td><?php echo $georae; ?></td>
			<td><?php echo $itemcode;  ?></td> 
			<td><?php echo $itemname;  ?></td>
			<td><?php echo $lek;  ?></td> 
			<td><?php echo $ipsu; ?></td>
			
			<td><?php echo $outstock; ?></td>
			<td><?php echo $nowstock; ?></td>
		

			<td><?php echo $SURANG; ?></td>
			<td style="background-color : #FFF9C4"><?php echo $chai; ?></td>
			<td id="boxea"><?php echo $ibox; ?></td>
			<td id="boxea"><?php echo $iea; ?></td>
			<td><?php echo $inventory;?></td>
			</tr>
		
        <?php
			}
                }
             }
        ?>  
        </table>  
</div>

</body>
</html>