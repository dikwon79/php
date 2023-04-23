<?php 
//DB연결
include('dbcon.php');


//클라이언트로 부터 넘어온 변수값
 $s0= trim($_POST[s0]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'일련번호 구분코드 
 $s1= trim($_POST[s1]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //입력날짜 

 

 //웹 실행 방지 
 if ($s0!='ian09') {  
    exit;  
 }


 $stmt = $con->prepare("delete from iteminfo");
 $stmt->execute();
    		 
 
  
 echo "전부 삭제하였습니다";
				 
?>
