<?php 
//DB����
include('dbcon.php');


//Ŭ���̾�Ʈ�� ���� �Ѿ�� ������
 $s0= trim($_POST[s0]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'�Ϸù�ȣ �����ڵ� 
 $s1= trim($_POST[s1]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //�Է³�¥ 

 

 //�� ���� ���� 
 if ($s0!='ian09') {  
    exit;  
 }


 $stmt = $con->prepare("delete from iteminfo");
 $stmt->execute();
    		 
 
  
 echo "���� �����Ͽ����ϴ�";
				 
?>
