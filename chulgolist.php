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
	

	$nowdate = isset($_POST['sdate']) ? $_POST['sdate'] : date("Y-m-d H:i:s", strtotime("-1 week")); // 일주일 전;  // tab 아이디 정보
	$nowdate2 = isset($_POST['edate']) ? $_POST['edate'] : date("Y-m-d");  // tab 아이디 정보
	
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

              $.datepicker.regional['ko'] = {
						closeText: '닫기',
						prevText: '이전달',
						nextText: '다음달',
						currentText: '오늘',
						monthNames: ['1월(JAN)','2월(FEB)','3월(MAR)','4월(APR)','5월(MAY)','6월(JUN)',
						'7월(JUL)','8월(AUG)','9월(SEP)','10월(OCT)','11월(NOV)','12월(DEC)'],
						monthNamesShort: ['1월','2월','3월','4월','5월','6월',
						'7월','8월','9월','10월','11월','12월'],
						dayNames: ['일','월','화','수','목','금','토'],
						dayNamesShort: ['일','월','화','수','목','금','토'],
						dayNamesMin: ['일','월','화','수','목','금','토'],
						weekHeader: 'Wk',
						dateFormat: 'yy-mm-dd',
						firstDay: 0,
						isRTL: false,
						showMonthAfterYear: true,
						yearSuffix: '',
						showOn: 'both',
						buttonText: "달력",
						changeMonth: true,
						changeYear: true,
						showButtonPanel: true,
						yearRange: 'c-99:c+99',
					};
					$.datepicker.setDefaults($.datepicker.regional['ko']);

					$('#sdate').datepicker();
					$('#sdate').datepicker("option", "maxDate", $("#edate").val());
					$('#sdate').datepicker("option", "onClose", function ( selectedDate ) {
						$("#edate").datepicker( "option", "minDate", selectedDate );
					});

					$('#edate').datepicker();
					$('#edate').datepicker("option", "minDate", $("#sdate").val());
					$('#edate').datepicker("option", "onClose", function ( selectedDate ) {
						$("#sdate").datepicker( "option", "maxDate", selectedDate );
					});






			});

            


		
		</script>
        <link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>
        <script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>
       
		
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
							<a href="chulgolist.php" class="list-group-item active">업장출고내역</a>
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

						if(empty($_REQUEST["search_word"])){ // 검색어가 empty일 때 예외처리를 해준다.
						$search_word ="";

						}else{

						$search_word =$_REQUEST["search_word"];

						}

						?>



						<form class="navbar-form pull-left" method="post" action=""> <!-- action 을 비워놔야 자신을 가리킨다 -->
                        <input type="text" name="sdate" id="sdate" class="form-control" size="30" value='<? echo $nowdate; ?>'/>  -  
						<input type="text" name="edate" id="edate" class="form-control" size="30" value='<? echo $nowdate2; ?>'/>
						<input type="text" size="40" name="search_word" class="form-control" value="<?=$search_word?>" placeholder="품목코드,명,업장검색 입력 후 enter" autofocus>
                        <button type="submit" class="btn btn-primary">조회</button>

                        &nbsp;
						<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '업장출고내역')">엑셀저장</button>

						</form>
						


						<?php 
                        
					    $sql = "SELECT x.deaddate, x.companyname,x.center,x.itemcode,x.itemname,x.customer,x.hap,x.unit,a.ipsu FROM (SELECT deaddate, companyname,center,itemcode,itemname,customer,sum(chaivalue) as 'hap',unit FROM labelmain where customer like '%$search_word%' and idate >='$nowdate' and idate <='$nowdate2'
                                    GROUP BY deaddate,itemcode,customer,unit)x left join iteminfo a on x.itemcode = a.itemcode";
					    $stmt = $con->prepare($sql);
						//cho $sql;
                        $stmt->execute();
						$num=$stmt->rowCount();	   
                        $page = isset($_GET['page'])?$_GET['page']:1;
     
                        
  
                       
					    $list=25;
						$block = 6;
					    $pageNum = ceil($num/$list); // 총 페이지
					    $blockNum = ceil($pageNum/$block); // 총 블록
					    $nowBlock = ceil($page/$block);

                  
												
						$s_page = ($nowBlock * $block) - 5;

						if ($s_page <= 1) {
							$s_page = 1;
						}

						$e_page = $nowBlock*$block;
						//echo $e_page;
						if ($pageNum <= $e_page) {
							$e_page = $pageNum;
						}



                        $s_point = ($page-1) * $list;



                        //$sql = "SELECT * FROM ipgo where itemname LIKE '%$search_word%' "; 

					    if ($search_word)
						{   
							 
                             
							  $sql = "SELECT x.deaddate,x.idate, x.companyname,x.center,x.itemcode,x.itemname,x.customer,x.hap,x.unit,a.ipsu, 
							CONCAT(if(a.ipsu is not NULL,(x.hap div a.ipsu),0),' / ',if(a.ipsu is not NULL,(x.hap mod a.ipsu),x.hap)) as 'PT' 
							FROM (SELECT deaddate,idate, companyname,center,itemcode,itemname,customer,sum(chaivalue) as 'hap',unit FROM labelmain 
                                     where (customer like '%$search_word%' or itemname like '%$search_word%'  or itemcode like '%$search_word%') and idate >='$nowdate' and idate <='$nowdate2' GROUP BY deaddate,itemcode,customer,unit order by deaddate desc)x left join iteminfo a on x.itemcode = a.itemcode order by x.idate desc,center desc";
							
							
						   // $sql = "SELECT * FROM (SELECT deaddate, companyname,center,itemcode,itemname,customer,sum(chaivalue) as 'hap',unit FROM labelmain 
                                   // GROUP BY deaddate,itemcode,customer,unit)x  where customer like '%$search_word%'  order by deaddate desc  limit  $s_point ,$list";
						}
						else{
                            $sql = "SELECT x.deaddate,x.idate, x.companyname,x.center,x.itemcode,x.itemname,x.customer,x.hap,x.unit,a.ipsu, 
							CONCAT(if(a.ipsu is not NULL,(x.hap div a.ipsu),0),' / ',if(a.ipsu is not NULL,(x.hap mod a.ipsu),x.hap)) as 'PT' 
							FROM (SELECT deaddate,idate, companyname,center,itemcode,itemname,customer,sum(chaivalue) as 'hap',unit FROM labelmain where idate >='$nowdate' and idate <='$nowdate2'
                                    GROUP BY deaddate,itemcode,customer,unit order by deaddate desc  limit  $s_point ,$list)x left join iteminfo a on x.itemcode = a.itemcode order by x.idate desc,center desc";


						}
                      
					



						// 테이블 생성?>
                     
						<table id='table' class="table table-striped table-bordered table-hover">
						  <thead>
							<tr>
							  <th scope="col">작업일자</th>	
							  <th scope="col">출고일자</th>
							  <th scope="col">업체</th>
							  <th scope="col">센터명</th>
							  <th scope="col">품목코드</th>
                              <th scope="col">품목명</th>
                            							
																					  
							  <th scope="col">업장명</th>
							  <th scope="col">수량</th>
                              <th scope="col">단위</th>
                              
                              <th  NOWRAP>PT</th>

 
							  


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
									    echo '<td NOWRAP>'.$idate.'</td>';
										echo '<td NOWRAP>'.$deaddate.'</td>'; 
										
										echo '<td>'.$companyname.'</td>';
										echo '<td>'.$center.'</td>';
										echo '<td>'.$itemcode.'</td>';
										
										
										echo '<td>'.$itemname.'</td>';
										echo '<td>'.$customer.'</td>';
										echo '<td>'.$hap.'</td>';
										

										echo '<td>'.$unit.'</td>';
										
                                        echo '<td NOWRAP>'.$PT.'</td>';
									
										
										
										echo '</tr>';
										$s=$s+1;
                                    
						          }
							   }
                          ?>
						  <tbody>
						</table>
			
                        


						
					   
						   <div class="col-md-12 text-center">
						    <ul class="pagination">


							<li class="page-item"><a class="page-link" href="?page=<? if($s_page-1<0){ echo "1";
								
							}else{  echo $s_page-1;
								
							}?>">Previous</a></li>
							
							<?
							for ($p=$s_page; $p<=$e_page; $p++) {
                            ?>


							
							<li class="page-item"><a class="page-link" href="?page=<?=$p?>"><?=$p?></a></li>
						     
							 <? } ?>
							<li class="page-item"><a class="page-link" href="?page=<? if($e_page+1 >$pageNum) { echo $pageNum; }
							 else {echo $e_page+1;}?>">Next</a></li>
							</ul>
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
