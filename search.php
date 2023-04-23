<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>검색</title>

<link rel="stylesheet" href="bootstrap/css/iaan.css">
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap cdn 설정 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
 
	function goAction(val1,val2){

	//window.opener.document.board_form.market_name.value = val;
    opener.document.getElementById("georae").value = val1; //일반적인 방법
	opener.document.getElementById("georaename").value = val2; //일반적인 방법
   
    opener.window.aa(val1); //<--부모창 함수 실행
    opener.document.getElementById('row_code1').focus();

	self.close();

//	window.close();

	}

</script>



</head>
<?php

    include('dbcon.php'); 
    //include('check.php');
   	
	$geoname = $_GET['geoname'];


	?>

<div class="container">
	
   
   <div class="row">
   

	
    <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
		    <th>거래처코드</th> 
            <th>거래처명</th> 
			<th>키워드검색</th>  
           
			
			
        </tr>  
        </thead>  
  
        <?php  
	   
		$sql = "SELECT geocode,geoname,labeltype from geoinfo where geoname like '%$geoname%' ";
	    
		
		$stmt = $con->prepare($sql);
	
	    $stmt->execute();
 
	    if ($stmt->rowCount() > 0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	        {
		    extract($row);
    


		if ($username != 'admin'){
		?>  
			<tr>  
			<td><a href='#' onClick='goAction("<?=$geocode?>","<?=$geoname?>")'><?=$geocode?></a></td>
			<td><a href='#' onClick='goAction("<?=$geocode?>","<?=$geoname?>")'><?=$geoname?></a></td>
			<td><a href='#' onClick='goAction("<?=$geocode?>","<?=$geoname?>")'><?=$labeltype?></a></td>
			
			
			</tr>
		
        <?php
			}
                }
             }
        ?>  
        </table>  
</div>

</body>
<div id='control' class="control">
    <button id="btnPrint" type="button" class="btn btn-default">신규</button>
	<button id="close" type="button" class="btn btn-default">닫기</button>
   
</div>
</html>