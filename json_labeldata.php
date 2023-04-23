<?php

    function ExcelDateToJSDate($datetime) {
      return round(($datetime - 25569)*86400);
	  
	}
  
	$requestlabeldata = file_get_contents("php://input");
	$array = json_decode($requestlabeldata, true);

    //print_r($array);
    include 'dbconn.php';
    include('dbcon.php');
   
    $filenum = $array['filenum'];//들어오는 파일 순서.
	$processdate = $array['daten']; //작업처리 날짜.
	$blacklist = $array['blackcheck']; //블랙리스트 업체 여부
    $centerblackllist = $array['centerblack']; //센터블랙
	$cuttinglist = $array['cuttinglist']; //블랙리스트 업체 여부
    $beforefive = array("2600","2601","2620","2622","2605","2625","2635","2630","2633","2624","2610","2370","2240","2623","2632","4000");  // 배열 생성과 동시에 초기화  이천수원 5시전 제어 
	///
    //컷팅 리스화 한다..................업체가 어디인지 찾고 컷팅하기-----------------------------------------------------------
   
    /*
    $arraylen =  count($array['maindata']);
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
	$datetime2 = new DateTime(date("Y-m-d", ExcelDateToJSDate($array['maindata'][0]["납품일자"])));//new DateTime($array['maindata'][0]["납품일자"]);
    
	

    $yoil = array("일","월","화","수","목","금","토");

     
    //$yoil2 = date('w', strtotime($array['daten']));
    
    $yoil2 = $yoil[date('w', strtotime($array['daten']))];
    
    
    // $차이 는 DateInterval 객체. var_dump() 찍어보면 대충 감이 옴.
	
		
    $chai = date_diff($datetime1, $datetime2);
    $stringchai = $chai->days;
	
    //invert가 1이면 과거 발주서, 0이면 현재이후
	if ($chai->invert == '1'){
		 
	    echo "전 발주서입니다. 납품날짜 확인해보세요";
		
		Context::close();exit;	

	}

    $stringDate = date_format($datetime2,"Y-m-d");
	$time = date("H:i:s"); //현 작업시간 
	$sep = ', ';
    
    
    //센터별 처리를 위한 지역 
	$cutcut = array();
	$sql = "SELECT * FROM print_info ";
   
	for ($i=0; $i<count($cuttinglist);$i++)
	{        
		if($i=='0') $sql.= "where";
             $sql .= " printinfo = '$cuttinglist[$i]' or";

	}
         
	$sql = rtrim($sql, "or"); // remove last separator 	 

    $result = mysqli_query($connect,$sql);
    while($row = mysqli_fetch_assoc($result)){

        array_push($cutcut,$row['center']);

	}
    $datacount =0;
	$dataDBcount = 0;
  
    if($blacklist=='blackon') $blk='Y';
	else $blk ='N';
     
    
    if($centerblackllist=='centeron') $blk='Z';
	
	 

	foreach ($array['maindata'] as $row) {

			
			$str = implode('ㅁ@', $row);
			$str = rtrim($str, $sep); // remove last separator
			$str = explode('ㅁ@', $str);
             


            // 미사용 코드 입력 차단 
			if (in_array(trim($str[1]), $config->common[0]->notusing)) continue;


			if ($yoil2 =='금'){
				
				if ($chai->days=='1') {
				
				//d1일 경우에 대한 코딩 	
					if (in_array(substr(trim($str[0]),0,4), $config->common[0]->D1)) continue;
							 
				}
				else if ($chai->days=='3') {
				//d3에대한 코딩 		
					if (in_array(substr(trim($str[0]),0,4), $config->common[0]->D2)) continue;				
				}
				else
				{
					   
					echo "납품날짜가 맞지 않습니다.";
					exit;	

				}


			}
			else{

                if ($chai->days=='1') {
				
				//d1일 경우에 대한 코딩 	
					if (in_array(substr(trim($str[0]),0,4), $config->common[0]->D1)) continue;
							 
				}
				else if ($chai->days=='2') {
				//d2에대한 코딩 		
					if (in_array(substr(trim($str[0]),0,4), $config->common[0]->D2)) continue;				
				}
				else
				{
					   
					echo "납품날짜가 맞지 않습니다.";
					exit;	

				}

			}

			
		
	    
			
			$blackcheck = false;
          
            //센터 블랙 확인 
			if ($centerblackllist=="blackcenoff"){
			
				
                 //수도권 블랙--------------------------------------------------------- 
               //수도권센터에 해당 품목이면 블랙해라 
                   //echo $centerblackllist;
               if (in_array(substr(trim($str[0]),0,4), $beforefive)){

                     if (in_array(trim($str[1]), $config->common[0]->centerblack)) continue;
                     

			   }

			}
			


            //블랙리스트 확인 
			if ($blacklist=='blackoff'){
			   
			   // 제이앤 제이 방식의 컷팅 
               //if (in_array(trim($str[3]), $config->common[0]->yeop)) continue;
			   // 품목 블랙 컷팅 
               if (in_array(trim($str[1]), $config->common[0]->code)) continue;
              
				
						
              




			   //-----------------------------------------------------------------
		        //포함 블랙 경우 --------------------------------------------

				foreach($config->common[0]->yeop as $customerarray) {
				    
					 
	
					if(strpos(trim($str[3]),$customerarray) !== false) { 
						$blackcheck = true;
						
				          	
				    }
				}
                
				
             // 수원수원2 이천 블랙품목불렉
			/*	if (in_array(trim($str[1]), $config->common[0]->code)) {
					
				     if (in_array(substr(trim($str[0]),0,4), $beforefive))
			    	 {
					    $blackcheck = true; 
					 }
						
				}  */

			}
			if ($blackcheck) continue;  //포함 블랙 경우 -----------

			//선택한 센터만 인쇄
            if (in_array(substr(trim($str[0]),0,4), $cutcut)){
			}	
			else{
				continue;
	        }
            
			// 160 직송 컷팅시킨다. 
			if (trim($str[8])=='160') continue;
            
			$datacount++;
	        
			//$str[11] = preg_replace("★ㅁ", "ss", $str[11]);
            //$str[11] = preg_replace("★ㅁ","11",$str[11]);
			//바코드 중간삭제
			/*$sql = "insert into labelcjimsi(idate, blk, worktime, companyname, chasu ,realchasu,differ,center, itemcode, itemname ,customer,deadtype,unit,surang,deliver,delivergubun,mcode ,mcondition ,special ,deaddate ,barcode,orderY ,cancelY,emergenY,sorterY ,groupnum ,labelpage) VALUES('".addslashes($array['daten'])."','".addslashes($blk)."','".addslashes($time)."','".addslashes('cj')."','".addslashes($array['chasu'])."','".addslashes($array['filenum'])."','".addslashes($stringchai)."',
			'".addslashes($str[0])."','".addslashes($str[1])."','".addslashes($str[2])."','".addslashes($str[3])."','".addslashes($str[4])."',
			'".addslashes($str[5])."','".addslashes($str[6])."','".addslashes($str[7])."','".addslashes($str[8])."','".addslashes($str[9])."','".addslashes($str[10])."',
			'".addslashes($str[11])."','".addslashes($stringDate)."','".addslashes(substr($str[13],0,18).substr($str[13],23,5))."','".addslashes($str[14])."','".addslashes($str[15])."',
			'".addslashes($str[16])."','".addslashes($str[17])."','".addslashes($str[18])."','".addslashes(substr($str[13],23,5))."')"; */
            
            $sql = "insert into labelcjimsi(worker, idate, blk, worktime, companyname, chasu ,realchasu,differ,center, itemcode, itemname ,customer,deadtype,unit,surang,deliver,delivergubun,mcode ,mcondition ,special ,deaddate ,barcode,orderY ,cancelY,emergenY,sorterY ,groupnum ,labelpage) VALUES('".$_SESSION['user_id']."','".addslashes($array['daten'])."','".addslashes($blk)."','".addslashes($time)."','".addslashes('cj')."','".addslashes($array['chasu'])."','".addslashes($array['filenum'])."','".addslashes($stringchai)."',
			'".addslashes($str[0])."','".addslashes($str[1])."','".addslashes($str[2])."','".addslashes($str[3])."','".addslashes($str[4])."',
			'".addslashes($str[5])."','".addslashes($str[6])."','".addslashes($str[7])."','".addslashes($str[8])."','".addslashes($str[9])."','".addslashes($str[10])."',
			'".addslashes($str[11])."','".addslashes($stringDate)."','".addslashes($str[13])."','".addslashes($str[14])."','".addslashes($str[15])."',
			'".addslashes($str[16])."','".addslashes($str[17])."','".addslashes($str[18])."','".addslashes(substr($str[13],23,5))."')";

             
            //echo $sql;
			$result = mysqli_query($connect,$sql);
		    
		    if($result) { 
				$dataDBcount++;}
		
		}//엑셀데이타 입력 끝
		
		if($datacount == $dataDBcount){
		echo $datacount.'success'.$dataDBcount;}
		else echo '데이타 입력점검 바랍니다';

		$connect->close();
        
?>
