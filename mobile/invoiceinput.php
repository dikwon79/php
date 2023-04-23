<!DOCTYPE html> 
<html>
<meta http-equiv="Content-Type" content="text/html;charset=euc-kr;">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
<head>
	<title>명현유통송장발행 프로그램</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" type="text/css" href="mh.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <!-- jQuery와 Postcodify를 로딩한다 -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
	 
	<!-- 위에서 생성한 <div>에 검색 기능을 표시하고, 결과를 입력할 <input>들과 연동한다 -->
	<script>
		$(function() { $("#postcodify").postcodify({
        insertPostcode5 : "#postcode",
        insertAddress : "#address",
        insertDetails : "#details",
        insertExtraInfo : "#extra_info",
        hideOldAddresses : false,
	    forceDisplayPostcode5 : true,
    }); });

	</script>
</head>
<body>
	<div data-role="page">
		<div data-role="header">
			<h1>택배 송장 입력</h1>
		</div>
		<div data-role="content">
			<h2>송장발행하기</h2>
			<form action="invoiceinput_post.php" method="post">
				<div data-role="fieldcontain"> 
					<label for="name">거래처명</label>    
				    <input type="text" id="name" name="geoName" value=""/>
				</div>
				
				<div data-role="fieldcontain"> 
				    <label for="name">주소</label>
				    <input type="text" id="postcode" name="postcode" style="width:30% !important" />						 
				</div>	 
				<div data-role="fieldcontain">
					<label for="name"></label>
					<input type="text" id="address" name="address"/>
				</div>
				<div data-role="fieldcontain">
					<label for="name">TEL</label>
					<input type="text" id="tel" name="tel"/>
				</div>
                <div data-role="fieldcontain">
					<label for="name">mobile</label>
					<input type="text" id="mobile"  name="mobile"/>
				</div>
                <div data-role="fieldcontain">
					<label for="name">수량</label>
					<input type="text" id="surang" name="surang" value="1"/>
				</div>
				<div data-role="fieldcontain">
				<!-- data-type="horizontal" : 배치방향 가로 "vertical" : 배치방향 세로  -->
					<fieldset data-role="controlgroup" data-type="horizontal">
					  <legend>지불유형</legend>
					  <!-- 타입이 checkbox임-->
					  <select name="type" id="type" name ="type" data-native-menu="false" multiple="multiple">
						  <option value="030" selected>신용</option>
						  <option value="020">착불</option>
						  <option value="010">선불</option>
					  </select>
					</fieldset>
				</div>
				<div data-role="fieldcontain">
				 	<label for="textarea1">품목명</label> 
				 	<textarea rows="8" cols="50" id="textarea1" name="textarea1">식품</textarea>
				</div>
				<div data-role="fieldcontain">
				 	<label for="textarea2">배송메세지</label> 
				 	<textarea rows="8" cols="50" id="textarea2" name="textarea2">배송전 전화부탁드립니다.</textarea>
				</div>
				<div style="text-align:center">
				<!--  data-inline: true = 인라인 요소로 만들어줌 -->
					<input type="reset" value="취소" data-icon="delete" data-inline="true"/>
					<input type="submit" value="전송"  data-icon="arrow-r" data-inline="true" />
				</div>
			</form>
		</div>
	</div>
</body>
