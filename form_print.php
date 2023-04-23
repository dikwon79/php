<?php require 'class.trade_note.php';  
    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 



  
  $processdate = $_GET['processdate'];
  $idate=substr($processdate,0,10);
  $numbering=substr($processdate,11,200);

  $sql ="select count(*) as 'count' from ipgo where ipgodate='$idate' and ipgonum='$numbering' ";
  
  $stmt = $con->prepare($sql);		
  $stmt->execute();
  $row = $stmt->fetch();  
  extract($row);
  $page = $count/10;
 

  for($i=0;$i<ceil($page);$i++){


  $NFORM = new Gizmo_TradeNote;
  $NFORM->SetTaxAdded(true);
  $NFORM->SetCompany('(주)이안로직스', '이종혁', '사업등록번호', '사업장주소', '업태', '종목');
  $NFORM->SetCustomer('*상호', '사업장주소', '전화번호');
  $NFORM->SetIssuedDate('2006-01-26');
  $NFORM->SetSerial('A0020333');
  $NFORM->SetPage($i+1);
  $NFORM->SetPair('BLUE');
  $NFORM->SetSignPath('/img/sign.gif');

  $range = 10*$i;
  $sql ="select *  from ipgo where ipgodate='$idate' and ipgonum='$numbering' limit $range, 10 ";

  
  $stmt = $con->prepare($sql);		
  $stmt->execute();
  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
	  extract($row);
					
 
  
  
     $NFORM->AddArticle($itemname, '', '', $surang, $ipgodate, $itemrule, $etc,false);
 
  }
     $NFORM->PrintNote(); 
  }
  
  
 ?>