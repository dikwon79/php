<?php

    include('dbcon.php');
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==3) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 

	

    if(isset($_GET['del_id']))
    {
		
		$del = $_GET['del_id'];


		$pieces = explode("/", $del);

		$sql = "DELETE FROM ipgo WHERE ipgodate = '$pieces[0]' and ipgonum = '$pieces[1]'";
	    echo $sql;
		$stmt = $con->prepare($sql);

		$stmt->execute();	
    }

    header("Location: ipgolist.php");
?>


 