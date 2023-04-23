<?php
    $jsonStr = file_get_contents("config.json");
	$config = json_decode($jsonStr); // if you put json_decode($jsonStr, true), it will convert the json string to associative array



   
    if(isset($_GET['search']))
	{
	   $getdate = $_GET['search'];
	   //echo substr($getdate,2,10);
       $value =  date("Y-m-d", strtotime(substr($getdate,2,10))); 
	   //echo $value;
	   //$value = new DateTime($getdate); 
	}
	else{
	   $value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
    }
	
    if(isset($_POST['tabid'])) $tab =$_POST['tabid'];
	if(isset($_GET['tabid'])) $tab =substr($_GET['tabid'],2,strlen($_GET['tabid'])-4);
	
	
	//echo $tab;

	$tabidinfo = isset($tab) ? $tab : 'cj';  // tab 아이디 정보
    
	
	

	if ($tabidinfo == 'shinsegye'){
	    $db = 'labelshinsegye';
	}
	else{
         
		 $db = 'labelcjimsi';
	}
	try { 

                $sql = "SELECT MAX(chasu) from ".$db." where idate ='$value' and companyname='$tabidinfo' and worker='".$_SESSION['user_id']."' ";

		
				$stmt = $con->prepare($sql);

				$stmt->execute();
			   
			} catch(PDOException $e) {
				die("Database error. " . $e->getMessage()); 
			}

			$row = $stmt->fetch();  
			$chasu = $row['MAX(chasu)']+1;


			
    ?>

	
	<head>
    <style>
        .container{ 
          width : 95%;
		  margin-left :25px;

        }
	
           .col-md-10 my-2{

             padding-left:0;
		}
		#navhead{
          background:#d2d2d2; 
          margin-left :-30; 
          margin-right :0; 
		

		}
		.col-sm-12{
         
          margin-left :-15; 
          padding-left:0;
		  padding-right:0;

		}
		#top{
            
           top :-20; 
		}
		#billboard1{
		  top : 20;
          font-size : 60px;
		}
		#billboard2{
		  top : 20;
          font-size : 60px;
		  color: red;
		 
		}
		#printoption{
          font-size : 34px;
		  color : red;
          font-weight : bold;             
		}
		#centeroption{
          font-size : 34px;
		  color : blue;
          font-weight : bold;             
		}
		.fixedHeader {
			position: sticky;
			top: 0;
	        
			text-align : center
		}
		.rightfix {
			height: 100%;
			overflow: auto;
			width : 100%;
			
		}

	</style>
    <link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>
       
	</head>
    
    <div class="container">
	
    
	<div id="navhead">
	<form class="navbar" role="search" method="post" action="printLabel.php">
    <div id='top' class="col-sm-3">
    	<h1 class="h2"><?=$tabidinfo;?>&nbsp; 발행</h1>
    </div>
 	<div class="col-sm-2">

	<input type="text" id="datePicker" name='search' class="form-control" value='<?=$value;?>'>
	<input  id="tabid" name="tabid" type="hidden" class="form-control" value='<?=$tabidinfo;?>'>
	</div>
	<div class="col-sm-2">
	<select name="chasu" id="chasu" class="form-control">
		  <? for($i=1;$i<31;$i++){ ?>
		  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?>><? echo $i.'차작업'?></option>
		  <?  }  ?>
		  
	</select>


	</div>
	<div class="col-sm-3">
	
	<button type="button" id="resubmit" class="btn btn-danger" onclick="submit()">조회</button>

	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#my80sizeCenterModal">유통이력</button>

	<button type="button" class="btn btn-primary" onclick="label('<?=$_SESSION['user_id']?>')">라벨발행</button>
	</div>
	<div class="col-sm-2"><input class="pt-3" type='file'  id='file' multiple /></div>  <!-- webkitdirectory directory -->
	</form>    
	</div>
	<div class="col-sm-12">
        <!-- Tab을 구성할 영역 설정-->
		<div style="left-margin:0px;margin-left:-15;">
		<!-- Tab 영역 태그는 ul이고 클래스는 nav와 nav-tabs를 설정한다. -->
		<ul id="myTab" class="nav nav-tabs">
		<!-- Tab 아이템이다. 태그는 li과 li > a이다. li태그에 active는 현재 선택되어 있는 탭 메뉴이다. -->
		<li class="<?= $tabidinfo == 'cj' ? 'active' : '' ?>"><a href="#cj" data-toggle="tab">씨제이</a></li>
		<!-- a 태그의 href는 아래의 tab-content 영역의 id를 설정하고 data-toggle 속성을 tab으로 설정한다. -->
		<li class="<?= $tabidinfo == 'spc' ? 'active' : '' ?>"><a href="#spc" data-toggle="tab">SPC</a></li>
		<li class="<?= $tabidinfo == 'shinsegye' ? 'active' : '' ?>"><a href="#shinsegye" data-toggle="tab">신세계</a></li>
		<li class="<?= $tabidinfo == 'welstory' ? 'active' : '' ?>"><a href="#welstory" data-toggle="tab">웰스토리</a></li>
		<li class="<?= $tabidinfo == 'reading' ? 'active' : '' ?>"><a href="#reading" data-toggle="tab">현재리딩현황</a></li>
		</ul>
		<!-- Tab이 선택되면 내용이 보여지는 영역이다. -->
		<!-- 태그는 div이고 class는 tab-content로 설정한다. -->
		<div class="tab-content">
		<!-- 각 탭이 선택되면 보여지는 내용이다. 태그는 div이고 클래스는 tab-pane이다. -->
		<!-- active 클래스는 현재 선택되어 있는 탭 영역이다. -->
		<div class="<?= $tabidinfo == 'cj' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="cj">
		     <!-- 첫번째 탭 내용 -->
             <? include "cjsection.php"; ?>
	    </div>
		<div class="<?= $tabidinfo == 'spc' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="spc">
		 <!--<div style="overflow-y:scroll;height:200px;"> -->
			 <? include "spcsection.php"; ?>	  
		</div>
		
		<!-- fade 클래스는 선택적인 사항으로 트랜지션(transition)효과가 있다.
		<!-- in 클래스는 fade 클래스를 선언하여 트랜지션효과를 사용할 때 in은 active와 선택되어 있는 탭 영역의 설정이다. -->
		<div class="<?= $tabidinfo == 'shinsegye' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="shinsegye">
		    <!-- 첫번째 탭 내용 -->
             <? include "shinsegyesection.php"; ?> 
		</div>
       
		<div class="<?= $tabidinfo == 'welstory' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="welstory">
		    <? include "welstorysection.php"; ?> 
          
		</div>
		<div class="<?= $tabidinfo == 'reading' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="reading">현재리딩 현황
		
		   <? include "readingmaterial.php"; ?> 
          
		</div>
		



    </div>

