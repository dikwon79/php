<!doctype html>
<meta http-equiv="Content-Type" content="text/html;charset=euc-kr;">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
<script type="text/javascript">
function aa(cal,idnumber,ipsu)
{
  
   var xmlhttp=new XMLHttpRequest();
   var inameD= "test"+idnumber;
  
   xmlhttp.open("GET","listinc.php?fixed="+document.getElementById("z"+idnumber).value+"&palet1="+document.getElementById("a"+idnumber).value+"&palet2="+document.getElementById("d"+idnumber).value+"&box="+document.getElementById("b"+idnumber).value+"&ea="+document.getElementById("c"+idnumber).value+"&ipsu="+ipsu+"&Gcode="+document.getElementById("georaeCode"+idnumber).value+"&type="+document.getElementById("type"+idnumber).value+"&code="+document.getElementById("code"+idnumber).value+"&nowinventory="+document.getElementById("nowinventory"+idnumber).value+"&cal="+cal,false);
   xmlhttp.send(null);
   
   document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

}
function a3(cal)
{
   location.href = "index.html?cal="+cal;
}
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
</script>

<link rel="stylesheet" type="text/css" href="mh.css" />
<html lang="ko">
<head>
<meta charset="euckr">


<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi">

<html>

<?php
    
     $search=$_POST['search'];
	 //echo $search;
	 $lec1=trim($_POST['lec1']); 
	 
	 if ($chogi!='1') 
	 {

	    $stype2=$_POST['Combo2']; //냉동 냉장 커피
        $stype3=$_POST['Name'];  //에디트 박스값
	 
	    $calimsi=$_POST['cal'];
        $imsi = explode('-',$calimsi);
		//$calimsi;	
        $cal = $imsi[0].$imsi[1].$imsi[2];	
		
	    
	 }
	 else
	 {
	    $stype2=$Combo2; //냉동 냉장 커피
	 }
	 
	 if ($stype2<14)
	 {
         $mcCode = 2;
		 $Center ='cj';
	 }
	 else if ($stype2==14)
	 {
         $mcCode = 6;
		 $Center ='롯데칠성';
	 }
	 else if ($stype2==15)
	 {
         $mcCode = 7;
		 $Center ='켈로그';
	 }
	 else if ($stype2<17)
	 {
		 $mcCode = 1;
		 $Center ='lotte';
	 }
	 else if ($stype2==17)
	 {
		 $mcCode = 4;
		 $Center ='벌말창고';
	 }
     else if ($stype2==18)
	 {
		 $mcCode = 3;
		 $Center ='farmnet';
	 }
	 else if ($stype2>=19)
	 {
         $mcCode = 2;
		 $Center ='cj';
	 }
     
     $thisMon = date("Ym01", strtotime($cal)); 

     $pre = date("Ymd", strtotime($cal. "-1 day")); 
	 //db에 연결, 순서대로 호스트, 아이디, 비밀번호, 데이터베이스 명 입니다.

	 @$db = new mysqli('localhost', 'jjukkh', 'admin3393!', 'jjukkh');

	
    
	 //DB에 연결할 때 에러가 발생할 경우 출력

	 if(mysqli_connect_errno())

	 {
		 echo '에러: 데이터베이스에 연결 할 수 없습니다.';
		 exit;
	 }
     if ($stype2<16) { 
     $query = "select a.MCODE ,a.MNAME,a.Mipsu,a.Mnowsu,a.Mgeorae,a.MTYPE,a.MZONE,sum(if(B.입출고구분='last',B.수량,0)) as 전일재고, sum(CASE WHEN  B.입출고구분='ipgo' and B.단위 = 'BOX' THEN B.수량*a.Mipsu WHEN  B.입출고구분='ipgo' and 
          B.단위 = 'EA' THEN B.수량 WHEN B.입출고구분='ipgo' and B.단위 = 'PAC' THEN B.수량 ELSE 0 END) as 입고 , sum(CASE WHEN  B.입출고구분='now' and B.단위 = 'BOX' THEN B.수량*a.Mipsu WHEN  B.입출고구분='now' and 
          B.단위 = 'EA' THEN B.수량 WHEN B.입출고구분='now' and B.단위 = 'PAC' THEN B.수량 ELSE 0 END)as 현출고,sum(if(B.입출고구분='panpum',B.수량,0)) as Mpanpum,sum(if(B.입출고구분='silsa',B.수량,0)) as 실사,if(B.입출고구분='zpreday',B.수량,0) as 고정,sum(B.구분) as 표시  from Miteminfo a, 
         (select 'last' as 입출고구분,c.MCODE as 코드, c.Mnowinv as 수량 ,'EA' as 단위,'0' as 구분 from Minventory_real c where c.MCCODE = '$mcCode' and c.MDATE ='$cal'
          union all
		  select 'silsa' as 입출고구분,e.MCODE as 코드, e.MSURANG as 수량 ,'EA' as 단위,'0' as 구분 from Mdailyreal e where e.MCCODE = '$mcCode' and e.MDATE ='$cal'
	      union all
	      select 'panpum' as 입출고구분,g.MCODE as 코드, g.Mpanpum as 수량 ,'EA' as 단위,'0' as 구분 from Minventory_real g where g.MCCODE = '$mcCode' and g.MDATE ='$cal'
		  union all
		  select 'now' as 입출고구분,d.Mitemcode2 as 코드, d.Mtax as 수량, d.Munit as 단위,'1' as 구분 from MLABEL d where  d.MCCODE = '$mcCode' and d.MINPUTDAY ='$cal' 
		  union all
		  select 'ipgo' as 입출고구분, f.MICODE as 코드, f.MSURANG as 수량 ,'EA' as 단위,'1' as 구분 from MInputout2 f where f.MCCODE = '$mcCode' and f.MDATE='$cal'
		  union all
		  select 'zpreday' as 입출고구분,MCODE as 코드, Mprocess as 수량 ,'EA' as 단위,'0' as 구분 from (select MCODE, Mprocess FROM Mdailyreal where MCCODE='$mcCode' ORDER BY MDATE desc) as k GROUP BY k.MCODE order by 입출고구분 desc)B where a.MCODE = B.코드 and a.MainCenter ='$Center' and ";
		  
     }
	 else if ($stype<19)
	 {
		 $query="select a.MCODE ,a.MNAME,a.Mipsu,a.Mnowsu,a.Mgeorae,a.MTYPE,a.MZONE,sum(if(B.입출고구분='last',B.수량,0)) as 전월재고, sum(CASE WHEN  B.입출고구분='ipgototal' and B.단위 = 'BOX' THEN B.수량*a.Mipsu WHEN  B.입출고구분='ipgototal' and 
          B.단위 = 'EA' THEN B.수량 WHEN B.입출고구분='ipgototal' and B.단위 = 'PAC' THEN B.수량 ELSE 0 END) as 입고합 ,sum(CASE WHEN  B.입출고구분='outTotal' and B.단위 = 'BOX' THEN B.수량*a.Mipsu WHEN  B.입출고구분='outTotal' and 
          B.단위 = 'EA' THEN B.수량 WHEN B.입출고구분='outTotal' and B.단위 = 'PAC' THEN B.수량 ELSE 0 END)as 출고합, sum(CASE WHEN  B.입출고구분='now' and B.단위 = 'BOX' THEN B.수량*a.Mipsu WHEN  B.입출고구분='now' and 
          B.단위 = 'EA' THEN B.수량 WHEN B.입출고구분='now' and B.단위 = 'PAC' THEN B.수량 ELSE 0 END)as 현출고,sum(if(B.입출고구분='lastpan',B.수량,0))+sum(if(B.입출고구분='panpum',B.수량,0)) as Mpanpum,sum(if(B.입출고구분='silsa',B.수량,0)) as 실사,a.Mfix as 고정,sum(B.구분) as 표시  from Miteminfo a, 
         (select 'last' as 입출고구분,c.MCODE as 코드, c.Mnowinv as 수량 ,'EA' as 단위,'0' as 구분 from Minventory_real c where c.MCCODE = '$mcCode' and (c.MDATE ='$thisMon')
          union all
		  select 'lastpan' as 입출고구분,c.MCODE as 코드, c.Mpanpum as 수량 ,'EA' as 단위,'0' as 구분 from Minventory_real c where c.MCCODE = '$mcCode' and (c.MDATE ='$thisMon')
          union all
		  select 'silsa' as 입출고구분,e.MCODE as 코드, e.MSURANG as 수량 ,'EA' as 단위,'0' as 구분 from Minventory_real e where e.MCCODE = '$mcCode' and e.MDATE ='$cal'
	      union all
	      select 'nowpanpum' as 입출고구분,d.Mitemcode2 as 코드, d.Mtax as 수량, d.Munit as 단위,'0' as 구분 from MLABEL d where d.Mcenter ='1000' and d.MCCODE = '$mcCode' and (d.MINPUTDAY >='$thisMon' AND d.MINPUTDAY <='$cal') 
		  union all
		  select 'outTotal' as 입출고구분,d.Mitemcode2 as 코드, d.Mtax as 수량, d.Munit as 단위,'0' as 구분 from MLABEL d where d.Mcenter !='1000' and d.MCCODE = '$mcCode' and (d.MINPUTDAY >='$thisMon' AND d.MINPUTDAY <='$cal')
		  union all
		  select 'now' as 입출고구분,d.Mitemcode2 as 코드, d.Mtax as 수량, d.Munit as 단위,'1' as 구분 from MLABEL d where  d.MCCODE = '$mcCode' and d.MINPUTDAY ='$cal' 
		  union all
		  select 'ipgo' as 입출고구분, f.MICODE as 코드, f.MSURANG as 수량 ,'EA' as 단위,'1' as 구분 from MInputout2 f where f.MCCODE = '$mcCode' and f.MDATE='$cal'
		  union all
		  select 'ipgototal' as 입출고구분, f.MICODE as 코드, f.MSURANG as 수량 ,'EA' as 단위,'0' as 구분 from MInputout2 f where f.MCCODE = '$mcCode' and (f.MDATE>='$thisMon' and f.MDATE<='$cal'))B where a.MCODE = B.코드 and";
		  
     } 
     else if ($stype >20 && $stype <24)
	 {
	 
	     
	 
	 
	 }




	 if ($stype2==1) 
	 {
        $query .= " a.MTYPE='냉동' group by a.MCODE";
	 }
	 else if ($stype2==2) 
	 {
        $query .= " a.MTYPE='냉장' group by a.MCODE";
	 }
	  
	 else if ($stype2==8) 
	 {
        $query .= " (a.MTYPE='웅진' or a.MTYPE='푸른식품' or a.MTYPE='해태음료') group by a.MCODE";
	 } 
	 else if ($stype2==9) 
	 {
        $query .= " (a.MTYPE='다미안' or a.MTYPE='A' or a.MTYPE='B') group by a.MCODE";
	 }
	 else if ($stype2==10) 
	 {
        $query .= " (a.MTYPE='C' or a.MTYPE='D' or a.MTYPE='롯데푸드' or a.MTYPE='신영')  group by a.MCODE";
	 }
	 else if ($stype2==11) 
	 {
        $query .= " (a.MTYPE='E' or a.MTYPE='F' or a.MTYPE='G' or a.MTYPE='롯데푸드' or a.MTYPE='주커피') group by a.MCODE";
	 }
	 else if ($stype2==12) 
	 {
        $query .= " (a.MTYPE='미래') group by a.MCODE";
	 }
	 else if ($stype2==13) 
	 {
        $query .= " (a.MTYPE='H' or a.MTYPE='동아오츠카' or a.MTYPE='정식품' or a.MTYPE='I' or a.MTYPE='J' or a.MTYPE='K' or a.MTYPE='L' or a.MTYPE='N' or a.MTYPE='O') group by a.MCODE";
	 }
	 else if ($stype2==14) 
	 {
        $query .= " a.MTYPE='롯데칠성' group by a.MCODE";
	 }
	 else if ($stype2==15) 
	 {
        $query .= " a.MTYPE='농심켈로그' group by a.MCODE";
	 }
	 else if ($stype2==16) 
	 {
        $query .= " a.MTYPE='오산롯데식자재' group by a.MCODE";
	 }
	 else if ($stype2==17) 
	 {
        $query .= " a.MTYPE='오산롯데기자재' group by a.MCODE";
	 }
	 else if ($stype2==18) 
	 {
        $query .= " a.MTYPE='오산롯데외식' group by a.MCODE";
	 }
	 else if ($stype2==19) 
	 {
        $query .= " a.MTYPE='벌말창고' group by a.MCODE";
	 }
	 else if ($stype2==20) 
	 {
        $query .= " a.MTYPE='farmnet' group by a.MCODE";
	 }
	 else if ($stype2==21) 
	 {
        $query .=" a.MTYPE<>'' and a.MCODE like '%$search%' group by a.MCODE";	
	 }
	 else if ($stype2==22) 
	 {
        $query .=" a.MTYPE<>'' and a.MNAME like '%$search%' group by a.MCODE";
	 }
	 else if ($stype2==23) 
	 {
        $query .=" a.MTYPE<>'' and a.MGEORAE like '%$search%' group by a.MCODE";
	  
	 }
     
     if ($lec1=='3') 
     {
	    $query .=" having 실사<>(전일재고+입고-현출고-Mpanpum) and (현출고 <>0 or 표시<>0)"; 
	  	
     }
     
     if ($lec1=='2') 
     {
        if (($stype2>13) and ($stype2<19))
        {
           $query .=" having (현출고 <>0 or 표시 <>0)";
        }
        else{
       

	      $query .=" having (현출고 <>0 or 표시 <>0)"; 
	    } 
 		
     }

     $query .= " order by a.MZONE asc";
     //echo $query;
 
	 $result = $db->query($query);

	 
     $num_results = $result->num_rows;
	 //쿼리를 보냈을 때 결과의 개수
     //echo $row['전일재고']	
