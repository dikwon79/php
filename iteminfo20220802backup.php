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
		
        <style>
        
		  html {
			height: 100%;
			}
			.container{
                width: 97%;
			}
			body {
			margin: 0;
			height: 100%;
			
		 
			}	
			section{
			   position :relative;
			   min-height:80%; 
			}
			#navitem{
               width : 102%;
			}
			footer {
			position: relative;
			bottom: 0;
			left: 0;
			right: 0;
			color: white;
			background-color: #333333;
			}
            .noshow{
				display:none;
			}
			.largecheck{

				width: 20px;
				height: 20px;
			}
			
           
		</style>
		<script>
		    var start = 0;
		    var list = 500;
			
			$(function(e){
			  append_list();
			  //스크롤 이벤트 
			  $(window).scroll(function(){
				  var dh = $(document).height();
				  var wh = $(window).height();
				  var wt = $(window).scrollTop();
				  if(dh == (wh + wt)){
					append_list();
				  }


			  });



		});

		
		function append_list(){
			var com = document.getElementById('companyname').value;
			var search = document.getElementById('myInput').value;
			$.post("iteminfo_append.php",{start:start, list:list, company:com, search:search},function(data){
				
				if (data)
				{
					$("#appendbox").append(data);
					start += list;

				}
				
				
			});

		}
        function hide(){
			  if ($(".noshow").css('display') == 'none')
			  {
				  $(".noshow").show();
				 
			  }
			  else{
                  $(".noshow").hide();
                  
			  }
			
		}
        
		</script>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item active">라벨발행</a>
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="paperofinventory3.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
							<a href="index.html" class="list-group-item">월별통계</a>
							<a href="setting.html" class="list-group-item">setting</a>
						
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
                     <? 
								$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
								$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';
								$searchtext1 = isset($_POST['companyname']) ? $_POST['companyname'] : '';

								
                               

                     ?>


                                <div class="container" style="padding-left:0px;margin-left:15px;">
								
								<div id="navitem"><form class="navbar" role="search" method="post" action="iteminfo.php">
								   <div class="col-sm-3">
								    
									<h1>&nbsp; 품목정보</h1>
								   </div>
								   <!--<div class="col-sm-4">	        
										<select name="stype" class="form-control">
										  <option value='0' <? if($stype =='0') echo "selected"; ?>>전체</option>
										  <option value='1' <? if($stype =='1') echo "selected"; ?>>품목코드</option>
										  <option value='2' <? if($stype =='2') echo "selected"; ?>>품목명</option>
										  <option value='3' <? if($stype =='3') echo "selected"; ?>>업체명</option>
										  <option value='4' <? if($stype =='4') echo "selected"; ?>>렉</option>
										  <option value='5' <? if($stype =='5') echo "selected"; ?>>재고조사담당</option>
										</select>
									   
								   </div>  -->
								   <div class="col-sm-3"><input type="text" name="companyname"  id="companyname" class="form-control" placeholder="업체명" value="<? if($searchtext1) echo $searchtext1  ?>"></div>
								  
								   <div class="col-sm-3"><input type="text" name="itext"  id="myInput" class="form-control" placeholder="코드,품목,총량인쇄구분조회" value="<? if($searchtext) echo $searchtext  ?>"></div>
								   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button>&nbsp;
								   <button type="button" class="btn btn-default" onclick="fnExcelReport('table', '품목정보')">엑셀저장</button>
								   <label>업체품목보이기</label><input class="largecheck" type="checkbox" onclick="hide()">
								   </div>
								   
							   </form>           
							   </div>
							

							
								      
									<div class="row">

										<table id ="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
											<thead>  
											<tr>  
											    
											    <th width='90px'>업체명</th> 
												<th width='90px'>출고코드</th>
												<th width='90px'>재고코드</th>
												<th width='400px'>품목명</th>
												<th class="noshow" width='400px'>업체품목</th>
																		
												<th width='90px'>렉번호</th> 
												<th width='90px'>입수</th>  
												<th width='90px'>출고수</th>  
												<th width='90px'>수도권블랙</th>
												<th width='90px'>품목불랙</th>  
												<th width='90px'>라벨사용유무</th>  
												<th width='120px'>총량인쇄구분</th>
												
												
											</tr>  
											</thead>  
									        
											<tbody id="appendbox">
											</tbody>
											</table>  
									</div>
						
								
						 
   	
				    </div>
				   
	   </section>
       </div>
	   <!--
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
		-->
       <?
         //6. 연결 종료
        
		 
		 ?>
		
	
		
 
	</body>
</html> 
<script>
function datasave(type){

   var a =document.querySelectorAll('[id*="field"]');  
  
   //JSON형태로 데이타 만들어서 넘길거야....^^ 
   var newitemdata = new Array() ;
  
   var b = type;
      // 객체 생성
   var data = new Object() ;    
   data.id = a[0].value;  
   data.mappingcode = a[1].value;  
   data.itemcode = a[2].value;
   data.itemname = a[3].value;
   data.geocode = a[4].value;
   data.georae =  a[5].value;
   data.lek = a[6].value;
   data.dan = a[7].value;
   data.ipsu = a[8].value;
   data.packsu = a[9].value;
   data.inventory = a[10].value;
   data.productiondate = a[11].value;
   data.expire = a[12].value;
   data.printoption = a[13].value;
   data.itemblack = a[14].value;
   data.usingY = a[15].value;
   data.labelY = a[16].value;
   data.ipgoprice = a[17].value;
   data.sellprice = a[18].value;
   data.printgubun = a[19].value;
   
   // 리스트에 생성된 객체 삽입
   newitemdata.push(data);
   
   var xhr = new XMLHttpRequest();
   
   xhr.open('POST', 'iteminput.php');
   xhr.setRequestHeader("Content-Type", "application/json");
   xhr.send(JSON.stringify({"additem" : newitemdata, "type" : b})); 
   xhr.onreadystatechange = function(){
   if(xhr.readyState === 4 && xhr.status === 200){

	   var _tzs = xhr.responseText;
	   if (_tzs ==="success")
	   {
			alert("저장하였습니다.");
	   }
	   else{
           alert(_tzs);
	   }
	
	 }
   }
   
   
}



</script>