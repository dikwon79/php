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
?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
		//전체 tr에서 찾는거
            $(document).ready(function(){
			  $("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });
			});
		
			//일정 td에서만 찾는 방법
			/*
			 $(document).ready(function() {
				$("#myInput").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#myTable > tr").hide();
					var temp = $("#myTable > tr > td:nth-child(15n+12):not(:contains('" + value + "'))");

					//var temp = $("#myTable > tr > td:nth-child(15n+3):contains('" + value + "')");


					
					$(temp).parent().show();
				});
			});
             */
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
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="ipgodetail.php" class="list-group-item">입고현황</a>
							<a href="paperofinventory3.php" class="list-group-item active">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
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

					
                    <div class="col-md-10 my-2" style="padding-left:0px;">
                     <? 
					 
						$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
						$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
						$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';

	         
					 
					 
					 
					 
					 ?>
              	           <div class="container">
						   <div id="navhead" style="margin-left:-30px;margin-top:0px">
						   <form class="navbar" role="search" method="post" action="">
                              
							   <div class="col-sm-2">
                                  
							   <h1 class="h2">&nbsp;재고장</h1>
						
							   </div>
							
							   <div class="col-sm-2">
							   
							   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
							   <div class="col-sm-3">
									  <div class="form-group">
									  <select name ='inventory' class="input-large form-control">
									  <option value="전체">전체</option>
                                <?
                                $sql = "select * from iteminfo WHERE inventory !='' GROUP BY inventory";
													
								$stmt = $con->prepare($sql);
							
								$stmt->execute();
						 
								if ($stmt->rowCount() > 0)
									{
										while($row=$stmt->fetch(PDO::FETCH_ASSOC))
									   {
									      extract($row);   

										  
										  ?>


									  <option value="<?=$inventory?>" <? if (trim($inventory) == trim($_POST['inventory'])) { ?> selected <? } ?>><?=$inventory?></option>
									  <?  }  }?>
									  </select>
									 </div>
							   </div>
							 
							 
							   <div class="col-sm-2"><input type="text" name="itext" id="myInput" class="form-control" placeholder="Search" value="<? if($searchtext) echo $searchtext  ?>"></div>
							   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button></div>
							 </form>           
						   </div>
						   
						   <div class="row">
						      <? include('papertest.php'); ?> 

							
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
