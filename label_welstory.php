<?php

    function ExcelDateToJSDate($datetime) {
      return round(($datetime - 25569)*86400);
	  
	}

	$requestlabeldata = file_get_contents("php://input");
	$array = json_decode($requestlabeldata, true);


    include 'dbconn.php';
   
 
	
	$filenum = $array['filenum'];//들어오는 파일 순서.
	$processdate = $array['daten']; //작업처리 날짜.
	$blacklist = $array['blackcheck']; //블랙리스트 업체 여부
	$cuttinglist = $array['cuttinglist']; //블랙리스트 업체 여부
    $centername = $array['centerN']; //센터명
	
	//컷팅 리스화 한다..................업체가 어디인지 찾고 컷팅하기-----------------------------------------------------------
    
  
    $arraylen =  count($array['maindata']);
	

	//cutting 배열
	include 'cut_common.php';

    
    //---------------------------------------------------------------------------------------------------------------
    //D1인지 D2인지 등 여부 찾기 
  
	$datetime1 = new DateTime($array['daten']);                   
	$datetime2 = $array['maindata'][0]["납기일자"];//new DateTime($array['maindata'][0]["납품일자"]);
    $datetime2 = new DateTime(substr($datetime2,0,10));

	
    // $차이 는 DateInterval 객체. var_dump() 찍어보면 대충 감이 옴.
    $chai = date_diff($datetime1, $datetime2);

    $stringchai = $chai->days;
 
    $stringDate = date_format($datetime2,"Y-m-d");
	$time = date("H:i:s"); //현 작업시간 
	$sep = ', ';
    
   
    
  
	
	foreach ($array['maindata'] as $row) {

			
			$str = implode('ㅁ', $row);
			$str = rtrim($str, $sep); // remove last separator
			$str = explode('ㅁ', $str);
			
			if ($chai->days=='1') {
				
			//d1일 경우에 대한 코딩 	
				if (in_array(substr(trim($str[0]),0,4), $config->welstory->D1)) continue;
                		 
			}
			else{
			//d2에대한 코딩 		
				if (in_array(substr(trim($str[0]),0,4), $config->welstory->D2)) continue;				
			}
	        $blk = 'N';
			
			
            //블랙리스트 확인 
			if (in_array($geocode, $blacklist)){
				$blk = 'Y';
                if (in_array(trim($str[10]), $config->welstory->yeop)) continue;
				if (in_array(trim($str[2]), $config->welstory->code)) continue;	
				

			}

			if ($str[1]=='존') continue;
			$sql = "insert into labelcjimsi(idate, blk, worktime, companyname, chasu ,differ, center, itemcode, itemname ,customer,deadtype,unit,surang,deliver,delivergubun,mcode ,mcondition ,special ,deaddate ,barcode,orderY ,cancelY,emergenY,sorterY ,groupnum ) VALUES('".addslashes($array['daten'])."','".addslashes($blk)."','".addslashes($time)."','".addslashes('welstory')."','".addslashes($array['chasu'])."','".addslashes($stringchai)."','".addslashes($centername)."','".addslashes($str[2])."','".addslashes($str[3])."','".addslashes($str[10])."','".addslashes($str[8])."',
			'".addslashes($str[26])."','".addslashes($str[21])."','".addslashes($str[18].$str[19])."','".addslashes($str[20])."','".addslashes('')."','".addslashes($str[7])."',
			'".addslashes($str[23])."','".addslashes($str[4])."','".addslashes($str[30].$str[29].$str[21])."','".addslashes('Y')."','".addslashes('N')."',
			'".addslashes('N')."','".addslashes($str[33])."','".addslashes($str[11])."')";

			mysqli_query($connect,$sql);
		    
		   
		
		}
		echo "success";
       

	   $connect->close();

   
?>

    
       