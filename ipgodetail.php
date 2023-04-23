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
             function setagain(){
                var xmlhttp=new XMLHttpRequest();
				var inameD= "side";
		  
			    xmlhttp.open("GET","setting_inc.php?code="+document.getElementById("comcode").value+"&companyname="+document.getElementById("comname").value+"&colnum="+document.getElementById("comnum").value+"&centername="+document.getElementById("centername").value+"&centercode="+document.getElementById("centercode").value+"&printorder="+document.getElementById("printorder").value,false);
				xmlhttp.send(null);
		    	document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

			 }
			 function change(num){
			    var xmlhttp=new XMLHttpRequest();
			 	var inameD= "side";
		        alert(num);
			    xmlhttp.open("GET","setting_del.php?pid="+num,true);
				xmlhttp.send(null);
		    	document.getElementById(inameD).innerHTML=xmlhttp.responseText;;
			 }
			 function form_modify(id,geoname,changoname)
			 {
                 
				 
                 location.href="ipgolist_modify.php?processdate=" + id +"&geoname="+geoname+"&changoname="+changoname;

			 }
			 function form_print(id)
			 {
				    
					
					
					var popupWidth = 800;
					var popupHeight = 900;
					var processdate = id;
					
					root = 'form_print.php' + '?processdate='+processdate;
					var popupX = (window.screen.width / 2) - (popupWidth / 2);
					// 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

					var popupY= (window.screen.height / 2) - (popupHeight / 2);
					// 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음


					 num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=800, width=1000, left='+ popupX + ', top='+ popupY;
					
					window.open(root, '전표인쇄', num);   
			 }
			 function excelmodeclick(){
                 
                  location.href="../ipgodetail.php";

			 }
			 function today(){
                 $('input[id=today1]').attr('value', format(new Date())); // 종료 날짜를 현재 날짜로 업데이트합니다.
				 $('input[id=today2]').attr('value', format(new Date())); // 종료 날짜를 현재 날짜로 업데이트합니다.
				
			 }
			 function format (date) {  
			  if (!(date instanceof Date)) {
				throw new Error('Invalid "date" argument. You must pass a date instance')
			  }

			  const year = date.getFullYear()
			  const month = String(date.getMonth() + 1).padStart(2, '0')
			  const day = String(date.getDate()).padStart(2, '0')

			  return `${year}-${month}-${day}`
			 }

			 function getDateOneMonthAgo() {
			  var now = new Date();
			  var oneMonthAgo = new Date(now.getFullYear(), now.getMonth() - 1, now.getDate());
			  return oneMonthAgo;
			 }

             function handleOneMonthAgoButton() {
			  var oneMonthAgo = getDateOneMonthAgo();
			  var formattedDate = format(oneMonthAgo); // formatDate 함수는 날짜를 원하는 형식으로 포맷하는 함수입니다.
              
			  // 필요한 요소들을 업데이트합니다.
			  $('input[id=today1]').attr('value', formattedDate); // 시작 날짜 업데이트
			  $('input[id=today2]').attr('value', format(new Date())); // 종료 날짜를 현재 날짜로 업데이트합니다.
			  
			}
			 function getDateOneYearAgo() {
			   var now = new Date();
			   var oneYearAgo = new Date(now.getFullYear() - 1, now.getMonth(), now.getDate());
			   return oneYearAgo;
			 }

             function handleOneYearAgoButton() {
			  var oneYearAgo = getDateOneYearAgo();
			  var formattedDate = format(oneYearAgo); // formatDate 함수는 날짜를 원하는 형식으로 포맷하는 함수입니다.
             
			  // 필요한 요소들을 업데이트합니다.
			  $('input[id=today1]').attr('value', formattedDate); // 시작 날짜 업데이트
			  $('input[id=today2]').attr('value', format(new Date())); // 종료 날짜를 현재 날짜로 업데이트합니다.
			  
			}




			 function search(){
				let day3 = document.getElementById('today1').value;
				let day4 = document.getElementById('today2').value;
				let search = document.getElementById('search').value;
				location.href="http://dikwon79.cafe24.com/ipgodetail.php?search="+ search + "&today1=" + day3 +"&today2="+day4+"&tsearch=0";
			 }
		
		</script>
		
         <style>
        .container{ 
          width : 95%;

    }
	
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

			#excelmode {
              left : 40%;
			  text-align:right;
			  
			}
            .table{
			 margin-top : 20px;
		
			 overflow: auto;
			}
			.btn{
				margin-right : 10px;
			}
			#table {
			 border-collapse: collapse;
			 border-top: 3px solid #168;
			}  
			#table th {
			color: #168;
			background: #f0f6f9;
			text-align: center;
			}
			#table th, .table td {
			  padding: 10px;
			  border: 1px solid #ddd;
			}
			#table th:first-child, .table td:first-child {
			  border-left: 0;
			}
			#table th:last-child, .table td:last-child {
			  border-right: 0;
			}
			#table tr td:first-child{
			  text-align: center;
			}
			#table caption{caption-side: bottom; display: none;}
			#hidetxt{
				font-size : 0.5em;
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
							<a href="ipgodetail.php" class="list-group-item active">입고현황</a>
							<a href="3pl.php" class="list-group-item">재고장</a>
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

					<div class="col-md-10 my-2">
                    <?php
                        
						$today1 = isset($_GET['today1']) ? $_GET['today1'] : date("Y-m-d");  // tab 아이디 
						$today2 = isset($_GET['today2']) ? $_GET['today2'] : date("Y-m-d");  // tab 아이디 정보
                        $tsearch = isset($_GET['tsearch']) ? $_GET['tsearch'] : "0";  
						$search = isset($_GET['search']) ? $_GET['search'] : "";
                         
						echo $search;
						
						if($today1 == $today2) $tsearch=1;
						else $tsearch=0;
						?>


                        <div class="col-md-10">
						    <div class="form-inline">
						        <div class="form-group">
								<label>기간 조회:</label>
								<input type="date" name='today1' id="today1"
									class="form-control input-sm ng-pristine ng-untouched ng-valid" ng-model="startDate"
									value="<?=$today1?>">
								<input type="date" name='today2' id="today2" class="form-control input-sm ng-pristine ng-valid ng-touched"
									ng-model="endDate" value="<?=$today2?>">
                                
								<div class="btn-group">
					            <span class="btn btn-success input-sm" onclick="handleOneYearAgoButton()" >1년</span>
								<span class="btn btn-success input-sm" onclick="handleOneMonthAgoButton()" >1개월</span>
								<span class="btn btn-success input-sm" onclick="today()" >당일</span>
								</div>
								<input type="text" name="search" id="search" height="30" size = "40" placeholder="품목코드 or 품목명검색">
                                <div class="btn-group">
								<span class="btn btn-success input-sm" onclick="search('1')">조회</span>																				
								<span class="btn btn-success input-sm" onclick="fnExcelReport('table', '입고현황')" >Excel</span>
								
							
								</div>
								
								
								
                                </div>
							</div>
						</div>					
						<div class="col-md-2" style="padding-top: 10px">
                        
                        </div>    

						<?php 
                        
					    if ($search ==""){
							$sql = "select pid from ipgo where ipgodate >= '".$today1."' and ipgodate <= '".$today2."' order by ipgodate desc,ipgonum desc";
					   

						}else{
                            $sql = "select pid from ipgo where (itemcode ='".$search."' or  itemname='".$search."') and ipgodate >= '".$today1."' and ipgodate <= '".$today2."' order by ipgodate desc,ipgonum desc";
					   
						}
						$stmt = $con->prepare($sql);

                        $stmt->execute();
						$num=$stmt->rowCount();	   
                        $page = isset($_GET['page'])?$_GET['page']:1;
     
                        
  
                       
					    $list=13;
						$block = 3;
					    $pageNum = ceil($num/$list); // 총 페이지
					    $blockNum = ceil($pageNum/$block); // 총 블록
					    $nowBlock = ceil($page/$block);


												
						$s_page = ($nowBlock * $block) - 2;

						if ($s_page <= 1) {
							$s_page = 1;
						}

						$e_page = $nowBlock*$block;
						if ($pageNum <= $e_page) {
							$e_page = $pageNum;
						}



                        $s_point = ($page-1) * $list;



                        //$sql = "SELECT * FROM ipgo where itemname LIKE '%$search_word%' "; 
                        //if($tsearch =="0"){
						//$sql = "select ipgodate as 'seq' ,geocode, geoname, itemname as 'title', surang as 'tsurang' ,hap as 'total' ,changocode,changoname,'회계','인쇄',charger from ipgo where ipgodate >= '".$today1."' and ipgodate <= '".$today2."' order by ipgodate desc,ipgonum desc limit  $s_point ,$list";
						
					    //}else{

						if ($search ==""){

							$sql = "select ipgodate as 'seq',itemcode ,geocode, geoname, itemname as 'title', surang as 'tsurang' ,hap as 'total' ,changocode,changoname,'회계',expiration,etc from ipgo where ipgodate >= '".$today1."' and ipgodate <= '".$today2."' order by ipgodate desc,ipgonum desc";
						

						}else{
                            $sql = "select ipgodate as 'seq',itemcode ,geocode, geoname, itemname as 'title', surang as 'tsurang' ,hap as 'total' ,changocode,changoname,'회계',expiration,etc from ipgo where (itemcode ='".$search."' or  itemname like '%".$search."%') and ipgodate >= '".$today1."' and ipgodate <= '".$today2."' order by ipgodate desc,ipgonum desc";
						
						}

						//}
                      
				



						// 테이블 생성?>
                        <div style="width:100%; height:600px; overflow:auto">
						<table id ="table" class="table table-striped table-bordered table-hover">
						  <thead>
							<tr>
					
							  <th scope="col">전표날짜</th>

						      <th scope="col">품목코드</th>
							  <th scope="col">품목명*입수</th>
                              <th scope="col">수량합</th>
                              <th scope="col">거래처명</th>
							  							
																					  
							  <th scope="col">유통기한</th>
							  <th scope="col">인쇄</th>
							  <th scope="col">비고</th>
							 
						
							</tr>
						  </thead>
						  <tbody>
					
					    
						
						<?
                               $s=1;
		   					   $stmt = $con->prepare($sql);

                               $stmt->execute();
							   



							   if ($stmt->rowCount() > 0)
							   {
								
								  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
								  {
									    extract($row); 
                       
								
										echo '<tr>';
								
										echo '<td>'.$seq.'</td>';
										
                                        echo '<td>'.$itemcode.'</td>';
										echo "<td>".$title.'</td>';
										echo '<td>'.$tsurang.'</td>';
										echo '<td>'.$geoname.'</td>';
										
										
										
										
										
										echo '<td>'.$expiration.'</td>';
										echo "<td onclick='form_print(\"$seq\");'>".'인쇄
										'.'</td>';
										

										echo '<td>'.$etc.'</td>';
                                       
										?>

                                        
										<?
										
										echo '</tr>';
				
                                    
						          }
							   }
                          ?>
						  <tbody>
						</table>
			            </div>
                        
						<!--

						<? if($tsearch =="0"){ ?> 
					   
						   <div class="col-md-12 text-center">
						    <ul class="pagination">


							<li class="page-item"><a class="page-link" href="?page=<? if($s_page-1<0){ echo "1";
								
							}else{  echo $s_page;
								
							}?>">Previous</a></li>
							
							<?
							for ($p=$s_page; $p<=$e_page; $p++) {
                            ?>


							
							<li class="page-item"><a class="page-link" href="?today1=<?=$today1?>&today2=<?=$today2?>&page=<?=$p?>"><?=$p?></a></li>
						     
							 <? } ?>
							<li class="page-item"><a class="page-link" href="?today1=<?=$today1?>&today2=<?=$today2?>&page=<? if($e_page+1 >$pageNum) { echo $pageNum; }
							 else {echo $e_page+1;}?>">Next</a></li>
							</ul>
						   </div> 
						
						 <? } ?>											
						
				    </div>
				  -->


	    
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
