 <!-- 라벨 -->
<?  if ($tabidinfo =="reading"){ ?>
 <div class="row">
	<table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
		<thead>  
		<tr>  
		    <th style="width : 100px">작업날짜</th>
			<th style="width : 50px">경로</th>          
			<th style="width : 50px">차수</th>
			<? for ($i=1 ;$i<$chasu;$i++) { ?>
			<th><button type="button" class="btn btn-primary" onclick="windowSize('printchongshinsegye.php',<?=$i?>,'width=900,height=558')"><?=$i.'차';?></button>
			<a class="btn btn-warning" href="workdelete.php?idate='<?=$value?>'&chasu='<?=$i?>'&companyname='shinsegye'" onclick="return confirm('<?php echo $i ?> 차수를 삭제할까요?')">
			Del</a></th>

			<? } ?>
			
			<th>작업자</th>
            <th>블랙현황</th>
            <th>작업시간</th>
            <th>삭제</th>
  
	 			
		</tr>  
		</thead>  
  
		<?php  
		//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		$sql = "SELECT * FROM labelcjimsi WHERE idate='$value' GROUP BY chasu,worker";
			  
		
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
			<td><?=$idate?></td>
			
			<td><?php echo $companyname;  ?></td> 
			
			<td><?php echo $chasu;  ?></td> 
			<td><?php echo $worker;  ?></td> 
			<td><?php echo $blk;  ?></td> 
			<td><?php echo $worktime;  ?></td> 
			<td><a class="btn btn-warning" href="readingmaterial_del.php?idate='<?=$value?>'&chasu='<?=$chasu?>'&worker='<?=$worker?>'&companyname='cj'" onclick="return confirm('<?php echo $chasu ?> 차수를 삭제할까요?')">삭체</a>

			</tr>
		
		<?php
			
				}
			 }
		?>  
		</table>  
 </div>
<? } ?>
<!--라벨끝  -->

 