<!DOCTYPE html> 
<html>
<head>
   	<meta http-equiv="Content-Type" content="text/html;charset=euc-kr;">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>�������������� ���α׷�</title>

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" type="text/css" href="mh.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    
	
</head>
<?php 
//DB����
 include("dbcon.php");

//Ŭ���̾�Ʈ�� ���� �Ѿ�� ������
 $name=iconv("utf-8", "EUC-KR", trim($_POST[geoName]));
 $address=iconv("utf-8", "EUC-KR", trim($_POST[address]));
 $postcode=iconv("utf-8", "EUC-KR", trim($_POST[postcode]));
 $tel=trim($_POST[tel]);
 $mobile=trim($_POST[mobile]);
 $surang=trim($_POST[surang]);
 $type=trim($_POST[type]);
 $textarea1=iconv("utf-8", "EUC-KR", trim($_POST[textarea1]));
 $textarea2=iconv("utf-8", "EUC-KR", trim($_POST[textarea2]));

 if(mysqli_connect_errno())
 {
		 echo '����: �����ͺ��̽��� ���� �� �� �����ϴ�.';
		 exit;
 }
 
 $sql = "insert into Minvoice(Mgeorae, Maddress, Maddress2, Mtel ,Mmobile, Msurang, Mtype, Mcontent, Mmessage) values ('$name','$postcode','$address','$tel','$mobile','$surang','$type','$textarea1','$textarea2' )";


 $conn->debug = false;
 $conn->Execute($sql); 
 $conn->close();
    
?>

<body>
      <h1>���ۿϷ� ��Ȳ</h1>
	  <li><? echo "���ۿϷ�Ǿ����ϴ�."; ?></li>
</body>
</html>
<script>history.go(-1);</script>
