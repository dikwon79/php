<?
    $sql = "SELECT COUNT(*) as 'labelsu' from(SELECT a.printinfo from(SELECT '0' AS 't', 'b1' AS val0, chasu, center, itemcode,itemname, 
	customer,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
    FROM labelcjimsi WHERE (companyname,idate, chasu,cancelY,barcode) in (SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode FROM labelcjimsi 
	WHERE companyname='cj' AND idate='$value' AND worker='admin' GROUP BY barcode))T left join print_info a ON T.center = concat(a.center,' / ',a.centername) WHERE T.cancelY!='Y')A";	
	
	$stmt = $con->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch();  
	$labelsu = $row['labelsu'];

	
	$sql = "SELECT COUNT(*) as 'blacksu' from labelcjimsi WHERE (companyname,idate, chasu,cancelY,barcode) in (select companyname,idate, max(chasu) as chasu ,cancelY,barcode from labelcjimsi where companyname='cj' AND idate='$value' AND cancelY='N' and worker='".$_SESSION['user_id']."' group by barcode)";	
		   



	$stmt = $con->prepare($sql);
	$stmt->execute();
	$row = $stmt->fetch();  
	$blacksu = 0;//$row['blacksu']-$labelsu;

?>
<div id="side"></div>
<div class="row" style="position:relative; margin:2px; height:150px; border:5px solid #2C3E50"> 
<div id='billboard1' class="col-sm-6">발행:<?=$labelsu?></div>
<div id='billboard2' class="col-sm-6">미발행:<?=$blacksu?></div>
</div>
<div id="option">
<div class="col-sm-2"><label>1.CJ프레시 웨이</label></div>


   <?  
	  $sql = "SELECT companyname,printinfo from print_info where companyname='cj' and center!='4000' group by companyname, printinfo";		 
	  $stmt = $con->prepare($sql);
	  $stmt->execute();
	  if ($stmt->rowCount() > 0)
	  {
		   $num=0;
		   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		   {
		   extract($row); 
		   
		 
   ?>
   <div class="col-sm-1"><?=$printinfo?> : <input type='checkbox' id='cut<?=$num?>' name='cut' value='<?=$printinfo?>' style="width:20px;height:20px;"> </label></div>
  
   <?  
	  $num++;
	 }  }?>
  
   <div class="col-sm-1"></div>
   
