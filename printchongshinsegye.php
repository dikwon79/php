<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>인쇄</title>

<link rel="stylesheet" href="bootstrap/css/iaan.css">
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap cdn 설정 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="excel.min.js"></script>
<style>
h1, h2, h3, h4, h5, dl, dt, dd, ul, li, ol, th, td, tr, p, blockquote, form, fieldset, legend, div,body,thead,tbody { -webkit-print-color-adjust:exact; }

body {

margin: 0;
padding: 0;

}
thead{
  background:#090 exact !important;

}
* {

box-sizing: border-box;

-moz-box-sizing: border-box;

}

.page {
width: 22cm;
min-height: 29.7cm;
padding: 1cm;
margin: 0 auto;
background:#eee exact !important;

}

.subpage {

border: 2px red solid;
height: 290mm;

}
.control {
width: 22cm;
height: 40px;
padding: 0;
margin: 0 auto;
background:green !important;

}

@page {

size: A4;
margin: 0;

}

@media print {

	html, body {
	width: 220mm;
	height: 297mm;
	}
	.page {
	margin: 0;
	border: initial;
	width: initial;
	min-height: initial;
	box-shadow: initial;
	background: initial;
	page-break-after: always;
	}
	.table th {
     background-color: #696969 !important;
	}
	tbody tr:nth-child(even) td{background-color: #eee !important;}

}
 
</style>
</head>

<?
error_reporting(E_ALL);

ini_set("display_errors", 1);


include('dbcon.php'); 
include('dbconn.php'); 

$processdate = $_GET['processdate'];

$chasu = $_GET['chasu'];

   
	    
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

$inputchasu = $chasu;
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



//총량지 발행방법  1,변화량  2, 총량으로 인쇄 
$sql = "select chongtype from setting where catering = 'cj' ";

$stmt = $con->prepare($sql);
$stmt->execute();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$chongtype = $row['chongtype'];
$chongtype = 2; //임시로 셋팅


$sql = "select * from labelmain where idate='$inputdate' and chasu='$inputchasu' and companyname='shinsegye' ";
$result = mysqli_query($connect,$sql);
$count = mysqli_num_rows($result);


if ($count > 0) 
{           

	
}
else
{
    $sql ="SET @maxID :='$smx'; ";
	mysqli_query($connect,$sql);
	$sql ="insert into labelmain (id,idate,blk,worktime, companyname, chasu, type, center,geocode, geoname, itemcode, itemname, customer, surang1,surang2,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special,cancelY,groupnum, PRINT_TIME,CONF_FLAG_TEXT,PR_REQ_SEQ_NM
    ,sorterY,QC_YN,IN_PLANT_NAME,SENSITIVE_STORE,TOT_PAGE,PKG_VOLUME) 
     SELECT @maxID:=@maxID+1,idate,blk,worktime,companyname,chasu,
	(CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
	when chaivalue <0 and surang2=0  then '*취소'
	when chaivalue <0 and surang2!=0 then '*감소'	           
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
	center,geocode,geoname,itemcode,itemname,customer,surang1,surang2,chaivalue,unit2,barcode1,barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum,PRINT_TIME,CONF_FLAG_TEXT,PR_REQ_SEQ_NM,sorterY,QC_YN,IN_PLANT_NAME,SENSITIVE_STORE,TOT_PAGE,PKG_VOLUME
	FROM (select idate,blk,worktime,companyname,chasu,center,geocode,geoname,itemcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
	sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
	,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum,PRINT_TIME,CONF_FLAG_TEXT,PR_REQ_SEQ_NM,sorterY,QC_YN,IN_PLANT_NAME,SENSITIVE_STORE,TOT_PAGE,PKG_VOLUME FROM (
	
	SELECT * FROM (select u.idate,u.blk,u.worktime,u.companyname, u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',if(x.surang IS NULL,0,x.surang) AS 'su1' ,
	u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-if(x.surang is NULL, 0,x.surang) as 'chai',
	x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum,
	u.PRINT_TIME,u.CONF_FLAG_TEXT,u.PR_REQ_SEQ_NM,u.sorterY,u.QC_YN,u.IN_PLANT_NAME,u.SENSITIVE_STORE,u.TOT_PAGE,u.PKG_VOLUME from(SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum from(select * from labelmain where (companyname,idate, chasu,cancelY,bar2) in (select companyname,idate, MAX(chasu) as chasu ,cancelY,bar2 from labelmain where chasu < '$inputchasu' and companyname='shinsegye' AND idate='$inputdate'  group by bar2)
	order by chasu desc) t group by t.bar2)x
	right JOIN (SELECT b.idate,b.blk,b.worktime,b.companyname, b.chasu, CONCAT(b.PLANT_CODE,' / ',b.PLANT_NAME) AS 'center' ,b.geocode,b.geoname, b.ITEM_NO AS 'itemcode'
, b.DESCRIPTION_LOC AS 'itemname', b.DEMAND_NAME AS 'customer',b.cancelY,b.UNIT_TEXT AS 'unit', sum(b.GUBUN_PR_QTY) as 'surang', max(b.DIS_INV_NO) as 'barcode' ,
b.ORIGIN_COUNTRY_TEXT AS 'mcode'
, b.RD_DATE AS 'deaddate',b.KEEP_TEMP_GUBUN_TEXT AS 'mcondition', b.DELY_LINE_NO AS'deliver', b.REMARK AS'special',b.ROLLTAINER_NO AS'groupnum',b.PRINT_TIME,b.CONF_FLAG_TEXT,b.PR_REQ_SEQ_NM
,b.SORTER_YN AS 'sorterY',b.QC_YN,b.IN_PLANT_NAME,b.SENSITIVE_STORE,b.TOT_PAGE,b.PKG_VOLUME FROM labelshinsegye b 
	WHERE chasu ='$inputchasu' AND idate='$inputdate'  AND companyname='shinsegye' GROUP BY DIS_INV_NO,center,ITEM_NO,DEMAND_NAME)u 
	ON x.barcode =u.barcode)z WHERE z.chai !=0 
UNION ALL
SELECT  x.idate,x.blk,x.worktime,x.companyname,'$inputchasu',x.center,x.geocode,x.geoname,x.itemcode,x.itemname,x.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
	u.cancelY as 'cancel2', x.unit as 'unit2' , if (u.surang is NULL, 0,u.surang) AS 'su2' ,if(u.surang IS NULL, 0,u.surang)-x.surang as 'chai',
	x.barcode AS 'barcode1', if(u.barcode IS NULL,x.barcode,u.barcode) AS 'barcode2', x.mcode,x.deaddate,x.mcondition,x.deliver as 'cha1', x.deliver as 'cha2', x.special,x.groupnum,
	x.PRINT_TIME,x.CONF_FLAG_TEXT,x.PR_REQ_SEQ_NM
,x.sorterY,x.QC_YN,x.inplant,x.SENSITIVE_STORE,x.TOT_PAGE,x.PKG_VOLUME
FROM(SELECT idate,blk,worktime,companyname,chasu,center,geocode,geoname,itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', 
if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver',mcode,deaddate,mcondition,special,groupnum,PRINT_TIME,CONF_FLAG_TEXT,PR_REQ_SEQ_NM
,sorterY,QC_YN,IN_PLANT_NAME AS 'inplant' ,SENSITIVE_STORE,TOT_PAGE,PKG_VOLUME 
from(select * from labelmain where (companyname,idate, chasu,cancelY,bar2) in (select companyname,idate, MAX(chasu) as chasu ,cancelY,bar2 from labelmain where chasu < '$inputchasu' and companyname='shinsegye' AND idate='$inputdate'  group by bar2)
	order by chasu desc) t group by t.bar2)x
	left JOIN (SELECT b.idate,b.blk,b.worktime,b.companyname, b.chasu, CONCAT(b.PLANT_CODE,'/',b.PLANT_NAME) AS 'center' ,b.geocode,b.geoname, b.ITEM_NO AS 'itemcode'
, b.DESCRIPTION_LOC AS 'itemname', b.DEMAND_NAME AS 'customer',b.cancelY,b.UNIT_TEXT AS 'unit', sum(b.GUBUN_PR_QTY) as 'surang', max(b.DIS_INV_NO) as 'barcode' ,
b.ORIGIN_COUNTRY_TEXT AS 'mcode'
, b.RD_DATE AS 'deaddate',b.KEEP_TEMP_GUBUN_TEXT AS 'mcondition', b.DELY_LINE_NO AS 'deliver', b.REMARK AS 'special',b.ROLLTAINER_NO AS 'groupnum',b.PRINT_TIME,b.CONF_FLAG_TEXT,b.PR_REQ_SEQ_NM
,b.SORTER_YN AS 'sorterY',b.QC_YN,b.IN_PLANT_NAME,b.SENSITIVE_STORE,b.TOT_PAGE,b.PKG_VOLUME FROM labelshinsegye b 
	WHERE chasu ='$inputchasu' AND idate='$inputdate' AND companyname='shinsegye' GROUP BY DIS_INV_NO,center,ITEM_NO,DEMAND_NAME)u 
	ON x.barcode =u.barcode WHERE IN_PLANT_NAME IS null)T GROUP BY barcode2,customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";


	mysqli_query($connect,$sql);
		  
	 

}



  $sql="SELECT T.printgubun,T.type,T.mapcode,T.itemcode,T.item,T.customer,T.grouping,T.printinfo,T.su1 ,T.su2,T.su3 AS 'Ttotal' 
,CONCAT (if (T.ipsu is not NULL,(T.su3 DIV T.ipsu),0),' / ',if (T.ipsu is not NULL,(T.su3 mod ipsu),T.su3)) as 'PT',T.unit AS 'danwi'
,cha2,mcondition,printgubun,lek
 FROM (SELECT a.ipsu,a.lek,a.printgubun,K.grouping,K.printinfo,K.type,K.itemcode,if(a.mappingcode IS NULL,K.itemcode,if(a.mappingcode='',K.itemcode,a.mappingcode)) AS mapcode,if(a.itemname is null,K.itemname,a.itemname) AS item,K.customer,K.su1,K.su2,K.su3,
 K.unit,K.cha2,K.mcondition FROM 
 (SELECT  e.grouping,e.printinfo,type,f.itemcode,f.itemname,f.customer,f.su1,f.su2,f.su3,f.unit,f.cha2,f.mcondition,f.geocode FROM 
 (SELECT type,itemcode,itemname,customer,center,surang1 AS 'su1',
 surang2 AS 'su2',chaivalue 'su3',unit,cha2,mcondition,geocode FROM labelmain 
 WHERE TYPE !='신규' and chasu='$inputchasu' AND idate='$inputdate' and companyname='shinsegye' GROUP BY center,itemcode, unit)f left JOIN print_info e 
 ON f.center = concat(e.center,' / ',e.centername))K LEFT JOIN iteminfo a ON K.itemcode = a.itemcode
 
 UNION all
 
 SELECT a.ipsu,a.lek,a.printgubun,K.grouping,K.printinfo,K.type,K.itemcode,if(a.mappingcode IS NULL,K.itemcode,if(a.mappingcode='',K.itemcode,a.mappingcode)) AS mapcode,if(a.itemname is null,K.itemname,a.itemname) AS item,K.customer,sum(K.su1),sum(K.su2),sum(K.su3),
 K.unit,K.cha2,K.mcondition FROM 
 (SELECT  e.grouping,e.printinfo,type,f.itemcode,f.itemname,f.customer,f.su1,f.su2,f.su3,f.unit,f.cha2,f.mcondition,f.geocode FROM 
 (SELECT type,itemcode,itemname,customer,center,sum(surang1) AS 'su1',
 sum(surang2) AS 'su2',sum(chaivalue) 'su3',unit,cha2,mcondition,geocode FROM labelmain 
 WHERE TYPE ='신규' and chasu='$inputchasu' AND idate='$inputdate' and companyname='shinsegye' GROUP BY center,itemcode, unit)f left JOIN print_info e 
 ON f.center = concat(e.center,' / ',e.centername))K LEFT JOIN iteminfo a ON K.itemcode = a.itemcode GROUP BY printinfo,mapcode)T 
 ORDER BY T.type,T.printgubun ASC,T.grouping asc ,T.printinfo asc, lek asc";
  
  $stmt = $con->prepare($sql);

  $stmt->execute();

  ?>

  <body>
  <div id='control' class="control">
    <button id="close" type="button" class="btn btn-default">Close</button>
    <button id="btnPrint" type="button" class="btn btn-default">Print</button>
  </div>

   

	<?
			
			 if ($stmt->rowCount() > 0)
			 {
				  $count =0;
				  $heightvalue=0;// 높이에 따라 페이지 분리
				  $heightvalue2=0;// 높이에 따라 페이지 분리
				  $check ='신규';
				  $center = '센터';
				  $printgubuncheck = '구분';
				  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				  {
					  extract($row);
					
                       
					   if ($type=='신규') 
					  {  
						   //	   if (($check !=trim($type)) or (($center !=trim($centername)) and ($printgubun!==null)))  2020-10-22일 수정함
						   if (($check !=trim($type)) or ($center !=trim($grouping)) or ($printgubuncheck !=trim($printgubun))) {
							   ?>
							  </tbody></table></div>
		                      </div> 
							   <?
							   $count =0;
							   $heightvalue=0;
							  
						   }
						   if(strlen($item)>45){
 
                              $heightvalue+=60.9091;

						   }
						   else{
                              $heightvalue+=38.1818;

						   }
                           

                           $check=$type;
						   $center=$grouping;
						   $printgubuncheck=$printgubun;
						   if ($count==0){
						   ?>
                           <div class="page">
						   <div class="subpage">
						   <div><h1><? if ($printgubun===null){ echo '품목미등록';} 
						               else { echo $printgubun;} ?></h1></div>
						   <table class="table table-striped table-bordered table-hover">
					       <thead>
							<tr>
								<th width='10%' >코드</th>
								<th width='10%'>렉</th>
								<th width='43%'>품목명</th>
								<th width='9%'>PT</th>
								<th width='9%'>수량</th>
								<th width='9%'>단위</th>
								<th width='10%'>센터</th>

							</tr>
						   </thead>
						   <tbody>
					     <?
						   }
						 ?>
					    <tr>
						<td width='10%'><?=$itemcode?></td>
						<td width='10%'><?=$lek?></td>
						<td width='43%'><?=$item?></td>
						<td width='9%'><?=$PT?></td>
						<?
                           if ($chongtype=='1'){
						?>
						<td width='9%'><?=$susu?></td>
						<?
						 }else {
						?>
						<td width='9%'><?=$Ttotal?></td>
						<? } ?>
						<td width='9%'><? if(strpos($danwi,'BOX')>0) echo 'BOX';
						                  else echo 'EA';?></td>
                        
						<td width='10%'><?=$printinfo?></td>
						
					    </tr>
                        <?

					  }
					  else
					  {
						    if ($check !=trim($type)) {
							   ?>
							  </tbody></table></div>
		                      </div> 
							   <?
							   $count =0;
							   $heightvalue2=0;
							  
						   }
                           
						   if(strlen($customer)>35){

                              $heightvalue2 +=83.636;
						      
						   }
                           else if(strlen($customer)>29){

						      if (strlen($item) > 40)  $heightvalue2 +=83.636;
							  else $heightvalue2 +=60.9091;
						   }
						   else 
							    $heightvalue2 +=83.636;
						   
						   if ($count==0){
							   $check=$type;




						   ?> 
						   
                           <div class="page">
						   <div class="subpage">
						   <div><h1><? if ($type===null){ echo '품목미등록';} 
						               else { echo $type;} ?></h1></div>
						   <table class="table table-striped table-bordered table-hover">
					       <thead>
							<tr>
								<th NOWRAP>품목코드</th>
								<th>품목명</th>
								<th>납품처명</th>
								<th NOWRAP>센터</th>
								
								<? if ($chongtype=='1'){ ?>
								<th>취소</th>
								<? } else {
									   
									   ?>
								<th>전</th>
								<th>후</th>
								<th>차</th>
                                <?  } ?>
								<th>단위</th>
								<th>차량</th>
								<th>보관</th>
								<th NOWRAP>업체</th>
								<? if ($chongtype=='1'){ ?>
								<th colspan=2>라벨순번</th>
								<? }
									   
							    ?>


							</tr>
						   </thead>
						   <tbody>
				          <?
						   }
						  ?>
                          <tr>
			
						  <td NOWRAP><?=$itemcode?></td>
						  <td><?=$item?></td>
						  <td><?=$customer?></td>
						  <td NOWRAP><?=$printinfo?></td>
						  <? if ($chongtype=='1'){ ?>
								 <td NOWRAP><?=$susu?></td>
								<? } else {
									   
									   ?>
								 <td NOWRAP><?=$su1?></td>
								 <td NOWRAP><?=$su2?></td>
						         <td NOWRAP><?=$Ttotal?></td>
                                <?  } ?>


						 
						 
						  
						  <td NOWRAP><? if(strpos($danwi,'BOX')>0) echo 'BOX';
						                  else echo 'EA';?></td>
						  <td NOWRAP><?=$cha2;?></td>	
						  <td NOWRAP><?=$mcondition?></td>
						  <td><?=$printgubun?></td>
						  <? if ($chongtype=='1'){ ?>
								 <td colspan=2><?=substr($labelcount,2,4)?></td>
								<? }
									   
							    ?>
                          	


						  </tr>
                      <?
					  }
                     $count++;

                    if ($heightvalue>977 or $heightvalue2>977){   
						
						
						$count=0;
						$heightvalue=0;
						$heightvalue2=0;
						?>
						</tbody></table></div>
		                      </div>
					  <?
					
				     } 
					 
				  }

			 }
		?>
		</tbody>
		</table>
		</div>
		</div>


    </p>
			

</body>
<script>
document.getElementById("btnPrint").onclick = function () {
    //printElement(document.getElementById("printThis"));
   var a = document.getElementById("control");
   a.style.display ='none';
   window.print();
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
</script>
</html>                
	
				





<?  /*

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
		$sql = "SELECT MAX(realchasu) as 'geochasu' FROM labelshinsegye WHERE chasu='$inputchasu' AND idate='$inputdate' and geocode='$geocode';";
		$result = mysqli_query($connect,$sql);
		$count = mysqli_num_rows($result);
        //echo $sql;
		if ($count > 0) {
		$sql ="SET @maxID :='$smx'; ";
		mysqli_query($connect,$sql);
		while($row = mysqli_fetch_assoc($result)) {

	          $inputrchasu1 = $row['geochasu']-1;
			  $inputrchasu2 = $row['geochasu'];
			  $inputgeocode = $geocode;
			 
			 

			  $sql ="insert into labelmain (id,idate,blk,worktime,chasu,geocode,geoname,type, center,itemcode, itemname, customer, surang1,surang2,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special) 
			  select @maxID:=@maxID+1,
              T.idate,T.blk,T.worktime,T.chasu,T.geocode,T.geoname,(CASE when T.chaivalue >0 AND T.surang1=0  then '신규' 
              when T.chaivalue >0 AND T.surang1!=0 then '증가'			
              when T.chaivalue <0 AND T.surang2=0  then '취소'
	          when T.chaivalue <0 AND T.surang2!=0 then '감소'	           
		      when T.chaivalue =0 AND !(T.surang1=0 AND T.surang2=0) AND (T.bar1 != T.bar2) then '바코드변경'	              
		      when T.chaivalue =0 AND !(T.surang1=0 AND T.surang2=0) AND (T.cha1 != T.cha2) then '차량번호변경' END) AS 'kind',T.center,T.ITEM_NO,T.DESCRIPTION_LOC,T.DEMAND_NAME,T.surang1,T.surang2,T.chaivalue,  T.UNIT_TEXT ,T.bar1,T.bar2,T.DIR_YN, T.RD_DATE,T.KEEP_TEMP_GUBUN_TEXT,T.cha2,T.CONF_FLAG_TEXT
			  FROM (SELECT b.idate,b.blk,b.worktime,b.chasu,b.geocode,b.geoname,CONCAT(b.PLANT_CODE,'/',b.PLANT_NAME) as 'center', b.ITEM_NO,b.DESCRIPTION_LOC,b.PKG_VOLUME,b.DEMAND_NAME,if(surang1 is NULL , 0, surang1) as 'surang1',if(surang2 is NULL , 0, surang2) as 'surang2',if(surang2 is NULL , 0, surang2)-if(surang1 is NULL , 0, surang1) AS 'chaivalue',  b.UNIT_TEXT ,a.bar1, b.bar2,b.DIR_YN,b.RD_DATE,b.KEEP_TEMP_GUBUN_TEXT,a.DELY_LINE_NO as 'cha1',b.DELY_LINE_NO AS 'cha2',b.CONF_FLAG_TEXT FROM 
			 (SELECT a.ITEM_NO,DESCRIPTION_LOC,PKG_VOLUME,DEMAND_NAME,sum(if(QC_YN='Y',0,GUBUN_PR_QTY)) AS 'surang1',UNIT_TEXT ,if(QC_YN='Y',0,BARCODE_DC) AS 'bar1' ,DELY_LINE_NO FROM labelshinsegye a WHERE realchasu ='$inputrchasu1' AND idate='$inputdate' and geocode ='$inputgeocode' GROUP BY DEMAND_NAME)a
			 right JOIN (
			  SELECT idate,blk,worktime,chasu,geocode,geoname,PLANT_CODE,PLANT_NAME,ITEM_NO,DESCRIPTION_LOC,PKG_VOLUME,DEMAND_NAME,sum(if(QC_YN='Y',0,GUBUN_PR_QTY)) AS 'surang2',UNIT_TEXT ,if(QC_YN='Y',0,BARCODE_DC) AS 'bar2', DIR_YN, RD_DATE, KEEP_TEMP_GUBUN_TEXT, DELY_LINE_NO,CONF_FLAG_TEXT FROM labelshinsegye b WHERE realchasu ='$inputrchasu2' AND idate='$inputdate' and geocode ='$inputgeocode' GROUP BY DEMAND_NAME)b 
					   ON a.ITEM_NO = b.ITEM_NO AND a.DEMAND_NAME= b.DEMAND_NAME)T";

           //echo $sql;
            mysqli_query($connect,$sql);
		  }
		}
		else echo "메인 재고장으로 저장에러입니다.";


		*/

		?>