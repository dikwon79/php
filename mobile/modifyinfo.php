<!DOCTYPE html>
<html>
  <head>
      <meta charset="euc-kr">
      <meta name="viewport" content="width=device-width" ,initial-scale="1">
      <title>�������� Ȩ������</title>
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
			   alert("��ǰ�ڵ带 �Է����ּ���");
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
		  //   alert("�����Ͽ����ϴ�.");
		  // }
		  // else alert("����");
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
            <a class="navbar-brand" href="#">(��)MH����</a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collpase-1">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">�Ұ�<span class="sr-only"></span></a></li>
                <li><a href="../new/">����</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">����������<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">CJ�����ÿ���</a></li>
                    <li><a href="#">�Ե�Ǫ��</a></li>
                  </ul>
                </li>

                <li><a href="#">���α׷����</a></li>
                <li><a href="#">���̿����</a></li>
                <li><a href="#">���θ�</a></li>
              </ul>

              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">��Ʈ���<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="login.html">�α���</a></li>
                    <li><a href="#">�α׾ƿ�</a></li>
                  </ul>
                </li>
              </ul>
              <form class="navbar-form navbar-right">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="������ �Է����ּ���">
                </div>
                <button type="submit" class="btn btn-default">�˻�</button>
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
         <div class=��table-responsive��>
           <table class="table table-bordered">
					<thead>
						<caption> ���������ϱ� </caption>
					</thead>
					<tbody>
						<form name="form1" action="" method="POST" encType="multiplart/form-data">
						    <tr>
								<th>â���ڵ�: </th>
								<td><input type="text" placeholder="â��(CJ,LOTTE,TUBAN����,�Ե�ĥ��,�̷α�)" name="mgarage" id="mgarage" value="<? echo $rs->fields[MainCenter]?>" class="form-control"/></td>
							</tr>
							<tr>
								<th>����: </th>
								<td><input type="text" placeholder="���¸� �Է��ϼ���. " name="mcode" id="mcode" value="<? echo $rs->fields[MCODE]?>" class="form-control"/></td>
							</tr>
							<tr>
								<th>ǰ���: </th>
								<td><input type="text" placeholder="ǰ����� �Է��ϼ���. "  name="mname" id="mname" value="<? echo $rs->fields[MNAME]?>" class="form-control"/></td>
							</tr>
							<tr>
								<th>��ġ: </th>
								<td>
								<? echo "��"?><input type="text" name="zone1" id="zone1"  value="<? echo substr($rs->fields[MZONE],0,3) ?>" placeholder="���� �Է��ϼ���. " class="form-control"><? echo "��"?><input type="text" name="zone2" id="zone2"  value="<? echo substr($rs->fields[MZONE],4,2)?>" placeholder="���� �Է��ϼ���." class="form-control"><? echo "����"?><input type="text" name="zone3" id="zone3"  value="<? echo substr($rs->fields[MZONE],7,2)?>" placeholder="������ �Է��ϼ���. " class="form-control"/><input type="hidden" name="zone4" id="zone4"  value="" class="form-control">								
						        </td>
							</tr>
							<tr>
								<th>�ܹ� �Լ�: </th>
								<td>
								<? echo "1��"?><input type="number" name="a" id="a<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<? echo $rs->fields[Mnowsu]?>" placeholder="����  �Է��ϼ���" class="form-control"/><? echo '�Լ�';?><input type="text" name="b" id="b<?=$i?>" value="<? echo $rs->fields[Mipsu]?>" placeholder="�Լ���  �Է��ϼ���" class="form-control"/>
								

							</tr>
							<tr>
								<td colspan="2">
									<input type="button" value="���" onClick ="modi();" class="pull-right"/>
									<input type="button" value="reset" class="pull-left"/>
									<input type="button" value="��ܵ��" class="pull-left" onclick="javascript:location.href='index.php'"/>
									<!-- <a class="btn btn-default" onclick="sendData()"> ��� </a>
									<a class="btn btn-default" type="reset"> reset </a>
									<a class="btn btn-default" onclick="javascript:location.href='list.jsp'">�� �������...</a> -->
								</td>
							</tr>
						</form>
					</tbody>
			</table>



         </div>
      <div id="side">����� ȭ����</div>
      <footer style="background-color:#000000; color:#ffffff">
        <div class="container">
          <br>
          <div class="row">
            <div class="col-sm-2" style="text-align: center;"><h3>(��)��������</h3></div>
            <div class="col-sm-8">
             ���򺻻�: ��⵵ ��õ�� ����� ���̷�39���� 41<p>
             ����ڵ�Ϲ�ȣ :122-81-66164 | TEL:070-0000-0000 | FAX:031-631-6394 | E-MAIL:jjukkh@hanmail.net<p>
             COPYRIGHT �� 2018 BY MH Co.td., ALL RIGHTS RESERVED.

            </div>
            <div class="col-sm-2" style="text-align: center">
              <div class="list-group">
                <a href="#" class="list-group-item">�̸���</a>
                <a href="#" class="list-group-item">����</a>
                <a href="#" class="list-group-item">����</a>
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
                ���������� Ư¡
                <button class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" style="text-align:center;">
                ���� ������ Ư¡�� ���α׷� ������� ��Ȯ�ϰ� ö���ϰ� ������ �ǰ� �ִٴ�
                ���Դϴ�. <br>������ �������� ��ǰ�� �����ľ�,�ξ����κм��� ö���� �����˴ϴ�.<br><br>
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
