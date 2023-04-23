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
<script src="ianexcel.js"></script>  
<script>
    const size = 1172; // roughly A4

function pageNum(top) {
  return Math.round((top + window.pageYOffset - document.body.clientTop) / size) + 1;
}

function pageCount() {
  return Math.round(document.documentElement.clientHeight / size);
}

document.addEventListener("DOMContentLoaded", () => {
  // Won't help us, because we can't position this properly when we have
  // flow content and don't have the luxury of div's representing exact
  // pages
  

  // But we can still get the total page count though!
  //const tot = pageCount();
  const pagenation = document.querySelectorAll(".page-number");
  var i=0;
  while(i < pagenation.length){
      pagenation[i].textContent = i+1 +'/'+pagenation.length
	  i = i +1;
  }


  //alert(pagenation.length);
  //console.log("top", document.documentElement.clientHeight);
  //console.log("page", document.documentElement.clientHeight/size);


  //footer.textContent = pageCount();
});


</script>

<style>
h1, h2, h3, h4, h5, dl, dt, dd, ul, li, ol, th, td, tr, p, blockquote, form, fieldset, legend, div,body,thead,tbody { -webkit-print-color-adjust:exact; }

body {

margin: 0;
padding: 0;

}

td {
   font-weight : bolder;
  
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

$sql = "select * from labelmain where idate='$inputdate' and chasu='$inputchasu' and companyname='cj' and worker='".$_SESSION['user_id']."' ";
$result = mysqli_query($connect,$sql);
$count = mysqli_num_rows($result);


if ($count > 0) 
{           

	        
}
else
{
	$sql ="SET @maxID :='$smx'; ";
	mysqli_query($connect,$sql);
	
	/*
	$sql ="insert into labelmain (id,worker,idate,blk,worktime, companyname, chasu, type, center,geocode, geoname, itemcode, itemname, customer, surang1,surang2,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special,cancelY,groupnum) 
	SELECT @maxID:=@maxID+1,worker,idate,blk,worktime,companyname,chasu,
	(CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
	when chaivalue <0 and surang2=0  then '*취소'
	when chaivalue <0 and surang2!=0 then '*감소'	           
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
	center,geocode,geoname,itemcode,itemname,customer,surang1,surang2,chaivalue,unit2,barcode1,barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum 
	FROM (select worker,idate,blk,worktime,companyname,chasu,center,geocode,geoname,itemcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
	sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
	,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum FROM (SELECT  u.worker,u.idate,u.blk,u.worktime,u.companyname, u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
	u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-x.surang as 'chai',
	x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum 
	FROM (
	SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum from(select * from labelmain where idate='$inputdate' and (substr(bar2,1,18), chasu) in (select substr(bar2,1,18), max(chasu) as chasu from labelmain where chasu < '$inputchasu' and companyname='cj' and worker='".$_SESSION['user_id']."' group by substr(bar2,1,18))
	order by chasu desc) t group by t.bar2)x ".$processtype." (SELECT b.worker,b.idate,b.blk,b.worktime,b.companyname, b.chasu, b.center,b.geocode,b.geoname, b.itemcode, b.itemname , b.customer ,
	b.cancelY,b.unit, sum(b.surang) as 'surang', max(b.barcode) as 'barcode' ,b.mcode, b.deaddate ,b.mcondition, b.deliver, b.special,b.groupnum FROM labelcjimsi b 
	WHERE chasu ='$inputrchasu2' AND idate='$inputdate' and companyname='cj' and worker='".$_SESSION['user_id']."' GROUP BY substr(b.barcode,1,18),center,itemcode,customer)u 
	ON substr(x.barcode,1,18) = substr(u.barcode,1,18))T GROUP BY substr(barcode2,1,18),customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";
   
    */
	

	$sql="insert into labelmain (id,worker,idate,blk,worktime, companyname, chasu, type, center,geocode, geoname, itemcode, mappingcode, itemname, customer, surang1,surang2,confirmsu,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special,cancelY,groupnum,TOT_PAGE) 
	SELECT @maxID:=@maxID+1,worker,idate,blk,worktime,companyname,chasu,
	(CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
	when chaivalue <0 and surang2=0  then '*취소'
	when chaivalue <0 and surang2!=0 then '*감소'	           
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
	when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
	center,geocode,geoname,itemcode,if(mappingcode is null,itemcode,if(mappingcode='0',0,mappingcode)),itemname,customer,surang1,surang2,surang2,chaivalue,unit2,barcode1,barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum,totalsu 
	FROM (select worker,idate,blk,worktime,companyname,chasu,center,geocode,geoname,itemcode,mappingcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
	sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
	,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum,sum(if(cancel2='N',labelpage,'0')) as 'totalsu' FROM (SELECT p.worker,p.idate,p.blk,p.worktime,p.companyname, p.chasu, p.center,p.geocode,p.geoname, p.itemcode,if (q.mappingcode IS NULL,p.itemcode,if(q.mappingcode='',p.itemcode,q.mappingcode)) AS 'mappingcode',p.itemname,p.customer, p.cancel1,p.unit1,p.su1,
	p.cancel2, p.unit2 , p.su2 ,p.chai,p.barcode1, p.barcode2, p.mcode,p.deaddate,p.mcondition,p.cha1,p.cha2, p.special,p.groupnum,p.labelpage  from(SELECT  u.worker,u.idate,u.blk,u.worktime,u.companyname, u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
	u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-x.surang as 'chai',
	x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum,u.labelpage
	FROM (
	SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum  from(select * from labelmain where idate='$inputdate' and (substr(bar2,1,18), chasu) in (select substr(bar2,1,18), max(chasu) as chasu from labelmain where chasu < '$inputchasu' and companyname='cj' and worker='".$_SESSION['user_id']."' group by substr(bar2,1,18))
	order by chasu desc) t group by t.bar2)x RIGHT join (SELECT b.worker,b.idate,b.blk,b.worktime,b.companyname, b.chasu, b.center,b.geocode,b.geoname, b.itemcode, b.itemname , b.customer ,
	b.cancelY,b.unit, sum(b.surang) as 'surang',  MAX(concat(SUBSTR(b.barcode,1,18),SUBSTR(b.barcode,24,5))) AS 'barcode' ,b.mcode, b.deaddate ,b.mcondition, b.deliver, b.special,b.groupnum, sum('1') as 'labelpage' FROM labelcjimsi b 
	WHERE chasu ='$inputrchasu2' AND idate='$inputdate' and companyname='cj' and worker='".$_SESSION['user_id']."' GROUP BY substr(b.barcode,1,18),center,itemcode,customer)u 
	ON substr(x.barcode,1,18) = substr(u.barcode,1,18))p LEFT JOIN iteminfo q ON q.itemcode = p.itemcode)T GROUP BY substr(barcode2,1,18),customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";
	
    //echo $sql;
	
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

        $sql="SELECT T.printgubun,T.georae,T.stype AS 'type',T.grouping AS 'centername',T.printinfo, T.mapcode,T.itemcode,T.item,T.customer,T.susu,T.af4,T.chai,T.unit AS 'danwi', CONCAT (if (T.ipsu IS NOT NULL,(T.susu DIV T.ipsu),if(T.unit='BOX',T.susu,0)),' / ',if(T.ipsu IS NOT NULL,(T.susu MOD T.ipsu),if(T.unit='BOX',0,T.susu))) AS 'PT',T.mcondition,T.deliver AS 'cha2',T.labelcount,T.lek,T.prechasu,T.ipsu
FROM (
SELECT b.printgubun,b.georae,b.ipsu,Z.stype,Z.grouping,Z.printinfo,Z.center, if(b.mappingcode IS NOT NULL,b.mappingcode,Z.itemcode) AS mapcode,Z.itemcode,if(b.itemname IS NULL, CONCAT('신규)',Z.itemname),b.itemname) AS 'item',Z.customer,Z.cancelY,Z.susu,Z.af4,Z.chai,Z.unit,Z.barcode,Z.mcondition,Z.deliver,Z.labelcount,b.lek,Z.prechasu
FROM (
SELECT '*취소' AS 'sType',a.grouping, a.printinfo, S.center, S.itemcode, S.itemname, S.customer, S.cancelY,S.be4 AS susu,S.af4,S.chaivalue AS chai,S.unit,S.bar1 AS barcode,S.mcondition,S.cha2 AS deliver, SUBSTR(bar1,24,5) AS labelcount,
(SELECT MIN(chasu) FROM labelcjimsi WHERE idate='$processdate' AND concat(substr(barcode,1,18),substr(barcode,24,5)) =concat(substr(S.bar1,1,18),substr(S.bar1,24,5)) GROUP BY concat(substr(S.bar1,1,18),substr(S.bar1,24,5))) AS 'prechasu'
FROM(
SELECT * from(SELECT d3.joincheck,d3.chasu,d3.center, d3.itemcode,d3.itemname,d3.customer,d3.deaddate, d3.special,d3.cancelY,d3.gubun1,
 A3.gubun2, d3.be4, d3.af4, d3.chaivalue,d3.unit,d3.bar1,d3.mcondition,d3.cha2,d3.labelcount,d3.mcode,d3.groupnum
 FROM (SELECT SUM(t) AS 'joincheck',chasu,center, itemcode,itemname,customer,deaddate, MAX(if(val0='b1',special,'')) AS special,cancelY, MAX(if(val0='b1',1,0)) AS 'gubun1',
 MAX(if(val0='b2',1,0)) AS 'gubun2', SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4', SUM(if(val0='b2',su,0))- SUM(if(val0='b1',su,0)) AS 'chaivalue',unit,barcode AS 'bar1',mcondition,deliver AS 'cha2',labelcount,mcode,groupnum
FROM(
SELECT '0' AS 't', 'b1' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE (companyname,idate, chasu,cancelY,barcode) in (
SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode
FROM labelcjimsi
WHERE chasu < $chasu AND companyname='cj' AND idate='$processdate' AND worker='".$_SESSION['user_id']."'
GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5))) UNION ALL
SELECT '1' AS 't','b2' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE chasu='$chasu' AND idate= '$processdate' AND companyname='cj' AND worker='".$_SESSION['user_id']."')t1
GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5)))d3 
LEFT JOIN (SELECT gubun2,substr(bar1,1,18) AS 'newbar' FROM (SELECT SUM(t) AS 'joincheck',chasu,center, itemcode,itemname,customer,deaddate, MAX(if(val0='b1',special,'')) AS special,cancelY, MAX(if(val0='b1',1,0)) AS 'gubun1',
 MAX(if(val0='b2',1,0)) AS 'gubun2', SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4', SUM(if(val0='b2',su,0))- SUM(if(val0='b1',su,0)) AS 'chaivalue',unit,barcode AS 'bar1',mcondition,deliver AS 'cha2',labelcount,mcode,groupnum
FROM(
SELECT '0' AS 't', 'b1' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE (companyname,idate, chasu,cancelY,barcode) in (
SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode
FROM labelcjimsi
WHERE chasu < $chasu AND companyname='cj' AND idate='$processdate' AND worker='".$_SESSION['user_id']."'
GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5))) UNION ALL
SELECT '1' AS 't','b2' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE chasu='$chasu' AND idate= '$processdate' AND companyname='cj' AND worker='".$_SESSION['user_id']."')t1
GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5)))L WHERE L.gubun2='1' GROUP BY SUBSTR(bar1,1,18))A3 ON A3.newbar = SUBSTR(d3.bar1,1,18))B WHERE (B.gubun1 ='1' and B.gubun2 ='1')  AND B.chaivalue !=0)S
LEFT JOIN print_info a ON S.center = CONCAT(a.center,' / ',a.centername))Z
LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode UNION ALL
SELECT b.printgubun,b.georae,b.ipsu,Z.stype,Z.grouping,Z.printinfo,Z.center, if(b.mappingcode IS NOT NULL,b.mappingcode,Z.itemcode) AS mapcode,Z.itemcode,if(b.itemname IS NULL, CONCAT('신규)',Z.itemname),b.itemname) AS 'item',Z.customer,Z.cancelY, SUM(CASE WHEN TRIM(Z.unit) = 'BOX' THEN if(b.packsu,Z.af4*b.packsu,Z.af4)  WHEN TRIM(Z.unit)='EA' THEN Z.af4 ELSE Z.af4 END) AS susu,'','',Z.unit,Z.barcode,Z.mcondition,Z.deliver,Z.labelcount,b.lek,''
FROM (
SELECT Y.stype,a.grouping,a.printinfo,Y.center, Y.itemcode,Y.itemname,Y.customer,Y.cancelY,Y.af4,Y.unit,Y.barcode,Y.mcondition,Y.deliver,Y.labelcount
FROM (
SELECT '신규' AS 'stype',center, itemcode,itemname,customer,cancelY,af4,unit,barcode,mcondition,deliver,labelcount
FROM (
SELECT SUM(t) AS 'joincheck',center, itemcode,itemname,customer,cancelY, SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4',unit,barcode,mcondition,deliver,labelcount
FROM(
SELECT '0' AS 't', 'b1' AS val0, center, itemcode,itemname, customer,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',cancelY
FROM labelcjimsi
WHERE (companyname,idate, chasu,cancelY,barcode) in (
SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode
FROM labelcjimsi
WHERE chasu < $chasu AND companyname='cj' AND idate='$processdate' AND worker='".$_SESSION['user_id']."'
GROUP BY barcode) UNION ALL
SELECT '1' AS 't','b2' AS val0, center, itemcode,itemname, customer,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',cancelY
FROM labelcjimsi
WHERE chasu='$chasu' AND idate= '$processdate' AND companyname='cj' AND worker='".$_SESSION['user_id']."')t1
GROUP BY barcode)t2
WHERE joincheck = '1' AND af4-be4 !=0 AND af4!=0) Y
LEFT JOIN print_info a ON Y.center = CONCAT(a.center,' / ',a.centername))Z
LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode
GROUP BY mapcode,Z.printinfo)T
ORDER BY stype ASC, centername ASC, printgubun ASC, printinfo ASC, T.lek ASC, T.item ASC, T.susu ASC, T.customer ASC, T.labelcount ASC";

		
}
else{

 // 맵핑 코드로 다시 개발.........................................................................................................................
  $sql="select printgubun, type,if(mappingcode IS NULL,itemcode,mappingcode) AS 'mapcode',itemcode,item,customer,centername,su1,su2 ,sum(total) as 'Ttotal' ,
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
 
 
 }
 
  //echo $sql;
  
  $stmt = $con->prepare($sql);

  $stmt->execute();

  ?>

  <body>
  <div id='control' class="control">
    <button id="close" type="button" class="btn btn-default">Close</button>
    <button id="btnPrint" type="button" class="btn btn-default">Print</button>
	<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '촐량지')">엑셀저장</button>
  </div>

  

	
	<?
			
			 if ($stmt->rowCount() > 0)
			 {
				  $count =0;
				  $totcount = 0;
				  $heightvalue=0;// 높이에 따라 페이지 분리
				  $heightvalue2=0;// 높이에 따라 페이지 분리
				  $check ='종류';
				  $center = '센터';
				  $printgubuncheck = '구분';
				  $totalsurang=0;
				  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				  {
					  extract($row);
					
                       
					   if ($type=='신규')
					  {  
						   //	   if (($check !=trim($type)) or (($center !=trim($centername)) and ($printgubun!==null)))  2020-10-22일 수정함
						   if (($check !=trim($type)) or ($center !=trim($centername)) or ($printgubuncheck !=trim($printgubun))) {
							   
							   if ($check=='신규'){ ?>
                         
							  <? } ?>
							  </tbody></table></div>
		                      </div> 
							   <?
                               $totcount++;
							   $count =0;
							   $heightvalue=0;
							   $totalsurang=0;
							  
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
						   <div><h1><? if ($printgubun===null){ echo '품목미등록'.'-'.$chasu.'차작업';} 
						               else { echo $printgubun.'-'.$chasu.'차작업';} ?><div style="font-size:30px;float:right;" class="page-number"></h1></div>
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

						<td width='43%' height='10' style='table-layout:fixed'><?=$item?></td>
						<td width='9%'style="font-size:20px;"><?=$PT?></td>
						<?
                           if ($chongtype=='1'){
						?>
						<td width='9%'><? echo $susu;
						                  $totalsurang+=$susu; ?></td>
						<?
						 }else {
						?>
						<td width='9%'><?=$Ttotal?></td>
						<? } ?>
						<td width='9%'><?  if ($printgubun===null){ echo $danwi;
							
						}else if($ipsu=='1'){ echo 'BOX';}
						else{
						 echo 'EA';
						}
						
						?></td>
                        
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
							   $totcount++;
							  
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
						   <div><h1><? if ($printgubun===null){ echo '품목미등록';} 
						               else { echo $check;} ?><div style="font-size:30px;float:right;" class="page-number"></h1></div>
						   <table id='table' class="table table-striped table-bordered table-hover">
					       <thead>
							<tr>
								<th width=5%>코드</th>
								<th>품목명</th>
								<th>납품처명</th>
								<th NOWRAP>센터</th>
								
								
								<th style='background-color:black; color:white'>전</th>
								<th>후</th>
								<th>차</th>
                               
								<th>단위</th>
								<th>차량</th>
								<th>보관</th>
								<th NOWRAP>업체</th>
								
								<th colspan=2>순번</th>
								


							</tr>
						   </thead>
						   <tbody>
				          <?
						   }
						  ?>
                          <tr>
			
						  <td><?=$itemcode?></td>
						  <td><?=$item?></td>
						  <td><?=$customer?></td>
						  <td NOWRAP><?=$printinfo?></td>
						 
						  <td style='background-color:black; color:white' NOWRAP><?=$susu?></td>
						
						  <td NOWRAP><?=$af4?></td>
						  <td NOWRAP><?=$chai?></td>
						 

						 
						 
						  
						  <td NOWRAP><?=$danwi?></td>
						  <td NOWRAP><?=$cha2;?></td>	
						  <td NOWRAP><?=$mcondition?></td>
						  <td><?=$georae?></td>
						  
						  <td colspan=2><? echo substr($labelcount,2,4)."<br>\n<b>".$prechasu.'차'?></td>
							
                          	


						  </tr>
                      <?
					  }
                     $count++;

                    if ($heightvalue>800 or $heightvalue2>800){   
						
						
						$count=0;
						$heightvalue=0;
						$heightvalue2=0;
						$totcount++;
						?>
						</tbody></table></div>
		                      </div>
					  <?
					
				     } 
					 
				  }

			 
		?>
		<? }else { echo '임시: 변경분이 없습니다.';   }?>
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
document.getElementById("close").onclick = function () {
    //printElement(document.getElementById("printThis"));
   
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
			