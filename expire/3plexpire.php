<?php
    $jsonStr = file_get_contents("../config.json");
	$config = json_decode($jsonStr); // if you put json_decode($jsonStr, true), it will convert the json string to associative array


    include('../dbcon.php'); 
    include('../check.php');
   
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
					 
	
	//$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	//$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';


     $selectname = isset($_POST['inventory']) ? $_POST['inventory'] : '시작';
    
	 if($_SESSION['is_admin'] < '2'){

		$selectname = $_SESSION['user_id'];
 
	 }
	 if ($selectname=='전체'){
		 $selectbox ='';

	 }
	 else{
		 $selectbox =" and georae = '$selectname' ";
	 } 


      

	?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>3pl</title>
	<link rel="stylesheet" href="jquery-ui-1.12.1/jquery-ui.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>

	<script src="jquery-ui-1.12.1/datepicker-ko.js"></script>
	<link rel="stylesheet" href="3pl.css">
    <link rel="stylesheet" href="3plmodal.css">
   
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/css/ui.jqgrid.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/jquery.jqgrid.min.js"></script>
  

	<script type="text/javascript">
	LoadingWithMask();
		$(document).ready(function () {
			hide();
			closeLoadingWithMask();
			$("#myInput").on("keyup", function () {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function () {
					$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			});

			$(function () {


				$("#datePicker").datepicker({
					onSelect: function (dateText, inst) {
						console.log(dateText);
						console.log(inst);
					}
				});
			});
            document.getElementById('preinven').innerText = document.getElementById('imsipreinven').innerText;
			document.getElementById('ipgo').innerText = document.getElementById('imsiipgo').innerText;
			document.getElementById('hide_CJ').innerText = document.getElementById('imsiCJ').innerText;
			document.getElementById('hide_SPC').innerText = document.getElementById('imsiSPC').innerText;
			document.getElementById('hide_SSG').innerText = document.getElementById('imsiSSG').innerText;
			document.getElementById('hide_RS').innerText = document.getElementById('imsiRS').innerText;
			document.getElementById('hide_dongwon').innerText = document.getElementById('imsidongwon').innerText;
			document.getElementById('hide_ahome').innerText = document.getElementById('imsiahome').innerText;
			document.getElementById('hide_wels').innerText = document.getElementById('imsiwels').innerText;
			document.getElementById('hide_hyundae').innerText = document.getElementById('imsihyundae').innerText;
			document.getElementById('hide_etc').innerText = document.getElementById('imsietc').innerText;
			document.getElementById('hide_out').innerText = document.getElementById('imsiout').innerText;
			document.getElementById('adjust').innerText = document.getElementById('imsiadjust').innerText;
            document.getElementById('totalout').innerText = document.getElementById('imsitotalout').innerText;
			document.getElementById('presentinven').innerText = document.getElementById('imsipresentinven').innerText;
			

			const row = document.getElementById('lastline');
            row.style.display = 'none';
            

		});

		function closeLoadingWithMask() {
			$('#mask, #loadingImg').hide();
			$('#mask, #loadingImg').empty();  
		}
        function LoadingWithMask() {
			//화면의 높이와 너비를 구합니다.
			var maskHeight = $(document).height();
			var maskWidth  = window.document.body.clientWidth;
			 
			//화면에 출력할 마스크를 설정해줍니다.
			var mask       = "<div id='mask' style='position:absolute; z-index:5000; background-color:#000000; display:none; left:0; top:0;'></div>";
			var loadingImg = '';
			  
			loadingImg += "<div id='loadingImg'>";
			loadingImg += " <img src='images/Spinner.gif' style='position: relative; display: block; margin: 0px auto;'/>";
			loadingImg += "</div>";  
		  
			//화면에 레이어 추가
			$('body')
				.append(mask)
				.append(loadingImg)
				
			//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채웁니다.
			$('#mask').css({
					'width' : maskWidth
					, 'height': maskHeight
					, 'opacity' : '0.3'
			}); 
		  
			//마스크 표시
			$('#mask').show();   
		  
			//로딩중 이미지 표시
			$('#loadingImg').show();
		} 
        
		function hide(){
			  if ($("[id^=hide]").css('display') == 'none')
			  {
				  $("[id^=hide]").show();//do something
			  }
			  else{
                  $("[id^=hide]").hide();
 
			  }
			
		}
		function getData(){
              
			   alert('tlfgod');
			   
         
			   $.ajax({
					url:'query.php', //request 보낼 서버의 경로
					type:'POST', // 메소드(get, post, put 등)
					
					async: false, //동기: false, 비동기(기본값): ture
					data:{'itemcode':'172165',
						  'idate1': 'test'},
						  //보낼 데이터,
					timeout: 2*60*60*1000, //2 hours,
					success: function(a) {
						//서버로부터 정상적으로 응답이 왔을 때 실행
						"use strict";
						$("#grid").jqGrid({
							colModel: [
								{ name: "itemcode",label :"품목코드", width : 80 },
								{ name: "itemname",label :"품목명" , width : 400 },
								{ name: "lek",label :"렉" , width : 80 },
								{ name: "ipsu",label :"입수" , width : 60  },
								{ name: "now" ,label :"현재고" , width : 60 },
								{ name: "0expire" ,label :"유통기한1" , width : 100 },
								{ name: "0ipgodate" ,label :"입고날짜1" , width : 60  },
								{ name: "0surang" ,label :"수량1" , width : 60  },
								{ name: "1expire" ,label :"유통기한2" , width : 60  },
								{ name: "1ipgodate" ,label :"입고날짜2" , width : 60  },
								{ name: "1surang" ,label :"수량2" , width : 60  },
								{ name: "2expire"  ,label :"유통기한3" , width : 60 },
								{ name: "2ipgodate" ,label :"입고날짜3" , width : 60 },
								{ name: "2surang" ,label :"수량3" , width : 60 },
								{ name: "3expire" ,label :"유통기한4" , width : 60 },
								{ name: "3ipgodate" ,label :"입고날짜4" , width : 60 },
								{ name: "3surang" ,label :"수량4" , width : 60 },
								{ name: "4expire" ,label :"유통기한5" , width : 60  },
								{ name: "4ipgodate" ,label :"입고날짜5" , width : 60 },
								{ name: "4surang" ,label :"수량5" , width : 60 },
						

							],
							data: a
						});
					},
					error: function(err) {
						alert('no');
					}
				});



		}
		function ajaxdetail(code,idate){
               
               let date = idate.split("-");
			   console.log(date[0]);
			   console.log(date[1]);
			   console.log(date[2]);
			
			   var inameD= "modal-content";
			   
			     
			   var modal = document.querySelector(".modal"); 
			   modal.style.display = "block";
			   //alert(modal);
			   
						 
			   $.ajax({
					url:'3plmodal.php', //request 보낼 서버의 경로
					type:'POST', // 메소드(get, post, put 등)
					
					async: false, //동기: false, 비동기(기본값): ture
					data:{'itemcode':code,
						  'idate1':date[0],
						  'idate2':date[1],
						  'idate3':date[2]}, //보낼 데이터,
					timeout: 2*60*60*1000, //2 hours,
					success: function(data) {
						//서버로부터 정상적으로 응답이 왔을 때 실행
						document.getElementById(inameD).innerHTML=data; 
					},
					error: function(err) {
						document.getElementById(inameD).innerHTML='error'; 
					}
				});





		}
		function closemodal(){
			var modal = document.querySelector(".modal"); 
			modal.style.display = "none";

		}
		function movepage(select){
			
			  alert("확인을 누르시면 페이지가 이동합니다")
			  var openNewWindow = window.open("/");
              //openNewWindow.location.href = "http://www.naver.com";

			  openNewWindow.location.href="../3pl.php?inventory="+select;
			  
			

		}
	</script>
</head>

<body>

    <!-- 팝업 될 레이어 --> 
    

	<div class="container">
		<div class="page-header">
			<h1 class="h2">&nbsp; 현재고 유통기한 현황</h1>
			<hr>
		</div>
		<div id="navhead">
			<form class="navbar" role="search" method="post" action="">

				<div class="col-sm-3">

                   
					<input type="date" name="ndate" size="20%" value='<? echo $nowdate; ?>' />
					<!--<input type="button" value="달력" onclick="$('#datePicker').datepicker('show');" /> -->
					
				</div>
				<div class="col-sm-2">
					<? if($_SESSION['is_admin'] > '1'){ ?>

					<div class="form-group">
						<select name='inventory' class="input-large form-control">
							<option value="전체">전체</option>
							<?
                                $sql = "select * from iteminfo group by georae";
													
								$stmt = $con->prepare($sql);
							
								$stmt->execute();
						 
								if ($stmt->rowCount() > 0)
									{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
									   {
									      extract($row);   
                                          if($georae =="") continue;
										  
										  ?>


							<option value="<?=$georae?>" <? if (trim($georae)==trim($_POST['inventory'])) { ?>
								selected
								<? } ?>><?=$georae?></option>
							<?  }  }?>
						</select>

					</div>
				</div>
				<?
							   }
							   else{  ?>
				<select name="stype" class="form-control" readonly>
					<option value='0' selected><?php echo $_SESSION['user_id']; ?></option>

				</select>

		</div>
		<? } ?>
		<div class="col-sm-1">
		    <input type="button" onclick= "getData()" class="btn btn-default" value="조회">
		</div>
		<div class="col-sm-4">
		    
			<input type="text" name="itext" id="myInput" class="form-control" placeholder="Search" value="">
		</div>
		<div class="col-sm-2"><button type="button"
				class="btn btn-default" onclick="fnExcelReport('table', '재고장')">Excel download</button>
				<button type="button"
				class="btn btn-default" style="margin-left:20px;" onclick="movepage('<?=$selectname?>')">현재고</button></div>
		</form>
	</div>
	<div class="modal"> 
         <div class="modal-content" id="modal-content"> 
           
			   
			 
         </div>
		 
    </div>

	<div class="row">
        

		<div class='col-sm-12'>
			<div class="rightfix">
				<table id="grid"></table>
			</div>

		</div>

	</div>

	</div>
</body>

</html>