<?php
   
    include('dbcon.php');
    include('check.php');
   
    if (is_login()){


        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==1)
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: iteminfo.php"); 


	if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
	{
		$edit_id = $_GET['edit_id'];
		
		
		
		$stmt_edit = $con->prepare('SELECT * FROM iteminfo WHERE id = :user_id');
		$stmt_edit->execute(array(':user_id'=>$edit_id));
		$edit_row = $stmt_edit->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
       
	}
	else
	{
		header("Location: iteminfo.php");
	}


	
    include('headitem.php');
?>

<div class="container">
	<div>
    	<h1 class="h2" align="center">&nbsp; 품목 정보 수정<a class="btn btn-success" href="admin.php" style="margin-left: 850px"><span class="glyphicon glyphicon-home"></span>&nbsp; Back</a></h1><hr>
    </div>
<form id="myform" method="post" enctype="multipart/form-data" class="form-horizontal" style="margin: 0 300px 0 300px;border: solid 1px;border-radius:4px">
    <?php
	if(isset($errMSG)){
		?>
        <div class="alert alert-danger">
          <span class="glyphicon glyphicon-info-sign"></span> &nbsp; <?php echo $errMSG; ?>
        </div>
        <?php
	}
	?>
	<table class="table table-responsive">
    <tr>
      
    	<td><label class="control-label">코드</label></td>
        <td>
        <input id="id" class="form-control" type="text" name="<? echo $itemcode; ?>" value="<?php echo $itemcode; ?>" placeholder="아이디를 입력하세요." autocomplete="off" readonly   />
        <input type="hidden" name="__autocomplete_fix_<? echo $itemcode; ?>" value="editusername" /> 
        </td>
    </tr>
    <tr>
      
		
    	<td><label class="control-label">상품명</label></td>
        <td>
        <input id="itemname" class="form-control" type="text" name="<? echo $itemname; ?>" value="<?php echo $itemname; ?>" placeholder="패스워드를 입력하세요." 
               autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
        <input type="hidden" name="__autocomplete_fix_<? echo $itemname; ?>" value="editpassword" /> 
        </td>
    </tr>
    <tr>
      
		
    	<td><label class="control-label">입수</label></td>
        <td>
        <input id="ipsu" class="form-control" type="text" name="<? echo $ipsu; ?>" value="<?php echo $ipsu; ?>" placeholder="패스워드를 입력하세요." 
               autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
        <input type="hidden" name="__autocomplete_fix_<? echo $ipsu; ?>" value="editpassword" /> 
        </td>
    </tr>
	<tr>
      
		
    	<td><label class="control-label">거래처</label></td>
        <td>
        <input id="georae" class="form-control" type="text" name="<? echo $georae; ?>" value="<?php echo $georae; ?>" placeholder="패스워드를 입력하세요." 
               autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
        <input type="hidden" name="__autocomplete_fix_<? echo $ipsu; ?>" value="editpassword" /> 
        </td>
    </tr>
	<tr>
      
		
    	<td><label class="control-label">렉</label></td>
        <td>
        <input id="lek" class="form-control" type="text" name="<? echo $lek; ?>" value="<?php echo $lek; ?>" placeholder="패스워드를 입력하세요." 
               autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
        <input type="hidden" name="__autocomplete_fix_<? echo $lek; ?>" value="editpassword" /> 
        </td>
    </tr>
	<tr>
      
		
    	<td><label class="control-label">단</label></td>
        <td>
        <input id="dan" class="form-control" type="text" name="<? echo $dan; ?>" value="<?php echo $dan; ?>" placeholder="패스워드를 입력하세요." 
               autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required />
        <input type="hidden" name="__autocomplete_fix_<? echo $dan; ?>" value="editpassword" /> 
        </td>
    </tr>
	<tr>
      
		
    	<td><label class="control-label">재고담당</label></td>
        <td>
        <input id="invertory" class="form-control" type="text" name="<? echo $invertory ?>" value="<?php  echo $inventory; ?>" placeholder="재고담당을 입력하세요."/>
        <input type="hidden" name="__autocomplete_fix_<? echo $invertory; ?>" value="editpassword" /> 
        </td>
    </tr>
	
	
	
    <tr>
	
	
        <td colspan="2" align="center">
		<button type="submit" name="btn_save_updates" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp; 업데이트</button>
        <a class="btn btn-warning" href="iteminfo.php"> <span class="glyphicon glyphicon-remove"></span>&nbsp; 취소</a>
        </td>
    </tr>
    </table>
</form>
</div>
</body>
</html>