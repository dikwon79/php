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
			  $("#table tr").click(function(){     
 
					var str = ""
					var tdArr = new Array();    // 배열 선언
						
					// 현재 클릭된 Row(<tr>)
					var data = $(this);
					var tr = data.parent().parent();
					var td = data.children();
                    //console.log("클릭한 Row의 모든 데이터 : "+td.text());
                    var no = td.eq(0).text();
					var itemcode = td.eq(1).text();
					var xhr = new XMLHttpRequest();
     
			
					xhr.open('POST', 'iteminfodetail.php');
					 
					xhr.setRequestHeader("Content-Type", "application/json");
					   
					xhr.send(JSON.stringify({"itemcode" : itemcode })); 
					xhr.onreadystatechange = function(){
					if(xhr.readyState === 4 && xhr.status === 200){
					
					
					   var _tzs = xhr.responseText;
					   if (_tzs)
					   {
							
							//alert(_tzs); 
							var itemdata = _tzs.split(',');
                            document.getElementById('field0').value= itemdata[0];
						    document.getElementById('field1').value= itemdata[2];
							document.getElementById('field2').value= itemdata[1];
							document.getElementById('field3').value= itemdata[3];
							document.getElementById('field4').value= itemdata[4];
							document.getElementById('field5').value= itemdata[5];
							document.getElementById('field6').value= itemdata[6];
							document.getElementById('field7').value= itemdata[7];
							document.getElementById('field8').value= itemdata[8];
							document.getElementById('field9').value= itemdata[9];
							document.getElementById('field10').value= itemdata[10];
							document.getElementById('field11').value= itemdata[11];
							document.getElementById('field12').value= itemdata[12];
							document.getElementById('field13').value= itemdata[13];
							document.getElementById('field14').value= itemdata[14];
							document.getElementById('field15').value= itemdata[15];
						    document.getElementById('field16').value= itemdata[16];
							document.getElementById('field17').value= itemdata[17];
							document.getElementById('field18').value= itemdata[18];
							document.getElementById('field19').value= itemdata[19];
							
					   }
					}}
						
			});
			$(window).scroll(function() {
  
			if($(this).scrollTop() > 273) {
				//$("#rightitem").css('top',$(this).scrollTop());
				if ($(this).scrollTop() > $(document).height())		
				{
                   $(".form-style-1").css('top',$(document).height());
                   $(".form-style-1").css('position','relative');		
				}
                $(".form-style-1").css('top',$(this).scrollTop()-210);
                $(".form-style-1").css('position','relative');		
				
			}
			else {
			
				$(".form-style-1").css('top','0');
				$(".form-style-1").css('position','relative');
				
			}
           });
		  
		   var jbOffset = $( '#navitem' ).offset();
		
             $( window ).scroll( function() {
              if ( $( document ).scrollTop() > jbOffset.top ) {
				 
                 $( '#navitem' ).addClass( 'jbFixed' );
                }
                else {
                $( '#navitem' ).removeClass( 'jbFixed' );
				
              }
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
            .form-style-1 {
			   
				margin:3px auto;
				max-width: 680px;
				padding: 20px 12px 10px 20px;
				font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			}
			.form-style-1 li {
				padding: 0;
				display: block;
				list-style: none;
				margin: 10px 0 0 -30px;
			}
			.form-style-1 label{
				margin:0 0 3px 0;
				padding:0px;
				display:block;
				font-weight: bold;
			}
			#field0{
				margin:0 0 3px 0;
				padding:0px;
				display:inline;
				font-weight: bold;
			}
			.form-style-1 input[type=text], 
			.form-style-1 input[type=date],
			.form-style-1 input[type=datetime],
			.form-style-1 input[type=number],
			.form-style-1 input[type=search],
			.form-style-1 input[type=time],
			.form-style-1 input[type=url],
			.form-style-1 input[type=email],
			textarea, 
			select{
				box-sizing: border-box;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				border:1px solid #BEBEBE;
				padding: 7px;
				margin:0px;
				-webkit-transition: all 0.30s ease-in-out;
				-moz-transition: all 0.30s ease-in-out;
				-ms-transition: all 0.30s ease-in-out;
				-o-transition: all 0.30s ease-in-out;
				outline: none;	
			}
			.form-style-1 input[type=text]:focus, 
			.form-style-1 input[type=date]:focus,
			.form-style-1 input[type=datetime]:focus,
			.form-style-1 input[type=number]:focus,
			.form-style-1 input[type=search]:focus,
			.form-style-1 input[type=time]:focus,
			.form-style-1 input[type=url]:focus,
			.form-style-1 input[type=email]:focus,
			.form-style-1 textarea:focus, 
			.form-style-1 select:focus{
				-moz-box-shadow: 0 0 8px #88D5E9;
				-webkit-box-shadow: 0 0 8px #88D5E9;
				box-shadow: 0 0 8px #88D5E9;
				border: 1px solid #88D5E9;
			}
			.form-style-1 .field-divided{
				width: 49%;
			}
			.form-style-1 .field-divided2{
				width: 29%;
			}
			.form-style-1 .field-divided3{
				width: 69%;
			}
			.form-style-1 .field-divided4{
				width: 53%;
			}
			.form-style-1 .field-divided5{
				width: 33.8%;
			}
			.form-style-1 .field-long{
				width: 99%;
			}
			.form-style-1 .field-select{
				width: 100%;
			}
			.form-style-1 .field-textarea{
				height: 100px;
			}
			.form-style-1 input[type=submit], .form-style-1 input[type=button]{
				background: #4B99AD;
				padding: 8px 15px 8px 15px;
				border: none;
				color: #fff;
			}
			.form-style-1 input[type=submit]:hover, .form-style-1 input[type=button]:hover{
				background: #4691A4;
				box-shadow:none;
				-moz-box-shadow:none;
				-webkit-box-shadow:none;
			}
			.form-style-1 .required{
				color:red;
			}
            //스크롤바 고정
			#main{
				position: fixed;
				top: 40;
			}

		</style>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item active">라벨발행</a>
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="paperofinventory2.php" class="list-group-item">재고장</a>
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

					<div class="col-md-10 my-2">
                     <? 
								$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
								$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';
                     ?>


                                <div class="container" style="padding-left:0px;margin-left:15px;">
								
								<div id="navitem"><form class="navbar" role="search" method="post" action="iteminfo.php">
								   <div class="col-sm-3">
								   
									<h1>&nbsp; 품목정보</h1>
								   </div>
								   <!--<div class="col-sm-4">	        
										<select name="stype" class="form-control">
										  <option value='0' <? if($stype =='0') echo "selected"; ?>>전체</option>
										  <option value='1' <? if($stype =='1') echo "selected"; ?>>품목코드</option>
										  <option value='2' <? if($stype =='2') echo "selected"; ?>>품목명</option>
										  <option value='3' <? if($stype =='3') echo "selected"; ?>>업체명</option>
										  <option value='4' <? if($stype =='4') echo "selected"; ?>>렉</option>
										  <option value='5' <? if($stype =='5') echo "selected"; ?>>재고조사담당</option>
										</select>
									   
								   </div>  -->
								   
								   <div class="col-sm-3"><input type="text" name="itext"  id="myInput" class="form-control" placeholder="Search" value="<? if($searchtext) echo $searchtext  ?>"></div>
								   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '품목정보')">엑셀저장</button></div>
								   <div class="col-sm-3"></div>
							   </form>           
							   </div>
							<div class="row">

								<div class="col-sm-5">
								      
									<div class="row">

										<table id ="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
											<thead>  
											<tr>  
											    <th width='90px'>업체명</th> 
												<th width='90px'>재고코드</th>  
												<th>품목명</th>
												
												
									
												
												
											</tr>  
											</thead>  
									        <tbody id="myTable">
											<?php  

											$sql = "SELECT * FROM iteminfo";
											
											if ($stype==1){
											   $sql.= " where itemcode like :var_condition";
											}
											else if ($stype==2){
											   $sql.= " where itemname like :var_condition";
											}
											else if ($stype==3){
											   $sql.= " where georae like :var_condition";
											}
											else if ($stype==4){
											   $sql.= " where lek like :var_condition";
											}
											else if ($stype==5){
											   $sql.= " where inventory like :var_condition";
											}

											$sql.= " ORDER BY lek asc ";


											$stmt = $con->prepare($sql);


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
												<td NOWRAP><?php echo $georae; ?></td>
												<td NOWRAP><?php echo $itemcode;  ?></td> 
												<td><?php echo $itemname;  ?></td>
												
												
												
												
												

												<!--<td><a class="btn btn-primary" href="itemeditform.php?edit_id=<?php echo $id ?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td> 
												<td><a class="btn btn-warning" href="delete.php?del_id=<?php echo $id  ?>" onclick="return confirm('<?php echo $itemname; ?> 품목을 삭제할까요?')">
												<span class="glyphicon glyphicon-remove"></span>Del</a></td>-->
												</tr>
											
											<?php
												}
													}
												 }
											?>  
											</tbody>
											</table>  
									</div>
								</div>
								<div class="col-sm-7">
                              
										<ul class="form-style-1">
											<li>
											 <label><b>상품기본 정보</b></label>
											 <input type='hidden' id='field0'>	
											</li>
											
											<li><label>맵핑 코드 /  재고 코드 &nbsp;<span class="required">*</span><input type="text" id="field1" class="field-divided5" placeholder="맵핑코드">&nbsp;<input type="text" id="field2" class="field-divided5" placeholder="재고코드"></label></li>
											<li><label>상    품    명 /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="required">*</span><input type="text" id="field3" class="field-divided3" placeholder="상품명"></label></li>
											<li><label>거래처코드 / 거래처명<span class="required">*
											</span></label><input type="text" id="field4" name="field4" class="field-divided2" placeholder="거래처코드" /> 
											<input type="text" id="field5" name="field5" class="field-divided3" placeholder="거래처명" /></li>
											<li><label>렉 / 단<span class="required">*
											</span></label><input type="text" id="field6" name="field6" class="field-divided" placeholder="렉" /> 
											<input type="text" id="field7" name="field7" class="field-divided" placeholder="단" /></li>
											<li><label>입수 / 팩킹수<span class="required">*
											</span></label><input type="text" id="field8" name="field8" class="field-divided" placeholder="입수" /> 
											<input type="text" id="field9" name="field9" class="field-divided" placeholder="팩킹수" /></li>
											
							  

											<li>              
												<label>재고담당 <span class="required">*</span></label>
												<input type="text" id="field10" name="field10" class="field-long" />
											</li>
											<li><label>제조일자 / 기간 <span class="required">*</span></label><input type="text" id="field11" name="field11" class="field-divided" placeholder="제조일자" /> 
											<input type="text" id="field12" name="field12" class="field-divided" placeholder="제조기간" /></li>
											
											<li><label>인쇄블랙(이천,수원5시전 블랙품목)/품목블랙 <span class="required">*</span></label><input type="text" id="field13" name="field13" class="field-divided2" placeholder="이천,수원5시제한품목" /> 
											<input type="text" id="field14" name="field14" class="field-divided3" placeholder="빈셀" /></li>
											<li><label>사용여부/라벨여부<span class="required">*
											</span></label><input type="text" id="field15" name="field15" class="field-divided" placeholder="사용여부" /> 
											<input type="text" id = "field16" name="field16" class="field-divided" placeholder="라벨인쇄여부" /></li>
											<li><label>입고가/출고가<span class="required">*
											</span></label><input type="text" id="field17" name="field15" class="field-divided" placeholder="입고가" /> 
											<input type="text" id = "field18" name="field18" class="field-divided" placeholder="출고가" /></li>
											<li>
												<label>총량인쇄구분자 <span class="required">*</span></label>
												<input type="text" id="field19" id="field19" class="field-long" placeholder="총량인쇄 구분자" /></li>
											</li>
											<li>
												<input type="button" value="저장" onclick="datasave('input');" />&nbsp;&nbsp;<input type="button" value="수정" onclick="datasave('modify');" />&nbsp;&nbsp;<input type="button" value="삭제" onclick="datasave('del');" />
											</li>
										</ul>
                                    

								</div>
							</div>  










              	
				    </div>
				   
	   </section>
       </div>
	   <!--
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
		-->
       <?
         //6. 연결 종료
        
		 
		 ?>
		
	
		
 
	</body>
