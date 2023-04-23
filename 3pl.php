<?php
    $jsonStr = file_get_contents("config.json");
	$config = json_decode($jsonStr); // if you put json_decode($jsonStr, true), it will convert the json string to associative array


    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: 3pl.php");
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
	<link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>

	<script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>
	<link rel="stylesheet" href="3pl.css">
    <link rel="stylesheet" href="3plmodal.css">
	<style>
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
			color : white;}

        a:link, a:hover, a:active{
			color : white;
		}
		
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
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
		function hide(){
			  if ($("[id^=hide]").css('display') == 'none')
			  {
				  $("[id^=hide]").show();//do something
			  }
			  else{
                  $("[id^=hide]").hide();
 
			  }
			
		}
		function ajaxdetail(code,itemname,idate){
               
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
						  'itemname':itemname,
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

			  openNewWindow.location.href="../3pldetail.php?inventory="+select;
			  
			

		}
	</script>
</head>

<body>

    <!-- 팝업 될 레이어 --> 
    

	<div class="container">
		<div class="page-header">
			<h1 class="h2">&nbsp; 위탁사 재고현황</h1>
			<div id="menusub">
			<ul>  
				<li class="label"><a href="3pl.php">재고현황</a></li>
				<li class="label"><a href="3plexpire.php">유통기한</a></li>
				<li class="label"><a href="3pldetail.php?inventory=<?=$selectname?>" target='_blank'>출고상세내역</a></li>
		    </ul>
			</div>
			<hr>
		</div>
		<div id="navhead">
			<form class="navbar" role="search" method="post" action="">

				<div class="col-sm-3">


					<input type="text" name="ndate" id="datePicker" size="20%" value='<? echo $nowdate; ?>' />
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
		</div>
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
					<thead>

						<tr>

							<th class='first-col' NOWRAP>재고코드</th>
							<th class='second-col' style=width:50px>품목명</th>
							<th class='fixedHeader'>렉번호</th>
							<th class='fixedHeader'>입수</th>
							<th class='fixedHeader'>전재고 </th>
							<th class='fixedHeader'>입고</th>
							<th class='fixedHeader'><button class="btn btn-warning" onclick="hide()">출고</button><div id="hidetxt">숨기기</div></th>
							<th class='fixedHeader'>조정</th>				
							<th class='fixedHeader'>현재고</th>
							<th id ="hide0" class='fixedHeader'>CJ</th>
							<th id ="hide1" class='fixedHeader'>SPC</th>
							<th id ="hide2" class='fixedHeader'>SSG</th>
							<th id ="hide3" class='fixedHeader'>RS</th>
							<th id ="hide4" class='fixedHeader'>동원</th>
							<th id ="hide5" class='fixedHeader'>아워홈</th>
							<th id ="hide6" class='fixedHeader'>웰스</th>
							<th id ="hide7" class='fixedHeader'>현대</th>
							<th id ="hide8" class='fixedHeader'>기타</th>
							<th id ="hide9" class='fixedHeader'>외식</th>
							


							<? for($i = 1 ; $i <= 31 ; $i++) { 
									 
									 
									 $num = sprintf('%02d',$i); ?>
							<th class='fixedHeader'><?=$num.'일'?></td>
								<?
								    }
									
									?>
						</tr>
					</thead>
					<tbody id="myTable">
						<tr>
							<td colspan="4">수량합</td>
							<td id="preinven"></td>
							<td id="ipgo"></td>
							<td id="totalout"></td>
							<td id="adjust"></td>
							<td id="presentinven"></td>
							<td id="hide_CJ"></td>
							<td id="hide_SPC"></td>
							<td id="hide_SSG"></td>
							<td id="hide_RS"></td>
							<td id="hide_dongwon"></td>
							<td id="hide_ahome"></td>
							<td id="hide_wels"></td>
							<td id="hide_hyundae"></td>
							<td id="hide_etc"></td>
							<td id="hide_out"></td>
                            
							<td></td>
						
							<td></td>
							<td colspan="31"></td>
						</tr>
						<?php  
                                $tpreinven = 0;
								$tipgo =0;
								$tCJ =0;
								$tSPC =0;
								$tshinsegye =0;
								$tRS=0;
								$tdongwon=0;
								$tahome=0;
								$twels=0;
								$thundae=0;
								$tetc=0;
								$tout=0;
								$tadjust =0;
								$ttotalhap=0;
								$tpreseninven=0;
							
								
                               
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
								
								 if (trim($mon) =="01") {
                                     $sql = "SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,if(a.ipgoprice='','999999',a.ipgoprice) AS 'asort',a.ipsu,SUM(if(B.list='기초',B.surang,0)) AS '전일재고',"; 
									
								 
								 } else{
                                     $sql = "SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,if(a.ipgoprice='','999999',a.ipgoprice) AS 'asort',a.ipsu, 
								 SUM(if(B.list='기초',B.surang,0))- SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0))+ SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.packsu,B.surang),0)) AS '전일재고',";

								 }
			                    
								 $sql .="SUM(if(B.list='입고',B.surang,0)) AS '입고', 
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = 'cj' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'CJ',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = 'SPC' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'SPC',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '신세계' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'shinsegye',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = 'RS' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'RS',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '동원' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'dongwon',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '아워홈' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'ahome',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '웰스토리' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'wels',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '현대' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'hundae',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '기타' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'etc',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '외식' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'out',
								 SUM(if(B.idate='$nowdate',CASE WHEN B.companyname = '조정' THEN CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END ELSE 0 END,0)) AS 'adjust',
								 
								 SUM(if(B.list='실사',B.surang,0)) AS '실사', ";

								 $eun = substr($nowdate,0,8);

								 //echo $eun;

								 for($i = 1 ; $i <= 31 ; $i++) { 
									 
									
									 $num = sprintf('%02d',$i); 
									  //echo $eun.$num.'/';
									 $sql .="sum(if(B.idate='$eun$num',if(B.companyname='조정',0,(CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END)),0)) AS  col".$num." ,";

									           
								 }

								 $sql = rtrim($sql, ','); // remove last separator
								 $sql .=" FROM iteminfo a,(
								 SELECT '기초' AS 'list', '' AS 'idate', '' AS 'companyname',itemcode AS 'mappingcode',SUM(surang) as 'surang','EA' AS 'unit'
								 FROM Deadline b
								 WHERE idate='$deaddate' GROUP by itemcode
								 UNION ALL
								 SELECT '입고' AS 'list', '' AS 'idate','' AS 'companyname',mappingcode, SUM(surang) AS 'surang','EA' AS 'unit'
								 FROM ipgo c
								 WHERE ipgodate='$nowdate'
								 GROUP BY mappingcode 
								 UNION ALL
								 SELECT '출고' AS 'list', idate, companyname,mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
								 FROM labelmain
								 WHERE idate ='$nowdate'
								 GROUP BY mappingcode,unit,companyname
								 UNION ALL
								 SELECT '출고' AS 'list', idate, companyname,mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
								 FROM labelXmain
								 WHERE idate ='$nowdate'
								 GROUP BY mappingcode,unit,companyname 
								 UNION ALL
								 SELECT '총입고' AS 'list','' AS 'idate','' AS 'companyname', e.mappingcode, SUM(if(e.surang='',0,e.surang)) AS 'surang','EA' AS 'unit'
								 FROM ipgo e
								 WHERE ipgodate >= '$deaddate' AND ipgodate <'$nowdate'
								 GROUP BY mappingcode 
								 UNION ALL
								 SELECT '총출고' AS 'list',idate,companyname, mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
								 FROM labelmain f
								 WHERE idate >= '$deaddate' AND idate < '$nowdate' 
								 GROUP BY idate,mappingcode,unit,companyname
								 UNION ALL
								 SELECT '총출고' AS 'list',idate,companyname, mappingcode, SUM(chaivalue) AS 'surang',unit AS 'unit'
								 FROM labelXmain f
								 WHERE idate >= '$deaddate' AND idate < '$nowdate' 
								 GROUP BY idate,mappingcode,unit,companyname 
								 UNION ALL
								 SELECT '실사' AS 'list', '' AS 'idate', '' AS 'companyname',itemcode AS 'mappingcode',SURANG AS 'surang', 'EA' AS 'unit'
								 FROM dailycounting g
								 WHERE g.idate='$nowdate')B
								 WHERE a.itemcode = B.mappingcode AND labelY='Y' ".$selectbox." GROUP BY B.mappingcode";
                                $sql.=" order by length(asort) asc,asort asc , lek asc";
                                  
							    //echo $sql;
								$stmt = $con->prepare($sql);
							   
				                //echo $sql;
							    $stmt->execute();
						        $datacount=0;
								if ($stmt->rowCount() > 0)
									{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
										{
											extract($row);
											$datacount++;
							   
								if ($username != 'admin'){
								?>
					
						<tr>
							<td class="first-col" NOWRAP><?php echo $itemcode; ?></td>

							<td class="second-col" NOWRAP><?php echo $itemname;  ?></td>
							<td NOWRAP><?php echo $lek;  ?></td>
							<td><?php echo $ipsu; ?></td>

							<td style="background-color:#fff7f2"><?php echo $전일재고; ?></td>
							<td><?php echo $입고; ?></td>
                            <? $totalhap = $CJ+$SPC+$shinsegye+$RS+$dongwon+$ahome+$wels+$hundae+$etc+$out; ?>
							<td><button onclick="ajaxdetail('<?=$itemcode?>','<?=$itemname?>','<?=$nowdate?>')"><?php echo $totalhap; ?></button></td>
                            <td><?php echo $adjust*-1; ?></td>
							
							<td style="background-color:#fff7f2"><?php echo $전일재고+$입고-($totalhap)-$adjust; ?></td>
							<td id ="hide0_<?=$datacount?>" class="CJ"><?php echo $CJ; ?></td>
							<td id ="hide1_<?=$datacount?>" class="SPC"><?php echo $SPC; ?></td>
							<td id ="hide2_<?=$datacount?>" class="SSG"><?php echo $shinsegye; ?></td>
							<td id ="hide3_<?=$datacount?>" class="RS"><?php echo $RS; ?></td>
							<td id ="hide4_<?=$datacount?>" class="dongwon"><?php echo $dongwon; ?></td>
							<td id ="hide5_<?=$datacount?>" class="ahome"><?php echo $ahome; ?></td>
							<td id ="hide6_<?=$datacount?>" class="wels"><?php echo $wels; ?></td>
							<td id ="hide7_<?=$datacount?>" class="hundae"><?php echo $hundae; ?></td>
							<td id ="hide8_<?=$datacount?>" class="etc"><?php echo $etc; ?></td>
							<td id ="hide9_<?=$datacount?>" class="out"><?php echo $out; ?></td>
                            
                            <? 

                            $tpreinven += $전일재고; 
                            $tipgo += $입고;
                            $tCJ += $CJ;
							$tSPC += $SPC;
							$tshinsegye += $shinsegye;
							$tRS += $RS;
							$tdongwon += $dongwon;
							$tahome += $ahome;
							$twels += $wels;
							$thundae += $hundae;
							$tetc += $etc;
							$tout += $out;
							$tadjust += $adjust*-1;
							$ttotalhap += $totalhap;
							$tpreseninven += $전일재고+$입고-($totalhap)-$adjust;			
								?>
							<? for($i = 1 ; $i <= 31 ; $i++) { 
									 
									 
									 $num = sprintf('%02d',$i);
									 $col = 'col'.$num;
									 if ($$col=='0'){
									 ?>
							<td>
								<? echo ''; ?>
							</td>
							<?
									 }else{
										 ?>
							<td>
								<? echo $$col; ?>
							</td>
							<?
								    }}
									
									?>

						</tr>

						<?php
									}
										}
									 }
								?>
                        <tr id="lastline">
							<td colspan="4">수량합</td>
							<td id="imsipreinven"><?=$tpreinven?></td>
							<td id="imsiipgo"><?=$tipgo?></td>
							<td id="imsitotalout"><?=$ttotalhap?></td>
							<td id="imsiadjust"><?=$tadjust?></td>
							
							<td id="imsipresentinven"><?=$tpreseninven?></td>
							<td id="imsiCJ"><?=$tCJ?></td>
							<td id="imsiSPC"><?=$tSPC?></td>
							<td id="imsiSSG"><?=$tshinsegye?></td>
							<td id="imsiRS"><?=$tRS?></td>
							<td id="imsidongwon"><?=$tdongwon?></td>
							<td id="imsiahome"><?=$tahome?></td>
							<td id="imsiwels"><?=$twels?></td>
							<td id="imsihyundae"><?=$thundae?></td>
							<td id="imsietc"><?=$tetc?></td>
							<td id="imsiout"><?=$tout?></td>
                            
							
						
							<td></td>
							<td colspan="31"></td>


							
						</tr>
					</tbody>
				</table>
			</div>

		</div>

	</div>

	</div>
</body>

</html>