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

	    $stype2=$_POST['Combo2']; //�õ� ���� Ŀ��
        $stype3=$_POST['Name'];  //����Ʈ �ڽ���
	 
	    $calimsi=$_POST['cal'];
        $imsi = explode('-',$calimsi);
		//$calimsi;	
        $cal = $imsi[0].$imsi[1].$imsi[2];	
		
	    
	 }
	 else
	 {
	    $stype2=$Combo2; //�õ� ���� Ŀ��
	 }
	 
	 if ($stype2<14)
	 {
         $mcCode = 2;
		 $Center ='cj';
	 }
	 else if ($stype2==14)
	 {
         $mcCode = 6;
		 $Center ='�Ե�ĥ��';
	 }
	 else if ($stype2==15)
	 {
         $mcCode = 7;
		 $Center ='�̷α�';
	 }
	 else if ($stype2<17)
	 {
		 $mcCode = 1;
		 $Center ='lotte';
	 }
	 else if ($stype2==17)
	 {
		 $mcCode = 4;
		 $Center ='����â��';
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
	 //db�� ����, ������� ȣ��Ʈ, ���̵�, ��й�ȣ, �����ͺ��̽� �� �Դϴ�.

	 @$db = new mysqli('localhost', 'jjukkh', 'admin3393!', 'jjukkh');

	
    
	 //DB�� ������ �� ������ �߻��� ��� ���

	 if(mysqli_connect_errno())

	 {
		 echo '����: �����ͺ��̽��� ���� �� �� �����ϴ�.';
		 exit;
	 }
     if ($stype2<16) { 
     $query = "select a.MCODE ,a.MNAME,a.Mipsu,a.Mnowsu,a.Mgeorae,a.MTYPE,a.MZONE,sum(if(B.�������='last',B.����,0)) as �������, sum(CASE WHEN  B.�������='ipgo' and B.���� = 'BOX' THEN B.����*a.Mipsu WHEN  B.�������='ipgo' and 
          B.���� = 'EA' THEN B.���� WHEN B.�������='ipgo' and B.���� = 'PAC' THEN B.���� ELSE 0 END) as �԰� , sum(CASE WHEN  B.�������='now' and B.���� = 'BOX' THEN B.����*a.Mipsu WHEN  B.�������='now' and 
          B.���� = 'EA' THEN B.���� WHEN B.�������='now' and B.���� = 'PAC' THEN B.���� ELSE 0 END)as �����,sum(if(B.�������='panpum',B.����,0)) as Mpanpum,sum(if(B.�������='silsa',B.����,0)) as �ǻ�,if(B.�������='zpreday',B.����,0) as ����,sum(B.����) as ǥ��  from Miteminfo a, 
         (select 'last' as �������,c.MCODE as �ڵ�, c.Mnowinv as ���� ,'EA' as ����,'0' as ���� from Minventory_real c where c.MCCODE = '$mcCode' and c.MDATE ='$cal'
          union all
		  select 'silsa' as �������,e.MCODE as �ڵ�, e.MSURANG as ���� ,'EA' as ����,'0' as ���� from Mdailyreal e where e.MCCODE = '$mcCode' and e.MDATE ='$cal'
	      union all
	      select 'panpum' as �������,g.MCODE as �ڵ�, g.Mpanpum as ���� ,'EA' as ����,'0' as ���� from Minventory_real g where g.MCCODE = '$mcCode' and g.MDATE ='$cal'
		  union all
		  select 'now' as �������,d.Mitemcode2 as �ڵ�, d.Mtax as ����, d.Munit as ����,'1' as ���� from MLABEL d where  d.MCCODE = '$mcCode' and d.MINPUTDAY ='$cal' 
		  union all
		  select 'ipgo' as �������, f.MICODE as �ڵ�, f.MSURANG as ���� ,'EA' as ����,'1' as ���� from MInputout2 f where f.MCCODE = '$mcCode' and f.MDATE='$cal'
		  union all
		  select 'zpreday' as �������,MCODE as �ڵ�, Mprocess as ���� ,'EA' as ����,'0' as ���� from (select MCODE, Mprocess FROM Mdailyreal where MCCODE='$mcCode' ORDER BY MDATE desc) as k GROUP BY k.MCODE order by ������� desc)B where a.MCODE = B.�ڵ� and a.MainCenter ='$Center' and ";
		  
     }
	 else if ($stype<19)
	 {
		 $query="select a.MCODE ,a.MNAME,a.Mipsu,a.Mnowsu,a.Mgeorae,a.MTYPE,a.MZONE,sum(if(B.�������='last',B.����,0)) as �������, sum(CASE WHEN  B.�������='ipgototal' and B.���� = 'BOX' THEN B.����*a.Mipsu WHEN  B.�������='ipgototal' and 
          B.���� = 'EA' THEN B.���� WHEN B.�������='ipgototal' and B.���� = 'PAC' THEN B.���� ELSE 0 END) as �԰��� ,sum(CASE WHEN  B.�������='outTotal' and B.���� = 'BOX' THEN B.����*a.Mipsu WHEN  B.�������='outTotal' and 
          B.���� = 'EA' THEN B.���� WHEN B.�������='outTotal' and B.���� = 'PAC' THEN B.���� ELSE 0 END)as �����, sum(CASE WHEN  B.�������='now' and B.���� = 'BOX' THEN B.����*a.Mipsu WHEN  B.�������='now' and 
          B.���� = 'EA' THEN B.���� WHEN B.�������='now' and B.���� = 'PAC' THEN B.���� ELSE 0 END)as �����,sum(if(B.�������='lastpan',B.����,0))+sum(if(B.�������='panpum',B.����,0)) as Mpanpum,sum(if(B.�������='silsa',B.����,0)) as �ǻ�,a.Mfix as ����,sum(B.����) as ǥ��  from Miteminfo a, 
         (select 'last' as �������,c.MCODE as �ڵ�, c.Mnowinv as ���� ,'EA' as ����,'0' as ���� from Minventory_real c where c.MCCODE = '$mcCode' and (c.MDATE ='$thisMon')
          union all
		  select 'lastpan' as �������,c.MCODE as �ڵ�, c.Mpanpum as ���� ,'EA' as ����,'0' as ���� from Minventory_real c where c.MCCODE = '$mcCode' and (c.MDATE ='$thisMon')
          union all
		  select 'silsa' as �������,e.MCODE as �ڵ�, e.MSURANG as ���� ,'EA' as ����,'0' as ���� from Minventory_real e where e.MCCODE = '$mcCode' and e.MDATE ='$cal'
	      union all
	      select 'nowpanpum' as �������,d.Mitemcode2 as �ڵ�, d.Mtax as ����, d.Munit as ����,'0' as ���� from MLABEL d where d.Mcenter ='1000' and d.MCCODE = '$mcCode' and (d.MINPUTDAY >='$thisMon' AND d.MINPUTDAY <='$cal') 
		  union all
		  select 'outTotal' as �������,d.Mitemcode2 as �ڵ�, d.Mtax as ����, d.Munit as ����,'0' as ���� from MLABEL d where d.Mcenter !='1000' and d.MCCODE = '$mcCode' and (d.MINPUTDAY >='$thisMon' AND d.MINPUTDAY <='$cal')
		  union all
		  select 'now' as �������,d.Mitemcode2 as �ڵ�, d.Mtax as ����, d.Munit as ����,'1' as ���� from MLABEL d where  d.MCCODE = '$mcCode' and d.MINPUTDAY ='$cal' 
		  union all
		  select 'ipgo' as �������, f.MICODE as �ڵ�, f.MSURANG as ���� ,'EA' as ����,'1' as ���� from MInputout2 f where f.MCCODE = '$mcCode' and f.MDATE='$cal'
		  union all
		  select 'ipgototal' as �������, f.MICODE as �ڵ�, f.MSURANG as ���� ,'EA' as ����,'0' as ���� from MInputout2 f where f.MCCODE = '$mcCode' and (f.MDATE>='$thisMon' and f.MDATE<='$cal'))B where a.MCODE = B.�ڵ� and";
		  
     } 
     else if ($stype >20 && $stype <24)
	 {
	 
	     
	 
	 
	 }




	 if ($stype2==1) 
	 {
        $query .= " a.MTYPE='�õ�' group by a.MCODE";
	 }
	 else if ($stype2==2) 
	 {
        $query .= " a.MTYPE='����' group by a.MCODE";
	 }
	  
	 else if ($stype2==8) 
	 {
        $query .= " (a.MTYPE='����' or a.MTYPE='Ǫ����ǰ' or a.MTYPE='��������') group by a.MCODE";
	 } 
	 else if ($stype2==9) 
	 {
        $query .= " (a.MTYPE='�ٹ̾�' or a.MTYPE='A' or a.MTYPE='B') group by a.MCODE";
	 }
	 else if ($stype2==10) 
	 {
        $query .= " (a.MTYPE='C' or a.MTYPE='D' or a.MTYPE='�Ե�Ǫ��' or a.MTYPE='�ſ�')  group by a.MCODE";
	 }
	 else if ($stype2==11) 
	 {
        $query .= " (a.MTYPE='E' or a.MTYPE='F' or a.MTYPE='G' or a.MTYPE='�Ե�Ǫ��' or a.MTYPE='��Ŀ��') group by a.MCODE";
	 }
	 else if ($stype2==12) 
	 {
        $query .= " (a.MTYPE='�̷�') group by a.MCODE";
	 }
	 else if ($stype2==13) 
	 {
        $query .= " (a.MTYPE='H' or a.MTYPE='���ƿ���ī' or a.MTYPE='����ǰ' or a.MTYPE='I' or a.MTYPE='J' or a.MTYPE='K' or a.MTYPE='L' or a.MTYPE='N' or a.MTYPE='O') group by a.MCODE";
	 }
	 else if ($stype2==14) 
	 {
        $query .= " a.MTYPE='�Ե�ĥ��' group by a.MCODE";
	 }
	 else if ($stype2==15) 
	 {
        $query .= " a.MTYPE='����̷α�' group by a.MCODE";
	 }
	 else if ($stype2==16) 
	 {
        $query .= " a.MTYPE='����Ե�������' group by a.MCODE";
	 }
	 else if ($stype2==17) 
	 {
        $query .= " a.MTYPE='����Ե�������' group by a.MCODE";
	 }
	 else if ($stype2==18) 
	 {
        $query .= " a.MTYPE='����Ե��ܽ�' group by a.MCODE";
	 }
	 else if ($stype2==19) 
	 {
        $query .= " a.MTYPE='����â��' group by a.MCODE";
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
	    $query .=" having �ǻ�<>(�������+�԰�-�����-Mpanpum) and (����� <>0 or ǥ��<>0)"; 
	  	
     }
     
     if ($lec1=='2') 
     {
        if (($stype2>13) and ($stype2<19))
        {
           $query .=" having (����� <>0 or ǥ�� <>0)";
        }
        else{
       

	      $query .=" having (����� <>0 or ǥ�� <>0)"; 
	    } 
 		
     }

     $query .= " order by a.MZONE asc";
     //echo $query;
 
	 $result = $db->query($query);

	 
     $num_results = $result->num_rows;
	 //������ ������ �� ����� ����
     //echo $row['�������']	
