<!DOCTYPE html>
<html>
  <head>
      <meta charset="euc-kr">
      <meta name="viewport" content="width=device-width" ,initial-scale="1">
      <title>명현유통 홈페이지</title>
      <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/mh.css">
  </head>
  <body>
        <style type="text/css">
          .jumbotron{
            background-image: url('images/main.jpg');
            background-size : cover;
			height : 45em;
            text-shadow: black 0.2em 0.2em 0.2em;
            color : white;
            
          }
        </style>
		<script type="text/javascript">

		function modi()
		{
		   if (form1.mcode.value=="")
		   {
			   alert("상품코드를 입력해주세요");
			   form1.mcode.value="";
			   form1.mcode.focus();
			   return false;
		   }
		   var xmlhttp=new XMLHttpRequest();
		   var inameD= "side";
		  
		   xmlhttp.open("GET","modify_inc.php?mgarage="+document.getElementById("mgarage").value+"&mcode="+document.getElementById("mcode").value+"&mname="+document.getElementById("mname").value+"&zone1="+document.getElementById("zone1").value+"&zone2="+document.getElementById("zone2").value+"&zone3="+document.getElementById("zone3").value+"&zone4="+document.getElementById("zone4").value+"&a="+document.getElementById("a").value+"&b="+document.getElementById("b").value,false);
		   xmlhttp.send(null);
		   
		   //if (xmlhttp.responseText=="sucess")
		  // {
		  //   alert("저장하였습니다.");
		  // }
		  // else alert("에러");
		   document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

		}
		</script>



      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
              data-target="#bs-example-navbar-collpase-1" aria-expanded="false">
              <span class="sr-only"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">(주)MH유통</a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collpase-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">소개<span class="sr-only"></span></a></li>
                <li><a href="../new/">물류</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">식자재유통<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">CJ프레시웨이</a></li>
                    <li><a href="#">롯데푸드</a></li>
                  </ul>
                </li>

                <li><a href="#">프로그램사업</a></li>
                <li><a href="#">바이오사업</a></li>
                <li><a href="#">쇼핑몰</a></li>
              </ul>

              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">인트라넷<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="login.html">로그인</a></li>
                    <li><a href="#">로그아웃</a></li>
                  </ul>
                </li>
              </ul>
              <form class="navbar-form navbar-right">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="내용을 입력해주세요">
                </div>
                <button type="submit" class="btn btn-default">검색</button>
              </form>
          </div>
        </div>
      </nav>
     
	 <?
		 include('dbcon.php');
		 

		 $code=$_GET["code"];
		 $nowinventory=$_GET["nowinventory"];
		 $today = date("Ymd h:i:s"); 
		  
		 $rs = $conn->Execute("select MainCenter, MCODE, MNAME, MUNIT, Mipsu, MZONE, Mnowsu, pid  from Miteminfo where MCODE=$code;"); 
		  
		 //echo $rs->field[MNAME];

      ?>
         <div class=”table-responsive“>
           <table class="table table-bordered">
					<thead>
						<caption> 정보변경하기 </caption>
					</thead>
					<tbody>
						<form name="form1" action="" method="POST" encType="multiplart/form-data">
						    <tr>
								<th>창고코드: </th>
								<td><input type="text" placeholder="창고(CJ,LOTTE,TUBAN물류,롯데칠성,켈로그)" name="mgarage" id="mgarage" value="<? echo $rs->fields[MainCenter]?>" class="form-control"/></td>
							</tr>
							<tr>
								<th>상태: </th>
								<td><input type="text" placeholder="상태를 입력하세요. " name="mcode" id="mcode" value="<? echo $rs->fields[MCODE]?>" class="form-control"/></td>
							</tr>
							<tr>
								<th>품목명: </th>
								<td><input type="text" placeholder="품목명을 입력하세요. "  name="mname" id="mname" value="<? echo $rs->fields[MNAME]?>" class="form-control"/></td>
							</tr>
							<tr>
								<th>위치: </th>
								<td>
								<? echo "단"?><input type="text" name="zone1" id="zone1"  value="<? echo substr($rs->fields[MZONE],0,3) ?>" placeholder="단을 입력하세요. " class="form-control"><? echo "층"?><input type="text" name="zone2" id="zone2"  value="<? echo substr($rs->fields[MZONE],4,2)?>" placeholder="층을 입력하세요." class="form-control"><? echo "순서"?><input type="text" name="zone3" id="zone3"  value="<? echo substr($rs->fields[MZONE],7,2)?>" placeholder="순서를 입력하세요. " class="form-control"/><input type="hidden" name="zone4" id="zone4"  value="" class="form-control">								
						        </td>
							</tr>
							<tr>
								<th>단및 입수: </th>
								<td>
								<? echo "1단"?><input type="number" name="a" id="a<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<? echo $rs->fields[Mnowsu]?>" placeholder="단을  입력하세요" class="form-control"/><? echo '입수';?><input type="text" name="b" id="b<?=$i?>" value="<? echo $rs->fields[Mipsu]?>" placeholder="입수를  입력하세요" class="form-control"/>
								

							</tr>
							<tr>
								<td colspan="2">
									<input type="button" value="등록" onClick ="modi();" class="pull-right"/>
									<input type="button" value="reset" class="pull-left"/>
									<input type="button" value="상단등록" class="pull-left" onclick="javascript:location.href='index.php'"/>
									<!-- <a class="btn btn-default" onclick="sendData()"> 등록 </a>
									<a class="btn btn-default" type="reset"> reset </a>
									<a class="btn btn-default" onclick="javascript:location.href='list.jsp'">글 목록으로...</a> -->
								</td>
							</tr>
						</form>
					</tbody>
			</table>



         </div>
      <div id="side">점장님 화이팅</div>
      <footer style="background-color:#000000; color:#ffffff">
        <div class="container">
          <br>
          <div class="row">
            <div class="col-sm-2" style="text-align: center;"><h3>(주)명현유통</h3></div>
            <div class="col-sm-8">
             덕평본사: 경기도 이천시 마장면 덕이로39번길 41<p>
             사업자등록번호 :122-81-66164 | TEL:070-0000-0000 | FAX:031-631-6394 | E-MAIL:jjukkh@hanmail.net<p>
             COPYRIGHT ⓒ 2018 BY MH Co.td., ALL RIGHTS RESERVED.

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
      <div class="row">
        <div class="modal" id="modal" tabindex="-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                명현물류의 특징
                <button class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" style="text-align:center;">
                저희 서비스의 특징은 프로그램 기반으로 정확하고 철저하게 관리가 되고 있다는
                점입니다. <br>매일의 재고조사로 상품의 수량파악,로쓰원인분석이 철저히 제공됩니다.<br><br>
                <img src="images/inventory.png" id="imagepreview" style="width:256px; height:256px;">
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
      <script src="js/bootstrap.js"></script>
  </body>

</html>
