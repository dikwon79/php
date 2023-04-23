<?php

    include('dbcon.php');
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==1) 
            ;
        else
            header("Location: admin_black.php");
    }else
        header("Location: admin_black.php"); 


    if(isset($_GET['id']))
    {
	$stmt = $con->prepare('DELETE FROM black_list WHERE pid =:del_id');
	$stmt->bindParam(':del_id',$_GET['id']);
	$stmt->execute();	
    }

    header("Location: admin_black.php");
?>