<?php
 
  
 //DB연결
 
 
 include('dbcon.php');
  
 $mgarage=$_GET["mgarage"];
 $mcode=$_GET["mcode"];
 
 $mname=$_GET["mname"];

 //$mname=iconv("EUC-KR", "utf-8",trim($_GET["mname"]));
 
 $zone1=$_GET["zone1"];
 $zone2=$_GET["zone2"];
 $zone3=$_GET["zone3"];
 $zone4=$_GET["zone4"];
 $a=$_GET["a"];
 $b=$_GET["b"];
 $zone=$zone1."-".$zone2."-".$zone3.$zone4;


 $today = date("Ymd h:i:s");
 $today2 = date("Ymd"); 
 
  echo $zone;
 //echo $total."(".$chai.")";

 
 
 $u1= date("Y"); 

 $u3= 'admin';

 
 $rs = $conn->Execute("select MCODE from Miteminfo  where MCODE= '$mcode'");
 if ($rs->fields[0] == 0) {
   $rs->close(); 
   $as = $conn->Execute("select MAX(pid) from Miteminfo  where substr(pid,1,4)='$u1' ");
    if ($as->fields[0] == 0)
    {$smx= $u1."00000001";}
    else
    {$smx= $as->fields[0] + 1;}
    $as->close();

    $sql .= "insert into Miteminfo  (PID, MDATE, MCharger, MCODE, MNAME, MZONE, Mnowsu, Mipsu, MainCenter, MinputDate) values ";


    $sql .= "('$smx','$today2','admin','$mcode','$mname','$zone','$a','$b','$mgarage','$today')";  
    
 
 }
 else{
       
	   
       
	   //$data=$data.$rs->fields[0];
	   $conn->Execute("update Miteminfo set MDATE='$today2', MainCenter='$mgarage' , MCODE='$mcode',MNAME='$mname',MZONE='$zone',Mnowsu='$a',Mipsu='$b' where MCODE = '$mcode'");
	   echo "success";
     
	 }
    //웹에서 실행시 처리되는 것 방지.
    $conn->debug = false;
    $conn->Execute($sql);

    

    $conn->close();
 //else문 끝

?>  