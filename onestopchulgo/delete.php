<?php

    include('../dbcon.php');
    include('../check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==3) 
            ;
        else
            header("Location: ../welcome.php");
    }else
        header("Location: ../index.php"); 

	

    if(isset($_GET['inputday']))
    {
		
		$inputday = $_GET['inputday'];
		$chasu = $_GET['chasu'];
		$worker = $_GET['worker'];
        
		$sql = "DELETE FROM labelXmain WHERE inputday = $inputday and chasu = $chasu";
		$stmt = $con->prepare($sql);

		//$stmt = $con->prepare('DELETE FROM labelXmain WHERE inputday =:inputday');
		
		//$stmt->bindParam(':del_id',$_GET['inputday']);
		$stmt->execute();	
    }

    header("Location: ./");
?>


 