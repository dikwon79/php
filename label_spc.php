<?php

    function ExcelDateToJSDate($datetime) {
      return round(($datetime - 25569)*86400);
	  
	}
  
	$requestlabeldata = file_get_contents("php://input");
	$array = json_decode($requestlabeldata, true);


    include 'dbconn.php';
   
   
 
    
    
  
	$processdate = $array['daten']; //작업처리 날짜.
	$blacklist = $array['blackcheck']; //블랙리스트 업체 여부
	$cuttinglist = $array['cuttinglist']; //블랙리스트 업체 여부

	///거래처 판단 코드 ---삭제
    //컷팅 리스화 한다..................업체가 어디인지 찾고 컷팅하기-----------------------------------------------------------
    
  
    $arraylen =  count($array['maindata']);
	
	/*
	$cutcodecheck = false;
	
	for ($i=0;$i<$arraylen-1;$i++){

           $cutcode =  $array['maindata'][0]["상품 코드"];
           $sql = "SELECT geocode,georae FROM iteminfo WHERE itemcode='$cutcode'";
		   $result = mysqli_query($connect,$sql);
		   $count = mysqli_num_rows($result);

           if ($count > 0) {
			   $cutcodecheck = true;
			   break;
           }
		  

	}


	if ($cutcodecheck) {
         $row = mysqli_fetch_assoc($result);
		 $geocode = $row['geocode'];
		 $geoname = $row['georae'];
			 
	     
	}
	else {

        echo '거래처 등록을 먼저 하셔야 합니다.';
		exit;

	}
    if(!$geocode) {
         echo '거래처 코드가 없습니다';
		 exit;

	}
    */
	//cutting 배열
	include 'cut_common.php';


    //---------------------------------------------------------------------------------------------------------------
    //D1인지 D2인지 등 여부 찾기 
  
	$datetime1 = new DateTime($array['daten']);                   
	$datetime2 = new DateTime($array['maindata'][0]["입고일자"]);
    //echo $datetime2;
    // $차이 는 DateInterval 객체. var_dump() 찍어보면 대충 감이 옴.
    $chai = date_diff($datetime1, $datetime2);
    $stringchai = $chai->days;
    $stringDate = date_format($datetime2,"Y-m-d");
	$time = date("H:i:s"); //현 작업시간 
	$sep = ', ';
    
	/*
    //센터별 처리를 위한 지역 
	$cutcut = array();
	$sql = "SELECT * FROM print_info ";
   
	for ($i=0; $i<count($cuttinglist);$i++)
	{        
		if($i=='0') $sql.= "where";
             $sql .= " grouping = '$cuttinglist[$i]' or";

	}
         
	$sql = rtrim($sql, "or"); // remove last separator 	 

    $result = mysqli_query($connect,$sql);
    while($row = mysqli_fetch_assoc($result)){

        array_push($cutcut,$row['center']);

	}
    */
   
	foreach ($array['maindata'] as $row) {

			
			$str = implode('ㅁ', $row);
		
			$str = rtrim($str, $sep); // remove last separator
			$str = explode('ㅁ', $str);
			
			if ($chai->days!='1') {
				
                   
			    echo "납품날짜가 맞지 않습니다.";
				exit;	

			}
	        $blk = 'Y';
			
            $centerdivision= explode('(', $str[8]);
			$str[8] = substr($centerdivision[1],0,4).' / '.$centerdivision[0];
			$sql = "insert into labelcjimsi(idate, blk, worktime, companyname, chasu ,differ, center, itemcode, itemname ,customer,deadtype,unit,surang,deliver,delivergubun,mcode ,mcondition ,special ,deaddate ,barcode,orderY ,cancelY,emergenY,sorterY ,groupnum ) VALUES('".addslashes($array['daten'])."','".addslashes($blk)."','".addslashes($time)."','".addslashes('spc')."','".addslashes($array['chasu'])."','".addslashes($stringchai)."','".addslashes($str[8])."','".addslashes($str[2])."','".addslashes($str[3])."','".addslashes($str[10])."','".addslashes($str[4])."',
			'".addslashes($str[5])."','".addslashes($str[14])."','".addslashes($str[21])."','".addslashes($str[22])."','".addslashes($str[12])."','".addslashes($str[19])."',
			'".addslashes($str[23])."','".addslashes($str[1])."','".addslashes($str[26])."','".addslashes('Y')."','".addslashes('N')."',
			'".addslashes('N')."','".addslashes($str[11])."','".addslashes('')."')";
					  
           
			mysqli_query($connect,$sql);
		   
		
		}//엑셀데이타 입력 끝
         
	    
?>
