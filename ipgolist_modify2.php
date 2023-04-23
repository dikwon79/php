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

 
    include('headipgo.php');

	
	$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';
	$nowdate =date("Y-m-d");
  
?>
<html>
<head>
<link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>

<script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>

<script type="text/javascript">
$(document).ready(function(){
   
$( '.col-sm-4' ).hide();
$('#rightipgo').attr('class','col-sm-12');
$("button.hide1").text('show');
$("button.hide1").attr('class','show1');


  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
   $( 'button.hide1' ).click( function() {

	     if($(this ).attr( 'class' )=='hide1'){
          $( '.col-sm-4' ).hide();
		  $('#rightipgo').attr('class','col-sm-12');
		  $("button.hide1").text('show');
		  $(this).attr('class','show1');
		 }else{
          $('#leftipgo').show();
		  $('#rightipgo').attr('class','col-sm-8');
		  $("button.show1").text('hide');
		  $(this).attr('class','hide1');

		 }

        } );
		 $( 'button.show1' ).click( function() {

	     if($(this ).attr( 'class' )=='hide1'){
          $( '.col-sm-4' ).hide();
		  $('#rightipgo').attr('class','col-sm-12');
		  $("button.hide1").text('show');
		  $(this).attr('class','show1');
		 }else{
          $('#leftipgo').show();
		  $('#rightipgo').attr('class','col-sm-8');
		  $("button.show1").text('hide');
		  $(this).attr('class','hide1');

		 }

        } );

   
});
//<![CDATA[
$(function(){
	
	
	$("#datePicker").datepicker({
		onSelect:function(dateText, inst) {
			console.log(dateText);
			console.log(inst);
		}
	});
});

$(document).keydown(function(event) {
  if (event.keyCode == '40') {
       add_row();
  }
  else if (event.keyCode == '38') {
       delete_row();
  }
});
//]]>

function aa(geocode)
{
  
   var xmlhttp=new XMLHttpRequest();
   var inameD= "myTable";
   
   xmlhttp.open("GET","historyipgo.php?geocode="+geocode,false);
   xmlhttp.send(null);
   
   document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

}
</script>

<style>
#navhead{
  
    background-color : #FFEBF0;
    height:150px;
    line-height:30px;
    padding:30px 0;
    margin : 10px -15px;
}
.container{ 
    width : 96%;

}
#navhead{

    margin : 0 0 0 -40px;
}

