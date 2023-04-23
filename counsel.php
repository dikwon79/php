
<!DOCTYPE html>
<html>
<head>

<style>

.logo_wrapper {
	position: relative;
	margin: 0 auto;
	padding: 10px 0;
	width: 956px;
/*	zoom: 1;*/
}

table {
	margin : 0 auto;
/*	width : 50%;
	height : 50%;*/
	border-top : 3px solid gray;
	
	
}

th {
	background: #EAEAEA;
	padding : 10px;
	width : 180px;
	color : #000;
	font-size:14px;
	border-bottom: 1px solid #BDBDBD;
	text-align:left;
	
}

td{
	border-bottom: 1px solid #BDBDBD;
	
	
}

tr{
	width : 400px;
}

span{
	color:#ff0000;
}

font {
	color:#8C8C8C;
}

nopadd{
	padding : 0px;
}

.main_div{
	
	
}

.title {
	font-size: 35px;
	font-weight : bold;
	color :#6B66FF;
	
	
}

.title_sub {
	color :#785D12;
	margin-top: -20px;
	
}

.input_width{
	width : 300px;
	height : 30px;
}

.main_img{width:930x; margin-top: 40px; margin-bottom:20px;margin-left: 478px; }


.btn_submit {width : 150px; margin:10px;padding:15px;border:0;background:#003399;color:#FFF;cursor:pointer; font-size: 18px; font-weight:bold; font-family:"맑은 고딕"}
.textalign_center{ text-align: center;}


</style>

</head>
<body>
	<form name="fcounselfom" id="fcounselfom" action="banner_update.php" method="post" onsubmit="return submitOk();">
		<input type="hidden" id="mon" name="mon" value="2" />

		<div class="main_div">
			<div class="logo_wrapper">
				<img src="/img/logo_pc.png">
			</div>
			<table>
				<tr>
					<th><span>*</span> 성함</th>
					<td><input type="text" id="name" name="name" class="input_width"/></td>
				</tr>
				<tr>
					<th><span>*</span> 휴대폰번호</th>
					<td><input type="number" id="cell" name="cell" class="input_width"/> '-' 제외하고 숫자만 입력해주세요.</td>
				</tr>
				<!--<tr>
					<th><span>*</span> 자료받으실 E-mail</th>
					<td><input type="text" name="email" class="input_width"/> <font size="2">매매기법 노하우가 담긴 강의자료를 보내드립니다.</font></td>
				</tr>-->
				<tr>
					<th>카페닉네임</th>
					<td><input type="text" name="nickname" class="input_width"/></td>
				</tr>
				<!--<tr>
					<th><span>*</span> 투자금액범위</th>
					<td>
						<select name="investRange" class="input_width">
							  <option value="">선택하세요</option> 
							  <option value="1">1000만원 미만</option>
							  <option value="2">1000만원~2500만원 미만</option>
							  <option value="3">2500만원~5000만원</option>
							  <option value="4">5000만원 이상</option>
						</select>
					</td>
				</tr>-->
				<tr>
					<th>상담내용</th>
					<td><textarea rows="14" cols="105"  name="content"></textarea></td>
				</tr>
				<tr>
					<td colspan="2" class="textalign_center"><input type="submit" value="상담신청" class="btn_submit"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
<span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></td>
				</tr>
				
			</table>
		</div>
	
		
	</form>	
</body>
<script>

function submitOk(){
	var name = document.getElementById("name").value;
	var cell = document.getElementById("cell").value;
	
	if (name==null || name=="") {
		alert("성함을 입력해주세요.");
		return false;
	}

	if (cell==null || cell=="") {
		alert("휴대폰번호를 입력해주세요.");
		return false;
	}

	alert('상담이 신청되었습니다.');
}

</script>


</html>