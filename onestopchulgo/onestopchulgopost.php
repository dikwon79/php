<?
  
  $blacklist = file_get_contents("php://input");
  $array = json_decode($blacklist, true);
  $info = array("1제주","1푸드빌","1장성","1이천","1대구","1양산","1수원2","1수원","1수원지하","1동탄","1동탄2","수원","수원2","수원2추가","수원지하",
                 "양산","이천","이천추가","장성","장성추가","제주","푸드빌","동탄","동탄2","강남","남서울","동서울","RS","대구","경북","부산","광주","spc","SPC","기타출고","직송","결품",
                 "동원","동원시화","동원이천","신세계","아워홈","외식","웰광주","웰김해","웰왜관","웰용인","웰평택","웰제주","경인1","경인2","미트박스",
                 "성남","영남","평택","현대","호남","조정","상황","cj","CJ","웰스토리");

  /**$info = array("강남","남서울","동서울","수원","수원2","수원2추가",
					"수원지하","양산","이천","이천추가","장성","장성추가","제주","푸드빌","SPC","spc","동원시화","동원이천","신세계"
					,"아워홈","광주","김해","왜관","용인","웰평","경인1","경인2","미트박스","성남","영남","평택","현대","호남","기타출고","외식","조정","상황");
 



  $infomapping = array("RS","RS","RS","CJ","CJ","CJ",
					"CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","SPC","SPC","동원","동원","신세계"
					,"아워홈","웰스토리","웰스토리","웰스토리","웰스토리","웰스토리","현대","현대","현대","현대","현대","현대","현대","현대","기타","외식","조정","기타");
   */ 
  $infomapping = array("CJd","CJd","CJd","CJd","CJd","CJd","CJd","CJd","CJd","CJd","CJd","CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","CJ","RS",
						"RS","RS","RS","RS","RS","RS","RS","SPC","SPC","기타","기타","기타","동원","동원","동원","신세계","아워홈","외식","웰스토리","웰스토리","웰스토리","웰스토리","웰스토리",
						"웰스토리","현대","현대","현대","현대","현대","현대","현대","현대","조정","기타","CJ","CJ","웰스토리");
  
 
  include '../dbconn.php';
  
  $date = date("Y-m-d");

  $sql = "select Max(chasu) as 'chasu' from labelXmain where inputday= '$date'";
  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);
  $row = mysqli_fetch_assoc($result);

 
  if ($count > 0) 
  {           
 
     $chasu = $row['chasu'] + 1;	
	 echo $chasu;
  }
  else
  {
     $chasu = 1;	  
  }
 

  foreach ($array['maindata'] as $row) {

	
	if (trim($row['출고일'])=="") continue;	
	
    $key = array_search(trim($row['경로']), $info);
   
    if ($infomapping[$key]=="CJd") continue;
    
	//조정시에는 마이너스 추가해서 디비 입력한다. 출고디비 사용하므로 
	if ($infomapping[$key]=="조정"){

		$surang = $row['수량'] * -1;
	}
	else{

	    $surang = $row['수량'];
	}
    $day = substr($row['출고일'],0,10);

	
    
	 
	$day = (($day- 25569) * 86400-60*60*9);
    $day = round($day*10)/10;
	$day = date('Y-m-d',$day);
	    
	
    
    
	$sql = "insert into labelXmain(worker,inputday,idate,chasu,itemcode,mappingcode,itemname,chaivalue,unit,companyname,customer) VALUES('"
		.addslashes($_SESSION['user_id'])."','".addslashes($date)."','"
		.addslashes($day)."','".addslashes($chasu)."','".addslashes($row['CJ코드'])."','".addslashes($row['CJ코드'])."','".addslashes($row['품명'])."','".addslashes($surang)."','".addslashes($row['단위'])."','".addslashes($infomapping[$key])."','".addslashes($info[$key])."')";
   
		   
    //echo $sql;
	mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...

  echo "success";

?>