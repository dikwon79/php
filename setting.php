<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>

<body>

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
 
    include('headitem.php');

   

    

    try { 

                $sql = "SELECT companyname,center,centername, grouping, printinfo from print_info";
				$stmt = $con->prepare($sql);

				$stmt->execute();
			   
			} catch(PDOException $e) {
				die("Database error. " . $e->getMessage()); 
			}

			$row = $stmt->fetch();  
			
		   
	?>

	

    <div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; SETTING</h1><hr>
    </div>
    <div id="navhead">
    <form class="navbar" role="search" method="post">       
       <div class="col-sm-9">
	   <H1>센터별 코드 및 그룹핑, 인쇄 설정을 합니다. </H1>
	   </div>
	   <div class="col-sm-3">
	   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#my80sizeCenterModal">입력</button>
	   <button type="button" class="btn btn-default" onclick="fnExcelReport('table', '재고장')">엑셀저장</button></div>
     </form>           
     </div>
     <div class="row">
                 <!-- Tab을 구성할 영역 설정-->
		<div style="left-margin:0px;">
		<!-- Tab 영역 태그는 ul이고 클래스는 nav와 nav-tabs를 설정한다. -->
		<ul class="nav nav-tabs">
		<!-- Tab 아이템이다. 태그는 li과 li > a이다. li태그에 active는 현재 선택되어 있는 탭 메뉴이다. -->
		<li class="active"><a href="#cj" data-toggle="tab">씨제이</a></li>
		<!-- a 태그의 href는 아래의 tab-content 영역의 id를 설정하고 data-toggle 속성을 tab으로 설정한다. -->
		<li><a href="#spc" data-toggle="tab">SPC</a></li>
		<li><a href="#shinsegae" data-toggle="tab">신세계</a></li>
		<li><a href="#welstory" data-toggle="tab">웰스토리</a></li>
		<li><a href="#lotte" data-toggle="tab">롯데푸드</a></li>
		</ul>
		<!-- Tab이 선택되면 내용이 보여지는 영역이다. -->
		<!-- 태그는 div이고 class는 tab-content로 설정한다. -->
		<div class="tab-content">
		<!-- 각 탭이 선택되면 보여지는 내용이다. 태그는 div이고 클래스는 tab-pane이다. -->
		<!-- active 클래스는 현재 선택되어 있는 탭 영역이다. -->
		<div class="tab-pane fade in active" id="cj">
		     <!-- 첫번  탭 내용 -->
		  <div style="overflow-y:scroll;height:80px;">
			 <div class="rows">
			 <b>그룹제어명 :</b> 총량지상에 한페이지안에 묶는 센터 
			 </div>
			 <div class="rows">

			 <b>인쇄물명  :</b> 총량지 한페이지에 나오더라도,인쇄물에는 구분을 해준다. 
			 </div>
		  </div>
          <table class="table table-bordered table-hover table-striped" style="ml-0 table-layout: fixed ; width: 100%">
				<thead>  
				<tr style="border: solid 1px;"> 
				    <th style="border: solid 1px ; padding:0px;" NOWRAP>납품센터</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터코드</th>  
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>그룹제어명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>인쇄물명</th>
					
                </tr>
				</thead>

                <?  $stmt = $con->prepare($sql);
	
		
					$stmt->execute();
			 
					if ($stmt->rowCount() > 0)
						{
							$i=0;
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
							   extract($row);
				               if ($companyname !='cj') continue;
							   $i++;
				
					?>  



				<tbody>
                <tr style="border: solid 1px;"> 
				    <td style="border: 1px solid; padding:0px;"><input type='text' id='in_5_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$companyname?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_1_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$center?>'></td>  
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_2_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$centername?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_3_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$grouping?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_4_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$printinfo?>'></td>
		
                </tr>
				<? }  }?>
				</tbody>
          </table>


		</div>
		<!-- id는 고유한 이름으로 설정하고 tab의 href와 연결되어야 한다. -->
		
		<div class="tab-pane fade" id="spc">
		  <div style="overflow-y:scroll;height:80px;">
			 <div class="rows">
			 <b>그룹제어명 :</b> 총량지상에 한페이지안에 묶는 센터 
			 </div>
			 <div class="rows">

			 <b>인쇄물명  :</b> 총량지 한페이지에 나오더라도,인쇄물에는 구분을 해준다. 
			 </div>
		   </div>
          <table class="table table-bordered table-hover table-striped" style="ml-0 table-layout: fixed ; width: 100%">
				<thead>  
				<tr style="border: solid 1px;"> 
				    <th style="border: solid 1px ; padding:0px;" NOWRAP>납품센터</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터코드</th>  
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>그룹제어명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>인쇄물명</th>
					
                </tr>
				</thead>

                <?  $stmt = $con->prepare($sql);
	
		
					$stmt->execute();
			 
					if ($stmt->rowCount() > 0)
						{
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
							   extract($row);
				               if ($companyname !='SPC') continue;
				
					?>  



				<tbody>
                <tr style="border: solid 1px;"> 
				    <td style="border: 1px solid; padding:0px;"><input type='text' id='in_5' size="20" style="width:100%; height :33px;border:0;" value='<?=$companyname?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_1' size="20" style="width:100%; height :33px;border:0;" value='<?=$center?>'></td>  
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_2' size="20" style="width:100%; height :33px;border:0;" value='<?=$centername?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_3' size="20" style="width:100%; height :33px;border:0;" value='<?=$grouping?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_4' size="20" style="width:100%; height :33px;border:0;" value='<?=$printinfo?>'></td>
		
                </tr>
				<? }  }?>
				</tbody>
          </table>
		  
		</div>
		
		<!-- fade 클래스는 선택적인 사항으로 트랜지션(transition)효과가 있다.
		<!-- in 클래스는 fade 클래스를 선언하여 트랜지션효과를 사용할 때 in은 active와 선택되어 있는 탭 영역의 설정이다. -->
		<div class="tab-pane fade" id="shinsegae">
		    <div style="overflow-y:scroll;height:80px;">
			 <div class="rows">
			 <b>그룹제어명 :</b> 총량지상에 한페이지안에 묶는 센터 
			 </div>
			 <div class="rows">

			 <b>인쇄물명  :</b> 총량지 한페이지에 나오더라도,인쇄물에는 구분을 해준다. 
			 </div>
		  </div>
          <table class="table table-bordered table-hover table-striped" style="ml-0 table-layout: fixed ; width: 100%">
				<thead>  
				<tr style="border: solid 1px;"> 
				    <th style="border: solid 1px ; padding:0px;" NOWRAP>납품센터</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터코드</th>  
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>그룹제어명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>인쇄물명</th>
					
                </tr>
				</thead>

                <?  $stmt = $con->prepare($sql);
	
		
					$stmt->execute();
			 
					if ($stmt->rowCount() > 0)
						{
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
							   extract($row);
				               if ($companyname !='shinsegye') continue;
				
					?>  



				<tbody>
                <tr style="border: solid 1px;"> 
				    <td style="border: 1px solid; padding:0px;"><input type='text' id='in_5' size="20" style="width:100%; height :33px;border:0;" value='<?=$companyname?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_1' size="20" style="width:100%; height :33px;border:0;" value='<?=$center?>'></td>  
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_2' size="20" style="width:100%; height :33px;border:0;" value='<?=$centername?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_3' size="20" style="width:100%; height :33px;border:0;" value='<?=$grouping?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_4' size="20" style="width:100%; height :33px;border:0;" value='<?=$printinfo?>'></td>
		
                </tr>
				<? }  }?>
				</tbody>
          </table>
		</div>
       
		<div class="tab-pane fade" id="welstory">
		    <div style="overflow-y:scroll;height:80px;">
			 <div class="rows">
			 <b>그룹제어명 :</b> 총량지상에 한페이지안에 묶는 센터 
			 </div>
			 <div class="rows">

			 <b>인쇄물명  :</b> 총량지 한페이지에 나오더라도,인쇄물에는 구분을 해준다. 
			 </div>
		  </div>
          <table class="table table-bordered table-hover table-striped" style="ml-0 table-layout: fixed ; width: 100%">
				<thead>  
				<tr style="border: solid 1px;"> 
				    <th style="border: solid 1px ; padding:0px;" NOWRAP>납품센터</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터코드</th>  
					<th style="border: solid 1px ; padding:0px;" NOWRAP>센터명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>그룹제어명</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>인쇄물명</th>
					
                </tr>
				</thead>

                <?  $stmt = $con->prepare($sql);
	
		
					$stmt->execute();
			 
					if ($stmt->rowCount() > 0)
						{
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
							   extract($row);
				               if ($companyname !='welstory') continue;
				
					?>  



				<tbody>
                <tr style="border: solid 1px;"> 
				    <td style="border: 1px solid; padding:0px;"><input type='text' id='in_5' size="20" style="width:100%; height :33px;border:0;" value='<?=$companyname?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_1' size="20" style="width:100%; height :33px;border:0;" value='<?=$center?>'></td>  
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_2' size="20" style="width:100%; height :33px;border:0;" value='<?=$centername?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_3' size="20" style="width:100%; height :33px;border:0;" value='<?=$grouping?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_4' size="20" style="width:100%; height :33px;border:0;" value='<?=$printinfo?>'></td>
		
                </tr>
				<? }  }?>
				</tbody>
          </table>
		
		</div>
		<div class="tab-pane fade" id="lotte">롯데푸드 셋팅파일
		
		
		</div>
		



    </div>

</div>
<!-- 80%size Modal at Center -->
			<div class="modal modal-center fade" id="my80sizeCenterModal" tabindex="-1" role="dialog" aria-labelledby="my80sizeCenterModalLabel">
			  <div class="modal-dialog modal-80size modal-center" role="document">
				<div class="modal-content modal-80size">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">센터 정보 입력하기</h4>
				  </div>
				  <div class="modal-body">
				  <? include "modal.php"; ?>
				  </div>
				  <div class="row">신규,수정,삭제</div>
				  <div class="modal-footer">
				    <button type="button" class="btn btn-default" onclick="modalsave()">저장</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- 80%size Modal at Center -->
		
		<!-- id는 고유한 이름으로 설정하고 tab의 href와 연결되어야 한다. -->

</body>
</html>