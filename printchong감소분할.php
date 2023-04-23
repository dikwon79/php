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
$onlychange = $_GET['onlychange'];  // 변경분만 인쇄하게 하기 위하여....
   
if ($onlychange=='true'){

      $processtype = "left join";
}
else {

      $processtype = "right join";
}

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

$sql = "select * from labelmain where idate='$inputdate' and chasu='$inputchasu' and companyname='cj' ";
$result = mysqli_query($connect,$sql);
$count = mysqli_num_rows($result);


if ($count > 0) 
{           

	        
}
else
{
	$sql ="SET @maxID :='$smx'; ";
	mysqli_query($connect,$sql);
	
	
	$sql ="insert into labelmain (id,idate,blk,worktime, companyname, chasu, type, center,geocode, geoname, itemcode, itemname, customer, surang1,surang2,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special,cancelY,groupnum) 
	SELECT @maxID:=@maxID+1,idate,blk,worktime,companyname,chasu,
	(CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
	when chaivalue <0 and surang2=0  then '*취소'
	when chaivalue <0 and surang2!=0 then '*감소'	           
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
	center,geocode,geoname,itemcode,itemname,customer,surang1,surang2,chaivalue,unit2,barcode1,barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum 
	FROM (select idate,blk,worktime,companyname,chasu,center,geocode,geoname,itemcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
	sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
	,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum FROM (SELECT  u.idate,u.blk,u.worktime,u.companyname, u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
	u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-x.surang as 'chai',
	x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum 
	FROM (
	SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum from(select * from labelmain where idate='$inputdate' and (substr(bar2,1,18), chasu) in (select substr(bar2,1,18), max(chasu) as chasu from labelmain where chasu < '$inputchasu' and companyname='cj' group by substr(bar2,1,18))
	order by chasu desc) t group by t.bar2)x ".$processtype." (SELECT b.idate,b.blk,b.worktime,b.companyname, b.chasu, b.center,b.geocode,b.geoname, b.itemcode, b.itemname , b.customer ,
	b.cancelY,b.unit, sum(b.surang) as 'surang', max(b.barcode) as 'barcode' ,b.mcode, b.deaddate ,b.mcondition, b.deliver, b.special,b.groupnum FROM labelcjimsi b 
	WHERE chasu ='$inputrchasu2' AND idate='$inputdate' and companyname='cj' GROUP BY substr(b.barcode,1,18),center,itemcode,customer)u 
	ON substr(x.barcode,1,18) = substr(u.barcode,1,18))T GROUP BY substr(barcode2,1,18),customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";
   

	mysqli_query($connect,$sql);
//비교분 점검해볼것............................		  
	//SELECT * from labelmain 
//WHERE (companyname,idate,substr(bar2,1,18), chasu) in (select companyname,idate,substr(bar2,1,18), max(chasu) as chasu 
//from labelmain  where companyname='cj' AND idate='2020-09-23' group by substr(bar2,1,18)) 

}



	  
 



  /*  기존 // itemcode

  $sql="select georae, type,itemcode,item,customer,centername,su1,su2,sum(total) as 'Ttotal' ,CONCAT (if (ipsu is not NULL,(sum(total) div ipsu),0),' / ',if (ipsu is not NULL,(sum(total) mod ipsu),sum(total))) as 'PT' ,danwi,cha2,mcondition,georae,lek  FROM (SELECT T.geoname,T.type,T.itemcode,if(a.itemname IS NULL,CONCAT('신규)',T.itemname),a.itemname)AS 'item',T.danwi ,customer,centername,su1,su2,su3,CASE when trim(T.danwi) = 'BOX' then su3*a.ipsu when TRIM(T.danwi)='EA' then SUM(T.su3) else SUM(T.su3) END AS total,cha2,mcondition,a.georae,a.lek,a.ipsu from iteminfo a RIGHT JOIN ( SELECT geoname,type,itemcode,itemname,customer,printinfo AS 'centername',c.su1, c.su2,c.su3,c.unit as 'danwi',c.cha2,c.mcondition,c.geocode FROM (SELECT geoname,chasu,type,itemcode,itemname,customer,deaddate,special,center,surang1 AS 'su1',surang2 AS 'su2',chaivalue AS 'su3',unit,cha2,mcondition,geocode,bar2,mcode FROM labelmain WHERE TYPE !='신규' and chasu='$chasu' AND idate='$processdate')c left JOIN print_info d ON c.center = concat(d.center,' / ',d.centername) UNION ALL SELECT K.geoname,K.type,K.itemcode,K.itemname,K.customer,centername,sum(K.su1),sum(K.su2),sum(K.su3) as 'danwi',K.unit,K.cha2,K.mcondition,K.geocode FROM (SELECT f.geoname,f.type,f.itemcode,f.itemname,f.customer,printinfo AS 'centername',f.su1,f.su2,f.su3,f.unit,f.cha2,f.mcondition,f.geocode FROM (SELECT geoname,type,itemcode,itemname,customer,center,surang1 AS 'su1',surang2 AS 'su2',sum(chaivalue) AS 'su3',unit,cha2,mcondition,geocode FROM labelmain WHERE TYPE ='신규' and chasu='$chasu' AND idate='$processdate' GROUP BY center,itemcode, unit)f left JOIN print_info e ON f.center = concat(e.center,' / ',e.centername))K GROUP BY centername,itemcode,unit )T ON T.itemcode = a.itemcode group by type,itemcode, centername,danwi )S GROUP BY type,itemcode, centername ORDER BY TYPE ASC ,georae asc,centername ASC,item asc";
  echo $sql;

  */ 

//총량지 발행방법  1,변화량  2, 총량으로 인쇄 
$sql = "select chongtype from setting where catering = 'cj' ";

$stmt = $con->prepare($sql);
$stmt->execute();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$chongtype = $row['chongtype'];
	

if ($chongtype=='1'){

        $sql="SELECT T.printgubun,T.stype as 'type',T.printinfo,T.center as 'centername', T.mapcode,T.itemcode,T.itemname as 'item',T.customer,T.susu,T.unit as 'danwi',CONCAT (if (T.ipsu is not NULL,(T.susu div T.ipsu),0),' / ',if (T.ipsu is not NULL,(T.susu mod T.ipsu),T.susu)) as 'PT' ,T.mcondition,T.deliver as 'cha2',T.labelcount,T.lek FROM (SELECT b.printgubun,b.ipsu,Z.stype,Z.printinfo,Z.center, if(b.mappingcode IS NOT NULL,b.mappingcode,Z.itemcode) AS mapcode,Z.itemcode,Z.itemname,Z.customer,Z.cancelY,Z.be4 as'susu',Z.unit,Z.barcode ,Z.mcondition,Z.deliver,Z.labelcount,b.lek FROM (SELECT Y.stype,a.printinfo,Y.center, Y.itemcode,Y.itemname,Y.customer,Y.cancelY,Y.be4,Y.unit,Y.barcode ,Y.mcondition,Y.deliver,Y.labelcount  FROM (SELECT '*취소' AS 'stype',center, itemcode,itemname,customer,cancelY,be4,unit,barcode ,mcondition,deliver,labelcount 
FROM (SELECT SUM(t) AS 'joincheck',center, itemcode,itemname,customer,cancelY,sum(if(val0='b1',su,0)) AS 'be4' ,sum(if(val0='b2',su,0)) AS 'af4' ,unit,barcode ,mcondition,deliver,labelcount 
FROM(
   SELECT '0' AS 't', 'b1' AS val0, center, itemcode,itemname, customer,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver,SUBSTR(barcode,19,5) AS 'labelcount',cancelY from labelcjimsi WHERE (companyname,idate, chasu,cancelY,barcode) in (select companyname,idate, MAX(chasu) as chasu ,cancelY,barcode from labelcjimsi where chasu < $chasu and companyname='cj' AND idate='$processdate'  group by barcode)
   UNION ALL
	SELECT '1' AS 't','b2' as val0, center, itemcode,itemname, customer ,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver,SUBSTR(barcode,19,5) AS 'labelcount',cancelY FROM labelcjimsi WHERE chasu='$chasu' AND idate= '$processdate'
)t1 GROUP BY barcode)t2 WHERE joincheck = '1' AND af4-be4 !=0 AND be4!=0)Y LEFT JOIN print_info a ON Y.center = concat(a.center,' / ',a.centername))Z LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode

UNION ALL

SELECT b.printgubun,b.ipsu,Z.stype,Z.printinfo,Z.center, if(b.mappingcode IS NOT NULL,b.mappingcode,Z.itemcode) AS mapcode,Z.itemcode,Z.itemname,Z.customer,Z.cancelY,sum(Z.af4) as 'susu',Z.unit,Z.barcode ,Z.mcondition,Z.deliver,Z.labelcount,b.lek FROM (SELECT Y.stype,a.printinfo,Y.center, Y.itemcode,Y.itemname,Y.customer,Y.cancelY,Y.af4,Y.unit,Y.barcode ,Y.mcondition,Y.deliver,Y.labelcount  
FROM (SELECT '신규' AS 'stype',center, itemcode,itemname,customer,cancelY,af4,unit,barcode ,mcondition,deliver,labelcount FROM (SELECT SUM(t) AS 'joincheck',center, itemcode,itemname,customer,cancelY,sum(if(val0='b1',su,0)) AS 'be4' ,sum(if(val0='b2',su,0)) AS 'af4' ,unit,barcode ,mcondition,deliver,labelcount FROM(
   SELECT '0' AS 't', 'b1' AS val0, center, itemcode,itemname, customer,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver,SUBSTR(barcode,19,5) AS 'labelcount',cancelY from labelcjimsi WHERE (companyname,idate, chasu,cancelY,barcode) in (select companyname,idate, MAX(chasu) as chasu ,cancelY,barcode from labelcjimsi where chasu < $chasu and companyname='cj' AND idate='$processdate'  group by barcode)
   UNION ALL
	SELECT '1' AS 't','b2' as val0, center, itemcode,itemname, customer ,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver,SUBSTR(barcode,19,5) AS 'labelcount',cancelY FROM labelcjimsi WHERE chasu='$chasu' AND idate= '$processdate'
)t1 GROUP BY barcode)t2 WHERE joincheck = '1' AND af4-be4 !=0)Y LEFT JOIN print_info a ON Y.center = concat(a.center,' / ',a.centername))Z LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode GROUP BY mapcode,Z.printinfo)T ORDER BY stype ASC, printgubun ASC , printinfo ASC, lek asc
";


}
else{

 // 맵핑 코드로 다시 개발.........................................................................................................................
  $sql="select printgubun, type,if(mappingcode IS NULL,itemcode,mappingcode) AS 'mapcode',itemcode,item,customer,centername,su1,su2,sum(total) as 'Ttotal' ,
CONCAT (if (ipsu is not NULL,(sum(total) div ipsu),0),' / ',if (ipsu is not NULL,(sum(total) mod ipsu),sum(total))) as 'PT' 
,danwi,cha2,mcondition,printgubun,lek FROM (SELECT T.geoname,T.type,a.mappingcode,T.itemcode,if(a.itemname IS NULL,CONCAT('신규)'
,T.itemname),a.itemname)AS 'item',T.danwi ,customer,centername,su1,su2,su3,
if (type='신규',CASE when trim(T.danwi) = 'BOX' then SUM(T.su3*a.ipsu) when TRIM(T.danwi)='EA' then SUM(T.su3) else SUM(T.su3) END ,T.su3) AS total,
cha2,mcondition,a.printgubun,a.lek,a.ipsu from iteminfo a RIGHT JOIN 
( SELECT geoname,type,itemcode,itemname,customer,printinfo AS 'centername',
c.su1, c.su2,c.su3,c.unit as 'danwi',c.cha2,c.mcondition,c.geocode FROM 
(SELECT geoname,chasu,type,itemcode,itemname,customer,deaddate,special,center,surang1 AS 'su1',surang2 AS 'su2',
chaivalue AS 'su3',unit,cha2,mcondition,geocode,bar2,mcode FROM labelmain WHERE TYPE !='신규' and chasu='$chasu' AND idate='$processdate' and companyname='cj')c
 left JOIN print_info d ON c.center = concat(d.center,' / ',d.centername) 
 UNION ALL SELECT K.geoname,K.type,K.itemcode,K.itemname,K.customer,centername,sum(K.su1),sum(K.su2),sum(K.su3) as 'danwi',
 K.unit,K.cha2,K.mcondition,K.geocode FROM 
 (SELECT f.geoname,f.type,f.itemcode,f.itemname,f.customer,printinfo AS 'centername',f.su1,f.su2,f.su3,f.unit,f.cha2,f.mcondition,f.geocode FROM 
 (SELECT geoname,type,itemcode,itemname,customer,center,surang1 AS 'su1',
 surang2 AS 'su2',sum(chaivalue) AS 'su3',unit,cha2,mcondition,geocode FROM labelmain 
 WHERE TYPE ='신규' and chasu='$chasu' AND idate='$processdate' and companyname='cj' GROUP BY center,itemcode, unit)f left JOIN print_info e 
 ON f.center = concat(e.center,' / ',e.centername))K GROUP BY centername,itemcode,unit )T ON T.itemcode = a.itemcode 
 group by type,itemcode, centername,danwi )S  GROUP BY type,mapcode, centername ORDER BY TYPE ASC ,printgubun asc,centername ASC,item ASC";
 
 echo $sql;
 }
 

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
						   if (($check !=trim($type)) or ($center !=trim($centername)) or ($printgubuncheck !=trim($printgubun))) {
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
						   $center=$centername;
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
						<td width='9%'><?=$Ttotal?></td>
						<td width='9%'><? echo 'EA';?></td>
                        
						<td width='10%'><?=$centername?></td>
						
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
						   <table class="table table-striped table-bordered table-hover">
					       <thead>
							<tr>
								<th NOWRAP>품목코드</th>
								<th>품목명</th>
								<th>납품처명</th>
								<th NOWRAP>센터</th>
								<th>전</th>
								<th>후</th>
								<th>차</th>
								<th>단위</th>
								<th>차량</th>
								<th>보관</th>
								<th NOWRAP>업체</th>


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
						  <td NOWRAP><?=$centername?></td>
						  <td NOWRAP><?=$su1?></td>
						  <td NOWRAP><?=$su2?></td>
						  <td NOWRAP><?=$Ttotal?></td>
						  <td NOWRAP><?=$danwi?></td>
						  <td NOWRAP><?=$cha2;?></td>	
						  <td NOWRAP><?=$mcondition?></td>
						  <td><?=$printgubun?></td>
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
   opener.location.reload();
   self.close();
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
	
				