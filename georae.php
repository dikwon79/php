
<style type="text/css"> // 폼디자인
}
.form-style-1 {
	margin:3px auto;
	max-width: 500px;
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
.form-style-1 .field-long{
	width: 100%;
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
.col-sm-7{
   width : 400px;
   padding-right : 0px;
   

}
.col-sm-5{padding-left:0px !important}

</style>


<?php

    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: iteminfo.php"); 

 
    include('headitem.php');

	
	$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';

    $sql = "SELECT * from geoinfo where 1";	
    $stmt = $con->prepare($sql);		
	$stmt->execute();
 
	
?>


<div class="container">
<div class="page-header">
    	<h1 class="h2">&nbsp; 거래처 정보</h1><hr>
</div>
<div id="navhead">
    <form class="navbar" role="search" method="post">
       
       <div class="col-sm-3">
	   
	   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
       <div class="col-sm-2">	        
			<select name="stype" class="form-control">
			 
			</select>
		   
	   </div>
	   <div class="col-sm-4"><input type="text" name="itext" class="form-control" placeholder="Search" value="<? if($searchtext) echo $searchtext  ?>"></div>
	   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '재고장')">엑셀저장</button></div>
     </form>           
   </div>
 <div class='row'>
    <div style="overflow-y:scroll;height:700px;" class='col-sm-7'>
       <table class="table table-bordered table-hover table-striped" style="ml-0 table-layout: fixed ; width: 100%">
           <thead>  
            <tr>  
			   <th NOWRAP>사용</th>
               <th NOWRAP>3PL</th>
			   <th NOWRAP>거래처코드</th>  
               <th NOWRAP>거래처명</th>
               <th NOWRAP>거래처분류</th>
			   <th NOWRAP>거래처구분</th>
               <th NOWRAP>대표자명</th>
               <th NOWRAP>사업자번호</th>
               <th NOWRAP>전화번호</th>
               <th NOWRAP>팩스</th>
               <th NOWRAP>주소</th>
			   <th NOWRAP>업태</th>
			   <th NOWRAP>종목</th>
			   <th NOWRAP>기타</th>
               <th NOWRAP>은행/계좌/예금주1</th>
               <th NOWRAP>은행/계좌/예금주2</th>
               <th NOWRAP>은행/계좌/예금주3</th>
               <th NOWRAP>성명1/이메일/부서/직위/tel</th>
               <th NOWRAP>성명2/이메일/부서/직위/tel</th>
               <th NOWRAP>성명3/이메일/부서/직위/tel</th>


 
            </tr>  
            </thead>  
  <?
        if ($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
			    extract($row);


  ?>
			<tr class="checkBtn" style="height:10px">  
			<td NOWRAP><?=$use;?></td>
			<td NOWRAP><?=$tpl;?></td> 
            <td NOWRAP><?=$geocode;?></td> 
            <td NOWRAP><?=$geoname;?></td> 
            <td NOWRAP><?=$geobunryu;?></td> 
            <td NOWRAP><?=$geogubun;?></td> 
            <td NOWRAP><?=$geoboss;?></td>
			<td NOWRAP><?=$businessNum;?></td>
   
			<td NOWRAP><?=$tel;?></td>
			<td NOWRAP><?=$fax;?></td>
			<td NOWRAP><? echo '('.$posnum.')'.$address;?></td>
            <td NOWRAP><?=$yeop;?></td>
			<td NOWRAP><?=$jongmok;?></td>
			<th NOWRAP><?=$gita;?></th>
            <th NOWRAP><?=$account1;?></th>
            <th NOWRAP><?=$account2;?></th>
            <th NOWRAP><?=$account3;?></th>
            <th NOWRAP><?=$recharger1;?></th>
            <th NOWRAP><?=$recharger2;?></th>
            <th NOWRAP><?=$recharger3;?></th>
            
			</tr>

            <?php
			
                }
             }
        ?>  

	   </table>
	</div>
   <div class='col-sm-5'>
         <!-- Tab을 구성할 영역 설정-->
		<div style="left-margin:0px;">
		<!-- Tab 영역 태그는 ul이고 클래스는 nav와 nav-tabs를 설정한다. -->
		<ul class="nav nav-tabs">
		<!-- Tab 아이템이다. 태그는 li과 li > a이다. li태그에 active는 현재 선택되어 있는 탭 메뉴이다. -->
		<li class="active"><a href="#maininfo" data-toggle="tab">기본정보</a></li>
		<!-- a 태그의 href는 아래의 tab-content 영역의 id를 설정하고 data-toggle 속성을 tab으로 설정한다. -->
		<li><a href="#addinfo" data-toggle="tab">부가정보</a></li>
		<li><a href="#messages" data-toggle="tab">블랙리스트정보</a></li>
		<li><a href="#settings" data-toggle="tab">Settings</a></li>
		</ul>
		<!-- Tab이 선택되면 내용이 보여지는 영역이다. -->
		<!-- 태그는 div이고 class는 tab-content로 설정한다. -->
		<div class="tab-content">
		<!-- 각 탭이 선택되면 보여지는 내용이다. 태그는 div이고 클래스는 tab-pane이다. -->
		<!-- active 클래스는 현재 선택되어 있는 탭 영역이다. -->
		<div class="tab-pane fade in active" id="maininfo">
		     <!-- 첫번째 탭 내용 -->
			<form>
			<ul class="form-style-1">
			    <li>
				 <label>현사용여부 /3PL여부</label>
					<select id="field_1" name="field_1" class="field-divided">
					<option value="Y">거래</option>
					<option value="N">미거래</option>
				 </select>
				
					<select id="field_2" name="field_2" class="field-divided">
					<option value="Y">3pl작업중</option>
					<option value="N">미업체</option>
				 </select>
				</li>
				
				<li><label>거래처코드 / 명 <span class="required">*</span></label><input type="text" id="field1" class="field-divided" placeholder="거래처코드" /> <input type="text" id="field2" class="field-divided" placeholder="거래처명" /></li>
				<li>
					<label>거래처분류</label>
					<select id="field3" name="field3" class="field-select">
					<option value="매입매출처">매입매출처</option>
					<option value="매입처">매입처</option>
					<option value="매출처">매출처</option>
					</select>
				</li>
				<li><label>거래처구분 / 대표자명<span class="required">*
				</span></label><input type="text" id="field4" name="field4" class="field-divided" placeholder="거래처구분" /> 
				<input type="text" id="field5" name="field5" class="field-divided" placeholder="대표자명" /></li>
				
  

                <li>              
					<label>사업자번호 <span class="required">*</span></label>
					<input type="text" id="field6" name="field6" class="field-long" />
				</li>
                <li><label>전화번호 / 팩스번호 <span class="required">*</span></label><input type="text" id="field7" name="field7" class="field-divided2" placeholder="전화번호" /> 
				<input type="text" id="field8" name="field8" class="field-divided2" placeholder="팩스번호" /></li>
                
				<li><label>우편번호 / 주소 <span class="required">*</span></label><input type="text" id="field9" name="field9" class="field-divided2" placeholder="우편번호" /> 
				<input type="text" id="field10" name="field10" class="field-divided3" placeholder="주소" /></li>
                <li><label>업태/종목<span class="required">*
				</span></label><input type="text" id="field11" name="field11" class="field-divided" placeholder="업태" /> 
				<input type="text" id = "field12" name="field2" class="field-divided" placeholder="종목" /></li>
				
				<li>
					<label>기타 정보 <span class="required">*</span></label>
					<textarea name="field13" id="field13" class="field-long field-textarea"></textarea>
				</li>
				<li>
					<input type="button" value="저장" onclick="datasave();" />&nbsp;&nbsp;<input type="button" value="수정" />&nbsp;&nbsp;<input type="button" value="삭제" />
				</li>
			</ul>
			</form>
		</div>
		<!-- id는 고유한 이름으로 설정하고 tab의 href와 연결되어야 한다. -->
		
		<div class="tab-pane fade" id="addinfo">
		   <ul class="form-style-1">
	       <li><label>계좌정보<span class="required">*</span>
		   
		   <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
			<thead>  
			<tr style="border: solid 1px;">  
				<th style="border: solid 1px;" NOWRAP></th> 
				<th style="border: solid 1px ; padding:0px;" NOWRAP>은행</th>  
				<th style="border: solid 1px ; padding:0px;" NOWRAP>계좌번호</th>
				<th style="border: solid 1px ; padding:0px;" NOWRAP>예금주</th>	
			</tr>
			</thead>  
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox' checked/></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field14_0" size="35" style="width:100%; height :33px;border:0;"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field14_1" size="120" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field14_2" size="20" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox'></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field15_0" size="35" style="width:100%; height :33px;border:0;"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field15_1" size="120" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field15_2" size="20" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox'></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field16_0" size="35" style="width:100%; height :33px;border:0;"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field16_1" size="120" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field16_2" size="20" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
		    </table>
			</li>


            
		  </ul>
		  <ul class="form-style-1">
	       <li><label>담당자정보<span class="required">*</span>
		   
		   <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
			<thead>  
			<tr style="border: solid 1px;">  
				<th style="border: solid 1px;" NOWRAP></th> 
				<th style="border: solid 1px ; padding:0px;" NOWRAP>성명</th>  
				<th style="border: solid 1px ; padding:0px;" NOWRAP>전자메일</th>
				<th style="border: solid 1px ; padding:0px;" NOWRAP>부서</th>
			
				<th style="border: solid 1px ; padding:0px;" NOWRAP>직위</th>
				<th style="border: solid 1px ; padding:0px;" NOWRAP>전화번호</th>
			</tr>
			</thead>  
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox' checked/></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field17_0" size="50" style="width:100%; height :33px;border:0;"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field17_1" size="120" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field17_2" size="40" style="width:100%; height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field17_3" size="40" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field17_4" size="50" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox'></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field18_0" size="50" style="width:100%; height :33px;border:0;"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field18_1" size="120" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field18_2" size="40" style="width:100%; height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field18_3" size="40" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field18_4" size="50" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
			<tr style="border: solid 1px;">
				<td style="border: 1px solid;"><input type='checkbox'></td> 
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field19_0" size="50" style="width:100%; height :33px;border:0;"></td>  
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field19_1" size="120" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field19_2" size="40" style="width:100%; height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field19_3" size="40" style="width:100%;height :33px;border:0;"></td>
				<td style="border: 1px solid; padding:0px;"><input type='text' id="field19_4" size="50" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
		    </table>
			</li>
            <li>
					<input type="Submit" value="저장" />&nbsp;&nbsp;<input type="Submit" value="수정" />&nbsp;&nbsp;<input type="Submit" value="삭제" />
			</li>

            
		  </ul>
		</div>
		
		
		
		<!-- fade 클래스는 선택적인 사항으로 트랜지션(transition)효과가 있다.
		<!-- in 클래스는 fade 클래스를 선언하여 트랜지션효과를 사용할 때 in은 active와 선택되어 있는 탭 영역의 설정이다. -->
		<div class="tab-pane fade" id="messages">
		    <ul class="form-style-1">
			<li><label>D1,D2센터제어<span class="required">*</span>
            <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; margin-top : 5px; border-collapse: collapse;">
			<thead>  
			<tr>  
				<th><input type='checkbox'></th> 
				<th style="padding:0px;" NOWRAP>컷데이</th>  
				<th style="padding:0px;" NOWRAP>센터</th>
				
			</tr>
			</thead>  
			<tbody id="my-tbody">
			<tr>
				<td><input type='checkbox'></td> 
				<td style="padding:0px;"><select name="day" class="black_day" size="1" style="width:100%; height :33px;border:0;">
					<option value="전체" selected>전체</option>
					<option value="D1">D1</option>
					<option value="D2">D2</option>
					</select></td>  
				<td style="padding:0px;"><input type='text' style="width:100%;height :33px;border:0;"></td>
				
			</tr>
			<tr>
				<td><input type='checkbox' checked></td> 
				<td style="padding:0px;"><select name="day" class="black_day" size="1" style="width:100%; height :33px;border:0;">
					<option value="전체">전체</option>
					<option value="D1" selected>D1</option>
					<option value="D2">D2</option>
					</select></td>  
				<td style="padding:0px;"><input type='text' style="width:100%;height :33px;border:0;"></td>
				
			</tr>
			<tr>
				<td><input type='checkbox' checked></td> 
				<td style="padding:0px;"><select name="day" class="black_day" size="1" style="width:100%; height :33px;border:0;">
					<option value="전체">전체</option>
					<option value="D1">D1</option>
					<option value="D2" selected>D2</option>
					</select></td>  
				<td style="padding:0px;"><input type='text' style="width:100%;height :33px;border:0;"></td>
				
			</tr>
			</tbody>
		    </table>
            </li>
		   
		    <li><label>센터별 품목코드<span class="required">*</span>
            <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; margin-top : 5px; border-collapse: collapse;">
			<thead>  
			<tr>  
				<th><input type='checkbox'></th> 
				<th style="padding:0px;" NOWRAP>센터</th>
				<th style="padding:0px;" NOWRAP>품목코드</th>
				
			</tr>
			</thead>  
			<tbody id="my-tbody">
			<tr>
				<td><input type='checkbox'></td>  
				<td style="padding:0px;"><input type='text' size="20" style="width:100%;height :33px;border:0;"></td>
				<td style="padding:0px;"><input type='text' size="60" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
			</tbody>
		    </table>
            </li>

            

            <li><label>센터별 업장<span class="required">*</span>
            <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; margin-top : 5px; border-collapse: collapse;">
			<thead>  
			<tr>  
				<th><input type='checkbox'></th> 
				<th style="padding:0px;" NOWRAP>센터</th>
				<th style="padding:0px;" NOWRAP>업장명</th>
				
			</tr>
			</thead>  
			<tbody id="my-tbody">
			
			<tr>
				<td><input type='checkbox'></td> 
				<td style="padding:0px;"><input type='text' size="20" style="width:100%;height :33px;border:0;"></td>
				<td style="padding:0px;"><input type='text' size="60" style="width:100%; height :33px;border:0;"></td>
				
			</tr>
			</tbody>
		    </table>
			</li>
		    <li>
					<input type="Submit" value="저장" />&nbsp;&nbsp;<input type="Submit" value="수정" />&nbsp;&nbsp;<input type="Submit" value="삭제" />
	    	</li>

		 	</ul>
		</div>
        


		<div class="tab-pane fade" id="settings">Settings 준비중입니다. 필요없을지도~ </div>
		</div>
		</div>



   </div>
   <div id="side" style='visibility:hidden;'></div>
