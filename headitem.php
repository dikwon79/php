<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>이안 로지스</title>
<!-- Bootstrap cdn 설정 -->
<!--
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="../bootstrap/css/font.css">
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>

-->


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


<script src="../excel.min.js"></script>
</head>

<!-- datetimepicker플러그인  -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-datepicker.css">
<link rel="stylesheet" media="print" href="../common.css">
<link rel="stylesheet" href="../bootstrap/css/iaan.css">
<script src="../ianexcel.js"></script>  
<script src="../bootstrap/js/bootstrap-datepicker.js"></script>
<script>
	$(function() {	
		$('#datePicker').datepicker({
		    format: "yyyy-mm-dd",	//데이터 포맷 형식(yyyy : 년 mm : 월 dd : 일 )
		    starDate: '-30y',	//달력에서 선택 할 수 있는 가장 빠른 날짜. 이전으로는 선택 불가능 ( d : 일 m : 달 y : 년 w : 주)
		    endDate: '+30y',//달력에 선택 할 수 있는 가장 느린 날짜. 이후로 선택 불가 ( d : 일 m : 달 y : 년 w : 주)
		    autoclose : true,	//사용자가 날짜를 클릭하면 자동 캘린더가 닫히는 옵션
		    calendarWeeks : false, //캘린더 옆에 몇 주차인지 보여주는 옵션 기본값 false 보여주려면 true
		    clearBtn : false, //날짜 선택한 값 초기화 해주는 버튼 보여주는 옵션 기본값 false 보여주려면 true
		    datesDisabled : ['2019-06-24','2019-06-26'],//선택 불가능한 일 설정 하는 배열 위에 있는 format 과 형식이 같아야함.
		    daysOfWeekDisabled : [6],	//선택 불가능한 요일 설정 0 : 일요일 ~ 6 : 토요일
		    daysOfWeekHighlighted : [3], //강조 되어야 하는 요일 설정
		    disableTouchKeyboard : false,	//모바일에서 플러그인 작동 여부 기본값 false 가 작동 true가 작동 안함.
		    immediateUpdates: false,	//사용자가 보는 화면으로 바로바로 날짜를 변경할지 여부 기본값 :false 
		    multidate : false, //여러 날짜 선택할 수 있게 하는 옵션 기본값 :false
		    multidateSeparator :",", //여러 날짜를 선택했을 때 사이에 나타나는 글짜 2019-05-01,2019-06-01
		    templates : {
		        leftArrow: '&laquo;',
		        rightArrow: '&raquo;'
		    }, //다음달 이전달로 넘어가는 화살표 모양 커스텀 마이징 
		    showWeekDays : true ,// 위에 요일 보여주는 옵션 기본값 : true
		    title: "이안캘린더",	//캘린더 상단에 보여주는 타이틀
		    todayHighlight : true ,	//오늘 날짜에 하이라이팅 기능 기본값 :false 
		    toggleActive : true,	//이미 선택된 날짜 선택하면 기본값 : false인경우 그대로 유지 truj,jm,.0,0je0.j,인 경우 날짜 삭제
		    weekStart : 0 ,//달력 시작 요일 선택하는 것 기본값은 0인 일요일 
		    language : "en"	//달력의 언어 선택, 그에 맞는 js로 교체해줘야한다.
		    
		});//datepicker end
	});//ready end

   $(document).ready(function() {
		var url = location.href;
		var getAr0 = url.indexOf("admin");
	    var getAr1 = url.indexOf("iteminfo");
	    var getAr2 = url.indexOf("input");
	    var getAr3 = url.indexOf("inventory");
	    
	    
		if(getAr0 != -1) {
	        $("#main").addClass("active");
	    }
	    if(getAr1 != -1) {
	        $("#item").addClass("active");
	    }
	    if(getAr2 != -1) {
	        $("#upload").addClass("active");
	    }
		if(getAr3 != -1) {
	        $("#inventory").addClass("active");
	    }

		
	    
        $("[id^=boxea]").hide();

       
		
	});	
		   
 

	

</script>
<!--<script src="bootstrap/js/di.js"></script> -->
<style>
    .col-sm-6 { padding-top : 8px; }
	label {

    font: normal 16px courier !important;
    
}


</style>
</head>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/3pl.php">이안로지스</a>
			<ul class="nav navbar-nav">
