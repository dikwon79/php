
 <div class="row">
     <div class="panel panel-default">
        <div class="panel-body">
		    <div class="form-inline">
		    <div class="form-group">
			<label>입력 조회:</label>
			<input type="date" name ='date3' id ='date3' class="form-control input-sm ng-pristine ng-untouched ng-valid" ng-model="startDate" value="<?=$today1?>">
			
			  <div class="btn-group">
			  	<label class="btn btn-success input-sm" onclick="radio1('3')">
				조회</label>
				
			</div>
			</div>
		</div>
      </div>
	<table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
		<thead>  
		<tr>  
		    <th style="width : 100px">업로드날짜</th>
			<th style="width : 100px">반영날짜</th>  
			<th style="width : 50px">차수</th>
            <th style="width : 50px">작업자</th>
			<th style="width : 50px">삭제</th>
			  	  	
		</tr>  
		</thead>  
  
		<?php  
		//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		$sql = "SELECT * FROM labelXmain WHERE inputday='$today1' GROUP BY chasu,worker";
			  
		
		$stmt = $con->prepare($sql);
	
		
		$stmt->execute();
 
		if ($stmt->rowCount() > 0)
			{
				$nocount =0;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
				   extract($row);
				   $nocount++;
	   
	
		?>  
			<tr> 
			<td><?=$inputday?></td>
			
			<td><?php echo $idate;  ?></td> 
			
			<td><?php echo $chasu;  ?></td> 
			<td><?php echo $worker;  ?></td> 
			<td><a class="btn btn-warning" href="./delete.php?inputday='<?=$inputday?>'&chasu='<?=$chasu?>'&worker='<?=$worker?>" onclick="return confirm('<?php echo $chasu ?> 차수를 삭제할까요?')">삭체</a>
            </td>
			</tr>
		
		<?php
			
				}
			 }

			  if (empty($tab) !="1"){

                 echo ("<script language=javascript> condition();</script>");
              }
  
		?>  
		</table>  
 </div>

<!--라벨끝  -->

 