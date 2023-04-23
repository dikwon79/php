<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    //include('dbcon.php');
        

    $stmt = $con->prepare('select * from black_list');
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 
		$D1 = array();
        $D2 = array();
        $yeop = array();

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            
            if ($kind =="D1") {array_push($D1,$name);}
			else if($kind =="D2") {array_push($D2,$name);}
			else {array_push($yeop,$name);}
        }
        
		
    }
    $stmt = $con->prepare("select itemcode from iteminfo where itemblack='Y'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $code = array(); 
		
       
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            
            array_push($code,$itemcode);			
        }
        
		
    }

    $stmt = $con->prepare("select itemcode from iteminfo where printoption='Y'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $centerblack = array();   //수도권블랙
		
       
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            
            array_push($centerblack,$itemcode);			
        }
        
		
    }
	
	$stmt = $con->prepare("select itemcode from iteminfo where usingY='N'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $notusing = array();   //수도권블랙
		
       
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            
            array_push($notusing,$itemcode);			
        }
        
		
    }

	array_push($data, 
                array('D1'=>$D1,
                'D2'=>$D2,
                'yeop'=>$yeop,
				'code'=>$code,
                'centerblack'=>$centerblack,
				'notusing'=>$notusing

            ));
        //header('Content-Type: application/json; charset=utf8');
        $json = json_encode(array("common"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
        //echo $json;

        
		$fp = fopen('../../config_common.json', 'w');
		fwrite($fp, $json);
		fclose($fp);

?>