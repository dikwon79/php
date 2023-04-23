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



	
	$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
	$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';
    $tabidinfo = isset($tab) ? $tab : 'first';  // tab 아이디 정보
    
	?>

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
							<a href="ipgo.php" class="list-group-item ">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="paperofinventory2.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item active">수동출고검증</a>
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

					<div class="col-md-10 my-2">
                     
                         
							
							<div id="navhead">
							<form class="navbar" role="search" method="post" action="checktodaywork.php">
							   
							   <div class="col-sm-3">
							   
							   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
							   <div class="col-sm-2">	        
									<select name="stype" class="form-control">
									  <option value='0' <? if($stype =='0') echo "selected"; ?>>전체</option>
									  <option value='1' <? if($stype =='1') echo "selected"; ?>>차수</option>
									</select>
								   
							   </div>
							   <div class="col-sm-4">
								  <select name="chasu" id="chasu" class="form-control">
									  <? for($i=1;$i<31;$i++){ ?>
									  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?>><? echo $i.'차작업'?></option>
									  <?  }  ?>
									  
								</select>
							   
							   </div>
							   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '출고검정')">엑셀저장</button></div>
							 </form>           
							</div>

							<div class="row">
                            <!-- Tab을 구성할 영역 설정-->
								<div style="left-margin:0px;">
								<!-- Tab 영역 태그는 ul이고 클래스는 nav와 nav-tabs를 설정한다. -->
									<ul id="myTab" class="nav nav-tabs">
									<!-- Tab 아이템이다. 태그는 li과 li > a이다. li태그에 active는 현재 선택되어 있는 탭 메뉴이다. -->
									<li class="<?= $tabidinfo == 'first' ? 'active' : '' ?>"><a href="#first" data-toggle="tab">검증</a></li>
									<!-- a 태그의 href는 아래의 tab-content 영역의 id를 설정하고 data-toggle 속성을 tab으로 설정한다. -->
									<li class="<?= $tabidinfo == 'data' ? 'active' : '' ?>"><a href="#data" data-toggle="tab">세부데이타</a></li>
									
									
									</ul>
								
								<!-- Tab이 선택되면 내용이 보여지는 영역이다. -->
								<!-- 태그는 div이고 class는 tab-content로 설정한다. -->
								<div class="tab-content">
									<!-- 각 탭이 선택되면 보여지는 내용이다. 태그는 div이고 클래스는 tab-pane이다. -->
									<!-- active 클래스는 현재 선택되어 있는 탭 영역이다. -->
									<div class="<?= $tabidinfo == 'first' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="first">
										 <!-- 첫번째 탭 내용 -->
										
										  <? include('upload_chulgocheck.php'); ?>
													
										
					
									</div>
									<div class="<?= $tabidinfo == 'data' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="data">
									<!--<div style="overflow-y:scroll;height:200px;"> -->
										   <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
											<thead>  
											<tr>  
												<th>회사명</th> 
												<th>거래처</th> 
												<th>작업날짜</th> 
												<th>맵핑코드</th> 
												<th style=width:300px>품목명</th>
												<th>수량</th>
												<th>단위</th>
												<th>센터</th>
												<th>차수</th>
												<th>업장명</th>
												<th>원수량</th>
												<th>원단위</th>
												
												
											</tr>  
											</thead>  
													   
											<?php  
											//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
											//0717$sql = "SELECT y.companyname,y.idate,if(a.mappingcode is not null,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) as 'code',y.itemname,if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue) AS 'surang','EA' as 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain where idate=:var_idate)y ON a.itemcode = y.itemcode";
											
											$sql = "SELECT h.companyname,h.georae,h.idate,h.code,h.itemname,h.surang,h.danwi,b.printinfo,h.center,h.chasu,h.customer,h.chaivalue,h.unit 
											from(SELECT y.companyname,if(a.georae is NULL,'미등록', a.georae) AS 'georae',y.idate,
											if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',
											if(a.itemname is NULL,y.itemname,a.itemname) AS 'itemname',if(a.itemname is NULL, chaivalue, 
											if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue)) AS 'surang',if(a.itemname IS NULL, y.unit, 'EA') AS 'danwi',
											y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a 
											RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain_copy 
											WHERE idate=:var_idate)y ON a.itemcode = y.itemcode)h 
											LEFT JOIN print_info b ON h.center = CONCAT(b.center,' / ',b.centername)";
											
											/*
											$sql = "SELECT y.companyname,y.idate,if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',y.itemname,if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue) AS 'surang','EA' AS 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit
													FROM (
													SELECT *
													FROM iteminfo)a
													RIGHT JOIN (
													SELECT TYPE, companyname,idate,itemcode,itemname,sum(chaivalue) AS 'chaivalue',unit,center,chasu,'센터별합' AS 'customer'
													FROM labelmain
													WHERE idate=:var_idate AND TYPE ='신규' GROUP BY center,itemcode,unit,chasu 
													UNION ALL
													SELECT TYPE, companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer
													FROM labelmain
													WHERE idate=:var_idate AND TYPE !='신규')y ON a.itemcode = y.itemcode";
											
											*/
											//$sql = "SELECT idate,itemcode,itemname,chaivalue,unit,center,chasu,customer,bar2 FROM labelmain where idate=:var_idate";
											
										    //echo $sql;   
												   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
											
											//$sql = "SELECT y.companyname,y.idate,if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',y.itemname,sum(if(y.unit='BOX',if(packsu is NULL, y.chaivalue, y.chaivalue*a.packsu),y.chaivalue)) AS 'surang','EA' AS 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (
                                                  //  SELECT * FROM iteminfo)a RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain WHERE idate=:var_idate)y ON a.itemcode = y.itemcode GROUP BY y.chasu,code,y.center"; 


											$stmt = $con->prepare($sql);

											$stmt->bindParam(':var_idate',$value);


											
											$stmt->execute();

											if ($stmt->rowCount() > 0)
												{
													while($row=$stmt->fetch(PDO::FETCH_ASSOC))
												{
												extract($row);
										   
											if ($username != 'admin'){
											?>  
												<tr>  
												<td><?php echo $companyname; ?></td>
												<td><?php echo $georae; ?></td>
												<td><?php echo $idate; ?></td>
												<td><?php echo $code; ?></td>
											
												<td><?php echo $itemname;  ?></td>
												<td><?php echo $surang;  ?></td> 
												<td><?php echo $danwi; ?></td>
												
												<td><?php echo $printinfo; ?></td>
												<td><?php echo $chasu; ?></td>
												<td><?php echo $customer; ?></td>
												<td><?php echo $chaivalue; ?></td>
												<td><?php echo $unit; ?></td>
												
												</tr>
											
											<?php
												}
													}
												 }
											?>  
											</table>  	  
												</div>
											</div>
											
								
			
							</div>

						
              	
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