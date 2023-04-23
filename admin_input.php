
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>신규 블랙리스트 입력</title>
<style>
@charset "UTF-8";
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR&display=swap');

body {
	margin: 0 auto;
	text-align: center;
	font-size: 16px;
	font-family: 'Noto Sans KR', sans-serif;
}

a:link, a:visited {
	text-decoration: none;
	color: #000;
}

#content {
	padding: 20px 0;
	min-width: 1024px;	/* 창의 최소 크기 지정 */
}

img {
	vertical-align: middle;	/* 세로축 가운데 정렬 */
}

table {
	width: 80%;
	margin: 0 auto;
	border: 1px solid;
	border-collapse: collapse;	/* 테두리 겹침 설정 collapse: 겹치지 않게 처리 */
}

table th, table td {
	border: 1px solid;
	padding: 5px 10px;
}

table td a:hover { font-weight: bold; }

.btnSet { margin-top: 20px;	}

a.btn-fill, a.btn-empty {
	text-align: center;
	padding: 3px 10px;
	border:1px solid #3367d6;
	border-radius: 3px;
	box-shadow: 2px 2px 3px #022d72;
	/* 오른쪽, 아래쪽, 번진 정도 */
}

a.btn-fill { 
	background-color: #3367d6;
	color: #fff;
}

a.btn-empty { 
	background-color: #fff;
	color: #3367d6
}

.btnSet a:not(:first-child) {
	margin-left: 3px;
}

a:hover { cursor:pointer; }

input {
	height: 32px;
	padding: 3px 5px;
	font-size: 15px;
}
select {
	height : 32px;
	font-size: 15px;
	padding :2px 10px;


}
input[type=radio] {
	width: 18px;
	margin: 0 5px 3px;
	vertical-align: middle;
}

table tr td label:not(:last-child) {
	margin-right: 20px;	
}

.w-pct60 { width: 60% }
.w-pct70 { width: 70% }
.w-pct80 { width: 80% }
.w-px40 { width: 40px }
.w-px60 { width: 60px }
.w-px80 { width: 80px }
.w-px100 { width: 100px }
.w-px120 { width: 120px }
.w-px140 { width: 140px }
.w-px160 { width: 160px }
.w-px180 { width: 180px }
.w-px200 { width: 200px }

</style>
<script>
	function check() {

	  if(form.kind.value == "") {

		alert("블랙종류를 입력해주세요.");

		form.kind.focus();

		return false;

	  }

	  else if(form.name.value == "") {

		alert("블랙명 or 코드을 입력해 주세요.");

		form.name.focus();

		return false;

	  }

	  else return true;

	}



</script>

</head>
<body>
<?  
    if(isset($_GET['id'])) $id = $_GET['id'];
   
	try { 
			$stmt = $con->prepare('select * from black_list where pid=:id');
			$stmt->bindParam(':id', $id);
			$stmt->execute();

	   } catch(PDOException $e) {
			die("Database error: " . $e->getMessage()); 
	   }

	   $row = $stmt->fetch();
	   $numberofrows = $stmt->rowCount();

	   //echo $numberofrows;

?>

<div id="content">
	<h3>블랙리스트 입력 </h3>
	<form name="form" action="admin_input_post.php" method="post" onsubmit="return check()">
		<table class='w-pct60'>
			<input type='hidden' name='id' value='<?=$id?>'>
			<tr>
				<th class='w-px200'>블랙종류</th>
			
				<td><select name='kind'>
					  <option value='' selected>-- 선택 --</option>
					  <option value='yeop' <? if($row['kind']=='yeop') echo 'selected';?>>업장명</option>
					  <option value='D1' <? if($row['kind']=='D1') echo 'selected';?>>D1</option>
					  <option value='D2' <? if($row['kind']=='D2') echo 'selected';?>>D2</option>
					</select>
					
				</td>

			</tr>
			
		
			<!--
			<tr>
				<th>블랙명</th>
				<td>
					<label><input type="radio" name="gender" value="남" checked/>남</label>
					<label><input type="radio" name="gender" value="여" />여</label>
				</td>
			</tr>

			-->
			<tr>
				<th>블랙명 or 코드</th>
				<td><input type="text" name="name" value="<?=$row['name']?>" /></td>
			</tr>
			
		</table>
	</form>
	
	<div class="btnSet">
	    
		<a class="btn-fill"  onclick="$('form').submit()">저장</a>
		<a class="btn-empty" href="admin_black.php">취소</a>
	</div>
</div>
</body>
</html>
