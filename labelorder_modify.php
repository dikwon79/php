<? 
    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
    include('headitem.php');?>

<?  
   
   $item = $_GET['item'];
   if($item)
   $sql = "select * from labelmain where id = '$item' "; 
   $stmt = $con->prepare($sql);
						
   $stmt->execute();
   
   if ($stmt->rowCount() > 0)
   {
	
	  $row=$stmt->fetch(PDO::FETCH_ASSOC);	  
	  extract($row); 


   
?>
    
<div class="container">
    <div id="navhead">
    <form class="navbar" role="search" method="post" action="">
	<div class="col-sm-2">
	<h1 class="h2">&nbsp;출고수정</h1><hr>
    </div>
    <div class="col-sm-10">
	<div class="col-sm-1">
	일자 : 
	</div>
	<div class="col-sm-5">

	<input type="text" name="date" id="datePicker" size="30" value='<? echo $idate; ?>'/>
	<input type="button" value="달력" onclick="$('#datePicker').datepicker('show');" />
	</div>
	<div class="col-sm-1">
	거래처: 

	</div>

    <div class="col-sm-5"><input  onkeypress="enter_test('georae')" name="georae" id="georae"  placeholder="거래처/센터" size="15" value=""/><input type="text" id="georaename" name="georaename" size="15"/></div>


<div class="row-pt-5">

<div class="col-sm-1"> 
담당자 : 
</div>
<div class="col-sm-5">

<input type="text" name="charger" id="charger" size="30" value='<?=$_SESSION['user_id']?>'/>
</div>
<div class="col-sm-1">
입고창고 : 
</div>

<div class="col-sm-5"><input onkeypress="enter_test('chango')" type="text" id='chango' name="chango"  placeholder="창고" size="15" value='<?=$row['changocode']?>'><input type="text" id='changoname' name="chango2" size="15" value='<?=$row['changoname']?>' ></div>

</div>



</div>
</div>







</form>           
</div>

<div id='buttonname' class='row'>
<button onclick="add_row()">행 추가하기</button>
<button onclick="delete_row()">행 삭제하기</button><button class="hide1">Hide</button>
<button onclick="">거래처등록</button>
<button onclick="">품목등록</button>
</div>




<?  } ?>