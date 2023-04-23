<?
//adodb library 불러오기
include('adodb/adodb.inc.php');
//DB연결
$conn = ADONewConnection('mysqli'); # 예 'mysql' 또는 'postgres'
$conn->Connect('localhost', 'dikwon79', 'ab0612abcD!', 'dikwon79');
                   //서버                    데이터베이스명
?>