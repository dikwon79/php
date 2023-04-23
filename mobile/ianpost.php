<!doctype html>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">
<head>
 


<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!-- 합쳐지고 최소화된 최신 CSS -->
<script>
function aa(cal,idnumber,ipsu)
{
  
   var xmlhttp=new XMLHttpRequest();
   var inameD= "test"+idnumber;
   
   xmlhttp.open("GET","listinc.php?itemcode="+document.getElementById("code"+idnumber).value+"&nowinventory="+document.getElementById("nowinventory"+idnumber).value+"&fixbox="+document.getElementById("fixbox"+idnumber).value+"&fixea="+document.getElementById("fixea"+idnumber).value+"&dan="+document.getElementById("dan"+idnumber).value+"&ipsu="+ipsu+"&heightcounting="+document.getElementById("heightcounting"+idnumber).value+"&boxcounting="+document.getElementById("boxcounting"+idnumber).value+"&eacounting="+document.getElementById("eacounting"+idnumber).value+"&cal="+cal,false);
   xmlhttp.send(null);
   
   document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

}

function a3(cal)
{
   location.href = "index.php?cal="+cal;
}
/*
function ab(idnumber,ipsu)
{
   
   var inameD="test"+idnumber;
 
   if(document.getElementById("b"+idnumber).value=="")
   {
       location.href="modifyinfo.php?code="+document.getElementById("code"+idnumber).value+"&palet1="+document.getElementById("a"+idnumber).value+"&box="+ipsu;
   }
   else
   {
      location.href="modifyinfo.php?code="+document.getElementById("code"+idnumber).value+"&palet1="+document.getElementById("a"+idnumber).value+"&box="+document.getElementById("b"+idnumber).value;
   }
  
}

*/
</script>

<link rel="stylesheet" type="text/css" href="iaan.css">
</head>


<html>



