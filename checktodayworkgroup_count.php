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
 
 

                     
	//$stype = isset($_POST['stype']) ? $_POST['stype'] : '';
	//$searchtext = isset($_POST['itext']) ? $_POST['itext'] : '';

    $chasu = $_POST['chasu'];
	$today = $_POST['daten'];

    try
	{
           $sql ="SELECT h.companyname,h.georae,h.idate,h.code,h.itemname,sum(h.surang) as 'surang' ,h.danwi,b.printinfo,h.center,h.chasu,h.customer,sum(h.chaivalue) as 'chaivalue',h.unit 
											from(SELECT y.companyname,if(a.georae is NULL,'미등록', a.georae) AS 'georae',y.idate,
											if(a.mappingcode IS NOT NULL,if(a.mappingcode='',y.itemcode,a.mappingcode),y.itemcode) AS 'code',
											if(a.itemname is NULL,y.itemname,a.itemname) AS 'itemname',if(a.itemname is NULL, chaivalue, 
											if(y.unit='BOX',y.chaivalue*a.packsu,y.chaivalue)) AS 'surang',if(a.itemname IS NULL, y.unit, 'EA') AS 'danwi',
											y.center,y.chasu,y.customer,y.chaivalue,y.unit FROM (SELECT * FROM iteminfo)a 
											RIGHT JOIN (SELECT companyname,idate,itemcode,itemname,chaivalue,unit,center,chasu,customer FROM labelmain 
											WHERE idate=:var_idate)y ON a.itemcode = y.itemcode)h 
											LEFT JOIN print_info b ON h.center = CONCAT(b.center,' / ',b.centername) GROUP BY h.code,b.printinfo order by h.georae,h.itemname,h.center asc";
					
			
			$stmt = $con->prepare($sql);
            
			$stmt->bindParam(':var_idate',$value);

			$stmt->execute();
			
			
			
			echo "success";

		
    }
	catch(PDOException $ex)
	{

		echo "fail";
	}
						 
    

  
?>
