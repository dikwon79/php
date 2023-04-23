<?php

    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
    include('headitem.php');


    header( "Content-type: application/vnd.ms-excel; charset=utf-8");
    header( "Content-Disposition: attachment; filename = excel_test.xls" );     
    header( "Content-Description: PHP4 Generated Data" );

	$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
	$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	$searchtext = isset($_POST['itext']) ? iconv("utf-8","EUC-KR",$_POST['itext']) : '';

	?>

<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 재고장</h1><hr>
    </div>
   
   <div class="row">
   

	<? $EXCEL_FILE = " 
    <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th>품목코드</th>  
            <th style=width:300px>품목명</th>
            <th>렉번호</th>
            <th>업체명</th> 
            <th>출고량</th>
			<th>현재고</th>
            <th>재고담당</th>
			<th>실사</th>
			<th>차이</th>
			
        </tr>  
        </thead>  
     "; //엑셀
        <?php  
	    //$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
	    $sql = "SELECT a.itemcode,a.itemname,a.lek,a.georae,b.outstock,b.nowstock,a.inventory,c.SURANG,(b.nowstock-c.SURANG) as chai  FROM iteminfo a
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
			<td><?php echo iconv("EUC-KR", "utf-8",$itemcode );  ?></td> 
			<td><?php echo iconv("EUC-KR", "utf-8",$itemname );  ?></td>
			<td><?php echo $lek; ?></td> 
			<td><?php echo iconv("EUC-KR", "utf-8",$georae ); ?></td>
			
			<td><?php echo $outstock; ?></td>
			<td><?php echo $nowstock; ?></td>
			<td><?php echo iconv("EUC-KR", "utf-8",$inventory);?></td>

			<td><?php echo $SURANG; ?></td>
			<td><?php echo $chai; ?></td>
			
			</tr>
		
        <?php
			}
                }
             }
        ?>  
        <? $EXCEL_FILE .= "</table>"; ?>
		
		 
		
		
</div>
       <?  echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

           echo $EXCEL_FILE; 
		   ?>
</body>
</html>