<? if (trim($_SESSION['is_admin'])=='0'){  ?>
            <li><a href="https://dikwon79.cafe24.com/3pl.php">재고장</a></li>
             
		
            
			<?php if (isset($_SESSION['user_id'])) { ?>
                <li style="align="right"><a href=""><?php echo $_SESSION['user_id']; ?>으로 로그인</a></li>
                <li align="right"><a href="https://dikwon79.cafe24.com/logout.php">Log Out</a></li>
            <?php } else { ?>
                <li align="right"><a href="https://dikwon79.cafe24.com/index.php">Login</a></li>
             <?php } ?>
			</ul>

<?
}
else if (trim($_SESSION['is_admin'])=='1'){  ?>
     <li><a href="https://dikwon79.cafe24.com/3pl.php">재고장</a></li>
             
		
            
			<?php if (isset($_SESSION['user_id'])) { ?>
                <li style="align="right"><a href=""><?php echo $_SESSION['user_id']; ?>으로 로그인</a></li>
                <li align="right"><a href="https://dikwon79.cafe24.com/logout.php">Log Out</a></li>
            <?php } else { ?>
                <li align="right"><a href="https://dikwon79.cafe24.com/index.php">Login</a></li>
             <?php } ?>
			</ul>
     
					              
<?
}
else if (trim($_SESSION['is_admin'])=='2'){  ?>
    <li id="label"><a href="https://dikwon79.cafe24.com/printLabel.php">라벨발행</a></li>
    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">조회<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://dikwon79.cafe24.com/georae.php">거래처정보</a></li>
					<li><a href="https://dikwon79.cafe24.com/ipgolist.php">입고조회</a></li>
					<li><a href="https://dikwon79.cafe24.com/ipgodetail.php">입고현황</a></li>
                    <li><a href="https://dikwon79.cafe24.com/iteminfo.php">품목정보</a></li>
					<li><a href="https://dikwon79.cafe24.com/checktodaywork.php">출고검증</a></li>
					<li><a href="https://dikwon79.cafe24.com/chulgolist.php">업장출고내역</a></li>
                  </ul>
             </li>
    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">입력<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://dikwon79.cafe24.com/ipgo.php">입고입력</a></li>
                    <li><a href="https://dikwon79.cafe24.com/chulgo.php">출고입력</a></li>
                  </ul>
             </li>
	 <li><a href="https://dikwon79.cafe24.com/3pl.php">재고장</a></li>
			 <!--
	<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">재고장<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                  
					<li><a href="https://dikwon79.cafe24.com/3pl.php">3pl</a></li>
                   
                  </ul>
             </li>	
           -->

<?
}
else{




?>

			<li id='main' class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">관리자모드<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://dikwon79.cafe24.com/index.php">사용자정보</a></li>
                    <li><a href="https://dikwon79.cafe24.com/setting.php">라벨및셋팅</a></li>
					<li><a href="https://dikwon79.cafe24.com/admin_black.php">블랙리스트</a></li>
					<li><a href="https://dikwon79.cafe24.com/upload_georae.php">거래처업로드</a></li>
					<li><a href="https://dikwon79.cafe24.com/upload_center.php">센터업로드</a></li>
                    <li><a href="https://dikwon79.cafe24.com/upload_01day.php">월초일괄업로드</a></li>
					<li id="upload"><a href="https://dikwon79.cafe24.com/input.php">업로드</a></li>
                    <li><a href="https://dikwon79.cafe24.com/Confirmedkey.php">재고확정키</a></li>
                 
                  </ul>
            </li>
			
			<li id="label"><a href="https://dikwon79.cafe24.com/printLabel.php">라벨발행</a></li>
			<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">조회<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://dikwon79.cafe24.com/georae.php">거래처정보</a></li>
					<li><a href="https://dikwon79.cafe24.com/ipgolist.php">입고조회</a></li>
					<li><a href="https://dikwon79.cafe24.com/ipgodetail.php">입고현황</a></li>
                    <li><a href="https://dikwon79.cafe24.com/iteminfo.php">품목정보</a></li>
					<li><a href="https://dikwon79.cafe24.com/checktodaywork.php">출고검증</a></li>
					<li><a href="https://dikwon79.cafe24.com/chulgolist.php">업장출고내역</a></li>
                  </ul>
             </li>
			<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">입력<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                   
                    <li><a href="https://dikwon79.cafe24.com/ipgo.php">입고입력</a></li>
                    <li><a href="https://dikwon79.cafe24.com/chulgo.php">출고입력</a></li>
					  <li role="separator" class="divider"></li>
                    <li><a href="https://dikwon79.cafe24.com/onestopipgo">입고일괄업로드</a></li>
                    <li><a href="https://dikwon79.cafe24.com/onestopchulgo">출고일괄업로드</a></li>
                  </ul>
             </li>
			
			
		
			
			
				
			
			<!--<li id="item"><a href="iteminfo.php">품목정보</a></li>      -->
             <li><a href="https://dikwon79.cafe24.com/3pl.php">재고장</a></li>
			 <!--
	<li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">재고장<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                  
					<li><a href="https://dikwon79.cafe24.com/3pl.php">3pl</a></li>
                   
                  </ul>
             </li>	
           -->
		
            
			<?php if (isset($_SESSION['user_id'])) { ?>
                <li style="align="right"><a href=""><?php echo $_SESSION['user_id']; ?>으로 로그인</a></li>
                <li align="right"><a href="https://dikwon79.cafe24.com/logout.php">Log Out</a></li>
            <?php } else { ?>
                <li align="right"><a href="https://dikwon79.cafe24.com/index.php">Login</a></li>
             <?php } ?>
			</ul>



			<? }?>
        </div>
    </div>
</nav>


