 <!-- 라벨 -->
 <div class="row">
	<table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
		<thead>  
		<tr>  
			<th style="width : 50px">No.</th>          
			<th style="width : 300px">업체이름</th>
			<? for ($i=1 ;$i<$chasu;$i++) { ?>
			<th><button type="button" class="btn btn-primary" onclick="windowSize('printchongshinsegye.php',<?=$i?>,'width=900,height=558')"><?=$i.'차';?></button>
			<a class="btn btn-warning" href="workdelete.php?idate='<?=$value?>'&chasu='<?=$i?>'&companyname='shinsegye'" onclick="return confirm('<?php echo $i ?> 차수를 삭제할까요?')">
			Del</a></th>

			<? } ?>
			
			<th>최종작업시간</th>
				
		</tr>  
		</thead>  
  
		<?php  
		//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		$sql = "SELECT y.blk,x.geocode,x.geoname,";
		
		for ($i=1 ;$i<$chasu;$i++) { 
			$sql .="MAX(case when y.chasu = '$i' then y.cha ELSE '' END) as col$i,"; 
		}
		$sql = rtrim($sql, ','); // remove last separator
		$sql .=" ,y.worktime FROM (SELECT * FROM geoinfo WHERE tpl='Y' and labeltype like '%신세계%')x LEFT JOIN (SELECT x.blk,ifnull(a.geocode,'100') as 'geo',COUNT(x.chasu) as 'cha' , x.chasu,x.worktime FROM (SELECT blk,itemcode, b.chasu,b.worktime from labelmain b where companyname='shinsegye' and idate='$value')x LEFT JOIN iteminfo a ON x.itemcode = a.itemcode GROUP BY a.georae,x.chasu)y ON x.geocode = y.geo GROUP BY x.geoname order by y.chasu desc,x.pid asc";
		
	   
			   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		 

	   /*
		 //과거 버ㅂ



		//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		$sql = "SELECT y.blk,x.geocode,x.geoname,";
		
		for ($i=1 ;$i<$chasu;$i++) { 
			$sql .="MAX(case when y.chasu = '$i' then y.cha ELSE '' END) as col$i,"; 
		}
		$sql = rtrim($sql, ','); // remove last separator
		$sql .=" ,y.worktime FROM (SELECT * FROM geoinfo WHERE tpl='Y')x LEFT JOIN (SELECT blk,geocode,COUNT(b.chasu) as cha , b.chasu,b.worktime from labelmain b where idate='$value' group BY b.chasu)y ON x.geocode = y.geocode GROUP BY x.geoname";
		

			   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		*/
		
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
			<td><?=$nocount?></td>
			
			<td><?php echo $geoname;  ?></td> 
			<? for ($i=1 ;$i<$chasu;$i++) { ?>
			<td><? 
			
			  $col = 'col'.$i;
		 
			   echo $$col ;?></td>

			<? } ?>
			<td><?php echo $worktime;  ?></td> 
			</tr>
		
		<?php
			
				}
			 }
		?>  
		</table>  
 </div>

 <!--라벨끝  -->

 <!-- 80%size Modal at Center -->
	<div class="modal modal-center fade" id="my80sizeCenterModal" tabindex="-1" role="dialog" aria-labelledby="my80sizeCenterModalLabel">
	  <div class="modal-dialog modal-80size modal-center" role="document">
		<div class="modal-content modal-80size">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">유통이력 입력하기</h4>
		  </div>
		  <div class="modal-body">
		   <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
			<thead>  
			<tr style="border: solid 1px;">  
				<th style="border: solid 1px;"><input type='checkbox'></th> 
				<th style="border: solid 1px ; padding:0px;" NOWRAP>품목코드</th>  
				<th style="border: solid 1px ; padding:0px;" NOWRAP>품목명</th>
		
				<th style="border: solid 1px ; padding:0px;" NOWRAP>제조일자</th>
				<th style="border: solid 1px ; padding:0px;" NOWRAP>개월</th>
				<th style="border: solid 1px ; padding:0px;" NOWRAP>비고</th>
				
			</tr>
			</thead>  
			<tbody id="my-tbody">

			 <?  
			  $sql = "SELECT itemcode,itemname,productiondate,expire from iteminfo where productiondate!='' ";		 
			  $stmt = $con->prepare($sql);
			  $stmt->execute();
			  if ($stmt->rowCount() > 0)
			  {
				   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				   {
				   extract($row);
				 
			  ?>
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox'></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' size="35" style="width:100%; height :33px;border:0;" value="<?=$itemcode?>"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' size="80" style="width:100%;height :33px;border:0;" value="<?=$itemname?>"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' size="20" style="width:100%; height :33px;border:0;" value="<?=$productiondate?>"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' size="20" style="width:100%; height :33px;border:0;" value="<?=$expire?>"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' size="50" style="width:100%; height :33px;border:0;" value="<?=$etc?>"></td>
			
			
			</tr>
			<?
				   }
			  }
				?>
			</tbody>
		 </table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- 80%size Modal at Center -->
	<div id="side">준비중입니다. 클릭하지 마세요 </div>
<!-- id는 고유한 이름으로 설정하고 tab의 href와 연결되어야 한다. -->