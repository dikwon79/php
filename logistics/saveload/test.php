<?php 
//DB연결
include('dbcon.php');


//클라이언트로 부터 넘어온 변수값
 $data= trim($_POST[data]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'일련번호 구분코드 
 $s0= trim($_POST[s0]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //'일련번호 구분코드 
 $s1= trim($_POST[s1]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //입력날짜 
 //$s2= trim($_POST[s2]); //iconv("EUC-KR", "utf-8",trim($_POST[s7])); //입력날짜 
 





 //웹 실행 방지 
 if ($s0!='ian09') {  
    exit;  
 }

  
 //$data = '23/34/5/6/7/8/9/0/';
 $data2 = explode('<k>',$data);
 
 
 $u1 = substr($s1,0,4);

 
 $stmt = $con->Execute("select * from iteminfo where substr(id,1,4)='$u1' order by id desc");
 $stmt->execute();

 if ($stmt->rowCount() > 0)
 {
	
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);

	$smx= $row['max(id)'] +1;
    		 
 }
 else{

	$smx= $u1."00000001";
 }


 $listvalue=array();

  for ($k=0; $k<count($data2)-1; $k++)
 {
    $data3 = explode ('<z>', $data2[$k]);
	
	

	$list=array($smx,$s1,trim(addslashes($data3[0])),trim(addslashes($data3[1])),trim(addslashes($data3[2])));
	
	
    array_push($listvalue,$list);
	$smx++;
 }



$args = array_fill(0, count($listvalue[0]),'?');



//print_r($listvalue);

$query = "INSERT INTO nowinven(id, idate, itemcode, out, nowstock) VALUES (".implode(',',$args).")";

$stmt= $con->prepare($query);

foreach($listvalue as $row){
   if($stmt->Execute($row)) {
      echo '저장';
   }

}
				 


?>




<?php

    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==1)
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
    include('head.php');

?>

<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 재고장</h1><hr>
    </div>
   
   <div class="container"><form class="navbar" role="search" method='post' action='paperofinventory.php'>
       
       <div class="col-sm-3"><input type="text" id="datePicker" name="nDate" class="form-control" value="<? echo date("Y-m-d");?>"></div>
       <div class="col-sm-2">
	        
			<select name="stype" class="form-control">
			  <option>전체</option>
			  <option>품목코드</option>
			  <option>품목명</option>
			  <option>업체명</option>
			  <option>재고조사담당</option>
			</select>
		   
	   </div>
	   <div class="col-sm-4"><input type="text" name="search2" class="form-control" placeholder="Search"></div>
	   <div class="col-sm-3"><button type="submit" class="btn btn-default">검색</button></div>
   </form>           
   </div>
   
   <div class="row">
   

	
    <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th>품목코드</th>  
            <th style=width:300px>품목명</th>
            <th>렉번호</th>
            <th>업체명</th> 
            <th>출고량</th>
			<th>현재고</th>
            <th>재고담당</th>
			<th>실사</th>
			<th>차이</th>
			
        </tr>  
        </thead>  

  
        <?php  
	    $stmt = $con->prepare('SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:search_idate');
        $stmt->bindParam(':search_idate',$nDate);



	    $stmt->execute();

            if ($stmt->rowCount() > 0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	       
		    extract($row);
       
		if ($username != 'admin'){
		?>  
			<tr>  
			<td><?php echo $itemcode;  ?></td> 
			<td><?php echo iconv("EUC-KR", "utf-8",$itemname );  ?></td>
			<td><?php echo $lek; ?></td> 
			<td><?php echo iconv("EUC-KR", "utf-8",$inventory ); ?></td>
			
			<td><?php echo $outstock; ?></td>
			<td><?php echo $nowstock; ?></td>
			<td><?php echo  iconv("EUC-KR", "utf-8",$inventory ); ?></td>
			<td>실사</td> 
			<td>차이</td>
			</tr>
		
        <?php
			}
                }
             }
        ?>  
        </table>  
</div>

</body>
</html>