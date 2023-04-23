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
    $nowdate = isset($_POST['ndate']) ? $_POST['ndate'] : (isset($_GET['ndate']) ? $_GET['ndate'] : date("Y-m-d"));  // tab 아이디 정보
    $stype= isset($_POST['stype']) ? $_POST['stype'] : '신규';
	
    include('headitem.php');?>
<!DOCTYPE html>
<html>
	<head>
	    <link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>

		<script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>
   

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
             function modal_view(id,chugotype,itemcode,mappingcode,itemname,customer,surang1,surang2,confirmsu,unit,modalreason){
				 
				 document.getElementById("modalid").value = id;
				 document.getElementById("modaltype").value = chugotype;
				 document.getElementById("modalcode").value = itemcode;
				 document.getElementById("modalmap").value = mappingcode;
				 document.getElementById("modalname").value = itemname;
				 document.getElementById("modalcus").value = customer;
                 document.getElementById("modalsu1").value = surang1;
				 
				 document.getElementById("modalsu2").value = surang2;
				 document.getElementById("modalconf").value = confirmsu;
				 document.getElementById("modalunit").value = unit;
				 document.getElementById("modalreason").value = modalreason;
			 }
            
             function confirmsave(){

							
					// 리스트 생성
				    var confirm = new Array() ;
				         
		             
		            // 객체 생성
				   
		            var data = new Object() ;
		             
		            data.mid =document.getElementById('modalid').value;
		            data.mtype =document.getElementById('modaltype').value;				
					data.mcode =document.getElementById('modalcode').value;
					data.mmap =document.getElementById('modalmap').value;
					data.mname =document.getElementById('modalname').value;
					data.mcus =document.getElementById('modalcus').value;
                    data.msu1 =document.getElementById('modalsu1').value;				
                    data.msu2 =document.getElementById('modalsu2').value;
					data.mconf =document.getElementById('modalconf').value;
                    data.munit =document.getElementById('modalunit').value;
                    data.modalreason =document.getElementById('modalreason').value;
							
							
				 
				             
				    // 리스트에 생성된 객체 삽입
					confirm.push(data) ;
						
				  

					var xhr = new XMLHttpRequest();



			   
					xhr.open('POST', 'confirmsave.php');
							 
					xhr.setRequestHeader("Content-Type", "application/json");
					   
					xhr.send(JSON.stringify({"confirm" : confirm})); 
					xhr.onreadystatechange = function(){
					if(xhr.readyState === 4 && xhr.status === 200){
					
					
					   var _tzs = xhr.responseText;
					   if (_tzs)
					   {
							alert(_tzs);
							
						
					   }
					   $("#btn_close").trigger("click");
 

					  
					   
					 }
					}

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
							<a href="paperofinventory2.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
							<a href="chulgolist.php" class="list-group-item">업장출고내역</a>
							<a href="chagelist.php" class="list-group-item">변경분리스트</a>
							<a href="Confirmedkey.php" class="list-group-item active">재고확정키</a>
						
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
						if(empty($_REQUEST["search_word1"])){ // 검색어가 empty일 때 예외처리를 해준다.
						$search_word1 ="";

						}else{

						$search_word1 =$_REQUEST["search_word1"];

						}


						?>

                        <div>
							   
							   <div class="col-sm-2">
							   <form method="post" action=""> <!-- action 을 비워놔야 자신을 가리킨다 -->
							   <input type="text" name="ndate" class="form-control" id="datePicker" size="30" value='<? echo $nowdate; ?>'/>
									 
							   </div>
							   <div class="col-sm-2">	        
									<select name="stype" class="form-control">
									  <option value='cj' <? if($stype =='cj') echo "selected"; ?>>cj</option>
									  <option value='spc' <? if($stype =='spc') echo "selected"; ?>>spc</option>
									</select>
								   
							   </div>
							   <div class="col-sm-2">	        
									<select name="stype" class="form-control">
									  <option value='신규' <? if($stype =='신규') echo "selected"; ?>>신규</option>
									  <option value='변경' <? if($stype =='변경') echo "selected"; ?>>변경</option>
									</select>
								   
							   </div>
							   <div class="col-sm-2">
							      
								  <input type="text" size="30" name="search_word" class="form-control" value='<?=isset($_POST["search_word"]) ? $_POST["search_word"] : "" ?>' placeholder="품목코드,재고코드,품목명 enter를 누르세요" autofocus>
                                  
							   
							   </div>
							
							   <div class="col-sm-2">
							      
								  <input type="text" size="30" name="search_word1" class="form-control" value='<?=isset($_POST["search_word1"]) ? $_POST["search_word1"] : "" ?>' placeholder="업장명 enter를 누르세요" autofocus>
                                  
							   
							   </div>
                                 
							   <div class="col-sm-2">
							   <button type="submit" class="btn btn-default">검색</button>&nbsp;
							
							   </div>
							     </form>  
                        </div>
						

						<?php 
						if ($stype =='신규') $stypedb = " where type ='$stype'";
						else $stypedb = " where type !='신규'";


					    $sql = "SELECT Y.id,b.geocode,b.georae,Y.worker,Y.chasu,Y.printinfo,Y.companyname,Y.type as 'chugotype',Y.itemcode,Y.mappingcode,Y.itemname,Y.customer,
							Y.surang1,Y.surang2,Y.confirmsu,Y.unit,Y.modalreason FROM (SELECT X.id,X.worker,X.chasu,a.printinfo,X.companyname,X.type,X.itemcode,X.mappingcode,X.itemname,X.customer
							,X.surang1,X.surang2,X.confirmsu,X.unit,X.modalreason from(SELECT id,worker,chasu,center,companyname,TYPE,itemcode,mappingcode,itemname,customer,surang1,surang2,confirmsu,unit,modalreason  
							FROM labelmain WHERE idate='$nowdate')X LEFT JOIN print_info a on substring(X.center,1,4) = a.center)Y LEFT JOIN iteminfo b 
							ON Y.itemcode = b.itemcode".$stypedb;
					    $stmt = $con->prepare($sql);

                        $stmt->execute();
						$num=$stmt->rowCount();	   
                        $page = isset($_GET['page'])?$_GET['page']:1;
     
                        
  
                       
					    $list=13;
						$block = 10;
					    $pageNum = ceil($num/$list); // 총 페이지
					    $blockNum = ceil($pageNum/$block); // 총 블록
					    $nowBlock = ceil($page/$block);


												
						$s_page = ($nowBlock * $block) - 9;

						if ($s_page <= 1) {
							$s_page = 1;
						}

						$e_page = $nowBlock*$block;
						if ($pageNum <= $e_page) {
							$e_page = $pageNum;
						}



                        $s_point = ($page-1) * $list;

                        if ($stype =='신규') $stypedb = " and type ='$stype'";
						else $stypedb = " and type !='신규'";


                        //$sql = "SELECT * FROM ipgo where itemname LIKE '%$search_word%' "; 

					    if (($search_word) or ($search_word1))
						{
						    $sql = "SELECT Y.id,b.geocode,b.georae,Y.worker,Y.chasu,Y.printinfo,Y.companyname,Y.type as 'chugotype',Y.itemcode,Y.mappingcode,Y.itemname,Y.customer,
							Y.surang1,Y.surang2,Y.confirmsu,Y.unit,Y.modalreason FROM (SELECT X.id,X.worker,X.chasu,a.printinfo,X.companyname,X.type,X.itemcode,X.mappingcode,X.itemname,X.customer
							,X.surang1,X.surang2,X.confirmsu,X.unit,X.modalreason from(SELECT id,worker,chasu,center,companyname,TYPE,itemcode,mappingcode,itemname,customer,surang1,surang2,confirmsu,unit,modalreason  
							FROM labelmain WHERE idate='$nowdate')X LEFT JOIN print_info a on substring(X.center,1,4) = a.center)Y LEFT JOIN iteminfo b 
							ON Y.itemcode = b.itemcode where (Y.itemcode like '%$search_word%' or Y.mappingcode like '%$search_word%' or Y.itemname like '%$search_word%' 
						    ) and (Y.customer like '%$search_word1%')".$stypedb;
						}
						else{
                            $sql = "SELECT Y.id,b.geocode,b.georae,Y.worker,Y.chasu,Y.printinfo,Y.companyname,Y.type as 'chugotype',Y.itemcode,Y.mappingcode,Y.itemname,Y.customer,
							Y.surang1,Y.surang2,Y.confirmsu,Y.unit,Y.modalreason FROM (SELECT X.id,X.worker,X.chasu,a.printinfo,X.companyname,X.type,X.itemcode,X.mappingcode,X.itemname,X.customer
							,X.surang1,X.surang2,X.confirmsu,X.unit,X.modalreason from(SELECT id,worker,chasu,center,companyname,TYPE,itemcode,mappingcode,itemname,customer,surang1,surang2,confirmsu,unit,modalreason  
							FROM labelmain WHERE idate='$nowdate')X LEFT JOIN print_info a on substring(X.center,1,4) = a.center)Y LEFT JOIN iteminfo b 
							ON Y.itemcode = b.itemcode".$stypedb." limit $s_point ,$list";


						}
                      
					   
                   

						// 테이블 생성?>
                     
						<table class="table table-striped table-bordered table-hover">
						  <thead>
							<tr>
					
							  <th scope="col">거래처명</th>
							  <th scope="col">차수</th>
							  <th scope="col">센터</th>
                              <th scope="col">출고지</th>
                            							
																					  
							  <th scope="col">유형</th>
							  <th scope="col">품목코드</th>
                              <th scope="col">재고코드</th>
							  <th scope="col">품목명</th>
                              <th scope="col">고객명</th>
                              <th scope="col">전수량</th>
							  <th scope="col">후수량</th>
							  <th scope="col">획정</th>
                              <th scope="col">단위</th>
							  <th scope="col">수정</th>
                              


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
								
										echo '<td>'.$georae.'</td>';
										echo '<td>'.$chasu.'</td>';
										//echo "<td onclick='form_modify(\"$seq\",\"$geocode/$geoname\",\"$changocode/$changoname\");'>".$title.'</td>';
										echo '<td>'.$printinfo.'</td>';
										echo '<td>'.$companyname.'</td>';
										echo '<td>'.$chugotype.'</td>';
										echo '<td>'.$itemcode.'</td>';
										echo '<td>'.$mappingcode.'</td>';
										echo '<td>'.$itemname.'</td>';
                                        echo '<td>'.$customer.'</td>';
										echo '<td>'.$surang1.'</td>';
										echo '<td>'.$surang2.'</td>';
										echo '<td>'.$confirmsu.'</td>';
										


										//echo "<td onclick='form_print(\"$seq\");'>".'인쇄
										//'.'</td>';
										

										echo '<td>'.$unit.'</td>';
                                        $modaldata ="'$id'".','."'$chugotype'".','."'$itemcode'".','."'$mappingcode'".','."'$itemname'".','."'$customer'".','."'$surang1'".','."'$surang2'".','."'$confirmsu'".','."'$unit'".','."'$modalreason'";
                                        
							
									
										?>

                                        <td><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#my80sizeCenterModal" onclick="modal_view(<?=$modaldata?>)">수정</a></td> 
										
										<?
										
										echo '</tr>';
				
                                    
						          }
							   }
                          ?>
						  <tbody>
						</table>
			
                        


						 <? if ((!$search_word) and (!$search_word1))  { ?>
					   
						   <div class="col-md-12 text-center">
						    <ul class="pagination">


							<li class="page-item"><a class="page-link" href="?page=<? if($s_page-1<0){ echo "1";
								
							}else{  echo $s_page;
								
							}?>">Previous</a></li>
							
							<?
							for ($p=$s_page; $p<=$e_page; $p++) {
                            ?>


							
							<li class="page-item"><a class="page-link" href="?page=<?=$p?>&ndate=<?=$nowdate?>"><?=$p?></a></li>
						     
							 <? } ?>
							<li class="page-item"><a class="page-link" href="?page=<? if($e_page+1 >$pageNum) { echo $pageNum; }
							 else {echo $e_page+1;}?>&ndate=<?=$nowdate?>">Next</a></li>
							</ul>
						   </div> 
						
						<? } ?> 												
						
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
	   <!-- 80%size Modal at Center -->
			<div class="modal modal-center fade" id="my80sizeCenterModal" tabindex="-1" role="dialog" aria-labelledby="my80sizeCenterModalLabel">
			  <div class="modal-dialog modal-80size modal-center" role="document">
				<div class="modal-content modal-80size">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">확정 수정하기</h4>
				  </div>
				  <div class="modal-body">

                   <div class="container">
							<div>
									<h1 class="h2" align="center">&nbsp; 재고 확정 수정<button  class="btn btn-success" id="btn_close" data-dismiss="modal" style="margin-left: 850px">닫기<span class="glyphicon glyphicon-home"></span></button></h1><hr>
							</div>
                        
							<!--<form id="myform" method="post" enctype="multipart/form-data" class="form-horizontal" style="margin: 0 300px 0 300px;border: solid 1px;border-radius:4px">  -->
								<?php
								if(isset($errMSG)){
									?>
									<div class="alert alert-danger">
									  <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
									</div>
									<?php
								}
								?>
								<input type='hidden' id='modalid'>
								<table class="table table-responsive">
								<tr>
								
									<td><label class="control-label">출고타입</label></td>
									<td>
									<select id="modaltype" class="form-control">
									  <option value='신규'>신규</option>
									  <option value='*취소'>취소</option>
									  <option value='*김소'>감소</option>
									  <option value='*증가'>증가</option>
									</select>
									</td>
								</tr>
								<tr>
								
									<td><label class="control-label">품목코드</label></td>
									<td>
									<input id="modalcode" class="form-control" type="text"  placeholder="품목코드 입력하세요" autocomplete="off" readonly   />
									
									</td>
								</tr>
								<tr>
									
									<td><label class="control-label">재고코드</label></td>
									<td>
									<input id="modalmap" class="form-control" type="text"  placeholder="재고코드 입력하세요" autocomplete="off"    />
									
									</td>
								</tr>
								<tr>					
									<td><label class="control-label">품목명</label></td>
									<td>
									<input id="modalname" class="form-control" type="text"  placeholder="품목명을 입력하세요" autocomplete="off"    />				
									</td>
								</tr>
								<tr>					
									<td><label class="control-label">고객명</label></td>
									<td>
									<input id="modalcus" class="form-control" type="text"  placeholder="고객명을 입력하세요" autocomplete="off"    />				
									</td>
								</tr>
								<tr>					
									<td><label class="control-label">이전수량</label></td>
									<td>
									<input id="modalsu1" class="form-control" type="text"  placeholder="수량을 입력하세요" autocomplete="off"    />				
									</td>
								</tr>
								<tr>					
									<td><label class="control-label">라벨수량</label></td>
									<td>
									<input id="modalsu2" class="form-control" type="text"  placeholder="수량을 입력하세요" autocomplete="off"  readonly  />				
									</td>
								</tr>
                               <tr>					
									<td><label class="control-label">확정수량</label></td>
									<td>
									<input id="modalconf" class="form-control" type="text"  placeholder="확정수량을 입력하세요" autocomplete="off"    />				
									</td>
								</tr>

								</tr>
                               <tr>					
									<td><label class="control-label">단위</label></td>
									<td>
									<input id="modalunit" class="form-control" type="text"  placeholder="단위를 입력하세요" autocomplete="off" readonly   />				
									</td>
								</tr>

								<tr>
									
									<td><label class="control-label">수정사유</label></td>
									<td>
									<textarea name="modalreason" id="modalreason" cols="60" rows="6" class="field-long field-textarea"></textarea>			
									</td>
								</tr>
								
								
								<tr>
								
								
									<td colspan="2" align="center">
									<button  name="btn_save_updates" class="btn btn-primary" onclick="confirmsave()"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp; 업데이트</button>
									<button class="btn btn-warning" id="btn_close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>취소</button>
									</td>
								</tr>
								</table>
							<!--</form> -->


				  </div>
				  
				  
				</div>
			  </div>
			</div>
			
			<!-- 80%size Modal at Center -->
	    
		
       <?
         //6. 연결 종료
        
		 
		 ?>
		
	
		
 
	</body>
</html> 





