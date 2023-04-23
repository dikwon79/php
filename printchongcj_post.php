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

    $chasu = $_POST['chasu'];
	$today = $_POST['daten'];

    try
	{
           $sql ="insert into labelcjimsi(worker, idate, blk, worktime, geocode,geoname,buydan,companyname, chasu ,realchasu,differ,center, itemcode, itemname ,customer,deadtype,unit,surang,deliver,
			delivergubun,mcode ,mcondition ,special ,deaddate ,barcode,orderY ,cancelY,emergenY,sorterY ,groupnum ,labelpage)
			SELECT B.worker,B.idate,B.blk,B.worktime,'','','',B.companyname,'$chasu',B.realchasu,B.differ,B.center,B.itemcode,B.itemname,B.customer,B.deadtype,B.unit,B.be4,B.cha2,B.delivergubun,B.mcode,B.mcondition,B.special,B.deaddate,B.bar1,'N','Y','N','N',B.groupnum,B.labelcount
			FROM(
			SELECT d3.joincheck,d3.worker,d3.idate,d3.blk,d3.worktime,d3.companyname,d3.chasu,d3.differ,d3.realchasu,d3.center, d3.itemcode,d3.itemname,d3.customer,d3.deadtype,d3.deaddate, d3.special,d3.cancelY,d3.gubun1, A3.gubun2, d3.be4, d3.af4, d3.chaivalue,d3.unit,d3.bar1,d3.mcondition,d3.cha2,d3.delivergubun,d3.labelcount,d3.mcode,d3.groupnum
			FROM (
			SELECT SUM(t) AS 'joincheck',worker,idate,blk,worktime,companyname,chasu,differ,realchasu,center, itemcode,itemname,customer,deadtype,deaddate, MAX(if(val0='b1',special,'')) AS special,cancelY, MAX(if(val0='b1',1,0)) AS 'gubun1', MAX(if(val0='b2',1,0)) AS 'gubun2', SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4', SUM(if(val0='b2',su,0))- SUM(if(val0='b1',su,0)) AS 'chaivalue',unit,barcode AS 'bar1',mcondition,deliver AS 'cha2',delivergubun,labelcount,mcode,groupnum
			FROM(
			SELECT '0' AS 't', 'b1' AS val0, worker,idate,blk,worktime,companyname,chasu,differ, realchasu,center, itemcode,itemname, customer,deadtype,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver,delivergubun,SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
			FROM labelcjimsi
			WHERE (companyname,idate, chasu,cancelY,barcode) in (
			SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode
			FROM labelcjimsi
			WHERE chasu < $chasu AND companyname='cj' AND idate='$today' AND worker='".$_SESSION['user_id']."'
			GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5))) UNION ALL
			SELECT '1' AS 't','b2' AS val0, worker,idate,blk,worktime,companyname,chasu,differ, realchasu,center, itemcode,itemname, customer,deadtype,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver,delivergubun, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
			FROM labelcjimsi
			WHERE chasu ='$chasu' AND idate= '$today' AND companyname='cj' AND worker='".$_SESSION['user_id']."')t1
			GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5)))d3
			LEFT JOIN (
			SELECT gubun2, SUBSTR(bar1,1,18) AS 'newbar'
			FROM (
			SELECT SUM(t) AS 'joincheck',worker,idate,blk,worktime,companyname,chasu,differ,realchasu,center, itemcode,itemname,customer,deadtype,deaddate, MAX(if(val0='b1',special,'')) AS special,cancelY, MAX(if(val0='b1',1,0)) AS 'gubun1', MAX(if(val0='b2',1,0)) AS 'gubun2', SUM(if(val0='b1',su,0)) AS 'be4', SUM(if(val0='b2',su,0)) AS 'af4', SUM(if(val0='b2',su,0))- SUM(if(val0='b1',su,0)) AS 'chaivalue',unit,barcode AS 'bar1',mcondition,deliver AS 'cha2',delivergubun,labelcount,mcode,groupnum
			FROM(
			SELECT '0' AS 't', 'b1' AS val0, worker,idate,blk,worktime,companyname,chasu,differ, realchasu,center, itemcode,itemname, customer,deadtype,deaddate,special,if(cancelY='N',surang,0) AS 'su', unit, barcode,mcondition,deliver,delivergubun, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
			FROM labelcjimsi
			WHERE (companyname,idate, chasu,cancelY,barcode) in (
			SELECT companyname,idate, MAX(chasu) AS chasu,cancelY,barcode
			FROM labelcjimsi
			WHERE chasu < $chasu AND companyname='cj' AND idate='$today' AND worker='".$_SESSION['user_id']."'
			GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5))) UNION ALL
			SELECT '1' AS 't','b2' AS val0, worker,idate,blk,worktime,companyname,chasu,differ, realchasu,center, itemcode,itemname, customer,deadtype,deaddate,special,if(cancelY='N',surang,0) AS 'su',unit,barcode,mcondition,deliver,delivergubun, SUBSTR(barcode,24,5) AS 'labelcount',mcode,cancelY,groupnum
			FROM labelcjimsi
			WHERE chasu ='$chasu' AND idate= '$today' AND companyname='cj' AND worker='".$_SESSION['user_id']."')t1
			GROUP BY CONCAT(SUBSTR(barcode,1,18), SUBSTR(barcode,24,5)))L
			WHERE L.gubun2='1'
			GROUP BY SUBSTR(bar1,1,18))A3 ON A3.newbar = SUBSTR(d3.bar1,1,18))B
			WHERE (B.gubun1 ='1' AND B.gubun2 ='1') AND B.chaivalue !=0 AND B.labelcount!='00001'";
					
			
			$stmt = $con->prepare($sql);


			$stmt->execute();
			
			
			
			
			$sql="insert into labelmain (worker,idate,blk,worktime, companyname, chasu, type, center,geocode, geoname, itemcode, mappingcode, itemname, customer, surang1,surang2,confirmsu,chaivalue,unit,bar1,bar2,mcode,deaddate,mcondition, cha2,special,cancelY,groupnum,TOT_PAGE) 
			SELECT worker,idate,blk,worktime,companyname,chasu,
			(CASE when chaivalue >0 AND surang1=0  then '신규' when chaivalue >0 AND surang1!=0 then '*증가'			
			when chaivalue <0 and surang2=0  then '*취소'
			when chaivalue <0 and surang2!=0 then '*감소'	           
			when chaivalue =0 and !(surang1=0 AND surang2=0) AND (bar1 !=bar2) then 	'*바코드변경'	              
			when chaivalue =0 and !(surang1=0 AND surang2=0) AND (cha1 != cha2) then '*차량번호변경' END) AS 'kind',
			center,geocode,geoname,itemcode,if(mappingcode is null,itemcode,if(mappingcode='0',0,mappingcode)),itemname,customer,surang1,surang2,surang2,chaivalue,unit2,if(barcode1 IS NULL, '',barcode1) AS 'barcode1',barcode2,mcode,deaddate,mcondition,cha2,special,cancel2,groupnum,totalsu 
			FROM (select worker,idate,blk,worktime,companyname,chasu,center,geocode,geoname,itemcode,mappingcode,itemname,customer,unit1,sum(if (cancel1='N',su1,'0')) AS 'surang1' ,unit2,sum(if (cancel2='N',su2,'0'))AS 'surang2',
			sum(if (cancel2='N',su2,'0'))-sum(if (cancel1='N',su1,'0')) AS 'chaivalue',MAX(if (cancel1='N',barcode1,'0')) AS 'bar1' , MAX(if (cancel2='N',barcode2,'0')) AS 'bar2'
			,barcode1,barcode2,mcode,deaddate,mcondition, cha1, cha2,special,cancel2,groupnum,sum(if(cancel2='N',labelpage,'0')) as 'totalsu' FROM (SELECT p.worker,p.idate,p.blk,p.worktime,p.companyname, p.chasu, p.center,p.geocode,p.geoname, p.itemcode,if (q.mappingcode IS NULL,p.itemcode,if(q.mappingcode='',p.itemcode,q.mappingcode)) AS 'mappingcode',p.itemname,p.customer, p.cancel1,p.unit1,p.su1,
			p.cancel2, p.unit2 , p.su2 ,p.chai,p.barcode1, p.barcode2, p.mcode,p.deaddate,p.mcondition,p.cha1,p.cha2, p.special,p.groupnum,p.labelpage  from(SELECT  u.worker,u.idate,u.blk,u.worktime,u.companyname, u.chasu, u.center,u.geocode,u.geoname, u.itemcode,u.itemname,u.customer, x.cancelY as 'cancel1',x.unit AS 'unit1',x.surang AS 'su1' ,
			u.cancelY as 'cancel2', u.unit as 'unit2' , u.surang AS 'su2' ,u.surang-x.surang as 'chai',
			x.barcode AS 'barcode1', u.barcode AS 'barcode2', u.mcode,u.deaddate,u.mcondition,x.deliver as 'cha1', u.deliver as 'cha2', u.special,u.groupnum,u.labelpage
			FROM (
			SELECT itemcode,itemname,customer,cancelY,unit,if(cancelY='Y',surang1,surang2) AS 'surang', if(cancelY='Y',bar1,bar2) AS 'barcode',cha2 AS 'deliver', groupnum  from(select * from labelmain where idate='$today' and (substr(bar2,1,18), chasu) in (select substr(bar2,1,18), max(chasu) as chasu from labelmain where chasu < '$chasu' and companyname='cj' and worker='".$_SESSION['user_id']."' group by substr(bar2,1,18))
			order by chasu desc) t group by t.bar2)x RIGHT join (SELECT b.worker,b.idate,b.blk,b.worktime,b.companyname, b.chasu, b.center,b.geocode,b.geoname, b.itemcode, b.itemname , b.customer ,
			b.cancelY,b.unit, sum(if(b.cancelY='Y',0,b.surang)) as 'surang',  MAX(concat(SUBSTR(b.barcode,1,18),SUBSTR(b.barcode,24,5))) AS 'barcode' ,b.mcode, b.deaddate ,b.mcondition, b.deliver, b.special,b.groupnum, sum('1') as 'labelpage' FROM labelcjimsi b 
			WHERE chasu ='$chasu' AND idate='$today' and companyname='cj' and worker='".$_SESSION['user_id']."' GROUP BY substr(b.barcode,1,18),center,itemcode,customer)u 
			ON substr(x.barcode,1,18) = substr(u.barcode,1,18))p LEFT JOIN iteminfo q ON q.itemcode = p.itemcode)T GROUP BY substr(barcode2,1,18),customer HAVING chaivalue !=0 OR bar1 <> bar2 OR cha1 <> cha2)S WHERE !(surang1 =0 AND surang2=0)";
			

			$stmt = $con->prepare($sql);


			$stmt->execute();

			
			echo "success";

		
    }
	catch(PDOException $ex)
	{

		echo "fail";
	}
						 
    

  
?>
