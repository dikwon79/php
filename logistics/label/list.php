<?php 
//DB연결
include('dbcon.php');

//클라이언트로 부터 넘어온 변수값
$s0=iconv("EUC-KR", "utf-8", trim($_POST[s0]));//구분코드(필수)
$s1=trim($_POST[s1]);  //품목정보 품목명
$s2=trim($_POST[s2]);
$s3=trim($_POST[s3]);//구분코드(필수)
$s4=trim($_POST[s4]);//구분코드(필수)
$s5=trim($_POST[s5]);//box
$s6=trim($_POST[s6]);//물류센터 업체 
$s7=trim($_POST[s7]);//물류센터 업체 


if (!$s0=="") {
      
     if($s7=='1'){
        /*  $sql="SELECT  if(b.printgubun is null,'*미등록*',if(b.printgubun='','*미등록*',b.printgubun)) as printgubun,Z.chasu,Z.printinfo,Z.center,Z.itemcode,
    if(b.itemname is null, Z.itemname,b.itemname) as 'item',Z.customer,Z.deaddate,Z.special,Z.be4,Z.unit,Z.labelcount,
        Z.barcode,Z.deliver,Z.mcondition,Z.mcode,if(b.packsu is null,'1',if(b.packsu='','1',b.packsu)) as packsu,Z.groupnum,b.productiondate,b.expire,Z.tot,if(Z.unit='BOX',1,if(if(b.packsu='',1,if(b.packsu='0',1,b.packsu))-Z.be4=0,1,0))AS 'bo',b.lek,
		if(b.georae is null,'*미등록*',if(b.georae='','*미등록*',b.georae)) as 'labelgeorae',if(b.printoption='Y','Y','N') as 'printoption',if(b.itemblack='Y','Y','N') as 'itemblack'
	FROM (SELECT chasu,stype, a.printinfo,Y.center,Y.itemcode,Y.itemname,
		Y.customer,Y.deaddate,Y.special, Y.cancelY,Y.be4,Y.unit,Y.barcode,Y.mcondition,Y.deliver,Y.labelcount,Y.mcode,Y.groupnum,Y.tot
    FROM (
      SELECT k.stype,k.chasu,k.center,k.itemcode,k.itemname,k.customer,k.deaddate,k.special,k.cancelY, k.be4,l.tot,k.unit,k.barcode ,k.mcondition,k.deliver,k.labelcount,k.mcode,k.groupnum FROM(
	SELECT '신규' AS 'stype',chasu,center, itemcode,itemname,customer,deaddate,special,cancelY,af4 AS 'be4',unit,barcode ,mcondition,deliver,labelcount,mcode,groupnum 
	FROM (SELECT SUM(t) AS 'joincheck',chasu,center, itemcode,itemname,customer,deaddate,MAX(if(val0='b1',special,'')) AS special,cancelY,sum(if(val0='b1',su,0)) AS 'be4' ,sum(if(val0='b2',su,0)) AS 'af4' ,unit,barcode ,mcondition,deliver,labelcount,mcode,groupnum 
	FROM(
		SELECT '0' AS 't', 'b1' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver,SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum from labelcjimsi WHERE (companyname,idate, chasu,cancelY,barcode) in (select companyname,idate, MAX(chasu) as chasu ,cancelY,barcode from labelcjimsi where chasu < $s4 and companyname='cj' AND idate='$s1' and worker='$s0' group by barcode)
		UNION ALL
		SELECT '1' AS 't','b2' as val0, chasu, center, itemcode,itemname, customer ,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver,SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum FROM labelcjimsi WHERE chasu='$s4' AND idate= '$s1' AND companyname='cj' and worker='$s0'
		)t1 GROUP BY barcode)t2 WHERE joincheck = '1' AND af4-be4 !=0 AND af4!=0)k 
		LEFT JOIN (
		SELECT sum(if(cancelY='N',surang,0)) AS 'tot',barcode FROM labelcjimsi WHERE chasu='$s4' AND idate= '$s1' AND companyname='cj' and worker='$s0' GROUP BY substr(barcode,1,18)
		)l ON substr(k.barcode,1,18) = substr(l.barcode,1,18)	

		)Y LEFT JOIN print_info a ON Y.center = concat(a.center,' / ',a.centername))Z LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode order by printgubun asc,Z.printinfo asc, Z.itemcode asc,Z.customer asc, Z.labelcount desc";																																					
         replace(Z.special,' ','')
	  */
	   $sql="SELECT if(b.printgubun IS NULL,'*미등록*',if(b.printgubun='','*미등록*',b.printgubun)) AS printgubun,Z.chasu,Z.printinfo,Z.center,Z.itemcode,
 if(b.itemname IS NULL, Z.itemname,b.itemname) AS 'item',Z.customer,Z.deaddate,replace(Z.special,'/r|n/','') as 'special',Z.be4,Z.af4,Z.unit,Z.labelcount,
 Z.barcode,Z.deliver,Z.mcondition,Z.mcode,if(b.packsu IS NULL,'1',if(b.packsu='','1',b.packsu)) AS packsu,Z.groupnum,b.productiondate,b.expire,Z.tot,if(Z.unit='BOX',1,if(if(b.packsu='',1,if(b.packsu='0',1,b.packsu))-Z.af4=0,1,0)) AS 'bo',b.lek,
		if(b.georae IS NULL,'*미등록*',if(b.georae='','*미등록*',b.georae)) AS 'labelgeorae',if(b.printoption='Y','Y','N') AS 'printoption',if(b.itemblack='Y','Y','N') AS 'itemblack'
FROM (
SELECT chasu,stype, a.printinfo,Y.center,Y.itemcode,Y.itemname,
		Y.customer,Y.deaddate,Y.special, Y.cancelY,Y.be4,Y.af4,Y.unit,Y.barcode,Y.mcondition,Y.deliver,Y.labelcount,Y.mcode,Y.groupnum,Y.tot
FROM (
SELECT k.stype,k.chasu,k.center,k.itemcode,k.itemname,k.customer,k.deaddate,k.special,k.cancelY, k.be4,k.af4,l.tot,k.unit,k.barcode,k.mcondition,k.deliver,k.labelcount,k.mcode,k.groupnum
FROM(
SELECT '신규' AS 'stype',chasu,center, itemcode,itemname,customer,deaddate,special,cancelY,be4,af4,unit,barcode,mcondition,deliver,SUBSTR(barcode,24,5) AS 'labelcount',mcode,groupnum
FROM (
SELECT SUM(t) AS 'joincheck',chasu,center, itemcode,itemname,customer,deaddate, MAX(if(val0='b2',special,'')) AS special,cancelY, SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4',unit,MAX(if(val0='b2',barcode,0)) as barcode,mcondition,deliver,labelcount,mcode,groupnum
FROM(
SELECT '0' AS 't', 'b1' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver, SUBSTR(barcode,19,5) AS 'labelcount',mcode,cancelY,groupnum 
FROM labelcjimsi
WHERE (companyname,idate, chasu,cancelY,concat(SUBSTR(barcode,1,18),SUBSTR(barcode,24,5))) in (SELECT companyname,idate, max(chasu) AS chasu,cancelY,concat(SUBSTR(barcode,1,18),SUBSTR(barcode,24,5))
FROM labelcjimsi WHERE chasu < $s4 AND companyname='cj' AND idate='$s1' AND worker='$s0'
GROUP BY concat(SUBSTR(barcode,1,18),SUBSTR(barcode,24,5)))  
UNION ALL
SELECT '1' AS 't','b2' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE chasu='$s4' AND idate= '$s1' AND companyname='cj' AND worker='$s0' AND cancelY='N'
		)t1
GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5)))t2
WHERE joincheck >= '1' AND be4 != af4 AND af4 !=0)k
LEFT JOIN (
SELECT SUM(if(cancelY='N',surang,0)) AS 'tot',barcode
FROM labelcjimsi
WHERE chasu='$s4' AND idate= '$s1' AND companyname='cj' AND worker='$s0'
GROUP BY SUBSTR(barcode,1,18))l ON SUBSTR(k.barcode,1,18) = SUBSTR(l.barcode,1,18))Y
LEFT JOIN print_info a ON Y.center = CONCAT(a.center,' / ',a.centername))Z
LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode
ORDER BY printgubun ASC,Z.printinfo ASC, Z.itemcode ASC,Z.customer ASC, Z.labelcount DESC";

    /*   $sql="SELECT if(b.printgubun IS NULL,'*미등록*',if(b.printgubun='','*미등록*',b.printgubun)) AS printgubun,Z.chasu,Z.printinfo,Z.center,Z.itemcode,
 if(b.itemname IS NULL, Z.itemname,b.itemname) AS 'item',Z.customer,Z.deaddate,Z.special,Z.be4,Z.af4,Z.unit,Z.labelcount,
 Z.barcode,Z.deliver,Z.mcondition,Z.mcode,if(b.packsu IS NULL,'1',if(b.packsu='','1',b.packsu)) AS packsu,Z.groupnum,b.productiondate,b.expire,Z.tot,if(Z.unit='BOX',1,if(if(b.packsu='',1,if(b.packsu='0',1,b.packsu))-Z.af4=0,1,0)) AS 'bo',b.lek,
		if(b.georae IS NULL,'*미등록*',if(b.georae='','*미등록*',b.georae)) AS 'labelgeorae',if(b.printoption='Y','Y','N') AS 'printoption',if(b.itemblack='Y','Y','N') AS 'itemblack'
FROM (
SELECT chasu,stype, a.printinfo,Y.center,Y.itemcode,Y.itemname,
		Y.customer,Y.deaddate,Y.special, Y.cancelY,Y.be4,Y.af4,Y.unit,Y.barcode,Y.mcondition,Y.deliver,Y.labelcount,Y.mcode,Y.groupnum,Y.tot
FROM (
SELECT k.stype,k.chasu,k.center,k.itemcode,k.itemname,k.customer,k.deaddate,k.special,k.cancelY, k.be4,k.af4,l.tot,k.unit,k.barcode,k.mcondition,k.deliver,k.labelcount,k.mcode,k.groupnum
FROM(
SELECT '신규' AS 'stype',chasu,center, itemcode,itemname,customer,deaddate,special,cancelY,be4,af4,unit,barcode,mcondition,deliver,labelcount,mcode,groupnum
FROM (
SELECT SUM(t) AS 'joincheck',chasu,center, itemcode,itemname,customer,deaddate, MAX(if(val0='b1',special,'')) AS special,cancelY, SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4',unit,MAX(if(val0='b2',barcode,0)) as barcode,mcondition,deliver,labelcount,mcode,groupnum
FROM(
SELECT '0' AS 't', 'b1' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE (companyname,idate, chasu,cancelY,barcode) in (
SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode
FROM labelcjimsi
WHERE chasu < $s4 AND companyname='cj' AND idate='$s1' AND worker='$s0'
GROUP BY barcode) UNION ALL
SELECT '1' AS 't','b2' AS val0, chasu, center, itemcode,itemname, customer,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
FROM labelcjimsi
WHERE chasu='$s4' AND idate= '$s1' AND companyname='cj' AND worker='$s0'
		)t1
GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5)))t2
WHERE joincheck = '1' AND be4 != af4 AND af4 !=0)k
LEFT JOIN (
SELECT SUM(if(cancelY='N',surang,0)) AS 'tot',barcode
FROM labelcjimsi
WHERE chasu='$s4' AND idate= '$s1' AND companyname='cj' AND worker='$s0'
GROUP BY SUBSTR(barcode,1,18))l ON SUBSTR(k.barcode,1,18) = SUBSTR(l.barcode,1,18))Y
LEFT JOIN print_info a ON Y.center = CONCAT(a.center,' / ',a.centername))Z
LEFT JOIN iteminfo b ON Z.itemcode = b.itemcode
ORDER BY printgubun ASC,Z.printinfo ASC, Z.itemcode ASC,Z.customer ASC, Z.labelcount DESC";  */

	 }
	 else{

	 $sql ="SELECT  if(a.georae IS not NULL ,if(a.georae='','*미등록*',a.georae),'*미등록*') as 'geoname',T.chasu,T.type,printinfo,centername,T.center,T.itemcode,if(a.itemname IS NULL,CONCAT('신규',T.itemname),a.itemname)AS 'item' ,customer,T.deaddate,T.special,su1,su2,su3,cast(SUBSTR(T.bar2,-5) AS INT ) AS 'labelsu',if(a.packsu is NULL,1,a.packsu) as packunit,CONCAT (if (a.packsu is not NULL,(T.su3 div a.packsu),0),' / ',if (a.packsu is not NULL,(T.su3 mod a.packsu),T.su3)) as 'PT' ,unit,cha2,mcondition,a.georae,T.bar2,T.mcode,T.groupnum,T.PRINT_TIME,T.CONF_FLAG_TEXT,T.PR_REQ_SEQ_NM,T.sorterY,T.QC_YN,T.IN_PLANT_NAME,T.SENSITIVE_STORE,T.TOT_PAGE,T.PKG_VOLUME from iteminfo a 
RIGHT JOIN 
(SELECT geocode,geoname,chasu,type,itemcode,itemname,customer,deaddate,special,printinfo,centername,c.center,c.su1, c.su2,c.su3,c.unit,c.cha2,c.mcondition,c.bar2,c.mcode,c.groupnum,PRINT_TIME,c.CONF_FLAG_TEXT,c.PR_REQ_SEQ_NM,c.sorterY,c.QC_YN,c.IN_PLANT_NAME,c.SENSITIVE_STORE,c.TOT_PAGE,c.PKG_VOLUME FROM (SELECT geoname,chasu,type,itemcode,itemname,customer,deaddate,special,center,surang1 AS 'su1',surang2 AS 'su2',chaivalue AS 'su3',unit,cha2,mcondition,geocode,bar2,mcode,groupnum,PRINT_TIME,CONF_FLAG_TEXT,PR_REQ_SEQ_NM,sorterY,QC_YN,IN_PLANT_NAME,SENSITIVE_STORE,TOT_PAGE,PKG_VOLUME FROM labelmain WHERE TYPE !='신규' and chasu='$s4' AND idate='$s1' and companyname='$s6')c left JOIN print_info d ON c.center = concat(d.center,' / ',d.centername)
UNION ALL
SELECT f.geocode,f.geoname,f.chasu,f.type,f.itemcode,f.itemname,f.customer,f.deaddate,f.special,printinfo,centername,f.center,f.su1,f.su2,f.su3,f.unit,f.cha2,f.mcondition,f.bar2,f.mcode,f.groupnum,f.PRINT_TIME,f.CONF_FLAG_TEXT,f.PR_REQ_SEQ_NM,f.sorterY,f.QC_YN,f.IN_PLANT_NAME,f.SENSITIVE_STORE,f.TOT_PAGE,f.PKG_VOLUME FROM (SELECT geoname,chasu,type,itemcode,itemname,deaddate,customer,special,center,surang1 AS 'su1',surang2 AS 'su2',chaivalue AS 'su3',unit,cha2,mcondition,geocode,bar2,mcode,groupnum,PRINT_TIME,CONF_FLAG_TEXT,PR_REQ_SEQ_NM,sorterY,QC_YN,IN_PLANT_NAME,SENSITIVE_STORE,TOT_PAGE,PKG_VOLUME FROM labelmain WHERE TYPE ='신규' and chasu='$s4' AND idate='$s1' and companyname='$s6')f left JOIN print_info e ON f.center = concat(e.center,' / ',e.centername))T
ON T.itemcode = a.itemcode ORDER BY geoname asc,TYPE ASC ,printinfo ASC,item ASC"; }
	 
     
        $stmt = $con->prepare($sql);
	    $stmt->execute();
 
	    if ($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		    {
		       extract($row);

			   if(trim($itemcode)=='343675') continue;
               
			   if($s7=='1'){

               $special = preg_replace('/\r\n|\r|\t|\n/','',$special); // 테스트 후 점검요망 10/11
               //$special = preg_replace("/\r\n|\r|\n/\"\'\","",$special); // 테스트 후 점검요망 10/11
             
			   $special = preg_replace("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i", "", $special);

               echo (stripslashes($printgubun)." <z> ".stripslashes($chasu)." <z> "."신규"." <z> ".stripslashes($printinfo)." <z> ".stripslashes($center)." <z> ".stripslashes($itemcode)." <z> ".stripslashes($item)." <z> ".stripslashes($customer)." <z> ".stripslashes($deaddate).
			   " <z> ".stripslashes(trim($special))." <z> ".stripslashes($af4)." <z> ".stripslashes($unit)." <z> ".stripslashes($labelcount)." <z> ".stripslashes($deliver)." <z> ".stripslashes($mcondition)." <z> ".stripslashes($barcode)." <z> ".stripslashes($mcode)." <z> ".stripslashes($packsu)." <z> ".stripslashes($groupnum).
			   " <z> ".stripslashes($productiondate)." <z> ".stripslashes($expire)." <z> ".stripslashes($tot)." <z> ".''." <z> ".stripslashes($bo)." <z> ".stripslashes($lek)." <z> ".stripslashes($labelgeorae)." <z> ".stripslashes($printoption)." <z> ".stripslashes($itemblack)." <z> ".stripslashes($be4)." <z> ".$PRINT_TIME." <z> ".$CONF_FLAG_TEXT." <z> ".$PR_REQ_SEQ_NM." <z> ".$sorterY." <z> ".$QC_YN." <z> ".$IN_PLANT_NAME." <z> ".$SENSITIVE_STORE." <z> ".$TOT_PAGE." <z> ".$PKG_VOLUME."	");

			                                                   
			   }else{
			   
			   
			   echo iconv("utf-8", "EUC-KR",$geoname."<z> ".$chasu."<z> ".$type."<z> ".$printinfo."<z> ".$center."<z> ".$itemcode."<z> ".$item."<z> ".$customer."<z> ".$deaddate.
			   "<z> ".$special."<z> ".$su2."<z> ".$unit."<z> ".$labelsu."<z> ".$cha2."<z> ".$mcondition."<z> ".$bar2."<z> ".$mcode."<z> ".$packunit."<z> ".$groupnum."<z> ".$PRINT_TIME."<z> ".$CONF_FLAG_TEXT."<z> ".$PR_REQ_SEQ_NM."<z> ".$sorterY."<z> ".$QC_YN."<z> ".$IN_PLANT_NAME."<z> ".$SENSITIVE_STORE."<z> ".$TOT_PAGE."<z> ".$PKG_VOLUME."	");
			   }
     
	        }

		}else{

			echo 'EOF';

		}

}


?>