#leftipgo{
   margin : 0 0 0 -40px;
     
}
#buttonname{
     margin : 0 0 0 -40px;
 
}
#rightipgo{
   margin : 20px 0 0 -20px;
     
}
html {
height: 100%;
}
body {
margin: 0;
height: 100%;
min-height:100%; 
}	
section{
   position :relative;
  
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
			
				<div class="row">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item">라벨발행</a>
							<a href="ipgo.php" class="list-group-item active">입고수정</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="index.html" class="list-group-item">재고장</a>
							<a href="index.html" class="list-group-item">출고검증</a>
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


						   
						  $processdate = $_GET['processdate'];
						  $geoname = $_GET['geoname'];
						  $geoname = explode('/',$geoname);
						  $changoname = $_GET['changoname'];
                          $changoname = explode('/',$changoname); 
						  $idate=substr($processdate,0,10);
						  $numbering=substr($processdate,11,200);
						 

						  $sql = "select * from ipgo where ipgodate='$idate' and ipgonum='$numbering'";
						  $stmt = $con->prepare($sql);
						  $stmt->execute();
                          
					  
                          
						?>
							<div class="container">
							
							
						   <div id="navhead">
						   <form class="navbar" role="search" method="post" action="">
                               <div class="row">
							      <div class="col-sm-2">
                                  
							     	<h1 class="h2">&nbsp;입고수정</h1><hr>
						
								  </div>
                                  <div class="col-sm-10">
                                       <div class="col-sm-1">
									   일자 : 
									   </div>
									   <div class="col-sm-5">

									   <input type="text" name="date" id="datePicker" size="30" value='<? echo $idate; ?>'/>
									   <input type='hidden' id='olddate' value='<?=$idate?>'>
									   <input type='hidden' id='numbering' value='<?=$numbering?>'>

									   <input type="button" value="달력" onclick="$('#datePicker').datepicker('show');" />
									   </div>
									   <div class="col-sm-1">
									   거래처 : 

									   </div>
									   
									   <div class="col-sm-5"><input  onkeypress="enter_test('georae')" name="georae" id="georae"  placeholder="거래처" size="15" value="<?=$geoname[0]?>"/><input type="text" id="georaename" name="georaename" size="15" value="<?=$geoname[1]?>"/></div>
							           

                                       <div class="row-pt-5">
									   
									   <div class="col-sm-1"> 
									   담당자 : 
									   </div>
									   <div class="col-sm-5">

									   <input type="text" name="charger" id="charger" size="30" value='<?=$_SESSION['user_id']?>'/>
									   </div>
									   <div class="col-sm-1">
									   입고창고 : 
									   </div>
									   
									   <div class="col-sm-5"><input onkeypress="enter_test('chango')" type="text" id='chango' name="chango"  placeholder="창고" size="15" value='<?=$changoname[0]?>'><input type="text" id='changoname' name="chango2" size="15" value='<?=$changoname[1]?>' ></div>
									   
									   </div>
                                       

 
								  </div>
                                </div>





							  
							   
							 </form>           
						   </div>
						   
						   <div id='buttonname' class='row'>
						   <button onclick="add_row()">행 추가하기</button>
						   <button onclick="delete_row()">행 삭제하기</button><button class="hide1">Hide</button>
                           </div>

						   
						   
						   <div class="row">
						   <div id='leftipgo' class="col-sm-4">
							 <h2>기존 입고검색</h2>
							  <p>먼저 거래처 검색을 하셔야 합니다.</p>  
							  <input class="form-control" id="myInput" type="text" placeholder="Search..">
							  <br>
							 
							  <table class="table table-bordered table-striped">
								<thead>
								  <tr>
									<th>품목코드</th>
									<th>품목명</th>
									<th>가격</th>
									<th>최근입고</th>
						 
								  </tr>
								</thead>
								<tbody id="myTable">
								 
								</tbody>
							  </table>
						  
						   </div>

						   <div id='rightipgo' class="col-sm-8">
							
							<table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
								<thead>  
								<tr style="border: solid 1px;">  
									<th style="border: solid 1px;"><input type='checkbox'></th> 
									<th style="border: solid 1px ; padding:0px;" NOWRAP>품목코드</th>  
									<th style="border: solid 1px ; padding:0px;" NOWRAP>품목명</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>규격</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>BOX</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>낱개</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>수량</th>

									<th style="border: solid 1px ; padding:0px;" NOWRAP>단가</th>
								
									<th style="border: solid 1px ; padding:0px;" NOWRAP>공급가액</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>부가세</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>유통기한</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>합계</th>
									<th style="border: solid 1px ; padding:0px;" NOWRAP>비고</th>
									
								</tr>
								</thead>  
								<tbody id="my-tbody">

								<?
                               
						        if ($stmt->rowCount() > 0)
							    {
								
								  $s=1;
								  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
								  {
									    extract($row); 
                       

								?>
								<tr style="border: solid 1px;">
									<td style="border: 1px solid;"><input type='checkbox'><input type='hidden' id='pid<?=$s?>' value='<?=$pid?>'></td> 
									<td style="border: 1px solid; padding:0px;"><input type='text' onkeypress="enter_test(<?=$s?>)" id='row_code<?=$s?>' size="35" style="width:100%; height :33px;border:0;" value="<?=$itemcode?>"></td>  
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_name<?=$s?>' size="120" style="width:100%;height :33px;border:0;" value="<?=$itemname?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_rule<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$itemrule?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' onkeypress="enter_count(<?=$s?>)" id='row_box<?=$s?>' size="10" style="width:100%; height :33px;border:0;" value="<?=$itembox?>">
									<input type='hidden' id='row_ipsu1'>
									</td>
									<td style="border: 1px solid; padding:0px;"><input type='text' onkeypress="enter_count(<?=$s?>)" id='row_ea<?=$s?>' size="10" style="width:100%; height :33px;border:0;" value="<?=$itemea?>">
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_surang<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$surang?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_price<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$buyprice?>"></td>
								
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_supply<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$supplyprice?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_tax<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$tax?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_expire<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$hap?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_hap<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$expiration?>"></td>
									<td style="border: 1px solid; padding:0px;"><input type='text' id='row_etc<?=$s?>' size="20" style="width:100%; height :33px;border:0;" value="<?=$etc?>"></td>	
								</tr>
								
								 <? $s = $s+1; } } ?>
								</tbody>
							 </table>
							 
								<button type="button" class="btn btn-primary" onclick="save()">수정하기</button>
								<button type="button" class="btn btn-warning" onclick="save('withprint')">수정+거래명세서</button>
								<button type="button" class="btn btn-seconday" onclick="newipgo()">신규입력</button>

							 

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
		
	

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>


<script>
 function save(type){

    var trcount = document.getElementById("table");
    var rowsCount = trcount.rows.length;
	
    var ipgodate = document.getElementById('datePicker').value;
	var olddate = document.getElementById('olddate').value;
    var numbering = document.getElementById('numbering').value;
	var charger = document.getElementById('charger').value;
	
	var georae = document.getElementById('georae').value;
	var georaeN = document.getElementById('georaename').value;
	if (!georae)
	{
		alert('거래처를 입력하여 주세요.');
		document.getElementById('georae').focus();
		return 0;

	}
	var warehouse = document.getElementById('chango').value;
	var warehouseN = document.getElementById('changoname').value;
	
	// 리스트 생성
    var ipgoList = new Array() ;
         
    var rowcount =0;
    for(var i=1; i <rowsCount; i++){
             
            // 객체 생성
           
            var data = new Object() ;
             
            data.number = i ;
            if(!document.getElementById('row_code'+i).value) continue;
            data.pid =document.getElementById('pid'+i).value;
            
            data.itemcode =document.getElementById('row_code'+i).value;
            data.itemname =document.getElementById('row_name'+i).value;
            data.itemrule =document.getElementById('row_rule'+i).value;
            data.itembox =document.getElementById('row_box'+i).value;
            data.itemea =document.getElementById('row_ea'+i).value;
            data.itemsurang =document.getElementById('row_surang'+i).value;
            data.itemprice =document.getElementById('row_price'+i).value;
            data.itemsupply=document.getElementById('row_supply'+i).value;
            data.itemtax =document.getElementById('row_tax'+i).value;
            data.itemexpire =document.getElementById('row_expire'+i).value;
            data.itemhap =document.getElementById('row_hap'+i).value;
            data.itemetc =document.getElementById('row_etc'+i).value;
            
 
             
            // 리스트에 생성된 객체 삽입
            ipgoList.push(data) ;
            rowcount++;
        }
         
	    if (rowcount<1)
	    {
	        alert('입력이 하나도 되지 않았습니다. 확인바랍니다.');
			return 0;
	    }
        // String 형태로 변환
        //var jsonData = JSON.stringify(ipgoList) ;
         
        //alert(jsonData) ;

        var xhr = new XMLHttpRequest();
     
			
		xhr.open('POST', 'ipgolist_modifypost.php');
		 
		xhr.setRequestHeader("Content-Type", "application/json");
		   
		xhr.send(JSON.stringify({"ipgodate" : ipgodate , "olddate" : olddate , "numbering" : numbering ,"charger" : charger , "georae" : georae ,"georaeN" : georaeN ,"warehouse" : warehouse ,"warehouseN" : warehouseN ,"maindata" : ipgoList})); 
		xhr.onreadystatechange = function(){
		if(xhr.readyState === 4 && xhr.status === 200){
		
		
		   var _tzs = xhr.responseText;
		   if (_tzs)
		   {
				
				alert(_tzs);
                
                if (type=='withprint')
                {
                
                var ipgonum= _tzs.split('/');
                var popupWidth = 800;
				var popupHeight = 900;
				
				
				root = 'form_print.php' + '?processdate='+ipgodate+'/'+ipgonum[0].trim();

				
				var popupX = (window.screen.width / 2) - (popupWidth / 2);
				// 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

				var popupY= (window.screen.height / 2) - (popupHeight / 2);
				// 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음


				 num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=800, width=1000, left='+ popupX + ', top='+ popupY;
				 
				 window.open(root, '전표인쇄', num);  
			     location.reload();

                }
				else{

                   location.reload();

				}
			    
 

				
		   }
		   
		   
		   
		 }
		 	 
		}
       


}
function newipgo(){
    location.href="ipgo.php";
}
 function enter_count(numbering){
    if (window.event.keyCode == 13) {
	var boxsu =  Number(document.getElementById('row_box'+numbering).value);
	var ea =  Number(document.getElementById('row_ea'+numbering).value);
    var ipsu =  document.getElementById('row_ipsu'+numbering).value;
	
	var total = (boxsu*ipsu)+ea;
	document.getElementById('row_surang'+numbering).value = total;
	document.getElementById('row_expire'+numbering).focus();
    } 
 
}
 function enter_test(option) {
        if (window.event.keyCode == 13) {
             
            var popupWidth = 400;
			var popupHeight = 500;
			
			var popupX = (window.screen.width / 2) - (popupWidth / 2);
			// 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

			var popupY= (window.screen.height / 2) - (popupHeight / 2);
			// 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음
           

			num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=400, width=500, left='+ popupX + ', top='+ popupY;

			if (option==='georae')
			{
			    var geonameinfo = document.getElementById('georae').value;
				var root = 'search.php' + '?geoname='+geonameinfo;
				var type = '거래처검색'
			
			}
			else if (option==='chango')
			{
				 var geonameinfo = document.getElementById('chango').value;
				 var root = 'searchchango.php' + '?changoname='+geonameinfo;
				 var type = '창고검색'
			}
			else 
			{
                 

				 var geonameinfo = document.getElementById('row_code'+option).value;
				 var root = 'searchitem.php' + '?item='+geonameinfo+'&num='+option;
				 var type = '품목검색'
				 num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=500, width=1000, left='+ popupX + ', top='+ popupY;

			}
			//root = root + '?processdate='+processdate+'&chasu='+value;
			
			window.open(root, type, num);   

		   }
}


   
  function add_row() {
    var my_tbody = document.getElementById('my-tbody');
    //var row = my_tbody.insertRow(0); // 상단에 추가
    var row = my_tbody.insertRow( my_tbody.rows.length ); // 하단에 추가
	
	var i = my_tbody.rows.length;
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
	var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
	var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
	var cell7 = row.insertCell(6);
    var cell8 = row.insertCell(7);
	var cell9 = row.insertCell(8);
    var cell10 = row.insertCell(9);
	var cell11 = row.insertCell(10);
    var cell12 = row.insertCell(11);
	var cell13 = row.insertCell(12);

	cell1.style.border = '1px solid';
    cell1.innerHTML = "<tr><td><input type='checkbox'/>";
    cell2.style.border = '1px solid';
    cell2.style.padding = '0px';
	cell2.innerHTML = "<input type='text' onkeypress=enter_test('"+i+"') id='row_code"+i+"' name='row_code"+i+"' size='35' style='width:100%; height :33px;border:0;'>";
	cell3.style.border = '1px solid';
    cell3.style.padding = '0px';
	cell3.innerHTML = "<input type='text' id='row_name"+i+"' name='row_name"+i+"' size='120' style='width:100%; height :33px;border:0;'>";
	cell4.style.border = '1px solid';
    cell4.style.padding = '0px';

	cell4.innerHTML = "<input type='text' id='row_rule"+i+"' name='row_rule"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell5.style.border = '1px solid';
    cell5.style.padding = '0px';

	cell5.innerHTML = "<input type='text' onkeypress=enter_count('"+i+"') id='row_box"+i+"' name='row_box"+i+"' size='10' style='width:100%; height :33px;border:0;'><input type='hidden' id='row_ipsu"+i+"'>";
	cell6.style.border = '1px solid';
    cell6.style.padding = '0px';

	cell6.innerHTML = "<input type='text' onkeypress=enter_count('"+i+"') id='row_ea"+i+"' name='row_ea"+i+"' size='10' style='width:100%; height :33px;border:0;'>";
	cell7.style.border = '1px solid';
    cell7.style.padding = '0px';

	cell7.innerHTML = "<input type='text' id='row_surang"+i+"' name='row_surang"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell8.style.border = '1px solid';
    cell8.style.padding = '0px';

	cell8.innerHTML = "<input type='text' id='row_price"+i+"' name='row_price"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell9.style.border = '1px solid';
    cell9.style.padding = '0px';

	cell9.innerHTML = "<input type='text' id='row_supply"+i+"' name='row_supply"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell10.style.border = '1px solid';
    cell10.style.padding = '0px';

	cell10.innerHTML = "<input type='text' id='row_tax"+i+"' name='row_tax"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell11.style.border = '1px solid';
    cell11.style.padding = '0px';

	cell11.innerHTML = "<input type='text' id='row_expire"+i+"' name='row_expire"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell12.style.border = '1px solid';
    cell12.style.padding = '0px';

	cell12.innerHTML = "<input type='text' id='row_hap"+i+"' name='row_hap"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
	cell13.style.border = '1px solid';
    cell13.style.padding = '0px';

	cell13.innerHTML = "<input type='text' id='row_etc"+i+"' name='row_etc"+i+"' size='20' style='width:100%; height :33px;border:0;'>";
    document.getElementById('row_code'+i).focus();
  

  }

  function delete_row() {
    var my_tbody = document.getElementById('my-tbody');
    if (my_tbody.rows.length < 2) return;
    // my_tbody.deleteRow(0); // 상단부터 삭제
    my_tbody.deleteRow( my_tbody.rows.length-1 ); // 하단부터 삭제
	document.getElementById('row_code'+my_tbody.rows.length).focus();
  }
</script>