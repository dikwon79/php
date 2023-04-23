<!DOCTYPE html> 
<html>
<head>
   	<meta http-equiv="Content-Type" content="text/html;charset=euc-kr;">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>명현유통송장발행 프로그램</title>

	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" type="text/css" href="mh.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    
	
</head>
<?php 
//DB연결
 include("dbcon.php");

//클라이언트로 부터 넘어온 변수값
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
		 echo '에러: 데이터베이스에 연결 할 수 없습니다.';
		 exit;
 }
 
 $sql = "insert into Minvoice(Mgeorae, Maddress, Maddress2, Mtel ,Mmobile, Msurang, Mtype, Mcontent, Mmessage) values ('$name','$postcode','$address','$tel','$mobile','$surang','$type','$textarea1','$textarea2' )";


 $conn->debug = false;
 $conn->Execute($sql); 
 $conn->close();
    
?>

<body>
      <h1>전송완료 현황</h1>
	  <li><? echo "전송완료되었습니다."; ?></li>
</body>
</html>
<script>history.go(-1);</script>
