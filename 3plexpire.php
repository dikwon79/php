<?php
    $jsonStr = file_get_contents("../config.json");
	$config = json_decode($jsonStr); // if you put json_decode($jsonStr, true), it will convert the json string to associative array


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
					 
	
	//$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	//$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';


     $selectname = isset($_POST['inventory']) ? $_POST['inventory'] : '시작';
    
	 if($_SESSION['is_admin'] < '1'){

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
  
    <style>
	    table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		th, td {
			padding: 5px;
			text-align: left;    
		}
		.label {
			background-color: blue;
			font-size: 17px;
			padding-left: 10px;
			margin-left: 10px;
			margin-top: 10px;
			align: right;
			display: inline-block;
			height: 35px; /* 예시로 높이를 30px로 지정 */
			line-height: 35px; /* line-height 속성을 추가하여 가운데 정렬 */
		}
		ul {
			  list-style: none;
			  margin: 0;
			  padding: 0;
			  display: flex;
		}
		li.icon {
			flex-basis: 25%;
		}
		#menusub {
		  float : left;
		  display: inline-block;
		  vertical-align: middle;
		  
		}
        a{
			color : white;
		}
		.col-sm-4{
			color :white;
		}
		#grid td {
		  height: 30px; 
		  text-align: center; /* 내용 가운데 정렬 */
		}
		#grid td:nth-child(2) {
		  text-align: left; /* 2번째 열(column) 내용 왼쪽 정렬 */
		}
		#grid td:nth-child(5) {
		  background-color: #CEF6F5; /* 5번째 열(column) 배경색 지정 */
		}
   
	  
        .ui-jqgrid-hdiv {
		  height: auto; /* 헤더 높이 자동 조정 */
		}
	</style>
	<script type="text/javascript">
	   
		$(document).ready(function () {

			$('#loadingImg').hide();
			hide();
			
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
			$('#top')
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
               
			 
			  //LoadingWithMask();
			  $('#loadingImg').show();
			  let up_names = document.getElementsByName("inventory");
              let date = document.getElementsByName("ndate");
               
			  let radio = $('input[name=chk_info]:checked').val();
            
			  //alert(radio);
              const div2 = document.getElementById('mainbone');
              div2.remove(); 

			  var div1 = document.createElement('div');
              div1.setAttribute("id", "mainbone");
              div1.setAttribute("class", "col-sm-12");
    
			  div1.innerHTML = "<div id='mainbone' class='col-sm-12'><div id = 'rightfix' class='rightfix'><table id='grid'></table></div></div>";
              document.getElementById('here').appendChild(div1);
              
			 

			  if (radio == '1')
			  {
				 $("input[name=chk_info]").next().css('color', 'white')
				 $('input[name=chk_info]:checked').next().css('color', 'yellow');
				   
				 $.ajax({
					url:'3plquery.php', //request 보낼 서버의 경로
					type:'POST', // 메소드(get, post, put 등)
					
					async: false, //동기: false, 비동기(기본값): ture
					data:{'inventory':up_names[0].value,
						  'date': date[0].value,
						  'option' : radio},
						  //보낼 데이터,
					timeout: 2*60*60*1000, //2 hours,
					success: function(a) {
						//서버로부터 정상적으로 응답이 왔을 때 실행
			
			   

 						"use strict";
						$("#grid").jqGrid({
						    gridview: true,
						    shrinkToFit: false,
							scrollOffset: 1,
							colModel: [
								{ name: "itemcode",label :"품목코드", width : 120 },
								{ name: "itemname",label :"품목명" , width : 400 },
								{ name: "lek",label :"렉" , width : 80 },
								{ name: "ipsu",label :"입수" , width : 60  },
								{ name: "now" ,label :"현재고" , width : 60 },
								{ name: "0expire" ,label :"유통기한1" , width : 100 },
								{ name: "0surang" ,label :"수량1" , width : 60  },
								{ name: "1expire" ,label :"유통기한2" , width : 100  },
								{ name: "1surang" ,label :"수량2" , width : 60  },
								{ name: "2expire"  ,label :"유통기한3" , width : 100 },
								{ name: "2surang" ,label :"수량3" , width : 60 },
								{ name: "3expire" ,label :"유통기한4" , width : 100 },
								{ name: "3surang" ,label :"수량4" , width : 60 },
								{ name: "4expire" ,label :"유통기한5" , width : 100  },
								{ name: "4surang" ,label :"수량5" , width : 60 },
								{ name: "5expire" ,label :"유통기한6" , width : 100  },
								{ name: "5surang" ,label :"수량6" , width : 60 },
								{ name: "6expire" ,label :"유통기한7" , width : 100  },
								{ name: "6surang" ,label :"수량7" , width : 60 },
								{ name: "7expire" ,label :"유통기한8" , width : 100  },
								{ name: "7surang" ,label :"수량8" , width : 60 },
								{ name: "8expire" ,label :"유통기한9" , width : 100  },
								{ name: "8surang" ,label :"수량9" , width : 60 },
								{ name: "9expire" ,label :"유통기한10" , width : 100  },
								{ name: "9surang" ,label :"수량10" , width : 60 },

						

							],
							data: a
							
						});
						$('#mask, #loadingImg').hide();	
					},
					error: function(err) {
						alert('no');
					}
				});

				
			  }
              else if(radio == '2'){
				    $("input[name=chk_info]").next().css('color', 'white')
				    $('input[name=chk_info]:checked').next().css('color', 'yellow');
					$.ajax({
					url:'3plquery.php', //request 보낼 서버의 경로
					type:'POST', // 메소드(get, post, put 등)
					
					async: false, //동기: false, 비동기(기본값): ture
					data:{'inventory':up_names[0].value,
						  'date': date[0].value,
						  'option' : radio},
						  //보낼 데이터,
					timeout: 2*60*60*1000, //2 hours,
					success: function(a) {
						//서버로부터 정상적으로 응답이 왔을 때 실행
						"use strict";
						$("#grid").jqGrid({
							gridview: true,
						    shrinkToFit: false,
							scrollOffset: 1,
							colModel: [
								{ name: "itemcode",label :"품목코드", width : 120 },
								{ name: "itemname",label :"품목명" , width : 400 },
								{ name: "lek",label :"렉" , width : 80 },
								{ name: "ipsu",label :"입수" , width : 60  },
								{ name: "now" ,label :"현재고" , width : 60 },			
								{ name: "0ipgodate" ,label :"입고날짜1" , width : 150  },
								{ name: "0expire" ,label :"유통기한1" , width : 150 },
								{ name: "0surang" ,label :"수량1" , width : 60  },								
								{ name: "1ipgodate" ,label :"입고날짜2" , width : 150  },
								{ name: "1expire" ,label :"유통기한2" , width : 150 },
								{ name: "1surang" ,label :"수량2" , width : 60  },							
								{ name: "2ipgodate" ,label :"입고날짜3" , width : 150 },
								{ name: "2expire" ,label :"유통기한3" , width : 150 },
								{ name: "2surang" ,label :"수량3" , width : 60 },							
								{ name: "3ipgodate" ,label :"입고날짜4" , width : 150 },
								{ name: "3expire" ,label :"유통기한4" , width : 150},
								{ name: "3surang" ,label :"수량4" , width : 60 },								
								{ name: "4ipgodate" ,label :"입고날짜5" , width : 150 },
								{ name: "4expire" ,label :"유통기한5" , width : 150 },
								{ name: "4surang" ,label :"수량5" , width : 60 },
						

							],
							data: a
							
						});
						$('#mask, #loadingImg').hide();	
					},
					error: function(err) {
						alert('no');
					}
				});
                $('#jqgh_grid_0ipgodate').css('font-size','18px');
				$('#jqgh_grid_1ipgodate').css('font-size','18px');
				$('#jqgh_grid_2ipgodate').css('font-size','18px');
				$('#jqgh_grid_3ipgodate').css('font-size','18px');
				$('#jqgh_grid_4ipgodate').css('font-size','18px');

			  }
			  else{
                $("input[name=chk_info]").next().css('color', 'white')
				$('input[name=chk_info]:checked').next().css('color', 'yellow');
				$.ajax({
					url:'3plquery.php', //request 보낼 서버의 경로
					type:'POST', // 메소드(get, post, put 등)
					
					async: false, //동기: false, 비동기(기본값): ture
					data:{'inventory':up_names[0].value,
						  'date': date[0].value,
						  'option' : radio},
						  //보낼 데이터,
					timeout: 2*60*60*1000, //2 hours,
					success: function(a) {
						//서버로부터 정상적으로 응답이 왔을 때 실행
					    
						"use strict";
						$("#grid").jqGrid({
			                gridview: true,
						    shrinkToFit: false,
							scrollOffset: 1,
							colModel: [
								{ name: "itemcode",label :"품목코드", width : 120 },
								{ name: "itemname",label :"품목명" , width : 400 },
								{ name: "lek",label :"렉" , width : 80 },
								{ name: "ipsu",label :"입수" , width : 60  },
								{ name: "now" ,label :"현재고" , width : 60 },
								{ name: "0expire" ,label :"유통기한1" , width : 150 },
								{ name: "0ipgodate" ,label :"입고날짜1" , width : 150  },
								{ name: "0surang" ,label :"수량1" , width : 60  },
								{ name: "1expire" ,label :"유통기한2" , width : 150  },
								{ name: "1ipgodate" ,label :"입고날짜2" , width : 150  },
								{ name: "1surang" ,label :"수량2" , width : 60  },
								{ name: "2expire"  ,label :"유통기한3" , width : 150 },
								{ name: "2ipgodate" ,label :"입고날짜3" , width : 150 },
								{ name: "2surang" ,label :"수량3" , width : 60 },
								{ name: "3expire" ,label :"유통기한4" , width : 150 },
								{ name: "3ipgodate" ,label :"입고날짜4" , width : 150 },
								{ name: "3surang" ,label :"수량4" , width : 60 },
								{ name: "4expire" ,label :"유통기한5" , width : 150  },
								{ name: "4ipgodate" ,label :"입고날짜5" , width : 150 },
								{ name: "4surang" ,label :"수량5" , width : 60 },
						

							],
							data: a
							
						});
						$('#mask, #loadingImg').hide();	
					},
					error: function(err) {
						alert('no');
					}
				});
                $('#jqgh_grid_0expire').css('font-size','18px');
				$('#jqgh_grid_1expire').css('font-size','18px');
				$('#jqgh_grid_2expire').css('font-size','18px');
				$('#jqgh_grid_3expire').css('font-size','18px');
				$('#jqgh_grid_4expire').css('font-size','18px');

			  }
             
         
			   

       

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
    <div id='loadingImg'>
	<img src='images/Spinner.gif' style='position: relative; display: block; margin: 0px auto;'/>
    </div>  
    <div id="top"></div>
	<div class="container">
		<div class="page-header">
			<h1 class="h2">&nbsp; 현재고 유통기한 현황</h1>
			<div id="menusub">
			<ul>  
	
			<li class="label"><a href="3pl.php">재고장</a></li>
			<li class="label"><a href="3plexpire.php">유통기한</a></li>
			<li class="label"><a href="3pldetail.php">출고상세내역</a></li>
		    </ul>
			</div>
			<hr>
		</div>
		
		<div id="navhead">
			<form class="navbar" role="search" method="post" action="">

				<div class="col-sm-3">

                   
					<input type="date" name="ndate" size="20%" value='<? echo $nowdate; ?>' />
					<!--<input type="button" value="달력" onclick="$('#datePicker').datepicker('show');" /> -->
					
				</div>
				<div class="col-sm-2">
					<? if($_SESSION['is_admin'] > '0'){ ?>

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
				<select name="inventory" class="form-control" readonly>
					<option value=<?=$_SESSION['user_id']?> selected><?php echo $_SESSION['user_id']; ?></option>

				</select>

		</div>
		<? } ?>
		<div class="col-sm-1">
		    <input type="button" onclick= "getData()" class="btn btn-default" value="조회">
		</div>
		<div class="col-sm-4">
		    <label>조회방식 선택 : </label>
		    <input type="radio" name="chk_info" value="1" checked="checked"><label>유통기한</label>
			<input type="radio" name="chk_info" value="2"><label>입고일자+유통기한</label>
			<input type="radio" name="chk_info" value="3"><label>유통기한+입고일자</label>
			<!--<input type="text" name="itext" id="myInput" class="form-control" placeholder="Search" value=""> -->
		</div>
		<div class="col-sm-2"><button type="button"
				class="btn btn-default" onclick="fnExcelReport('rightfix', '유통기한현황')">Excel download</button>
				</div>
		</form>
	</div>
	<div class="modal"> 
         <div class="modal-content" id="modal-content"> 
           
			   
			 
         </div>
		 
    </div>

	<div id='here' class="row">
		<div id='mainbone' class='col-sm-12'>
			<div id = "rightfix" class="rightfix">
			
				<table id="grid"></table>
				
			</div>
		</div>
	</div>
</body>

</html>

<script>
	    var table = document.createElement("table");

		// create table header
		var header = table.createTHead();
		var headerRow = header.insertRow(0);
		var headerCell1 = headerRow.insertCell(0);
		headerCell1.innerHTML = "품목코드";
		var headerCell2 = headerRow.insertCell(1);
		headerCell2.innerHTML = "품목명";
		var headerCell3 = headerRow.insertCell(2);
		headerCell3.innerHTML = "렉";
		var headerCell4 = headerRow.insertCell(3);
		headerCell4.innerHTML = "입수";
		var headerCell5 = headerRow.insertCell(4);
		headerCell5.innerHTML = "현재고";
		var headerCell6 = headerRow.insertCell(5);
		headerCell6.innerHTML = "유통기한1";
		var headerCell7 = headerRow.insertCell(6);
		headerCell7.innerHTML = "수량1";
		var headerCell8 = headerRow.insertCell(7);
		headerCell8.innerHTML = "유통기한2";
		var headerCell9 = headerRow.insertCell(8);
		headerCell9.innerHTML = "수량2";
		var headerCell10 = headerRow.insertCell(9);
		headerCell10.innerHTML = "유통기한3";
		var headerCell11 = headerRow.insertCell(10);
		headerCell11.innerHTML = "수량3";
		var headerCell12 = headerRow.insertCell(11);
		headerCell12.innerHTML = "유통기한4";
		var headerCell13 = headerRow.insertCell(12);
		headerCell13.innerHTML = "수량4";
		var headerCell14 = headerRow.insertCell(13);
		headerCell14.innerHTML = "유통기한5";
		var headerCell15 = headerRow.insertCell(14);
		headerCell15.innerHTML = "수량5";
		var headerCell16 = headerRow.insertCell(15);
		headerCell16.innerHTML = "유통기한6";
		var headerCell17 = headerRow.insertCell(16);
		headerCell17.innerHTML = "수량6";
		var headerCell18 = headerRow.insertCell(17);
		headerCell18.innerHTML = "유통기한7";
		var headerCell19 = headerRow.insertCell(18);
		headerCell19.innerHTML = "수량7";
		var headerCell20 = headerRow.insertCell(19);
		headerCell20.innerHTML = "유통기한8";
		var headerCell21 = headerRow.insertCell(20);
		headerCell21.innerHTML = "수량8";
		var headerCell22 = headerRow.insertCell(21);
		headerCell22.innerHTML = "유통기한9";
		var headerCell23 = headerRow.insertCell(22);
		headerCell23.innerHTML = "수량9";
		var headerCell24 = headerRow.insertCell(23);
		headerCell24.innerHTML = "유통기한10";
		var headerCell25 = headerRow.insertCell(24);
		headerCell25.innerHTML = "수량10";


        	
		document.getElementById("header").appendChild(table);
</script>