</div>
<script> 
		    
		


            $(".checkBtn").click(function(){ 
			
     
			var str = ""
			var tdArr = new Array();	// 배열 선언
			var checkBtn = $(this);
			
			// checkBtn.parent() : checkBtn의 부모는 <td>이다.
			// checkBtn.parent().parent() : <td>의 부모이므로 <tr>이다.
			//var tr = checkBtn.parent().parent();
			var tr = checkBtn;
			var td = tr.children();
			
			/*console.log("클릭한 Row의 모든 데이터 : "+tr.text());
			
			var geraecode = td.eq(0).text();
			var geraename = td.eq(1).text();
			var kindofgeo = td.eq(2).text();
			var boss = td.eq(3).text();
			var businessnum = td.eq(4).text();
			var tel = td.eq(5).text();
			var fax = td.eq(6).text();
			var address = td.eq(7).text();

			*/
			// 반복문을 이용해서 배열에 값을 담아 사용할 수 도 있다.
			td.each(function(i){	
				tdArr.push(td.eq(i).text());
			});
			
			console.log("배열에 담긴 값 : "+tdArr);
           // console.log("배열에 담긴 값 : "+document.getElementById('field_11').("checked"));
	        	        
 			document.getElementById('field_1').value =tdArr[0];
			document.getElementById('field_2').value = tdArr[1];
			document.getElementById('field1').value = tdArr[2];
            document.getElementById('field2').value = tdArr[3];
            document.getElementById('field3').value = tdArr[4];
            document.getElementById('field4').value = tdArr[5];
            document.getElementById('field5').value = tdArr[6];
			document.getElementById('field6').value = tdArr[7];
			document.getElementById('field7').value = tdArr[8];
            document.getElementById('field8').value = tdArr[9];

			var str = tdArr[10];
            var res = str.split(')');

			document.getElementById('field9').value = res[0].substring(1,30);
			document.getElementById('field10').value = res[1];
            document.getElementById('field11').value = tdArr[11];
			document.getElementById('field12').value = tdArr[12];
			document.getElementById('field13').value = tdArr[13];
			//계좌정보
			for (var i=13;i<16 ; i++)
			{
			    var str = tdArr[i+1];
				var res = str.split("/");
                for (var j=0;j<3 ;j++ )
                {
					
				   var id = 'field'+eval(i+1)+'_'+j;
                   document.getElementById(id).value = res[j];
				}
				
			
			
			}
			//담당자정보
			for (var i=16;i<19 ; i++)
			{
			    var str = tdArr[i+1];
				if (str!='')
				{
				     var res = str.split("/");
					for (var j=0;j<5 ;j++ )
					{
						
					   var id = 'field'+eval(i+1)+'_'+j;			  
					   document.getElementById(id).value = res[j];
					   
					}	
				}
			}
			//alert(tdArr[2]);
			
			/*str +=	" * 클릭된 Row의 td값 = No. : <font color='red'>" + no + "</font>" +
					", 아이디 : <font color='red'>" + userid + "</font>" +
					", 이름 : <font color='red'>" + name + "</font>" +
					", 이메일 : <font color='red'>" + email + "</font>";		
			
			$("#ex2_Result1").html(" * 클릭한 Row의 모든 데이터 = " + tr.text());		
			$("#ex2_Result2").html(str);	

		   */
});

