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
            
	
	</style>
	</head>



	<body>

       <div class="container">
       <section id="main">
			
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item">라벨발행</a>
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item active">입고조회</a>
							<a href="ipgodetail.php" class="list-group-item">입고현황</a>
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

						if(empty($_REQUEST["search_word"])){ // 검색어가 empty일 때 예외처리를 해준다.
						$search_word ="";

						}else{

						$search_word =$_REQUEST["search_word"];

						}

						?>


                        <div class="col-md-10">
						<form class="navbar-form pull-left" method="get" action=""> <!-- action 을 비워놔야 자신을 가리킨다 -->

						<input type="text" size="40" name="search_word" class="form-control" placeholder="검색어를 입력 후 enter를 누르세요" autofocus>

						</form>
						</div>
						<div class="col-md-2" style="padding-top: 10px">
                        <button class="btn btn-warning" id="excelmode" onclick="excelmodeclick()">엑셀전환모드</button>
                        </div>    

						<?php 
                        
					    $sql = "select pid from ipgo where itemname like '%$search_word%' group by ipgodate,ipgonum order by ipgodate desc,ipgonum desc";
					    $stmt = $con->prepare($sql);

                        $stmt->execute();
						$num=$stmt->rowCount();	   
                        $page = isset($_GET['page'])?$_GET['page']:1;
     
                        
  
                       
					    $list=13;
						$block = 8;
					    $pageNum = ceil($num/$list); // 총 페이지
					    $blockNum = ceil($pageNum/$block); // 총 블록
					    $nowBlock = ceil($page/$block);


												
						$s_page = ($nowBlock * $block) - 7;//블락수에 따라 뺴줘야함 8-1

						if ($s_page <= 1) {
							$s_page = 1;
						}

						$e_page = $nowBlock*$block;
						if ($pageNum <= $e_page) {
							$e_page = $pageNum;
						}

                        //echo $pageNum."blckNum".$blockNum."nowBlock".$nowBlock."s_page".$s_page."epage".$e_page;

                        $s_point = ($page-1) * $list;



                        //$sql = "SELECT * FROM ipgo where itemname LIKE '%$search_word%' "; 

					    if ($search_word)
						{
						    $sql = "select concat(ipgodate,'/',ipgonum) as 'seq' ,geocode, geoname, concat(itemname,' 외 ',count(*),'건') as 'title', sum(surang) as 'tsurang' ,sum(hap) as 'total' ,changocode,changoname,'회계','인쇄',charger from ipgo where itemname like '%$search_word%' group by ipgodate,ipgonum order by ipgodate desc,ipgonum desc limit  $s_point ,$list";
						}
						else{
                            $sql = "select '선택' as 'num' ,concat(ipgodate,'/',ipgonum) as 'seq' ,geocode,geoname, concat(itemname,' 외 ',count(*),'건') as 'title', sum(surang) as 'tsurang' ,sum(hap) as 'total' ,changocode,changoname,'회계','인쇄',charger from ipgo where 1 group by ipgodate,ipgonum order by ipgodate desc,ipgonum desc 
							limit $s_point ,$list";


						}
                      
					



						// 테이블 생성?>
                     
						<table class="table table-striped table-bordered table-hover">
						  <thead>
							<tr>
					
							  <th scope="col">전표날짜</th>
							  <th scope="col">거래처명</th>
							  <th scope="col">품목</th>
                              <th scope="col">수량합</th>
                            							
																					  
							  <th scope="col">금액</th>
							  <th scope="col">입고창고</th>
                              <th scope="col">인쇄</th>
							  <th scope="col">담당자</th>
							  <th scope="col">수정</th>
                              <th scope="col">삭제</th>


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
										echo '<td>'.$geoname.'</td>';
										echo "<td onclick='form_modify(\"$seq\",\"$geocode/$geoname\",\"$changocode/$changoname\");'>".$title.'</td>';
										
										
										echo '<td>'.$tsurang.'</td>';
										echo '<td>'.$total.'</td>';
										echo '<td>'.$changoname.'</td>';
										echo "<td onclick='form_print(\"$seq\");'>".'인쇄
										'.'</td>';
										

										echo '<td>'.$charger.'</td>';
                                       
										?>

                                        <td><button class="btn btn-primary" onclick="form_modify('<?=$seq?>','<?=$geocode.'/'.$geoname?>','<?=$changocode.'/'.$changoname?>')">Edit</button></td> 
										<td><a class="btn btn-warning" href="ipgodelete.php?del_id=<?php echo $seq ?>" onclick="return confirm('<?php echo $seq ?> 전표를 삭제할까요?')">
										<span class="glyphicon glyphicon-remove"></span>Del</a></td>
										<?
										
										echo '</tr>';
				
                                    
						          }
							   }
                          ?>
						  <tbody>
						</table>
			
                        


						
					   
						   <div class="col-md-12 text-center">
						    <ul class="pagination">


							<li class="page-item"><a class="page-link" href="?page=<? if($s_page-1<=0){ echo "1";
								
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
