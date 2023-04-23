<?php 
//DB연결
include('dbcon.php');


//클라이언트로 부터 넘어온 변수값
 $data= trim($_POST[data]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'일련번호 구분코드 
 $s0= trim($_POST[s0]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'일련번호 구분코드 
 


 //웹 실행 방지 
 if ($s0!='ian09') {  
    exit;  
 }

  
 
 $stmt = $con->prepare("select activate from users where username='dikwon79'");
 $stmt->execute();
 $row = $stmt->fetch(PDO::FETCH_ASSOC);
 extract($row);

 if ($row['activate'] =='3'){
	 
	 echo 'kwondongil';
     $mhIP = $_SERVER['REMOTE_ADDR'];
	 $idate = date("Y-m-d h:i:s", time());
	  
     $query = "INSERT INTO logininfo(idate, ip) VALUES ('$idate','$mhIP')";

     $stmt= $con->prepare($query);

    
     $stmt->Execute();
}
else echo 'EOF';
				 

?>

 

