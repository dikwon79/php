 <?php

    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==3) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 

 
    include('headitem.php');
?>

<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 대용량 업로드</h1><hr>
    </div>
<div class="row">

    <table class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th>프로그램명</th>  
            <th>다운주소</th>
            
        </tr>  
        </thead>  
  
			<tr>  
			<td>이안 대용량 업로드 프로그램(new버젼)</td> 
			<td><a href=./down/excelUp.exe>다운로드</a></td>		
			</tr> 
			<tr>  
			<td>이안 라벨인쇄 세팅파일(제일먼저 설치)</td> 
			<td><a href=./down/labelsetting.zip>다운로드</a></td>		
			</tr>
			<tr>  
			<td>이안 라벨인쇄 </td> 
			<td><a href=./down/iaanlogis.exe>다운로드</a></td>		
			</tr>
			<tr>  
			<td>품목정보 샘플</td> 
			<td><a href=./down/iteminfo.xls>다운로드</a></td>		
			</tr> 
			<tr>  
			<td>데일리 업로드자료</td> 
			<td><a href=./down/dailyupload.xls>다운로드</a></td>		
			</tr> 
        </table>  
</div>

</body>
</html>