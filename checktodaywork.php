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
 
    include('headitem.php');



	
	$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
	$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';


    if(isset($_POST['tabid'])) $tab =$_POST['tabid'];
	



    $tabidinfo = isset($tab) ? $tab : 'first';  // tab 아이디 정보
   
	?>

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
			  alert('완료');
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
            

		</style>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item">라벨발행</a>
							<a href="ipgo.php" class="list-group-item ">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="ipgodetail.php" class="list-group-item">입고현황</a>
							<a href="3pl.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item active">출고검증</a>
							<a href="chulgolist.php" class="list-group-item">업장출고내역</a>
							<a href="chagelist.php" class="list-group-item">변경분리스트</a>
						
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
                     
                         
							
							<div id="navhead">
							<form class="navbar" role="search" method="post" action="checktodaywork.php">
							   
							   <div class="col-sm-3">
							   <input  id="tabid" name="tabid" type="hidden" class="form-control" value='<?=$tabidinfo;?>'>
							   <!-- type="text" id="datePicker" -->
							   <input  type="date" name='search' class="form-control" value="<? echo $value;?>"></div>
							   <div class="col-sm-2">	        
									<select name="stype" class="form-control">
									  <option value='0' <? if($stype =='0') echo "selected"; ?>>전체</option>
									  <option value='1' <? if($stype =='1') echo "selected"; ?>>차수</option>
									</select>
								   
							   </div>
							   <div class="col-sm-4">
								  <select name="chasu" id="chasu" class="form-control">
									  <? for($i=1;$i<31;$i++){ ?>
									  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?>><? echo $i.'차작업'?></option>
									  <?  }  ?>
									  
								</select>
							   
							   </div>
							   <div class="col-sm-3"><button id="resubmit" type="submit" class="btn btn-default">검색</button>&nbsp;<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '검증')">엑셀저장</button></div>
							 </form>           
							</div>

							<div class="row">
                            <!-- Tab을 구성할 영역 설정-->
								<div style="left-margin:0px;">
								<!-- Tab 영역 태그는 ul이고 클래스는 nav와 nav-tabs를 설정한다. -->
									<ul id="myTab" class="nav nav-tabs">
									<!-- Tab 아이템이다. 태그는 li과 li > a이다. li태그에 active는 현재 선택되어 있는 탭 메뉴이다. -->
									<li class="<?= $tabidinfo == 'first' ? 'active' : '' ?>"><a href="#first" data-toggle="tab">검증</a></li>
									<li class="<?= $tabidinfo == 'second' ? 'active' : '' ?>"><a href="#second" data-toggle="tab">센터통합데이터</a></li>
									<!-- a 태그의 href는 아래의 tab-content 영역의 id를 설정하고 data-toggle 속성을 tab으로 설정한다. -->
									<li class="<?= $tabidinfo == 'data' ? 'active' : '' ?>"><a href="#data" data-toggle="tab">세부데이타</a></li>
									
									
									</ul>
								
								<!-- Tab이 선택되면 내용이 보여지는 영역이다. -->
								<!-- 태그는 div이고 class는 tab-content로 설정한다. -->
								<div class="tab-content">
									<!-- 각 탭이 선택되면 보여지는 내용이다. 태그는 div이고 클래스는 tab-pane이다. -->
									<!-- active 클래스는 현재 선택되어 있는 탭 영역이다. -->
									<div class="<?= $tabidinfo == 'first' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="first">
										 <!-- 첫번째 탭 내용 -->
										
										  <? include('upload_chulgocheck.php'); ?>
													
										
					
									</div>
									<div class="<?= $tabidinfo == 'second' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="second">
										 <!-- 첫번째 탭 내용 -->
										
                                          
										  <? 
										  
										 
										  include('checktodayworkgroup.php'); ?>
													
										
					
									</div>
									<div class="<?= $tabidinfo == 'data' ? 'tab-pane fade in active' : 'tab-pane fade' ?>" id="data">
									<!--<div style="overflow-y:scroll;height:200px;"> -->

									     <? 
										  
										 
										  include('checktodayworkdetail.php'); ?>
													
										   
												</div>
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
		
	
		
 
	</body>
</html> 

<script>
$("#myTab a").click(function(e) {
			   e.preventDefault();
			   var target = $(e.target).attr("href");
			   //alert(target);

			   $('#tabid').val(target.substring(1));
			   //$("#resubmit").trigger("click");


			  // $("resubmit").click();
			});


</script>