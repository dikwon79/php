<!DOCTYPE html> 
<html>
<meta http-equiv="Content-Type" content="text/html;charset=euc-kr;">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
<head>
	<title>이안재고조사 프로그램</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
   
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <script> 
    var userAgent = navigator.userAgent.toLowerCase(); // 접속 핸드폰 정보 
    
	
    // 모바일 홈페이지 바로가기 링크 생성 
	/*if(userAgent.match('iphone')) { 	
		document.write('<link rel="apple-touch-icon" href="/png" />') 
	} else if(userAgent.match('ipad')) { 
		document.write('<link rel="apple-touch-icon" sizes="72*72" href="" />') 
	} else if(userAgent.match('ipod')) { 
		document.write('<link rel="apple-touch-icon" href="" />') 
	} else if(userAgent.match('android')) { 
		document.write('<link rel="shortcut icon" href="" />') 
	} 
		

*/
	</script>
   
   
</head>

<?   
     include('mobiledbcon.php');

     $today = date('Y-m-d',time()); 
     $query = "SELECT inventory FROM iteminfo GROUP BY inventory order by inventory asc ";
	 $result = $db->query($query);	 
     $num_results = $result->num_rows;

?>
<body>

   
  <h1><center>이안 모바일 재고조사</center></h1>
  <div class="ui-body-d ui-content" id="one">
  <div role="main" class="ui-content">
   <form method='post' action='ianpost.php'> 
   <fieldset data-role="controlgroup">
    <legend>날짜입력</legend>
    <label for="select-native-5">파트</label>
    <p><input type="date" id="cal" name="cal" data-role="date" data-inline="true" value='<?=$today?>'></p>
   </fieldset>
   <fieldset data-role="controlgroup">
    <legend>조건검색:</legend>
    <label for="select-native-5">파트</label>
    <select name="Combo2" id="select-native-5">
        <option value="#">재고담당구역</option>
        <?
		 for($i=0; $i<$num_results; $i++)
        {
           $row = $result->fetch_assoc(); 
		   $man = $row['inventory'];  ?>

		 <option value="<? echo $man; ?>"><? echo $man; ?></option>
           
		 <?  
	     }

		?>
    </select>
    <label for="text-1">랙번호</label>
    <input name="search" id="search" type="text">
    </label>
	
	<fieldset data-role="controlgroup">
    <legend>조건:</legend>
    <label for="select-native-5">조사방법</label>
    <select name="lec1" id="lec1">
        <option value="#">조사방법</option>
        <option value="1">전수</option>     
	    <option value="2">출고만</option>
        <option value="3">에러만</option>    
    </select>
    

    </fieldset>
   
     <p>검색버튼 누르세요. <input type='button' value='검색  '  onclick='submit();'></p>    

   </form>

  </div>
  </div>
  
 



<!-- second page -->



</body>
</html>