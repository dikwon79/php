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

	///
    //컷팅 리스화 한다..................업체가 어디인지 찾고 컷팅하기-----------------------------------------------------------
    
  
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

	//cutting 배열
	include 'cut_common.php';


    //---------------------------------------------------------------------------------------------------------------
    //D1인지 D2인지 등 여부 찾기 
  
	$datetime1 = new DateTime($array['daten']);                   
	$datetime2 = new DateTime(date("Y-m-d", ExcelDateToJSDate($array['maindata'][0]["납품일자"])));//new DateTime($array['maindata'][0]["납품일자"]);
    //echo $datetime2;
    // $차이 는 DateInterval 객체. var_dump() 찍어보면 대충 감이 옴.
    $chai = date_diff($datetime1, $datetime2);
    $stringchai = $chai->days;
    $stringDate = date_format($datetime2,"Y-m-d");
	$time = date("H:i:s"); //현 작업시간 
	$sep = ', ';
    
 
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
   
   
	foreach ($array['maindata'] as $row) {

			
			$str = implode('ㅁ', $row);
			$str = rtrim($str, $sep); // remove last separator
			$str = explode('ㅁ', $str);
			
			if ($chai->days=='1') {
				
			//d1일 경우에 대한 코딩 	
				if (in_array(substr(trim($str[0]),0,4), $config->common->D1)) continue;
                		 
			}
			else if ($chai->days=='2') {
			//d2에대한 코딩 		
				if (in_array(substr(trim($str[0]),0,4), $config->common->D2)) continue;				
			}
			else
		    {
                   
			    echo "납품날짜가 맞지 않습니다.";
				exit;	

			}
	        $blk = 'N';
			
            
            //블랙리스트 확인 
			if (in_array($geocode, $blacklist)){
				$blk = 'Y';
                if (in_array(trim($str[3]), $config->common->yeop)) continue;
				if (in_array(trim($str[1]), $config->common->code)) continue;	
				

			}
			//선택한 센터만 인쇄
            if (in_array(substr(trim($str[0]),0,4), $cutcut)){
			}	
			else{
				continue;
	        }

			$sql = "insert into labelcjimsi(idate, blk, worktime, chasu ,realchasu,differ,geocode,geoname, center, itemcode, itemname ,customer,deadtype,unit,surang,deliver,delivergubun,mcode ,mcondition ,special ,deaddate ,barcode,orderY ,cancelY,emergenY,sorterY ,groupnum ) VALUES('".addslashes($array['daten'])."','".addslashes($blk)."','".addslashes($time)."','".addslashes($array['chasu'])."','".addslashes($array['filenum'])."','".addslashes($stringchai)."',
			(select geocode from iteminfo where itemcode='".$str[1]."'),(select georae from iteminfo where itemcode='".$str[1]."'),
			'".addslashes($str[0])."','".addslashes($str[1])."','".addslashes($str[2])."','".addslashes($str[3])."','".addslashes($str[4])."',
			'".addslashes($str[5])."','".addslashes($str[6])."','".addslashes($str[7])."','".addslashes($str[8])."','".addslashes($str[9])."','".addslashes($str[10])."',
			'".addslashes($str[11])."','".addslashes($stringDate)."','".addslashes(substr($str[13],0,18).substr($str[13],23,5))."','".addslashes($str[14])."','".addslashes($str[15])."',
			'".addslashes($str[16])."','".addslashes($str[17])."','".addslashes($str[18])."')";
           
			mysqli_query($connect,$sql);
		    
		   
		
		}//엑셀데이타 입력 끝
         
	    
   
	    
        $u1 = date("Y"); 
        // 순번....순서.........................................................................
        $sql = "select * from labelmain where substr(id,1,4)='$u1' order by id desc";
		
        $result = mysqli_query($connect,$sql);
		$count = mysqli_num_rows($result);
		
	
		$row = mysqli_fetch_assoc($result);
		if ($count > 0) 
		{           
		      $smx= $row['id'];
			
		}
		else
		{
            $smx= $u1."000000000";
	
		}
            
        // 업체별로 차수 구해서 새로운 디비에 입력해준다..............................................
		
		$inputchasu = $array['chasu'];
		$inputdate = $processdate;
		
		

	    $inputrchasu1 = $inputchasu-1;
	    $inputrchasu2 = $inputchasu;
	    
		
		/*
		$sql = "select * from labelcjimsi where idate='$processdate' and chasu='$inputchasu' and realchasu ='$filenum' group by geocode";
		
        $result = mysqli_query($connect,$sql);
		
		$conditional =  " (geocode='' or ";
 		while($row=mysqli_fetch_assoc($result)){

            $conditional.= "geocode=".$row['geocode']. " or ";

		}

		$conditional =rtrim($conditional,' or ');
        $conditional .=")";
		*/
        
        		 
	    $sql ="SELECT @maxID:=@maxID+1,idate,blk,worktime,chasu,
	          (CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
			   when chaivalue <0 and surang2=0  then '*취소'
			   when chaivalue <0 and surang2!=0 then '*감소'	           
			   when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
			   when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
	           center,geocode,geoname,itemcode,itemname,customer,surang1,surang2,chaivalue,unit2,barcode1,barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum 
			   FROM (select idate,blk,worktime,chasu,center,geocode,geoname,itemcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
				sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
				,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum FROM (SELECT  u.idate,u.blk,u.worktime,u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
				u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-x.surang as 'chai',
				x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum 
				FROM (
				SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum from(select * from labelmain where idate='$inputdate' and (bar2, chasu) in (select bar2, max(chasu) as chasu from labelmain where chasu < '$inputchasu' group by bar2)
	            order by chasu desc) t group by t.bar2)x
				right JOIN (SELECT b.idate,b.blk,b.worktime,b.chasu, b.center,b.geocode,b.geoname, b.itemcode, b.itemname , b.customer ,
                b.cancelY,b.unit, sum(b.surang) as 'surang', max(b.barcode) as 'barcode' ,b.mcode, b.deaddate ,b.mcondition, b.deliver, b.special,b.groupnum FROM labelcjimsi b 
                WHERE chasu ='$inputrchasu2' AND idate='$inputdate' and realchasu ='$filenum' GROUP BY substr(b.barcode,1,18),center,itemcode,customer)u 
				ON substr(x.barcode,1,18) = substr(u.barcode,1,18))T GROUP BY substr(barcode2,1,18),customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";
              
	    $result = mysqli_query($connect,$sql);

		$count = mysqli_num_rows($result);
        if ($count >0)
        
		{
		     
			  $sql ="SET @maxID :='$smx'; ";
	          mysqli_query($connect,$sql);
	          $sql ="insert into labelmain (id,idate,blk,worktime,chasu, type, center,geocode, geoname, itemcode, itemname, customer, surang1,surang2,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special,cancelY,groupnum) 
	          SELECT @maxID:=@maxID+1,idate,blk,worktime,chasu,
	          (CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
			   when chaivalue <0 and surang2=0  then '*취소'
			   when chaivalue <0 and surang2!=0 then '*감소'	           
			   when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
			   when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
	           center,geocode,geoname,itemcode,itemname,customer,surang1,surang2,chaivalue,unit2,barcode1,barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum 
			   FROM (select idate,blk,worktime,chasu,center,geocode,geoname,itemcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
				sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
				,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum FROM (SELECT  u.idate,u.blk,u.worktime,u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
				u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-x.surang as 'chai',
				x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum 
				FROM (
				SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum from(select * from labelmain where idate='$inputdate' and (bar2, chasu) in (select bar2, max(chasu) as chasu from labelmain where chasu < '$inputchasu' group by bar2)
	            order by chasu desc) t group by t.bar2)x
				right JOIN (SELECT b.idate,b.blk,b.worktime,b.chasu, b.center,b.geocode,b.geoname, b.itemcode, b.itemname , b.customer ,
                b.cancelY,b.unit, sum(b.surang) as 'surang', max(b.barcode) as 'barcode' ,b.mcode, b.deaddate ,b.mcondition, b.deliver, b.special,b.groupnum FROM labelcjimsi b 
                WHERE chasu ='$inputrchasu2' AND idate='$inputdate' and realchasu ='$filenum' GROUP BY substr(b.barcode,1,18),center,itemcode,customer)u 
				ON substr(x.barcode,1,18) = substr(u.barcode,1,18))T GROUP BY substr(barcode2,1,18),customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";

			   mysqli_query($connect,$sql);
			  
			 
			 
			   echo "success";
			   $connect->close();
		}
		else{
		   
	            $sql = "delete from labelcjimsi where idate='$processdate' and chasu='$inputchasu' and realchasu ='$filenum' ";
                mysqli_query($connect,$sql);
				$connect->close();
				echo "변경분이 없습니다.";
		}

	

?>
