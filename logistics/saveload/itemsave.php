<?php 
//DB연결
include('dbcon.php');


//클라이언트로 부터 넘어온 변수값
 $data= iconv("EUC-KR","utf-8", trim($_POST[data])); //'일련번호 구분코드 
 //$data= trim($_POST[data]); //iconv("EUC-KR", "utf-8",trim($_POST[data])); //'일련번호 구분코드 
 $s0= trim($_POST[s0]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'일련번호 구분코드 
 $s1= trim($_POST[s1]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //입력날짜 
 //$s2= trim($_POST[s2]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //입력날짜 
 


 //웹 실행 방지 
 if ($s0!='ian09') {  
    exit;  
 }

  
 //$data = '23/34/5/6/7/8/9/0/';
 $data2 = explode('<k>',$data);
 
 
 $u1 = date("Y"); 

 //$rs = $conn->Execute("select MAX(id) from iteminfo where substr(id,1,4)='$u1' ");
 
 $stmt = $con->prepare("select * from iteminfo where idate='$s1'");
 $stmt->execute();

 if ($stmt->rowCount() > 0)
 {
	
	 $stmt = $con->prepare("delete from iteminfo where idate='$s1'");
     $stmt->execute();
    		 
 }
  
 $stmt = $con->prepare("select * from iteminfo where substr(id,1,4)='$u1' order by id desc");
 $stmt->execute();

 if ($stmt->rowCount() > 0)
 {
	
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);

	$smx= $row['id'] +1;
    		 
 }
 else{

	$smx= $u1."00000001";
 }

 $listvalue=array();

/*

 $stmt = $con->prepare("select max(id) from iteminfo where substr(id,1,4)='$u1'");
 $stmt->execute();

 if ($stmt->rowCount() > 0)
 {
	
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);

	$smx= $row['max(id)'] +1;
    		 
 }
 else{

	$smx= $u1."00000001";
 }
 $listvalue=array();

 */
  $countMsg=count($data2)-1;
  
  for ($k=0; $k<count($data2)-1; $k++)
 {
    $data3 = explode ('<z>', $data2[$k]);
	
	
	//$itemcode[$k]= trim(addslashes($data3[0])); //품목코드
	//$itemname[$k]= trim(addslashes($data3[1])); //품목명
	//$ipsu[$k]= trim(addslashes($data3[2])); //입수	
    //팩킹정보
	//거래커코ㄷ,


	//$georae[$k]= trim(addslashes($data3[5]));//업체명
	//$lek[$k]= trim(addslashes($data3[6]));//위치정보
    //$inventory[$k]= trim(addslashes($data3[5]));//재고조사인벤토리

	$list=array($smx,$s1,trim(addslashes($data3[0])),trim(addslashes($data3[1])),trim(addslashes($data3[2])),trim(addslashes($data3[3])),trim(addslashes($data3[4])),trim(addslashes($data3[5])),trim(addslashes($data3[6])),trim(addslashes($data3[7])),trim(addslashes($data3[8])),trim(addslashes($data3[9])),trim(addslashes($data3[10])),trim(addslashes($data3[11])),trim(addslashes($data3[12])),trim(addslashes($data3[13])),trim(addslashes($data3[14])),trim(addslashes($data3[15])),trim(addslashes($data3[16])),trim(addslashes($data3[17])),trim(addslashes($data3[18])));
	
	
    array_push($listvalue,$list);
	$smx++;
 }



$args = array_fill(0, count($listvalue[0]),'?');

$query = "INSERT INTO iteminfo(id, idate, itemcode, itemname,itemnameGeo,ipsu,packsu,geocode,georae,lek,dan,inventory,printoption,itemblack,mappingcode,pathway,usingY,labelY,printgubun,ipgoprice,sellprice) VALUES (".implode(',',$args).")";


$stmt= $con->prepare($query);

$savecount=0;
foreach($listvalue as $row){

	$stmt->Execute($row);
	$savecount++;
}
				 
if ($countMsg=$savecount){
  echo $savecount.iconv("utf-8", "EUC-KR",'건이 정상 저장되었습니다');
  include('getjson2.php');

}
else  echo $countMsg-$savecount.iconv("utf-8", "EUC-KR",'건이 저장되지 못했네요.체크바랍니다.');






?>


