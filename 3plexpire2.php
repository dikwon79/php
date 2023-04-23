<?php
    $jsonStr = file_get_contents("config.json");
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
	<link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>

	<script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>
	<link rel="stylesheet" href="3pl.css">
    <link rel="stylesheet" href="3plmodal.css">
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
        function sortTable(n) {
		  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
		  table = document.getElementById("table");

		  switching = true;
		  //Set the sorting direction to ascending:
		  dir = "asc"; 
		  /*Make a loop that will continue until
		  no switching has been done:*/
		  while (switching) {
			//start by saying: no switching is done:
			switching = false;
			rows = table.rows;
			/*Loop through all table rows (except the
			first, which contains table headers):*/
			for (i = 1; i < (rows.length - 1); i++) {
			  //start by saying there should be no switching:
			  shouldSwitch = false;
			  /*Get the two elements you want to compare,
			  one from current row and one from the next:*/
			  x = rows[i].getElementsByTagName("TD")[n];
			  y = rows[i + 1].getElementsByTagName("TD")[n];
			  /*check if the two rows should switch place,
			  based on the direction, asc or desc:*/
			  if (dir == "asc") {
				if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				  //if so, mark as a switch and break the loop:
				  shouldSwitch= true;
				  break;
				}
			  } else if (dir == "desc") {
				if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
				  //if so, mark as a switch and break the loop:
				  shouldSwitch = true;
				  break;
				}
			  }
			}
			if (shouldSwitch) {
			  /*If a switch has been marked, make the switch
			  and mark that a switch has been done:*/
			  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			  switching = true;
			  //Each time a switch is done, increase this count by 1:
			  switchcount ++;      
			} else {
			  /*If no switching has been done AND the direction is "asc",
			  set the direction to "desc" and run the while loop again.*/
			  if (switchcount == 0 && dir == "asc") {
				dir = "desc";
				switching = true;
			  }
			}
		  }
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
		    <button type="submit" class="btn btn-default">조회</button>&nbsp;
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
				<table id='table' class="table table-bordered">
					

						<tr>

							<th class='first-col' NOWRAP>재고코드</th>
							<th class='second-col' style=width:50px>품목명</th>
							<th class='fixedHeader'>렉번호</th>
							<th class='fixedHeader'>입수</th>
							<th class='fixedHeader'>현재고 </th>
							
							<th onclick="sortTable(5)" class='fixedHeader'>1유통기한</td>
							<th onclick="sortTable(6)" class='fixedHeader'>1입고일자</td>
							<th class='fixedHeader'>1수량</td>

                            <th onclick="sortTable(8)" class='fixedHeader'>2유통기한</td>
							<th onclick="sortTable(9)" class='fixedHeader'>2입고일자</td>
							<th class='fixedHeader'>2수량</td>

							<th onclick="sortTable(11)" class='fixedHeader'>3유통기한</td>
							<th onclick="sortTable(12)" class='fixedHeader'>3입고일자</td>
							<th class='fixedHeader'>3수량</td>

							<th onclick="sortTable(14)" class='fixedHeader'>4유통기한</td>
							<th onclick="sortTable(15)" class='fixedHeader'>4입고일자</td>
							<th class='fixedHeader'>4수량</td>

							<th onclick="sortTable(17)" class='fixedHeader'>5유통기한</td>
							<th onclick="sortTable(18)" class='fixedHeader'>5입고일자</td>
							<th class='fixedHeader'>5수량</td>






						</tr>
					
				
						
						<?php  
                               
								
              
								$sql = "SELECT idate FROM Deadline ORDER BY idate desc limit 1";

								$stmt = $con->prepare($sql);

								$stmt->execute();
								
								
								

								$row = $stmt->fetch();  
								$t = substr($nowdate,0,7);
								$deaddate = $t."-01";
					             
								$mon = substr($nowdate,8,2);

								//echo $mon;
								//$t = substr($nowdate,0,7);

								//echo $deaddate;
								
							
								$expireDate = str_replace('-', '', $deaddate);     
								  
								
                                $sql = "SELECT *  FROM (SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,if(a.ipgoprice='','999999',a.ipgoprice) AS 'asort',a.ipsu, SUM(if(B.list='기초',B.surang,0))- SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0))+ SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0)) AS '전일재고'
									FROM iteminfo a,(
									SELECT '기초' AS 'list', '' AS 'idate', '' AS 'companyname',b.itemcode AS 'mappingcode', SUM(surang) AS 'surang','EA' AS 'unit'
									FROM Deadline b
									WHERE idate='$deaddate'
									GROUP BY b.itemcode
									UNION ALL
									SELECT '총입고' AS 'list','' AS 'idate','' AS 'companyname', e.mappingcode, SUM(if(e.surang='',0,e.surang)) AS 'surang','EA' AS 'unit'
									FROM ipgo e
									WHERE e.ipgodate >= '$deaddate' AND e.ipgodate <='$nowdate'
									GROUP BY e.mappingcode 
									UNION ALL
									SELECT '총출고' AS 'list',idate,companyname, mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
									FROM labelmain f
									WHERE f.idate >= '$deaddate' AND f.idate <= '$nowdate'
									GROUP BY f.idate,f.mappingcode,f.unit,f.companyname 
									UNION ALL
									SELECT '총출고' AS 'list',idate,companyname, g.mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
									FROM labelXmain g
									WHERE g.idate >= '$deaddate' AND g.idate <= '$nowdate'
									GROUP BY g.idate,g.mappingcode,g.unit,g.companyname
									)B
									WHERE a.itemcode = B.mappingcode AND labelY='Y'".$selectbox."  
									GROUP BY B.mappingcode)V
									LEFT JOIN (SELECT c.ipgodate,c.itemcode AS 'ipgoitem',c.mappingcode AS 'ipgomapping',c.surang,c.expiration,REPLACE(c.ipgodate,'-','') AS 'date1' ,REPLACE(c.expiration,'.','') AS 'date2' from ipgo c 
									WHERE  REPLACE(c.expiration,'.','') >= '$expireDate' AND c.expiration LIKE '2%'
									ORDER BY c.ipgodate desc)M ON V.mappingcode = M.ipgomapping
									ORDER BY V.mappingcode asc,M.ipgodate DESC";
                                  
							   
								$stmt = $con->prepare($sql);
							   
				                //echo $sql;
							    $stmt->execute();
						        $datacount=0;
								if ($stmt->rowCount() > 0)
								{
									    $basic_itemcode = '000000';
										$basic_surang = 0;

										$arr = array( // 1차원 배열을 3개 갖는 2차원 배열 선언
											array(),
											array(),
											array()
										);
										$nRow = 0; //배열 
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
										{
											extract($row);
                                           
											if($surang == NULL) {
												$surang = 0;
											}
											if ($basic_itemcode != $mappingcode){
												$basic_itemcode = $mappingcode;
												$basic_surang = $전일재고;
                                                
												
												if($basic_itemcode != '000000'){
                                                  for($i = 0; $i < $nRow; $i++){
													  ?>

                                                    
                                            
													<td class="fifth-col" NOWRAP><?php echo $arr[$nRow-1-$i][0]; ?></td>
													<td class="seventh-col" NOWRAP style="font-size:12px"><?php echo $arr[$nRow-1-$i][1];?></td>
													<td class="fifth-col" NOWRAP><?php echo $arr[$nRow-1-$i][2];?></td>
 

												  <?  
												  }
												  
												  for($i = $nRow ; $i < 5; $i++){
                                                     ?>
                                                    <td class="fifth-col" NOWRAP></td>
													<td class="seventh-col" NOWRAP></td>
													<td class="fifth-col" NOWRAP></td>

													 <?
												  }
												  
												  ?>
                                                    </tr><?
												}
                                                $nRow = 0;
                                            ?>
											<tr>
											<td class="first-col" NOWRAP><?php echo $mappingcode; ?></td>
											<td class="second-col" NOWRAP><?php echo $itemname; ?></td>
											<td class="third-col" NOWRAP><?php echo $lek; ?></td>
											<td class="fourth-col" NOWRAP><?php echo $ipsu; ?></td>
											<td class="fifth-col" NOWRAP><?php echo $전일재고; ?></td>
											<?
                                             
 
											}
											if($basic_surang <= 0){ //총재고가 마이너스 인 경우
												
												continue;
											}
											else if($basic_surang > $surang){ //총재고가 입고수량보다 클경우

												$arr[$nRow][0] = $date2;
                                                $arr[$nRow][1] = $date1;
                                                $arr[$nRow][2] = $surang;
                                                $nRow++; 
											
                                          
												
											} 
                                            
											else{ //총재고가 0보다 크고 입고수량보다 작을경우
											    $arr[$nRow][0] = $date2;
                                                $arr[$nRow][1] = $date1;
                                                $arr[$nRow][2] = $basic_surang;
                                                $nRow++; 
												
											
                                          

											}
											$basic_surang -= $surang;

											//echo $basic_surang;
											?>
											
											<?
							            }
								}
								
							?>
					
						
					
				</table>
			</div>

		</div>

	</div>

	</div>
</body>

</html>