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
 
    include('headipgo.php');
	
	//$nowdate =date("Y-m-d");
	$nowdate = isset($_POST['ndate']) ? $_POST['ndate'] : date("Y-m-d");  // tab 아이디 정보
	
	?>
<!DOCTYPE html>
<html>
	<head>
	    <link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>

        <script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>

		<script type="text/javascript">
            $(document).ready(function(){
			  $("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });

               $(function(){
	
	
				$("#datePicker").datepicker({
					onSelect:function(dateText, inst) {
						console.log(dateText);
						console.log(inst);
					}
				});
			});



			});

            function modifylabel(option) {
           
             
            var popupWidth = 400;
			var popupHeight = 500;
			
			var popupX = (window.screen.width / 2) - (popupWidth / 2);
			// 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

			var popupY= (window.screen.height / 2) - (popupHeight / 2);
			// 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음
           

			num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=400, width=500, left='+ popupX + ', top='+ popupY;

			 

			 var idnumber = document.getElementById('id').value;
			 var root = 'labelorder_modify.php' + '?item='+idnumber;
			 var type = '품목검색'
			 num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=500, width=1000, left='+ popupX + ', top='+ popupY;

		
			//root = root + '?processdate='+processdate+'&chasu='+value;
			
			window.open(root, type, num);   

		   }

            


		
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
							<a href="ipgodetail.php" class="list-group-item">입고현황</a>
							<a href="3pl.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
							<a href="chulgolist.php" class="list-group-item">업장출고내역</a>
							<a href="chagelist.php" class="list-group-item active">변경분리스트</a>
						
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
							<form class="navbar" role="search" method="post" action="chagelist.php">
							   
							   <div class="col-sm-3">
							   
							   
							   <input type="text" name="ndate" id="datePicker" size="30" value='<? echo $nowdate; ?>'/>
									   <input type="button" value="달력" onclick="$('#datePicker').datepicker('show');" />
									   </div>
							   <div class="col-sm-2">	        
									<select name="stype" class="form-control">
									  <option value='0' <? if($stype =='0') echo "selected"; ?>>전체</option>
									  <option value='1' <? if($stype =='1') echo "selected"; ?>>차수</option>
									</select>
								   
							   </div>
							   <div class="col-sm-4">
								  <select name="chasu" id="chasu" class="form-control">
									  <? for($i=1;$i<31;$i++){ ?>
									  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?><? echo $i.'차작업'?></option>
									  <?  }  ?>
									  
								</select>
							   
							   </div>
							   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '변경리스트')">엑셀저장</button></div>
							 </form>           
							</div>

							<div class="row">



							<table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
								<thead>  
								<tr>  
									<th>구분</th> 
									<th>제품코드</th> 
									<th style=width:300px>품목명</th>
									<th>납품처명</th>  
									<th>센터</th>
									<th>사전수량</th>
									<th>현재수량</th>
									<th>단위</th>
									<th>차량번호</th>
									<th>보관</th>
									<th>업장명</th>
									
									
								</tr>  
								</thead>  

								<?php  
								//$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
								//$sql = "SELECT y.companyname,y.idate,y.itemcode,y.itemname,if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue) AS 'surang','EA' as 'danwi',y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain where idate=:var_idate)y ON a.itemcode = y.itemcode";
								
								
								//$sql = "SELECT U.TYPE ,U.itemcode,U.itemname,U.customer, concat(U.printinfo,'/',U.chasu,'차') as 'center',U.surang1,U.surang2,U.unit,U.cha2,U.mcondition,a.georae FROM (SELECT TYPE ,itemcode,itemname,customer, e.printinfo,chasu,surang1,surang2,unit,cha2,mcondition  from(SELECT * FROM labelmain WHERE (TYPE!='신규') AND idate=:var_idate ORDER BY companyname ASC,chasu asc,TYPE ASC)T LEFT JOIN 
								//print_info e on T.center = concat(e.center,' / ',e.centername))U LEFT JOIN iteminfo a ON a.itemcode = U.itemcode ORDER BY mcondition asc,printinfo ASC,georae asc";
							    
								$sql = "SELECT U.TYPE ,U.itemcode,U.itemname,U.customer, concat(U.printinfo,'/',U.chasu,'차') as 'center',U.surang1,U.surang2,U.unit,U.cha2,U.mcondition,if(U.mcondition='냉장','실온',U.mcondition) AS 'conditionimsi',a.georae FROM (SELECT TYPE ,itemcode,itemname,customer, e.printinfo,chasu,surang1,surang2,unit,cha2,mcondition  from(SELECT * FROM labelmain WHERE (TYPE!='신규' and TYPE!='*증가') AND idate=:var_idate ORDER BY chasu asc)T LEFT JOIN 
								print_info e on T.center = concat(e.center,' / ',e.centername))U LEFT JOIN iteminfo a ON a.itemcode = U.itemcode ORDER BY chasu asc";
								//$sql = "SELECT * FROM labelmain WHERE (TYPE!='신규' AND TYPE!='*증가') AND idate=:var_idate ORDER BY companyname ASC,chasu asc,TYPE ASC";
								//$sql = "SELECT idate,itemcode,itemname,chaivalue,unit,center,chasu,customer,bar2 FROM labelmain where idate=:var_idate";
								
									   
									   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
								
							
								$stmt = $con->prepare($sql);

								$stmt->bindParam(':var_idate',$nowdate);


								//echo $sql;
								$stmt->execute();

								if ($stmt->rowCount() > 0)
									{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
									{
									extract($row);
							   
								if ($username != 'admin'){
								?>  
									<input type='hidden' id='id' value='<?=$id?>'>
									<tr>
									<td><?php echo $type; ?></td>
									<td onclick='modifylabel()'><?php echo $itemcode;  ?></td>
									<td><?php echo $itemname; ?></td>
									<td><?php echo $customer; ?></td>
									<td><?php echo $center;  ?></td>
									<td><?php echo $surang1;  ?></td> 
									<td><?php echo $surang2; ?></td>
									<td><?php echo $unit; ?></td>
									<td><?php echo $cha2; ?></td>
									<td><?php echo $conditionimsi.'('.$mcondition.')'; ?></td>
									<td><?php echo $georae; ?></td>
								
									
									</tr>
								
								<?php
									}
										}
									 }
								?>  
								</table>  
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
