 <? 
    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
 

                     
	//$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	//$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';
    $start = $_POST['start'];
	$list = $_POST['list'];
    $company = $_POST['company'];
	$search = $_POST['search'];



    
	$sql= "SELECT T.printgubun,T.georae,T.stype AS 'type',T.grouping AS 'centername',T.printinfo, T.mapcode,T.itemcode,T.item,T.customer,T.susu,T.af4,T.chai,T.unit AS 'danwi', CONCAT (if (T.ipsu IS NOT NULL,(T.susu DIV T.ipsu),if(T.unit='BOX',T.susu,0)),' / ',if(T.ipsu IS NOT NULL,(T.susu MOD T.ipsu),if(T.unit='BOX',0,T.susu))) AS 'PT',T.mcondition,T.deliver AS 'cha2',T.labelcount,T.lek,T.prechasu,T.ipsu
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

	$stmt = $con->prepare($sql);


	$stmt->execute();

		if ($stmt->rowCount() > 0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
		extract($row);
   
	?>  
		<tr>
		<input type='hidden' value='<?=$id?>'>
		<td><?php echo $usingY; ?></td>
		<td><?php echo $georae; ?></td>
		<td NOWRAP><?php echo $itemcode;  ?></td>
		<td NOWRAP><?php echo $mappingcode;  ?></td>
		<td><?php echo $itemname;  ?></td>
		<td><?php echo $lek;  ?></td>
		<td><?php echo $ipsu;  ?></td>
		<td><?php echo $packsu;  ?></td>
		<td><?php echo $printoption;  ?></td>
		<td><?php echo $itemblack;  ?></td>
		<td><?php echo $printgubun;  ?></td>
		

		</tr>
	
	<?php
		
			}
		 }
	?>  
	

								
						 









