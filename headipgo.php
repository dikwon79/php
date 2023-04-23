<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>이안 로지스</title>


<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap cdn 설정 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="excel.min.js"></script>
</head>

<!-- datetimepicker플러그인  -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-datepicker.css">
<link rel="stylesheet" media="print" href="common.css">
<link rel="stylesheet" href="bootstrap/css/iaan.css">
<script src="ianexcel.js"></script>  
<script>

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

            <li id="label"><a href="3pl.php">재고장</a></li>
		
            
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
    <li id="label"><a href="../printLabel.php">라벨발행</a></li>
    <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                  aria-expanded="false">조회<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="https://dikwon79.cafe24.com/georae.php">거래처정보</a></li>
					<li><a href="https://dikwon79.cafe24.com/ipgolist.php">입고조회</a></li>
					<li><a href="https://dikwon79.cafe24.com/ipgodetail.php">입고현황</a></li>
                    <li><a href="https://dikwon79.cafe24.com/iteminfo.php">품목정보</a></li>
					<li><a href=".https://dikwon79.cafe24.com/checktodaywork.php">출고검증</a></li>
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
                    li><a href="https://dikwon79.cafe24.com/index.php">사용자정보</a></li>
                    <li><a href="https://dikwon79.cafe24.com/setting.php">라벨및셋팅</a></li>
					<li><a href="https://dikwon79.cafe24.com/upload_black.php">블랙리스트</a></li>
					<li><a href="https://dikwon79.cafe24.com/upload_georae.php">거래처업로드</a></li>
					<li><a href="https://dikwon79.cafe24.com/upload_center.php">센터업로드</a></li>
					<li id="upload"><a href="https://dikwon79.cafe24.com/input.php">업로드</a></li>
					<li><a href="https://dikwon79.cafe24.com/Confirmedkey.php">재고확정키</a></li>
                  </ul>
            </li>
		
			<li id="label"><a href="printLabel.php">라벨발행</a></li>
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
					<div class="https://dikwon79.cafe24.com/dropdown-divider"></div>
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


