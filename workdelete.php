<?php
    include('dbcon.php'); 
    include('check.php');

    if(is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==1)
            header("Location: admin.php");
        else 
            header("Location: welcome.php");
    }



    if(isset($_GET['chasu']))
    {
		
		$chasu= $_GET['chasu'];
		$date = $_GET['idate'];
        $company = $_GET['companyname'];
		if (trim($company) == "'shinsegye'"){
	         $db = 'labelshinsegye';
		}
		else{
			 
			 $db = 'labelcjimsi';
		}

		$sql = "DELETE FROM labelmain WHERE idate =$date and chasu=$chasu and companyname=$company and worker='".$_SESSION['user_id']."' ";
	 
		$stmt = $con->prepare($sql);
	    
	    $stmt->execute();	
		$sql = "DELETE FROM ".$db." WHERE idate =$date and chasu=$chasu and companyname=$company and worker='".$_SESSION['user_id']."' ";
	    echo $sql;
		$stmt = $con->prepare($sql);
	    $stmt->execute();	
	
    }
	 // header("Location: printLabel.php?search='$date&tabid='$company'");
    
      header("Location: printLabel.php?search='$date&tabid='$company'");
     //$string = "http://iaanlogis.shop/printLabel.php?search=".$date."&tabid=".$company;
	
     //echo "<script>location.href='<?=$string?>'</script>";
	 // header("Location: ".$string);


 



      
?>