?>

<body>
<? 
  
  if(!$stype2) { exit;} //��� �ҷ������� ����Ÿ�� �峭 �ƴ϶�....
  $today=$cal;
  
 
  $nRow=0;
  for($i=0; $i<$num_results; $i++)

  {
        $row = $result->fetch_assoc(); 
        $ipsu[$i]=$row['Mipsu'];  
		$MCODE = $row['MCODE'];
        
        //if ($lec1=="2") continue;

        $p= explode("/",$row[����]); 

 ?>

<table class="layout display responsive-table">
<thead>
<tr>
<? 
   		
    echo '<�������:'.$row['�����'].'>'; 
    
	if ($row['�ǻ�']=='0') {

       $p[0]='';
       $p[1]='';
       $p[2]='';
       //$p[0]='';
 
	}

 ?>
</tr>
<tr>
<th>����ȣ</th>
<th>ǰ���</th>
<th>�����</th>
<th>���</th>
<th colspan="2">����</th>
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
       $total = $row['�������']-$row['Mpanpum']-($row['�����']*$changevalue)+$row['�԰���']; 
        echo $total;
   }
   else{
      if ($Bcheck) {
         $total = $row['�������']-$row['Mpanpum']-$row['�����']*12+$row['�԰�']; 
      }
      else{
         $total = $row['�������']-$row['Mpanpum']-$row['�����']+$row['�԰�'];
      }	 
      echo $total;
	  
   }
   //echo $Bcheck;
   