<?php
     include('mobiledbcon.php');
     $cal = $_POST['cal'];	//날짜
	 $stype=trim($_POST['Combo2']); //재고조사 담당
     $search=trim($_POST['search']); //재고조사 담당$_POST['search']; //검색
	 $lec1=trim($_POST['lec1']); // 1전수,2출고, 3에러
     
	
	 
	 //$query = "SELECT a.itemcode,a.itemname,a.ipsu,a.georae,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate='$cal' and a.inventory ='$stype' ";
     /*
     $query = "SELECT a.itemcode,a.itemname,a.ipsu,a.georae,a.lek,a.inventory,b.outstock,b.nowstock,c.SURANG,(b.nowstock-c.SURANG) as chai,d.fixbox,d.fixea,a.dan,c.countheight,c.countBox,c.countEa FROM iteminfo a
     LEFT JOIN nowinven b ON a.itemcode=b.itemcode and b.idate='$cal'
     LEFT JOIN dailycounting c ON a.itemcode= c.itemcode and c.idate='$cal'
     LEFT JOIN (SELECT itemcode,fixbox,fixea,countheight,countBox,countEa from dailycounting where (itemcode,idate) IN (SELECT itemcode, MAX(idate) from dailycounting group BY itemcode)
               order by idate DESC)d ON a.itemcode =d.itemcode ";
	 
	 */
	 if($search){
         $selectbox.= " and a.itemname like '%$search%' ";  
	 }
	 else{
	   $selectbox.= " and a.inventory ='$stype' ";  
	 
     }
     //$selectbox =" and inventory = '$selectname' ";
     $sql = "SELECT idate FROM Deadline ORDER BY idate desc limit 1";
     $result = $db->query($sql);
     $row = $result->fetch_assoc(); 
     $deaddate = $row['idate'];
     
	 $query = "SELECT a.itemcode,a.georae,a.mappingcode,a.itemname,a.lek,a.ipsu,
								sum(if(B.list='기초',B.surang,0))-SUM(if(B.list='총출고',if(B.unit='BOX',B.surang*a.ipsu,B.surang),0))+SUM(if(B.list='총입고',if(B.unit='BOX',B.surang*a.ipsu,B.surang),0)) AS '전일재고',
								sum(if(B.list='입고',B.surang,0)) AS '입고',
								sum(CASE WHEN B.companyname = 'CJ' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'outstock', 
								sum(CASE WHEN B.companyname = 'spc' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'SPC', 
								sum(CASE WHEN B.companyname = 'shinsegye' THEN CASE WHEN B.unit = 'BOX' THEN a.ipsu*B.surang ELSE B.surang END else 0 END)AS 'shinsegye', 
								SUM(if(B.list='실사',B.surang,0)) AS '실사'
								FROM iteminfo a,(
								SELECT '기초'AS 'list', '' AS 'companyname',itemcode as 'mappingcode',surang,'EA' AS 'unit' from Deadline b WHERE idate='$deaddate'
								UNION ALL 
								SELECT '입고' AS 'list', '' AS 'companyname',mappingcode,sum(surang) as 'surang','EA' AS 'unit' from ipgo c WHERE ipgodate='$cal' GROUP BY mappingcode
								UNION ALL 
								SELECT '출고' AS 'list', companyname,mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain d WHERE idate ='$cal' GROUP BY mappingcode,unit
								UNION ALL
								SELECT '총입고' AS 'list','' AS 'companyname', e.mappingcode,sum(if(e.surang='',0,e.surang)) AS 'surang','EA' AS 'unit' from ipgo e WHERE ipgodate > '$deaddate' and ipgodate <'$cal' GROUP BY mappingcode
								UNION ALL
								SELECT '총출고' AS 'list','' AS 'companyname', mappingcode,sum(chaivalue) AS 'surang',unit AS 'unit' from labelmain f WHERE idate > '$deaddate' and idate < '$cal' GROUP BY mappingcode,unit
								UNION ALL
								SELECT '실사' AS 'list', '' AS 'companyname',itemcode as 'mappingcode',SURANG AS 'surang', 'EA' AS 'unit' from dailycounting g WHERE g.idate='$cal'
								)B WHERE a.itemcode = B.mappingcode AND usingY='Y' ".$selectbox." GROUP BY B.mappingcode";
	 
	 //$query ="SELECT itemcode,fixbox,fixea from dailycounting where (itemcode,idate) IN (SELECT itemcode, MAX(idate) from dailycounting group BY itemcode)
      //         order by idate desc;"
   
     
     if ($lec1=='2') 
     {
        
         $query .=" having (b.outstock<>0)";
       
 		
     }
	 else if ($lec1=='3'){

		
     
	    $query .=" having ((c.SURANG IS NULL) and (b.outstock<>0)) OR ((chai <> 0) and (c.SURANG <>0 ))"; 
	  	
     

	 }

     $query .= " order by a.lek asc";
     echo $query;
	 $result = $db->query($query);

	 
     $num_results = $result->num_rows;
	 $cal = substr($cal,0,4).substr($cal,5,2).substr($cal,8,2);
	 
?>

<body>
<div class="container">
<? 
 
  $today=$cal;
  
  $nRow=0;
  for($i=0; $i<$num_results; $i++)

  {
        $row = $result->fetch_assoc(); 
        $ipsu[$i]=$row['ipsu'];  
		$MCODE = $row['itemcode'];
		

   
 
 ?>

<table class="layout display responsive-table">
<thead>
<tr>
<th>구역</th>
<th>품목정보</th>
<th>현재고</th>
<th>고정box</th>
<th>고정ea</th>
<th>실재고</th>
<th colspan="2">계산</th>
</tr>
</thead>
<tbody>
<form name="form1_<?=$i?>" action="" method="POST">

<tr>
<td class="organisationnumber">
<? echo stripslashes($row['georae']."(".$row['lek']).")";?>
</td>
<td class="organisationname" onClick ="ab(<?=$i?>,<?=$ipsu[$i]?>);">
 <? echo stripslashes("[".$row['itemcode']."]".$row['itemname']);
     
 ?>
 <input type="hidden" name="code" id="code<?=$i?>" value="<?=$row['itemcode']?>";>
</td>
<td class="organisationname">
<? 
   $nowstock = $row['전일재고']+$row['입고']-$row['outstock']; 	  
   echo $nowstock;
   echo '   (금일출고:'.$row[outstock].')';
 
  
   
?>
<input type="hidden" name="nowinventory" id="nowinventory<?=$i?>" value="<?= $row['nowstock'];?>";>
</td>
<td class="organisationname">
<? echo "고정재고(Box)전일:"?><?=$row['fixbox'].'BOX'?><input type="text" name="fixbox" id="fixbox<?=$i?>" value="<?=$row['fixbox']?>"style="width:100%;"></td>
<td class="organisationname">
<? echo "고정재고(EA)전일:"?><?=$row['fixea'].'EA'?><input type="text" name="fixea" id="fixea<?=$i?>" value="<?=$row['fixea']?>"style="width:100%;"></td>
<td  class="organisationname"><? echo "1단"?><input type="number" name="dan" id="dan<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<?=$row['dan']?>" style="width:100%;"><? echo "높이"?><input type="text" name="heightcounting" id="heightcounting<?=$i?>" value="<?=$row['countheight']?>" style="width:100%;"><? echo '박스'; echo "(".$ipsu[$i].")"?><input type="text" name="boxcounting" id="boxcounting<?=$i?>" value="<?=$row['countBox']?>" style="width:100%;">
<? echo "개"?><input type="text" name="eacounting" id="eacounting<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<?=$row['countEa']?>" style="width:100%;">
<button type="button" class="btn btn-primary" onClick ="aa(<?=$cal?>,<?=$i?>,<?=$ipsu[$i];?>);">실사 계산후 업로드 하기</button>
</td>
<td colspan="2" id="test<?=$i?>" class="organisationname">
</td>

</td>
</tr>
</form>
 <?
    
    }
 ?>
 </table>
<?
	 $result->free();
	 $db->close();
?>

</body>
<form name="form2" action="" method="POST">
<tr>
 <td colspan="5" class="organisationnumber">
   <input type ="button" name="button2" value="초기화면으로" style="width:100%" onClick ="a3('<?=$cal?>')"> 
 </td>


</tr>
</form>

</html>