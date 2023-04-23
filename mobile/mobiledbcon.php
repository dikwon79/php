<? @$db = new mysqli('localhost', 'dikwon79', 'ab0612abcD!@', 'dikwon79');

	
    
	 //DB에 연결할 때 에러가 발생할 경우 출력

	 if(mysqli_connect_errno())

	 {
		 echo '에러: 데이터베이스에 연결 할 수 없습니다.';
		 exit;
	 }
   
?>