?>
<input type="hidden" name="nowinventory" id="nowinventory<?=$i?>" value="<?=$total;?>";>
<input type="hidden" name="georaeCode" id="georaeCode<?=$i?>" value="<?=$mcCode;?>";>

</td>
<td class="organisationname">
<? echo "�������(Box)����:"?><?=$p[3].'BOX'?><input type="text" name="z" id="z<?=$i?>" value="<?=$p[3]?>"style="width:100%;"></td>
<td  class="organisationname"><? echo "1��"?><input type="number" name="a" id="a<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<?=$row['Mnowsu']?>" style="width:100%;"><? echo "����"?><input type="text" name="d" id="d<?=$i?>" value="<?=$p[0]?>" style="width:100%;"><? echo '�ڽ�'; echo "(".$ipsu[$i].")"?><input type="text" name="b" id="b<?=$i?>" value="<?=$p[1]?>" style="width:100%;">
<? echo "��"?><input type="text" name="c" id="c<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<?=$p[2]?>" style="width:100%;"><input type ="button" name="button1" value="���������" onClick ="aa(<?=$cal?>,<?=$i?>,<?=$ipsu[$i];?>);">
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
   <input type ="button" name="button2" value="�ʱ�ȭ������" style="width:100%" onClick ="a3('<?=$calimsi?>')"> 
 </td>


</tr>
</form>

</html>