<!DOCTYPE html> 
<html>
<meta http-equiv="Content-Type" content="text/html;charset=euc-kr;">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1;">
<head>
	<title>�������������� ���α׷�</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
	<link rel="stylesheet" type="text/css" href="mh.css" />
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <!-- jQuery�� Postcodify�� �ε��Ѵ� -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="//d1p7wdleee1q2z.cloudfront.net/post/search.min.js"></script>
	 
	<!-- ������ ������ <div>�� �˻� ����� ǥ���ϰ�, ����� �Է��� <input>��� �����Ѵ� -->
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
			<h1>�ù� ���� �Է�</h1>
		</div>
		<div data-role="content">
			<h2>��������ϱ�</h2>
			<form action="invoiceinput_post.php" method="post">
				<div data-role="fieldcontain"> 
					<label for="name">�ŷ�ó��</label>    
				    <input type="text" id="name" name="geoName" value=""/>
				</div>
				
				<div data-role="fieldcontain"> 
				    <label for="name">�ּ�</label>
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
					<label for="name">����</label>
					<input type="text" id="surang" name="surang" value="1"/>
				</div>
				<div data-role="fieldcontain">
				<!-- data-type="horizontal" : ��ġ���� ���� "vertical" : ��ġ���� ����  -->
					<fieldset data-role="controlgroup" data-type="horizontal">
					  <legend>��������</legend>
					  <!-- Ÿ���� checkbox��-->
					  <select name="type" id="type" name ="type" data-native-menu="false" multiple="multiple">
						  <option value="030" selected>�ſ�</option>
						  <option value="020">����</option>
						  <option value="010">����</option>
					  </select>
					</fieldset>
				</div>
				<div data-role="fieldcontain">
				 	<label for="textarea1">ǰ���</label> 
				 	<textarea rows="8" cols="50" id="textarea1" name="textarea1">��ǰ</textarea>
				</div>
				<div data-role="fieldcontain">
				 	<label for="textarea2">��۸޼���</label> 
				 	<textarea rows="8" cols="50" id="textarea2" name="textarea2">����� ��ȭ��Ź�帳�ϴ�.</textarea>
				</div>
				<div style="text-align:center">
				<!--  data-inline: true = �ζ��� ��ҷ� ������� -->
					<input type="reset" value="���" data-icon="delete" data-inline="true"/>
					<input type="submit" value="����"  data-icon="arrow-r" data-inline="true" />
				</div>
			</form>
		</div>
	</div>
</body>