</html> 
<script>
function datasave(type){

   var a =document.querySelectorAll('[id*="field"]');  
  
   //JSON형태로 데이타 만들어서 넘길거야....^^ 
   var newitemdata = new Array() ;
  
   var b = type;
      // 객체 생성
   var data = new Object() ;    
   data.id = a[0].value;  
   data.mappingcode = a[1].value;  
   data.itemcode = a[2].value;
   data.itemname = a[3].value;
   data.geocode = a[4].value;
   data.georae =  a[5].value;
   data.lek = a[6].value;
   data.dan = a[7].value;
   data.ipsu = a[8].value;
   data.packsu = a[9].value;
   data.inventory = a[10].value;
   data.productiondate = a[11].value;
   data.expire = a[12].value;
   data.printoption = a[13].value;
   data.itemblack = a[14].value;
   data.usingY = a[15].value;
   data.labelY = a[16].value;
   data.ipgoprice = a[17].value;
   data.sellprice = a[18].value;
   data.printgubun = a[19].value;
   
   // 리스트에 생성된 객체 삽입
   newitemdata.push(data);
   
   var xhr = new XMLHttpRequest();
   
   xhr.open('POST', 'iteminput.php');
   xhr.setRequestHeader("Content-Type", "application/json");
   xhr.send(JSON.stringify({"additem" : newitemdata, "type" : b})); 
   xhr.onreadystatechange = function(){
   if(xhr.readyState === 4 && xhr.status === 200){

	   var _tzs = xhr.responseText;
	   if (_tzs ==="success")
	   {
			alert("저장하였습니다.");
	   }
	   else{
           alert(_tzs);
	   }
	
	 }
   }
   
   
}



</script>