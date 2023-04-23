<?php
function  createConfirmationmbox(){
    echo '<script type="text/javascript"> ';
    echo 'var inputname = prompt("Please enter your name", "");';
	echo '</script>';
    $Roomidx = "<script>document.write (inputname);</script>";



    return $Roomidx;
   
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JavaScript Prompt Box by PHP</title>
<?php
   
    $a =  createConfirmationmbox();
	echo $a;
	
?>
</head>
<body>
</body>
</html>