</div>

</body>
</html>
<script>
$("#myTab a").click(function(e) {
   e.preventDefault();
   var target = $(e.target).attr("href");
   
   $('#tabid').val(target.substring(1));
   $("#resubmit").trigger("click");


  // $("resubmit").click();
});

$(document).ready(function(){
    for (var i = 0; i < sessionStorage.length; i++) {
 

	var n = sessionStorage.getItem("cut"+i);

    if (n==='Y')
    {
		$("input:checkbox[id=cut"+i+"]").prop("checked", true);
    }
	else {

        $("input:checkbox[id=cut"+i+"]").prop("checked", false);

	}
    }
    var n = sessionStorage.getItem("blackunlock");
	if (n==='Y')
    {
		$("input:checkbox[id=blackunlock]").prop("checked", true);
    }
	else {

        $("input:checkbox[id=blackunlock]").prop("checked", false);

	}
    var n = sessionStorage.getItem("centerunlock");
	if (n==='Y')
    {
		$("input:checkbox[id=centerunlock]").prop("checked", true);
    }
	else {

        $("input:checkbox[id=centerunlock]").prop("checked", false);

	}

	var n = sessionStorage.getItem("onlychange");
	if (n==='Y')
    {
		$("input:checkbox[id=onlychange]").prop("checked", true);
    }
	else {

        $("input:checkbox[id=onlychange]").prop("checked", false);

	}
    
	
	
	
	//if($("input:checkbox[id='" + chkValue + "']").is(":checked")){ // 체크했을 때,

});
/*
$("input:checkbox").on('click', function() { 
	 //alert('체크박스 클릭'+ $(this).attr('id'));
     //alert($("input:checkbox[id=blackunlock]").prop("checked"));
	 if($(this).attr('id')==='centerunlock'){
		 
		 if ($("input:checkbox[id=blackunlock]").prop("checked")){
		 
		 }
		 else{
            alert('블랙리스트 먼저 체크하셔야 합니다');
		    $(this).prop("checked", false);
		  
		 }
	 }
	 if($(this).prop('checked')){

	  $(this).prop("checked", true);
	  var click_val =  $(this).attr('id');
	  
      sessionStorage.setItem(click_val, "Y"); 
       
     }
     else {
       $(this).prop("checked", false);
	   var click_val =  $(this).attr('id');
       sessionStorage.setItem(click_val, "N"); 

    }
 });  */