?>

<body>
<? 
  
  if(!$stype2) { exit;} //모두 불러내려면 데이타가 장난 아니라....
  $today=$cal;
  
 
  $nRow=0;
  for($i=0; $i<$num_results; $i++)

  {
        $row = $result->fetch_assoc(); 
        $ipsu[$i]=$row['Mipsu'];  
		$MCODE = $row['MCODE'];
        
        //if ($lec1=="2") continue;

        $p= explode("/",$row[고정]); 

 ?>

<table class="layout display responsive-table">
<thead>
<tr>
<? 
   		
    echo '<금일출고:'.$row['현출고'].'>'; 
    
	if ($row['실사']=='0') {

       $p[0]='';
       $p[1]='';
       $p[2]='';
       //$p[0]='';
 
	}

 ?>
</tr>
<tr>
<th>렉번호</th>
<th>품목명</th>
<th>현재고</th>
<th>계산</th>
<th colspan="2">수량</th>
</tr>
</thead>
<tbody>
<form name="form1_<?=$i?>" action="" method="POST">

<tr>
<td class="organisationnumber">
<? echo stripslashes($row['MTYPE']."(".$row['MZONE']).")";?>
<input type="hidden" name="type" id="type<?=$i?>" value="<?=$row['MTYPE']?>";>
</td>
<td class="organisationname" onClick ="ab(<?=$i?>,<?=$ipsu[$i]?>);">
 <? echo stripslashes("[".$row['MCODE']."]".$row['MNAME']);
     
 ?>
 <input type="hidden" name="code" id="code<?=$i?>" value="<?=$row['MCODE']?>";>
</td>
<td class="organisationname">
<? 
   $Bcheck = false;
   //if (trim($row['MCODE'])=='161541') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161545') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161546') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161547') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161548') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161542') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161544') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161543') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='161540') {  $Bcheck = true;}
   //else if (trim($row['MCODE'])=='173444') {  $Bcheck = true;}
    
   if (trim($row['MCODE'])=='122876') { $changevalue = 5;}
   else { $changevalue=1; }

   
   if (($stype2>15) and ($stype2<20))
   {
       $total = $row['전월재고']-$row['Mpanpum']-($row['출고합']*$changevalue)+$row['입고합']; 
        echo $total;
   }
   else{
      if ($Bcheck) {
         $total = $row['전일재고']-$row['Mpanpum']-$row['현출고']*12+$row['입고']; 
      }
      else{
         $total = $row['전일재고']-$row['Mpanpum']-$row['현출고']+$row['입고'];
      }	 
      echo $total;
	  
   }
   //echo $Bcheck;
   
?>
<input type="hidden" name="nowinventory" id="nowinventory<?=$i?>" value="<?=$total;?>";>
<input type="hidden" name="georaeCode" id="georaeCode<?=$i?>" value="<?=$mcCode;?>";>

</td>
<td class="organisationname">
<? echo "고정재고(Box)전일:"?><?=$p[3].'BOX'?><input type="text" name="z" id="z<?=$i?>" value="<?=$p[3]?>"style="width:100%;"></td>
<td  class="organisationname"><? echo "1단"?><input type="number" name="a" id="a<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<?=$row['Mnowsu']?>" style="width:100%;"><? echo "높이"?><input type="text" name="d" id="d<?=$i?>" value="<?=$p[0]?>" style="width:100%;"><? echo '박스'; echo "(".$ipsu[$i].")"?><input type="text" name="b" id="b<?=$i?>" value="<?=$p[1]?>" style="width:100%;">
<? echo "개"?><input type="text" name="c" id="c<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<?=$p[2]?>" style="width:100%;"><input type ="button" name="button1" value="계산후저장" onClick ="aa(<?=$cal?>,<?=$i?>,<?=$ipsu[$i];?>);">
</td>
<td colspan="2" id="test<?=$i?>" class="organisationname">
</td>

</td>
</tr>
</form>
 <?
    
    }
 ?>

<?
	 $result->free();
	 $db->close();
?>

</body>
<form name="form2" action="" method="POST">
<tr>
 <td colspan="5" class="organisationnumber">
   <input type ="button" name="button2" value="초기화면으로" style="width:100%" onClick ="a3('<?=$calimsi?>')"> 
 </td>


</tr>
</form>

</html>