function datasave(){

   var a =document.querySelectorAll('[id*="field"]');  
  
   //JSON형태로 데이타 만들어서 넘길거야....^^ 
   var georae = new Array() ;
  
      // 객체 생성
   var data = new Object() ;    
   data.geocode = a[0].value;  
   data.geoname = a[1].value;
   data.geobunryu = a[2].value;
   data.geogubun = a[3].value;
   data.geoboss =  a[4].value;
   data.businessNum = a[5].value;
   data.tel = a[6].value;
   data.fax = a[7].value;
   data.postnum = a[8].value;
   data.address = a[9].value;
   data.yeop = a[10].value;
   data.jongmok = a[11].value;
   data.gita = a[12].value;
   data.account1 = a[13].value+'/'+a[14].value+'/'+a[15].value;
   data.account2 = a[16].value+'/'+a[17].value+'/'+a[18].value;
   data.account3 = a[19].value+'/'+a[20].value+'/'+a[21].value;
   data.recharger1 = a[22].value+'/'+a[23].value+'/'+a[24].value+'/'+a[25].value+'/'+a[26].value; 
   data.recharger2 = a[27].value+'/'+a[28].value+'/'+a[29].value+'/'+a[30].value+'/'+a[31].value; 
   data.recharger3 = a[32].value+'/'+a[33].value+'/'+a[34].value+'/'+a[35].value+'/'+a[36].value; 

   // 리스트에 생성된 객체 삽입
   georae.push(data) ;
	   
   var xhr = new XMLHttpRequest();
   xhr.open('POST', 'georae_post.php');
   xhr.onreadystatechange = function(){
   if(xhr.readyState === 4 && xhr.status === 200){
	
	
	   var _tzs = xhr.responseText;
	   if (_tzs ==="success")
	   {
			alert("저장하였습니다.");
	   }
	   
	   document.querySelector('#side').innerHTML = _tzs; 
	 }
   }
   xhr.setRequestHeader("Content-Type", "application/json");
   xhr.send(JSON.stringify(georae)); 
   


}

</script>