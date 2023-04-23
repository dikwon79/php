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
 
    include('headitem.php');?>
<!DOCTYPE html>
<html>
	<head>
		
   

        <script type="text/javascript">
            $(document).ready(function(){
			  $("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });
			});

            


		
		</script>
		
        <style>
        
		  html {
			height: 100%;
			}
			body {
			margin: 0;
			height: 100%;
			
		
			}
			#navhead{
         
             margin-left :-40; 
             margin-right :0; 
		

		}
			section{
			   position :relative;
			   min-height:100%; 
			}
			footer {
			position: relative;
			bottom: 0;
			left: 0;
			right: 0;
			color: white;
			background-color: #333333;
			}
            .container{
			   width : 95%;
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
							<a href="index.html" class="list-group-item">월별통계</a>
							<a href="setting.html" class="list-group-item">setting</a>
						
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
                              
							   <div class="col-sm-3">
                                  
							   <h1 class="h2">&nbsp;재고장</h1>
						
							   </div>
							
							   <div class="col-sm-3">
							   
							   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
							 
							   <div class="col-sm-3"><input type="text" name="itext" id="myInput" class="form-control" placeholder="Search" value="<? if($searchtext) echo $searchtext  ?>"></div>
							   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '재고장')">엑셀저장</button></div>
							 </form>           
						   </div>
						   
						   <div class="row">
						   

							
							<table  class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
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

								$sql = "SELECT idate FROM Deadline ORDER BY idate desc limit 1";

								$stmt = $con->prepare($sql);

								$stmt->execute();
									   
									

								$row = $stmt->fetch();  
								$deaddate = $row['idate'];
								//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
								$sql = "SELECT  w.mappingcode,w.georae,w.itemcode,w.itemname,w.lek,w.ipsu, if(w.predeadline,w.predeadline,0)+if(w.preipgo,w.preipgo,0)+if(w.prechulgo,w.prechulgo,0) AS 'prestock' ,w.ipgo as 'ipgo',w.CJ as 'cj',w.SPC as 'spc',w.shinsegye,if(w.CJ,w.CJ,0)+if(w.SPC,w.SPC,0)+if(w.shinsegye,w.shinsegye,0) as 'hap' ,
								if(w.predeadline,w.predeadline,0)+if(w.preipgo,w.preipgo,0)+if(w.prechulgo,w.prechulgo,0)+if(w.ipgo,w.ipgo,0)-(if(w.CJ,w.CJ,0)+if(w.SPC,w.SPC,0)+if(w.shinsegye,w.shinsegye,0)) as 'todaystock',if(w.silsa,w.silsa,0) as 'silsa'  FROM (SELECT h.mappingcode,h.georae,h.itemcode,h.itemname,h.lek,h.ipsu,
								i.surang AS 'predeadline',l.surang AS 'preipgo',if(m.unit = 'BOX', m.total*h.ipsu,m.total) AS 'prechulgo',j.surang AS 'ipgo', 
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
								FROM (SELECT a.mappingcode,a.georae,a.itemcode,a.itemname,a.lek,a.ipsu FROM iteminfo a WHERE usingY='Y')h
								LEFT JOIN (SELECT * from Deadline b WHERE idate='$deaddate' )i ON h.itemcode=i.itemcode
								LEFT JOIN (SELECT * from ipgo c WHERE ipgodate='$value' )j ON h.itemcode=j.itemcode
								LEFT JOIN (SELECT companyname, idate,center,itemcode,itemname,sum(surang2) AS 'total',unit from labelmain d WHERE idate ='$value' GROUP BY itemcode,unit)k ON h.itemcode=k.itemcode
								LEFT JOIN (SELECT * from ipgo e WHERE ipgodate > '$deaddate' and ipgodate <'$value' )l ON h.itemcode=l.itemcode
								LEFT JOIN (SELECT companyname, idate,center,itemcode,itemname,sum(surang2) AS 'total',unit from labelmain f WHERE idate > '$deaddate' and idate < '$value' GROUP BY itemcode,unit)m ON h.itemcode=m.itemcode
								LEFT JOIN (SELECT itemcode,SURANG from dailycounting g WHERE g.idate='$value')n ON h.itemcode=n.itemcode
								GROUP BY h.mappingcode)w ORDER BY georae DESC,lek desc";
										
								//echo $sql;	   
									   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
								
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
								
								$sql.=" order by a.lek asc "; */

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
									<td NOWRAP><?php echo $mappingcode; ?></td>
									<td><?php echo $georae; ?></td>
									<td NOWRAP><?php echo $itemcode;  ?></td> 
									<td><?php echo $itemname;  ?></td>
									<td><?php echo $lek;  ?></td> 
									<td><?php echo $ipsu; ?></td>
									
									<td><?php echo $prestock; ?></td>
									<td><?php echo $ipgo; ?></td>
								

									<td><?php echo $cj; ?></td>
									<td><?php echo $spc; ?></td>
									<td><?php echo $shinsegye; ?></td>
									<td><?php echo $hap; ?></td>
									<td><?php echo $todaystock; ?></td>
									<td><?php echo $silsa; ?></td>
									<td><?php echo $todaystock-$silsa; ?></td>
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
								<tr><td colspan='15'>&nbsp;</td></tr>
								<tr><td colspan='15'>&nbsp;</td></tr>
								<tr><td colspan='15'>&nbsp;</td></tr>
								<tr><td colspan='15'>&nbsp;</td></tr>
								<tr><td colspan='15'>&nbsp;</td></tr>
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