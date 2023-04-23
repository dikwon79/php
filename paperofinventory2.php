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
 
    include('headitem.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
		//전체 tr에서 찾는거
            $(document).ready(function(){
			  $("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });
			});
		
			//일정 td에서만 찾는 방법
			/*
			 $(document).ready(function() {
				$("#myInput").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#myTable > tr").hide();
					var temp = $("#myTable > tr > td:nth-child(15n+12):not(:contains('" + value + "'))");

					//var temp = $("#myTable > tr > td:nth-child(15n+3):contains('" + value + "')");


					
					$(temp).parent().show();
				});
			});
             */
		</script>	
		
        <style>
		   
        
		    html {
			    height: 100%;
			}
			.container{
                width: 95%;
			}
			body {
			margin: 0;
			height: 100%;
			
		 
			}	
			section{
			   position :relative;
			   min-height:75%; 
			}
			#navitem{
               width : 98.5%;
			}
			footer {
			position: relative;
			bottom: 0;
			left: 0;
			right: 0;
			color: white;
			background-color: #333333;
			}
            

		</style>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item">라벨발행</a>
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="paperofinventory2.php" class="list-group-item active">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
							<a href="chulgolist.php" class="list-group-item">업장출고내역</a>
							<a href="chagelist.php" class="list-group-item">변경분리스트</a>
						
						</div>
					
					    <div class="p-0 my-2">
							<div class="card text-center pt-2 bg-light">
								<h5 class="pt-2 pb-2">기타 사이트</h5>
								<ul class="list-group">
									<li class="list-group-item">메일</li>
									<li class="list-group-item">cj프레시웨이</li>
									<li class="list-group-item">네이버</li>
									<li class="list-group-item">구글</li>
									<li class="list-group-item">이안로지스</li>
									<li class="list-group-item">송림푸드</li>

								</ul>
							
							</div>
						</div>
					</div>

					
                    <div class="col-md-10 my-2" style="padding-left:0px;">
                     <? 
					 
						$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
						$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
						$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';

	         
					 
					 
					 
					 
					 ?>
              	           <div class="container">
						   <div id="navhead" style="margin-left:-30px;margin-top:0px">
						   <form class="navbar" role="search" method="post" action="">
                              
							   <div class="col-sm-2">
                                  
							   <h1 class="h2">&nbsp;재고장</h1>
						
							   </div>
							
							   <div class="col-sm-2">
							   
							   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
							   <div class="col-sm-3">
									  <div class="form-group">
									  <select name ='inventory' class="input-large form-control">
									  <option value="전체">전체</option>
                                <?
                                $sql = "select * from iteminfo WHERE inventory !='' GROUP BY inventory";
													
								$stmt = $con->prepare($sql);
							
								$stmt->execute();
						 
								if ($stmt->rowCount() > 0)
									{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
									   {
									      extract($row);   

										  
										  ?>


									  <option value="<?=$inventory?>" <? if (trim($inventory) == trim($_POST['inventory'])) { ?> selected <? } ?>><?=$inventory?></option>
									  <?  }  }?>
									  </select>
									 </div>
							   </div>
							 
							 
							   <div class="col-sm-2"><input type="text" name="itext" id="myInput" class="form-control" placeholder="Search" value="<? if($searchtext) echo $searchtext  ?>"></div>
							   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '재고장')">엑셀저장</button></div>
							 </form>           
						   </div>
						   
						   <div class="row">
						

							
							<table  id='table' class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
								<thead>  
								<tr>  
									<th NOWRAP>재고코드</th> 
									<th>거래처</th> 
									<th NOWRAP>품목코드</th>
									<th style=width:300px>품목명</th>
									<th>렉번호</th>
									<th>입수</th>
									<th>전재고 </th>
									<th>입고</th>
									<th>CJ</th>
									<th>SPC</th>
									<th>신세계</th>
									<th>출고합</th>
									<th>현재고</th>
									<th>실사</th>
									<th>차이</th>
									<th id="boxea">BOX</th>
									<th id="boxea">EA</th>
									
								</tr>  
								</thead>  
								<tbody id="myTable">
								<?php  

								
                                $selectname = isset($_POST['inventory']) ? $_POST['inventory'] : '시작';

						      
								$sql = "SELECT idate FROM Deadline ORDER BY idate desc limit 1";

								$stmt = $con->prepare($sql);

								$stmt->execute();
								
								
								if ($selectname=='전체'){
									 $selectbox ='';

								}
								else{
                                     $selectbox =" and inventory = '$selectname' ";
								}

								$row = $stmt->fetch();  
								$deaddate = $row['idate'];
								//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
								$sql = "SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,a.ipsu,
								sum(if(B.list='기초',B.surang,0))-SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.ipsu,B.surang),0))+SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.ipsu,B.surang),0)) AS '전일재고',
								sum(if(B.list='입고',B.surang,0)) AS '입고',
								sum(CASE WHEN B.companyname = 'CJ' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'CJ', 
								sum(CASE WHEN B.companyname = 'spc' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'SPC', 
								sum(CASE WHEN B.companyname = 'shinsegye' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'shinsegye', 
								SUM(if(B.list='실사',B.surang,0)) AS '실사'
								FROM iteminfo a,(
								SELECT '기초'AS 'list', '' AS 'companyname',itemcode as 'mappingcode',surang,'EA' AS 'unit' from Deadline b WHERE idate='$deaddate'
								UNION ALL 
								SELECT '입고' AS 'list', '' AS 'companyname',mappingcode,sum(surang) as 'surang','EA' AS 'unit' from ipgo c WHERE ipgodate='$value' GROUP BY mappingcode
								UNION ALL 
								SELECT '출고' AS 'list', companyname,mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain d WHERE idate ='$value' GROUP BY mappingcode,unit
								UNION ALL
								SELECT '총입고' AS 'list','' AS 'companyname', e.mappingcode,sum(if(e.surang='',0,e.surang)) AS 'surang','EA' AS 'unit' from ipgo e WHERE ipgodate >= '$deaddate' and ipgodate <'$value' GROUP BY mappingcode
								UNION ALL
								SELECT '총출고' AS 'list','' AS 'companyname', mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain f WHERE idate >= '$deaddate' and idate < '$value' GROUP BY mappingcode,unit
								UNION ALL
								SELECT '실사' AS 'list', '' AS 'companyname',itemcode as 'mappingcode',SURANG AS 'surang', 'EA' AS 'unit' from dailycounting g WHERE g.idate='$value'
								)B WHERE a.itemcode = B.mappingcode AND labelY='Y' ".$selectbox." GROUP BY B.mappingcode";
								
							    
								
								/*
								
								
								SELECT  w.mappingcode,w.georae,w.itemcode,w.itemname,w.lek,w.ipsu, if(w.predeadline,w.predeadline,0)+if(w.preipgo,w.preipgo,0)+if(w.prechulgo,w.prechulgo,0) AS 'prestock' ,w.ipgo as 'ipgo',w.CJ as 'cj',w.SPC as 'spc',w.shinsegye,if(w.CJ,w.CJ,0)+if(w.SPC,w.SPC,0)+if(w.shinsegye,w.shinsegye,0) as 'hap' ,
								if(w.predeadline,w.predeadline,0)+if(w.preipgo,w.preipgo,0)+if(w.prechulgo,w.prechulgo,0)+if(w.ipgo,w.ipgo,0)-(if(w.CJ,w.CJ,0)+if(w.SPC,w.SPC,0)+if(w.shinsegye,w.shinsegye,0)) as 'todaystock',if(w.silsa,w.silsa,0) as 'silsa'  FROM (SELECT h.mappingcode,h.georae,h.itemcode,h.itemname,h.lek,h.ipsu,
								i.surang AS 'predeadline',l.surangipgo AS 'preipgo',if(m.unit = 'BOX', m.total*h.ipsu,m.total) AS 'prechulgo',j.surang AS 'ipgo', 
								sum(CASE																														
								WHEN k.companyname = 'CJ' THEN																														
								CASE WHEN k.unit = 'BOX' THEN h.ipsu*k.total 
									 ELSE k.total END																														
								END)AS 'CJ',
								sum(CASE																														
								WHEN k.companyname = 'spc' THEN																														
								CASE WHEN k.unit = 'BOX' THEN h.ipsu*k.total 
									 ELSE k.total END																														
								END)AS 'SPC',
								sum(CASE																														
								WHEN k.companyname = 'shinsegye' THEN																														
								CASE WHEN k.unit = 'BOX' THEN h.ipsu*k.total 
									 ELSE k.total END																														
								END)AS 'shinsegye',n.SURANG AS 'silsa'
								FROM (SELECT a.mappingcode,a.georae,a.itemcode,a.itemname,a.lek,a.ipsu FROM iteminfo a WHERE usingY='Y' ".$selectbox.")h
								LEFT JOIN (SELECT * from Deadline b WHERE idate='$deaddate' )i ON h.itemcode=i.itemcode
								LEFT JOIN (SELECT ipgodate,changocode,itemcode,mappingcode,sum(surang) as 'surang',expiration from ipgo c WHERE ipgodate='$value' GROUP BY itemcode)j ON h.itemcode=j.itemcode
								LEFT JOIN (SELECT companyname, idate,center,itemcode,itemname,sum(chaivalue) AS 'total',unit from labelmain d WHERE idate ='$value' GROUP BY itemcode,unit)k ON h.itemcode=k.itemcode
								LEFT JOIN (SELECT e.itemcode,SUM(if(e.surang='',0,e.surang)) AS 'surangipgo' from ipgo e WHERE ipgodate > '$deaddate' and ipgodate <'$value' GROUP BY itemcode )l ON h.itemcode=l.itemcode
								LEFT JOIN (SELECT companyname, idate,center,itemcode,itemname,sum(chaivalue) AS 'total',unit from labelmain f WHERE idate > '$deaddate' and idate < '$value' GROUP BY itemcode,unit)m ON h.itemcode=m.itemcode
								LEFT JOIN (SELECT itemcode,SURANG from dailycounting g WHERE g.idate='$value')n ON h.itemcode=n.itemcode
								GROUP BY h.mappingcode)w ORDER BY georae DESC,lek desc";
										
								echo $sql;	   
									   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
								*/
								/*
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
								*/
								$sql.=" order by a.lek asc ";

								$stmt = $con->prepare($sql);
							   
							     /*
								$stmt->bindParam(':var_idate',$value);

								if ($stype > 0){
								  $searchtext = '%'.$searchtext.'%';	 

								  $stmt->bindParam(':var_condition',$searchtext);
								}
								
						        */
								
								$stmt->execute();
						 
								if ($stmt->rowCount() > 0)
									{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
									{
									extract($row);
							   
								if ($username != 'admin'){
								?>  
									<tr>  
									<td NOWRAP><?php echo $itemcode; ?></td>
									<td><?php echo $georae; ?></td>
									<td NOWRAP><?php echo $mappingcode;  ?></td> 
									<td><?php echo $itemname;  ?></td>
									<td><?php echo $lek;  ?></td> 
									<td><?php echo $ipsu; ?></td>
									
									<td><?php echo $전일재고; ?></td>
									<td><?php echo $입고; ?></td>
								

									<td><?php echo $CJ; ?></td>
									<td><?php echo $SPC; ?></td>
									<td><?php echo $shinsegye; ?></td>
									<td><?php echo $CJ+$SPC+$shinsegye; ?></td>
									<td><?php echo $전일재고+$입고-($CJ+$SPC+$shinsegye); ?></td>
									<td><?php echo $실사; ?></td>
									<td><?php echo $전일재고+$입고-($CJ+$SPC+$shinsegye)-$실사; ?></td>
									<!--
									<td style="background-color : #FFF9C4"><?php echo $chai; ?></td>
									<td id="boxea"><?php echo $ibox; ?></td>
									<td id="boxea"><?php echo $iea; ?></td>
									<td><?php echo $inventory;?></td>

									-->
									</tr>
								
								<?php
									}
										}
									 }
								?> 
								
								</tbody>
								</table>  
			








              	
				    </div>
				   
	   </section>
       </div>
	   
	    <footer class="footer" style="background-color:#0756b2; color:#ffffff">
        <div class="container">
          <br>
          <div class="row">
            <div class="col-sm-2" style="text-align: center;"><h3>(주)이안로지스</h3></div>
            <div class="col-sm-8">
             본사: 신둔<p>
             제2창고: 백암<p>
             사업자등록번호 :100-00-00000 | TEL:070-0000-0000 | FAX:031-000-0000 | E-mail : dikwon79@naver.com<p>
             COPYRIGHT ⓒ 2020 BY sam , ALL RIGHTS RESERVED.

            </div>
            <div class="col-sm-2" style="text-align: center">
              <div class="list-group">
                <a href="#" class="list-group-item">이메일</a>
                <a href="#" class="list-group-item">본사</a>
                <a href="#" class="list-group-item">지사</a>
              </div>
            </div>
          </div>
        </div>



      </footer>
		
       <?
         //6. 연결 종료
        
		 
		 ?>
		
	
		
 
	</body>
</html> 
