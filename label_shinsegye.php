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

	
	//컷팅 리스화 한다..................업체가 어디인지 찾고 컷팅하기-----------------------------------------------------------
    
  
    $arraylen =  count($array['maindata']);
	

	//cutting 배열
	include 'cut_common.php';

    
    //---------------------------------------------------------------------------------------------------------------
    //D1인지 D2인지 등 여부 찾기 
  
	$datetime1 = new DateTime($array['daten']);                   
	$datetime2 = $array['maindata'][1]["RD_DATE"];//new DateTime($array['maindata'][0]["납품일자"]);
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
				if (in_array(substr(trim($str[0]),0,4), $config->shinsegye->D1)) continue;
                		 
			}
			else{
			//d2에대한 코딩 		
				if (in_array(substr(trim($str[0]),0,4), $config->shinsegye->D2)) continue;				
			}
	        $blk = 'N';
			
			
            //블랙리스트 확인 
			if (in_array($geocode, $blacklist)){
				$blk = 'Y';
                if (in_array(trim($str[10]), $config->shinsegye->yeop)) continue;
				if (in_array(trim($str[2]), $config->shinsegye->code)) continue;	
				

			}
            
			if ($str[1]=='존') continue;
            if ($str[7]=='') continue;

			$sql = "insert into labelshinsegye(idate, blk, geocode, geoname,companyname, worktime, chasu, realchasu ,differ, DELY_LINE_NO,DEMAND_DEPT,	DEMAND_DEPT_NAME,DEMAND_SUB_DEPT,DEMAND_SUB_DEPT_NAME,DEMAND,DEMAND_NAME,ITEM_NO,DESCRIPTION_LOC,SPECIFICATION,WEIGHT,PKG_VOLUME,	GUBUN_PR_QTY,LABEL_PR_QTY,TEMP_PR_QTY,CUR_P,TOT_PAGE,LABEL_PAGE,REMARK,CONF_FLAG,CONF_FLAG_TEXT,DIR_YN,BARCODE,KEEP_TEMP_GUBUN_CD,	KEEP_TEMP_GUBUN_TEXT,ORIGIN_CD,ORIGIN_COUNTRY_TEXT,PLANT_CODE,PLANT_NAME,VENDOR_CODE,VENDOR_NAME,UNIT_MEASURE,UNIT,UNIT_TEXT,RD_DATE,	PO_NO,PR_NO,PR_SEQ,PR_REQ_SEQ,DIS_INV_NO,DT_SEQ,PRINTDATE,PRINTTIME,PRINTQTY,FLAG,TS_FLAG,DANGER_YN,ROLLTAINER_NO,SENSITIVE_STORE,	PR_REQ_SEQ_NM,IN_PLANT_CODE,IN_PLANT_NAME,PRINT_TIME,SORTER_YN,DOCK_NO,QC_YN,PRODUCTION_DATE,VALID_DATE,DISTRIBUTION_NO,LOT_NO,	BARCODE_DC) VALUES('".addslashes($array['daten'])."','".addslashes($blk)."','".addslashes($geocode)."','".addslashes($geoname)."','".addslashes('shinsegye')."','".addslashes($time)."','".addslashes($array['chasu'])."','".addslashes($realchasu)."','".addslashes($stringchai)."','".addslashes($str[0])."','".addslashes($str[1])."','".addslashes($str[2])."','".addslashes($str[3])."','".addslashes($str[4])."',
			'".addslashes($str[5])."','".addslashes($str[6])."','".addslashes($str[7])."','".addslashes($str[8])."','".addslashes($str[9])."','".addslashes($str[10])."',
			'".addslashes($str[11])."','".addslashes($str[12])."','".addslashes($str[13])."','".addslashes($str[14])."','".addslashes($str[15])."',
			'".addslashes($str[16])."','".addslashes($str[17])."','".addslashes($str[18])."','".addslashes($str[19])."','".addslashes($str[20])."','".addslashes($str[21])."',
			'".addslashes($str[22])."','".addslashes($str[23])."','".addslashes($str[24])."','".addslashes($str[25])."','".addslashes($str[26])."','".addslashes($str[27])."',
			'".addslashes($str[28])."','".addslashes($str[29])."','".addslashes($str[30])."','".addslashes($str[31])."','".addslashes($str[32])."',
			'".addslashes($str[33])."','".addslashes($str[34])."','".addslashes($str[35])."','".addslashes($str[36])."','".addslashes($str[37])."','".addslashes($str[38])."',
			'".addslashes($str[39])."','".addslashes($str[40])."','".addslashes($str[41])."','".addslashes($str[42])."','".addslashes($str[43])."','".addslashes($str[44])."',
			'".addslashes($str[45])."',
			'".addslashes($str[46])."','".addslashes($str[47])."','".addslashes($str[48])."','".addslashes($str[49])."','".addslashes($str[50])."',
			'".addslashes($str[51])."','".addslashes($str[52])."','".addslashes($str[53])."','".addslashes($str[54])."','".addslashes($str[55])."','".addslashes($str[56])."',
			'".addslashes($str[57])."','".addslashes($str[58])."','".addslashes($str[59])."','".addslashes($str[60])."')";
					  
			mysqli_query($connect,$sql);
		    
		   // echo $sql;
		
		}
	
       
      
			  
	   echo "success";
       

	   $connect->close();

   


?>