function printevent(){
        
 

		 if ($("input:checkbox[id=blackunlock]").prop("checked")){
			 $("input:checkbox[id=blackunlock]").prop("checked", false);
			
             sessionStorage.setItem("blackunlock", "N"); 
		 
		 }
		 else{


            
            
		    $("input:checkbox[id=blackunlock]").prop("checked", true);
           
            sessionStorage.setItem("blackunlock", "Y"); 
		  
		 }

}
function centerevent(){

        if ($("input:checkbox[id=blackunlock]").prop("checked")){
			 if ($("input:checkbox[id=centerunlock]").prop("checked")){
				 $("input:checkbox[id=centerunlock]").prop("checked", false);
				 sessionStorage.setItem("centerunlock", "N"); 
			 
			 }
			 else{
				
				$("input:checkbox[id=centerunlock]").prop("checked", true);
				sessionStorage.setItem("centerunlock", "Y"); 
			  
			 }
			
		
		}
		else
     	{
			alert('블랙리스트부터 체크하셔야합니다.');
		}	   

		

}
function windowSize(root, value, num) {   
	var popupWidth = 800;
	var popupHeight = 900;
    var processdate = document.getElementById('datePicker').value;
	var onlychange = false;
    if ($("input:checkbox[id=onlychange]").prop("checked"))
    {
       onlychange = true;
	}
	else onlychange = false;
    //alert(onlychange);
	//alert(value);
    if (onlychange==true && value=='1')
    {
		alert("1차 작업에는 변경분인쇄가 불가능합니다");
		return;
    }
    root = root + '?processdate='+processdate+'&chasu='+value+'&onlychange='+onlychange;
	var popupX = (window.screen.width / 2) - (popupWidth / 2);
	// 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

	var popupY= (window.screen.height / 2) - (popupHeight / 2);
	// 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음


     num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=800, width=1000, left='+ popupX + ', top='+ popupY;
	
	window.open(root, value, num);   
	
	//var status = "toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,width=240, height=200, top=0,left=20";

}
function modalsave(){

    var trcount = document.getElementById("modaltable");
    var rowsCount = trcount.rows.length;
	



  
    
    // 리스트 생성
    var expireList = new Array() ;
         
    var rowcount =0;
    for(var i=1; i <rowsCount; i++){
             
            // 객체 생성
           
            var data = new Object() ;
             
            data.itemcode =document.getElementById('itemcode'+i).value;
            data.productiondate =document.getElementById('productiondate'+i).value;
            data.duration =document.getElementById('duration'+i).value;
            data.etc =document.getElementById('etc'+i).value;
            
            
 
             
            // 리스트에 생성된 객체 삽입
            expireList.push(data) ;
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



   
		xhr.open('POST', 'modalsave.php');
				 
		xhr.setRequestHeader("Content-Type", "application/json");
		   
		xhr.send(JSON.stringify({"expireinfo" : expireList})); 
		xhr.onreadystatechange = function(){
		if(xhr.readyState === 4 && xhr.status === 200){
		
		
		   var _tzs = xhr.responseText;
		   if (_tzs)
		   {
				alert(_tzs);
			
		   }
		   
		  
		   
		 }
		}

}
function checkboxclick(){
var check = $("#checkall").prop("checked");
$("input[name=check]").prop("checked", check);
}

function label(id){
  var processdate = document.getElementById('datePicker').value;
  var chasu = document.getElementById('chasu').value-1;
  var catering = document.getElementById('tabid').value;

  location.href="iaanlabel://"+processdate+','+chasu+','+catering+','+id;  

}

var processdate = document.getElementById('datePicker').value;
var chasu = document.getElementById('chasu').value;



function gridExcelToWeb(file, center, target,filenum, count){
    
	var reader = new FileReader(); 

    reader.onload = function (evt) {
        if (evt.target.readyState == FileReader.DONE) {
            var data = evt.target.result;  //해당 데이터, 웹 서버에서 ajax같은거로 가져온 blob 형태의 데이터를 넣어주어도 동작 한다.
       
			data = new Uint8Array(data);
			
            var workbook = XLSX.read(data, {type : 'array' , cellDates: false});
			


            var sheetName = '';
            workbook.SheetNames.forEach( function(data, idx){   //시트 여러개라면 이 안에서 반복문을 통해 돌리면 된다.
                if(idx == 0){
                    sheetName = data;
					
                }
            });
            test1 = workbook;
          
            var jsondata= XLSX.utils.sheet_to_json (workbook.Sheets[sheetName],{skipHeader: true});
			//jason으로 파일 보내기 
			
            var blacklist='';
			//check를 가진 값의 이름을 가져오기

			
			if(document.getElementById("blackunlock").checked == false){
			   blacklist = document.getElementById('blackunlock').value;  }
			else blacklist ='blackon';

            //수도권 센터 블랙
			var centerblack='';
			if(document.getElementById("centerunlock").checked == false){
			   centerblack = document.getElementById('centerunlock').value;  }
			else centerblack ='centeron';


			//센터별 인쇄시 컷팅정보

			var cuttinglist = new Array();
			var cutsize = document.getElementsByName("cut").length;
			for(var i = 0 ; i <cutsize ;i++){

				if(document.getElementsByName("cut")[i].checked == true){
					cuttinglist.push(document.getElementsByName("cut")[i].value);
				
				}


				
			}
			var xhr = new XMLHttpRequest();
     
			if (jsondata[0]['현 발주'])
			{
                xhr.open('POST', 'label_welstory.php');
			}
			else if (jsondata[0]['주문KEY'])
			{
                xhr.open('POST', 'label_spc.php');
			}
			else{
		
			xhr.open('POST', 'json_labeldata.php',false);}
			 
			xhr.setRequestHeader("Content-Type", "application/json");
			   
            xhr.send(JSON.stringify({"filenum" : filenum , "centerN" : center , "daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist , "centerblack" : centerblack , "cuttinglist" : cuttinglist ,"maindata" : jsondata})); 
            //xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
               
			  
			   
			 document.querySelector('#side').innerHTML = '('+count+')전체('+filenum+')'+xhr.responseText+document.querySelector('#side').innerHTML;; 

			 if (count == filenum)
			 {
				 alert(xhr.responseText);
				 //var chasuNum = document.getElementById('chasu').value;
				
                
                 window.setTimeout(function(){

                       //windowSize('printchongcj.php',chasuNum,'width=900,height=558')
                       
                    
						    $.post("printchongcj_post.php",{chasu:chasu, daten:processdate},function(data){
							
							if (data.trim()==='success')
							{
								location.reload();
								windowSize('printchongcj2.php',chasu,'width=900,height=558')

							}
							else{ alert('출고검증입력 오류');}
							
							
						});



                   }, 2000);  // 0.2 초 지연 후 출력


				 //location.reload();
				
			 }	   
			   
			  
               
         }
           // }

        
	
        }
    };
    reader.readAsArrayBuffer(file);
    

	

}   
 
$('#file').change( function(){
    var result= confirm("실행하시겠습니까?");
	if (result)
	{
	    //document.write("<h1> 실행합니다. </h1>")
		fileList = $(this)[0].files;  //파일 대상이 리스트 형태로 넘어온다.
        var count = fileList.length-1;
		
		for(var i=0;i < fileList.length;i++){
			//var file = fileList[i];
		////const selectedFile = $(this)[0].files[0];
		
		var selectedFile = fileList[i];
		
		var name =selectedFile.name; 
		
		var startpoint = name.lastIndexOf("."); 

        var filename = (name.substring(startpoint+1,selectedFile.length)).trim();

       

        if (filename ==="xlsx" || filename==="xls")
        {
			
				 //	평/왜/용/광
			var sPandan = name.indexOf("xlsx");
			if (sPandan > 0)
			{
			   var center =(name.substring(sPandan+4,sPandan+7)).trim();
			}
			
			
		
		    gridExcelToWeb(selectedFile, center, $('#grid'+i),i,count); 
            	 

        }
		else if (filename ==="txt")
		{
			processFile(selectedFile, center, $('#grid'+i),i); 
		}
		else{
            alert("처리파일이 아닙니다.");
			return;

		}	
	  } 
	  $("#file1").val("");



	 
	}else{

       $("#file1").val(""); //크롬에서만 작동 ......크롬 권장

	}

    

});
//text file process
function processFile(file, center, target,filenum){
	var reader = new FileReader();
	reader.readAsText(file,"euc-kr");
	
	reader.onload = function () {
	//var table = '<TABLE WIDTH="100%" CELLSPACING=0 border="1"><TR>';	
    var filedata = reader.result;
    
	var cells = filedata.split('\n').map(function (el) { return el.split('	'); });
	 
    //var headings = cells.shift();
    //var headings = ['no','gubun','itemcode','itemname','ddate','state','kindof','temp','palzu','customercode',	'customer','ipsu','ipgoplace1','ipgozone1','bus1','surang1','deliver1','special1','ipgoplace2','ipgozone2',	'bus2','surang2','deliver2','special2','change','changsu','unit','diffnum','alzunum','palzuitem',	'ordernum','orderitmenum','done','sorter'];
	var headings = cells[2];
    cells.splice(0,3);
	
    
	var obj = cells.map(function (el) {
	var obj = {};
	

	for (var i = 0, l = el.length; i < l; i++) {
		obj[headings[i]] = isNaN(Number(el[i])) ? el[i] : +el[i];
	
	}
	  return obj;
	});

  
    //check를 가진 값의 이름을 가져오기
	var blacklist = new Array();
	var size = document.getElementsByName("check").length;
	for(var i = 0; i < size; i++){

		 if(document.getElementsByName("check")[i].checked == true){  
			
			 blacklist.push(document.getElementsByName("check")[i].value);
			 
		}
	}
	//센터별 인쇄시 컷팅정보

	var cuttinglist = new Array();
	var cutsize = document.getElementsByName("cut").length;
	for(var i = 0 ; i <cutsize ;i++){

		if(document.getElementsByName("cut")[i].checked == true){
			cuttinglist.push(document.getElementsByName("cut")[i].value);
		
		}


		
	}

    var xhr = new XMLHttpRequest();
	xhr.open('POST', 'label_shinsegye.php');
	 
	xhr.setRequestHeader("Content-Type", "application/json");
	//xhr.send(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));   
	xhr.send(JSON.stringify({"filenum" : filenum , "daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"cuttinglist" : cuttinglist ,"maindata" : obj})); 
	//xhr.send(JSON.stringify({"daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"maindata" : obj})); 
    xhr.onreadystatechange = function(){
	if(xhr.readyState === 4 && xhr.status === 200){
	
	
	   var _tzs = xhr.responseText;
	   if (_tzs)
	   {
			alert(_tzs);
	   }
	   
	   document.querySelector('#side').innerHTML = _tzs; 
	 }
	}

   }
}
</script>