</div> 
<!--<div id="option">
<div class="col-sm-12">2.변경분만:<input type='checkbox' id='onlychange' name='onlychange' value='9999' style="width:20px;height:20px;"> </label></div></div>-->
<div id="option">
<div id ="printoption" class="col-sm-6" onclick="printevent();">3.체크시 전체출력(블랙리스트):<input type='checkbox' id='blackunlock' name='blackunlock' value='blackoff' style="width:50px;height:50px;"></div>
<div id ="centeroption" class="col-sm-6" onclick="centerevent();">4.마감후체크(센터블랙):<input type='checkbox' id='centerunlock' name='centerunlock' value='blackcenoff' style="width:50px;height:50px;"></div>   
</div>




		 <!-- 여기 까지 -->
		 
         <!-- 라벨 -->
		 <div class="row">
         <div class="rightfix"> 
            <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
				<thead>  
				<tr>  
					<th class='fixedHeader' style="width : 50px">No.</th>          
					<!--<th style="width : 70px"><input id="checkall" type="checkbox" onclick="checkboxclick()">체크시블랙제외</th> -->
					<th class='fixedHeader' style="width : 300px">업체이름</th>
					
					<? for ($i=1 ;$i<$chasu;$i++) { ?>
					<th class='fixedHeader'>
					<!-- 문제 생겼을 경우에 printchongcj.php파일을 사용할것 -->
					<button type="button" id="<?='chasu'.$i?>" class="btn btn-primary" onclick="windowSize('printchongcj2.php',<?=$i?>,'width=900,height=558')"><?=$i.'차';?></button>
					<button type="button" id="<?='chasu'.$i?>" class="btn btn-primary" onclick="windowSize('printchongAllcenter.php',<?=$i?>,'width=900,height=558')"><?=$i.'All';?></button>
					<button type="button" id="<?='chasu'.$i?>" class="btn btn-primary" onclick="windowSize('printchongcj.php',<?=$i?>,'width=900,height=558')"><?=$i.'test';?></button>
					
					<a class="btn btn-warning" href="workdelete.php?idate='<?=$value?>'&chasu='<?=$i?>'&companyname='cj'" onclick="return confirm('<?php echo $i ?> 차수를 삭제할까요?')">
					Del</a></th>

					<? } ?>
					
					
				</tr>  
				</thead>  
		  
				<?php  
				//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
				$sql = "select * from (SELECT x.geocode,x.geoname,";
				
				for ($i=1 ;$i<$chasu;$i++) { 
					$sql .="sum(case when y.chasu = '$i' then y.cha ELSE 0 END) as col$i,"; 
				}
				$sql = rtrim($sql, ','); // remove last separator
				$sql .=" FROM (SELECT * FROM geoinfo WHERE tpl='Y' and labeltype like '%CJ%')x LEFT JOIN 
                 (SELECT ifnull(if(a.geocode='','100',a.geocode),'100') as 'geo',sum(x.labelsu) AS 'cha',x.chasu,x.worktime FROM (SELECT itemcode, b.chasu,b.worktime,if(chaivalue<0,-1,TOT_PAGE) AS 'labelsu' from labelmain b where companyname='cj' and idate='$value' and worker='".$_SESSION['user_id']."')x 
                 LEFT JOIN iteminfo a ON x.itemcode = a.itemcode GROUP BY a.georae,x.chasu)y ON x.geocode = y.geo GROUP BY x.geoname
				 union all
				 select '1' as 'ke', '작업시간',";
				for ($i=1 ;$i<$chasu;$i++) { 
					//$sql .="concat(if(blk='N','all ',''),MAX(case when chasu = '$i' then worktime ELSE 0 END)) as col$i,"; 
					$sql .="CONCAT(if(MAX(CASE WHEN chasu = '$i' THEN blk ELSE '' END)='Z','CEN',if(MAX(CASE WHEN chasu = '$i' THEN blk ELSE '' END)='Y','ALL','')),MAX(CASE WHEN chasu = '$i' THEN worktime ELSE 0 END)) AS col$i,";
				}
				$sql = rtrim($sql, ','); // remove last separator
                $sql .=" FROM labelcjimsi WHERE companyname='cj' AND idate='$value' and worker='".$_SESSION['user_id']."' GROUP BY ke)Z ORDER BY geocode asc"; 

				 
				
				//echo $sql;
		

				
               
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
					<!--<td><input name='check' type='checkbox' style="width:20px;height:20px;" value='<?=$geocode?>' <? if ($blk=='Y') { ?> checked <? }; 
				   
				
					   ?>></td>  -->
					<td><?php echo $geoname;  ?></td> 
					<? for ($i=1 ;$i<$chasu;$i++) { ?>
					<td><? 
					
					  $col = 'col'.$i;
				 
					   echo $$col ;?></td>

					<? } ?>
				
					</tr>
				
				<?php
					
						}
					 }
				?>  
				</table>
				</div>
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
				   <table id="modaltable" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
					
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
					  $sql = "SELECT itemcode,itemname,productiondate,expire,etc from iteminfo where productiondate!='' ";		 
					  $stmt = $con->prepare($sql);
					  $stmt->execute();
					  $mcount =0;
					  if ($stmt->rowCount() > 0)
					  {
						   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
						   {
						   extract($row);
						   $mcount++;
						 
					  ?>
					<tr style="border: solid 1px;">
						<td style="border: 1px solid;"><input type='checkbox' size="5"  style="width:100%; height:32px;border:0;"></td> 
						<td style="border: 1px solid; padding:0px;"><input type='text' id='itemcode<?=$mcount?>' size="35" style="width:100%; height:32px;border:0;" value="<?=$itemcode?>"></td>  
						<td style="border: 1px solid; padding:0px;"><input type='text' size="80" style="width:100%;height :32px;border:0;" value="<?=$itemname?>"></td>
						<td style="border: 1px solid; padding:0px;"><input type='text' id='productiondate<?=$mcount?>' size="20" style="width:100%; height :32px;border:0;" value="<?=$productiondate?>"></td>
						<td style="border: 1px solid; padding:0px;"><input type='text' id='duration<?=$mcount?>' size="20" style="width:100%; height :32px;border:0;" value="<?=$expire?>"></td>
						<td style="border: 1px solid; padding:0px;"><input type='text' id='etc<?=$mcount?>' size="50" style="width:100%; height :32px;border:0;" value="<?=$etc?>"></td>
					
					
					</tr>
					<?
						   }
					  }
						?>
					</tbody>
				 </table>
				  </div>
				  <div class="row">개월 사용법 : d8-> 생산날짜 + 8일 , m6 -> 생산날짜 + 6개월 , y2 -> 생산날짜+2년</div>
				  <div class="modal-footer">
				    <button type="button" class="btn btn-default" onclick="modalsave()">저장</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- 80%size Modal at Center -->
		
		<!-- id는 고유한 이름으로 설정하고 tab의 href와 연결되어야 한다. -->