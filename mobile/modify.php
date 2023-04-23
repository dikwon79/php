<!DOCTYPE html>
<script type="text/javascript">

function modi()
{
   if (form1.mcode.value=="")
   {
	   alert("상품코드를 입력해주세요");
	   form1.mcode.value="";
	   form1.mcode.focus();
	   return false;
   }
   var xmlhttp=new XMLHttpRequest();
   var inameD= "side";
  
   xmlhttp.open("GET","modify_inc.php?mcode="+document.getElementById("mcode").value+"&mname="+document.getElementById("mname").value+"&zone1="+document.getElementById("zone1").value+"&zone2="+document.getElementById("zone2").value+"&zone3="+document.getElementById("zone3").value+"&zone4="+document.getElementById("zone4").value+"&a="+document.getElementById("a").value+"&b="+document.getElementById("b").value,false);
   xmlhttp.send(null);
   
   //if (xmlhttp.responseText=="sucess")
  // {
  //   alert("저장하였습니다.");
  // }
  // else alert("에러");
   document.getElementById(inameD).innerHTML=xmlhttp.responseText;;

}
</script>

<head>
<title>@media query</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />

<style>
#header, #footer, #side {background-color:#FFE08C;}
#header{margin-bottom:10px;}
a#menu{text-decoration:none;display:none;}


#nav{ padding:0; margin:4;display:inline;}
#nav li{display:inline;}
 
#contents {min-height: 400px; width: 80%; background: #E4F7BA;float:left;}

#side {min-height: 400px;}
#footer {margin-top: 10px;}
 


@media screen and (max-width: 480px) 
{
#nav{display:none;}
a#menu{display:inline;} 
a#menu:hover + #nav{display:inline;} 
#contents { width: auto; float: none; min-height: 200px;margin-bottom: 10px;}

#side { width: auto; min-height: 0;}
}
</style>
 
<link rel="stylesheet" type="text/css" href="mobile.css">
</head>

<body>
 
<?
 include('dbcon.php');
 

 $code=$_GET["code"];
 $nowinventory=$_GET["nowinventory"];
 $today = date("Ymd h:i:s"); 
  
 $rs = $conn->Execute("select MCODE, MNAME, MUNIT, Mipsu, MZONE, Mnowsu, pid  from Miteminfo where MCODE=$code;"); 
  
 //echo $rs->field[MNAME];

?>

<div id="header">
<a href="#nav" id="menu">&#8634;</a>
<ul id="nav">
<li><a href="#">Home &#10072;</a></li>
<li><a href="#">신규등록 &#10072;</a></li>
<li><a href="#">수정등록 &#10072;</a></li>
<li><a href="#">메뉴</a></li>
</ul>
</div> 


 
<table class="layout display responsive-table">
<thead>
<tr>
<th>상태</th>
<th>품목명</th>
<th>위치<? echo $rs->fields[MZONE]?></th>
<th>단,입수</th>
</tr>
</thead>
<tbody>
<form name="form1" action="" method="POST">

<tr>
<td class="organisationnumber">
<input type="text" name="mcode" id="mcode" value="<? echo $rs->fields[MCODE]?>" style="width:100%;" size="10"> 
</td>
<td class="organisationname">
<input type="text" name="mname" id="mname" value="<? echo $rs->fields[MNAME]?>" style="width:100%;">  
</td>
<td class="organisationname">
<? echo "단"?><input type="text" name="zone1" id="zone1"  value="<? echo substr($rs->fields[MZONE],0,3) ?>" style="width:100%;"><? echo "층"?><input type="text" name="zone2" id="zone2"  value="<? echo substr($rs->fields[MZONE],4,2)?>" style="width:100%;"><? echo "빠렛번호"?><input type="text" name="zone3" id="zone3"  value="<? echo substr($rs->fields[MZONE],7,2)?>" style="width:100%;"><? echo "순서"?><input type="text" name="zone4" id="zone4"  value="<? echo substr($rs->fields[MZONE],9,2)?>" style="width:100%;">
</td>
<td  class="organisationname"><? echo "1단"?><input type="number" name="a" id="a<?=$i?>" pattern="[0-9]*" inputmode="numeric" min="0" value="<? echo $rs->fields[Mnowsu]?>" style="width:100%;"><? echo '입수';?><input type="text" name="b" id="b<?=$i?>" value="<? echo $rs->fields[Mipsu]?>" style="width:100%;">
<input type ="button" name="button1" value="정보저장" onClick ="modi();">
</td>
</td>
</tr>
</table>
</form>
<div id="side">점장님 화이팅</div>

 

</body>

</html>