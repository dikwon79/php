<?php
 //DB����
  include('mobiledbcon.php');
 
 //if(!$itemcode) exit;

 $itemcode=$_GET["itemcode"];
 $nowinventory=$_GET["nowinventory"];

 $fixbox=$_GET["fixbox"];
 $fixea=$_GET["fixea"];
 $dan=$_GET["dan"];
 $ipsu=$_GET["ipsu"];
 $heightcounting=$_GET["heightcounting"];
 $boxcounting=$_GET["boxcounting"];
 $eacounting=$_GET["eacounting"];
 
 $cal=substr($_GET["cal"],0,4).'-'.substr($_GET["cal"],4,2).'-'.substr($_GET["cal"],6,2);

 $today = date("Ymd h:i:s"); 
 
 //�������ڽ�------------------------------------------------------------
 $fixedexp=explode(".",$fixbox);
 $fixedcount=count($fixedexp);
 $fixboximsi=0;
 for ($i=0; $i<$fixedcount; $i++)
 {
   $fixboximsi= $fixboximsi+$fixedexp[$i];
 
 }
 //�������ea------------------------------------------------------------
 $fixedexp=explode(".",$fixea);
 $fixedcount=count($fixedexp);
 $fixeaimsi=0;
 for ($i=0; $i<$fixedcount; $i++)
 {
   $fixeaimsi= $fixeaimsi+$fixedexp[$i];
 
 }


  //����------------------------------------------------------------
 $palet2exp=explode(".",$heightcounting);
 $palet2count = count($palet2exp);
 $heightcountingimsi =0;
 for ($i=0; $i<$palet2count; $i++)
 {
    $heightcountingimsi= $heightcountingimsi+$palet2exp[$i];
 }

 

 //�ڽ��Է� ����---------------------------------------------------
 $boxexp=explode(".",$boxcounting);
 $boxcount = count($boxexp);
 $boxcountingimsi =0;
 for ($j=0; $j<$boxcount; $j++)
 {
   $boxcountingimsi= $boxcountingimsi+$boxexp[$j];
 
 }
  //ea�Էº���---------------------------------------------------
 $eaexp=explode(".",$eacounting);
 $eacount = count($eaexp);
 $eacountingimsi =0;
 for ($k=0; $k<$eacount; $k++)
 {
   $eacountingimsi= $eacountingimsi+$eaexp[$k];
   
 }


 //$name = iconv("EUC-KR", "utf-8",'����:');
 //�ڽ���� ------------------------------------------------------------
 
 $counting1 = $dan*$heightcountingimsi+$fixboximsi+$boxcountingimsi;

 //�������------------------------------------------------------------
 $counting = $fixeaimsi + $eacountingimsi;

 

 //-----------------------------------------------------------------
 $total =$counting1*$ipsu+$counting; 
 $chai = $total- $nowinventory;

 echo $total."(".$chai.")";


 $u1= date("Y"); 



 $query="select * from dailycounting where idate ='$cal' and  itemcode= '$itemcode' ";
 $result = $db->query($query);
 $num_results = $result->num_rows;

 if ($num_results >0) {
    
    $query="delete from dailycounting where idate ='$cal' and  itemcode= '$itemcode' ";;
    $result = $db->query($query); 
   
    }
    $sql = "insert into dailycounting (idate, itemcode, fixbox ,fixea, countdan, countheight, countBox, countEa, SURANG) values ";


    $sql .= "('$cal','$itemcode','$fixbox','$fixea','$dan','$heightcounting','$boxcounting','$eacounting','$total')";  
    
 
 
    //������ ����� ó���Ǵ� �� ����.
    $db->query($sql);
    $db->close();

  
 //else�� ��
 
?>  