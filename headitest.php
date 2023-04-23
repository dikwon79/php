<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>명현유통</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/iaan.css">
<script src="bootstrap/js/bootstrap.min.js"></script>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script src="excel.min.js"></script>

</head>

<!-- datetimepicker플러그인  -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-datepicker.css">
<script src="ianexcel.js"></script>  
<script src="bootstrap/js/bootstrap-datepicker.js"></script>
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
    .col-sm-4 { padding-top : 5px; }
</style>
</head>

<body>
<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">명현유통</a>
			<ul class="nav navbar-nav">
            <li id="main"><a href="../index.php">사용자정보</a></li>
			<li id="upload"><a href="input.php">업로드</a></li>
			<li id="item"><a href="iteminfo.php">품목정보</a></li>      
            <li id="inventory"><a href="paperofinventory.php">재고장</a></li>
		
            
			<?php if (isset($_SESSION['user_id'])) { ?>
                <li style="align="right"><a href=""><?php echo $_SESSION['user_id']; ?>으로 로그인</a></li>
                <li align="right"><a href="logout.php">Log Out</a></li>
            <?php } else { ?>
                <li align="right"><a href="index.php">Login</a></li>
             <?php } ?>
			</ul>
        </div>
    </div>
</nav>
