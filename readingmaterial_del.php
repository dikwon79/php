<?php
    include('dbcon.php'); 
    include('check.php');





    if(isset($_GET['chasu']))
    {
		
		$chasu= $_GET['chasu'];
		$date = $_GET['idate'];
       

        $company = $_GET['companyname'];
	    
		$worker = $_GET['worker'];
	    $db = "WHERE idate =$date and chasu=$chasu and companyname=$company and worker=$worker ";
		

       

		$sql = "DELETE FROM labelmain ".$db;
	    //echo $sql;
		$stmt = $con->prepare($sql);
	    
	    $stmt->execute();	
		$sql = "DELETE FROM labelcjimsi ".$db;
	    //echo $sql;
		$stmt = $con->prepare($sql);
	    $stmt->execute();
		
	
    }
	 // header("Location: printLabel.php?search='$date&tabid='$company'");
    
     header("Location: printLabel.php?search='$date&tabid=reading'");
     //$string = "http://iaanlogis.shop/printLabel.php?search=".$date."&tabid=".$company;
	
     //echo "<script>location.href='<?=$string?>'</script>";
	 // header("Location: ".$string);


 



      
?>
