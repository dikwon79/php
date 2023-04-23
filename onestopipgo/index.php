 <? 
    include('../dbcon.php'); 
    include('../check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: ../welcome.php");
    }else
        header("Location: ../index.php"); 
 
    include('../headitem.php');?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
           $(document).ready(function(){
	
				$('ul.tabs li').click(function(){							//선택자를 통해 tabs 메뉴를 클릭 이벤트를 지정해줍니다.
					var tab_id = $(this).attr('data-tab');

					$('ul.tabs li').removeClass('current');			//선택 되있던 탭의 current css를 제거하고 
					$('.tab-content').removeClass('current');		

					$(this).addClass('current');								////선택된 탭에 current class를 삽입해줍니다.
					$("#" + tab_id).addClass('current');
				})

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
            
            ul.tabs{
				margin: 0px;
				padding: 0px;
				list-style: none;
			}

			ul.tabs li{
			  display: inline-block;
				background: #898989;
				color: white;
				padding: 10px 15px;
				cursor: pointer;
			}
			ul.tabs a,ul.tabs button{
			    float : right;
				padding: 9px 10px;
				margin : 1px;
			}


			ul.tabs li.current{
				background: #e0e0e0;
				color: #222;
			}

			.tab-content{
			  display: none;
				background: ;
				padding: 12px;
			}

			.tab-content.current{
				display: inherit;
			}
		</style>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="#" class="list-group-item">입고입력</a>
							<a href="#" class="list-group-item active">출고입력</a>
							<a href="#" class="list-group-item">입고일괄입력</a>
							<a href="#" class="list-group-item">출고일괄입력</a>
							
						
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
                     <? include 'admin_main.php' ?>
                                    	
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
