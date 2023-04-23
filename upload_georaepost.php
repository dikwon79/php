<?  
  $blacklist = file_get_contents("php://input");
  $array = json_decode($blacklist, true);


  include 'dbconn.php';

    
  $u1 = date("Y"); 
  // 순번....순서.........................................................................
  $sql = "delete from geoinfo";

  $result = mysqli_query($connect,$sql);
  $count = mysqli_num_rows($result);


  $row = mysqli_fetch_assoc($result);
  if ($count > 0) 
  {           
		  $smx= $row['pid'];
		
  }
  else
  {
		$smx= $u1."000000000";

  }

  

  foreach ($array['maindata'] as $row) {

		
			

	$sql = "insert into geoinfo(useY,tpl,geocode,geoname,labeltype,geobunryu,geogubun,geoboss,businessNum,tel,fax,posnum,address,yeop,jongmok,gita,account1,account2,account3
,recharger1,recharger2,recharger3,startdate) VALUES('".addslashes($row['useY'])."','".addslashes($row['tpl'])."','".addslashes($row['geocode'])."',
'".addslashes($row['geoname'])."','".addslashes($row['labeltype'])."','".addslashes($row['geobunryu'])."','".addslashes($row['geogubun'])."','".addslashes($row['geoboss'])."'
,'".addslashes($row['businessNum'])."','".addslashes($row['tel'])."','".addslashes($row['fax'])."','".addslashes($row['posnum'])."','".addslashes($row['address'])."'
,'".addslashes($row['yeop'])."','".addslashes($row['jongmok'])."','".addslashes($row['gita'])."','".addslashes($row['account1'])."','".addslashes($row['account2'])."'
,'".addslashes($row['account3'])."','".addslashes($row['recharger1'])."','".addslashes($row['recharger2'])."','".addslashes($row['recharger3'])."'
,'".addslashes($row['startdate'])."')";
           
	mysqli_query($connect,$sql);
		    
		   
		
  }//입력끝...

  echo "success";

?>
