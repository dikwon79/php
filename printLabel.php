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
 
    include('headitem.php');?>
<!DOCTYPE html>
<html>
	<head>
		
        <script type="text/javascript">
		  $(document).ready(function(){  
             
           
			 
       
            	// (페이지가 열리자마자) 함수를 불러오기. 
			 var callFunction = get_timer(); 
		

		});
		function setagain(){
                var xmlhttp=new XMLHttpRequest();
				var inameD= "side";
		  
			    xmlhttp.open("GET","setting_inc.php?code="+document.getElementById("comcode").value+"&companyname="+document.getElementById("comname").value+"&colnum="+document.getElementById("comnum").value+"&centername="+document.getElementById("centername").value+"&centercode="+document.getElementById("centercode").value+"&printorder="+document.getElementById("printorder").value,false);
				xmlhttp.send(null);
		    	document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

			 }
			 function change(num){
			    var xmlhttp=new XMLHttpRequest();
			 	var inameD= "side";
		        alert(num);
			    xmlhttp.open("GET","setting_del.php?pid="+num,true);
				xmlhttp.send(null);
		    	document.getElementById(inameD).innerHTML=xmlhttp.responseText;;
			 }
			 function timer(){ 

				 var date = new Date(); 
                 
				 // 그 지역의 날짜 (locale date). 
				 var dateString = date .toLocaleDateString(); 

				 // 그 지역의 시간 (locale time). 
				 var timeString = date .toLocaleTimeString('en-GB'); 

				 var text = dateString + " " + timeString; 
                 if (timeString=='17:00:00')
                 {
					 $("input:checkbox[id=blackunlock]").prop("checked", true);
					 sessionStorage.setItem("blackunlock", "Y"); 
                 }
				 // 'text'만 저장하고, 이 함수 끝내기. 
				 return text; 
			} 


			function get_timer(){ 

				 // 함수값 불러와서, 태그 안에 집어넣기. 
				 document.getElementById( "realTimer" ).innerHTML = timer(); 

				 // 1000 밀리초(=1초) 후에, 이 함수를 실행하기 (반복 실행 효과). 
				 setTimeout( "get_timer()", 1000 ); 
			} 
			//Ctrl + C 
		 
			$(document).on('click', '#ctrlCButton', function() {
				if (document.body.createTextRange) {
					//createTextRangeをサポート(IE)
					var textRange = document.body.createTextRange();
					textRange.moveToElementText(document.getElementById("song"));
					textRange.execCommand("Copy");
				   
				} else {
					//createTextRangeを非サポート(IE以外)
					window.getSelection().selectAllChildren(document.getElementById('song'));
					document.execCommand('Copy');
				  
				}
			});
		    

		</script>
		
        <style>
        
		  html {
			height: 100%;
			}
			body {
			margin: 0;
			height: 100%;
			
		
			}	
			section{
			   position :relative;
			   min-height:75%; 
			}
			footer {
			position: relative;
			bottom: 0;
			left: 0;
			right: 0;
			color: white;
			background-color: #333333;
			}
             #song {
              				width: 100%;
              				border: 1px solid #444444;
              				border-collapse: collapse;
              			  }
              			  #song td {
              				border: 1px solid #444444;
              				padding: 10px;
              			  }
            


		</style>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item active">라벨발행</a>
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
                            <a href="ipgodetail.php" class="list-group-item">입고현황</a>
							<a href="3pl.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
							<a href="chulgolist.php" class="list-group-item">업장출고내역</a>
							<a href="chagelist.php" class="list-group-item">변경분리스트</a>
						
						</div>
						<div class="p-0 my-2">
							<div class="card text-center pt-2 bg-light">
								<h5 class="pt-2 pb-2">cj전산 단축키</h5>
							</div>
						</div>
					    <div class="p-0 my-2">
							
                           
                                 <table id='song'>
								 <tr><td rowspan=2><a id="ctrlCButton" class="btn btn-info btn-small" style="width: 100px;" rel="tooltip" data-original-title="송림푸드">
									<i class="icon-pencil icon-white"></i>
									<span class="btnTitle" style="vertical-align: text-top;">송림</span>
								  </a></td><td>1001963</td></tr>		
								  <tr><td>1015993</td></tr>
								 </table>
							
						  
						</div>
						
					    <div class="p-0 my-2">
							<div class="card text-center pt-2 bg-light">
								<h5 class="pt-2 pb-2">기타 사이트</h5>
								
								<ul class="list-group">
								<!-- Target -->

									<li class="list-group-item">메일</li>
									<li class="list-group-item">cj프레시웨이</li>
									<li class="list-group-item">네이버</li>
									<li class="list-group-item">구글</li>
									<li class="list-group-item">이안로지스</li>
									<li class="list-group-item">송림푸드</li>
									
									<p id="realTimer"></p>
                                    
								</ul>
							
							</div>
						</div>
					</div>

					<div class="col-md-10 my-2">
                     <? include 'makinglabel.php' ?>
              	
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
