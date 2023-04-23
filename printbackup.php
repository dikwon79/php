<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>인쇄</title>

<link rel="stylesheet" href="bootstrap/css/iaan.css">
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap cdn 설정 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="excel.min.js"></script>
<style>
h1, h2, h3, h4, h5, dl, dt, dd, ul, li, ol, th, td, tr, p, blockquote, form, fieldset, legend, div,body,thead,tbody { -webkit-print-color-adjust:exact; }

body {

margin: 0;
padding: 0;

}
thead{
  background:#090 exact !important;

}
* {

box-sizing: border-box;

-moz-box-sizing: border-box;

}

.page {
width: 22cm;
min-height: 29.7cm;
padding: 1cm;
margin: 0 auto;
background:#eee exact !important;

}

.subpage {

border: 2px red solid;
height: 290mm;

}
.control {
width: 22cm;
height: 40px;
padding: 0;
margin: 0 auto;
background:green !important;

}

@page {

size: A4;
margin: 0;

}

@media print {

	html, body {
	width: 220mm;
	height: 297mm;
	}
	.page {
	margin: 0;
	border: initial;
	width: initial;
	min-height: initial;
	box-shadow: initial;
	background: initial;
	page-break-after: always;
	}
	.table th {
     background-color: #696969 !important;
	}
	tbody tr:nth-child(even) td{background-color: #eee !important;}

}
 
</style>
</head>

<?
error_reporting(E_ALL);

ini_set("display_errors", 1);


  include('dbcon.php'); 
  
  $processdate = $_GET['processdate'];

  $chasu = $_GET['chasu'];
  $sql = "SELECT T.geoname,T.type,T.itemcode,if(a.itemname IS NULL,CONCAT('신규)',T.itemname),a.itemname)AS 'item' ,customer,centername,su1,su2,su3,CONCAT (if (a.ipsu is not NULL,(T.su3 div a.ipsu),0),' / ',if (a.ipsu is not NULL,(T.su3 mod a.ipsu),T.su3)) as 'PT' ,unit,cha2,mcondition,a.georae,a.lek from iteminfo a 
RIGHT JOIN (

SELECT geoname,type,itemcode,itemname,customer,printinfo AS 'centername',c.su1, c.su2,c.su3,c.unit,c.cha2,c.mcondition,c.geocode FROM (SELECT geoname,chasu,type,itemcode,itemname,customer,deaddate,special,center,surang1 AS 'su1',surang2 AS 'su2',chaivalue AS 'su3',unit,cha2,mcondition,geocode,bar2,mcode FROM labelmain WHERE TYPE !='신규' and chasu='$chasu' AND idate='$processdate')c left JOIN print_info d ON c.center = concat(d.center,' / ',d.centername)

UNION ALL
SELECT  K.geoname,K.type,K.itemcode,K.itemname,K.customer,centername,sum(K.su1),sum(K.su2),sum(K.su3),K.unit,K.cha2,K.mcondition,K.geocode FROM (SELECT f.geoname,f.type,f.itemcode,f.itemname,f.customer,printinfo AS 'centername',f.su1,f.su2,f.su3,f.unit,f.cha2,f.mcondition,f.geocode FROM (SELECT geoname,type,itemcode,itemname,customer,center,surang1 AS 'su1',surang2 AS 'su2',sum(chaivalue) AS 'su3',unit,cha2,mcondition,geocode FROM labelmain WHERE TYPE ='신규' and chasu='$chasu' AND idate='$processdate' GROUP BY  center,itemcode, unit)f 
left JOIN print_info e ON f.center = concat(e.center,' / ',e.centername))K GROUP BY centername,itemcode,unit


)T
ON T.itemcode = a.itemcode ORDER BY georae asc,TYPE ASC ,centername ASC,item asc";

//echo $sql;

  $stmt = $con->prepare($sql);

  $stmt->execute();

  ?>

  <body>
  <div id='control' class="control">
    <button id="close" type="button" class="btn btn-default">Close</button>
    <button id="btnPrint" type="button" class="btn btn-default">Print</button>
  </div>

  

	
	<?
			
			 if ($stmt->rowCount() > 0)
			 {
				  $count =0;
				  $check ='신규';
				  $center = '센터';
				  while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				  {
					  extract($row);
					
                       
					   if ($type=='신규') 
					  {  
						   if (($check !=trim($type)) or (($center !=trim($centername)) and ($georae!==null))) {
							   ?>
							  </tbody></table></div>
		                      </div> 
							   <?
							   $count =0;
						   }
                           $check=$type;
						   $center=$centername;
						   if ($count==0){
						   ?>
                           <div class="page">
						   <div class="subpage">
						   <div><h1><? if ($georae===null){ echo '품목미등록';} 
						               else { echo $georae;} ?></h1></div>
						   <table class="table table-striped table-bordered table-hover">
					       <thead>
							<tr>
								<th NOWRAP>코드</th>
								<th NOWRAP>렉</th>
								<th >품목명</th>
								<th NOWRAP>PT</th>
								<th NOWRAP>수량</th>
								<th NOWRAP>단위</th>
								<th NOWRAP>센터</th>

							</tr>
						   </thead>
						   <tbody>
					     <?
						   }
						 ?>
					    <tr>
						<td NOWRAP><?=$itemcode?></td>
						<td NOWRAP><?=$lek?></td>
						<td ><?=$item?></td>
						<td NOWRAP><?=$PT?></td>
						<td NOWRAP><?=$su3?></td>
						<td NOWRAP><?=$unit?></td>
                        
						<td NOWRAP><?=$centername?></td>
						
					    </tr>
                        <?

					  }
					  else
					  {
                           if ($count==0){
							   $check=$type;
						   ?> 
						   <div class="page">
						   <div class="subpage">
						   <table class="table table-striped table-bordered table-hover">
					       <thead>
							<tr>
								<th NOWRAP>품목코드</th>
								<th>품목명</th>
								<th>납품처명</th>
								<th>센터</th>
								<th>전</th>
								<th>후</th>
								<th>차이</th>
								<th>단위</th>
								<th>차량번호</th>
								<th>보관</th>
								<th>업체명</th>


							</tr>
						   </thead>
						   <tbody>
				          <?
						   }
						  ?>
                          <tr>
			
						  <td NOWRAP><?=$itemcode?></td>
						  <td><?=$item?></td>
						  <td><?=$customer?></td>
						  <td><?=$centername?></td>
						  <td NOWRAP><?=$su1?></td>
						  <td NOWRAP><?=$su2?></td>
						  <td NOWRAP><?=$su3?></td>
						  <td NOWRAP><?=$unit?></td>
						  <td NOWRAP><?=$cha2?></td>	
						  <td NOWRAP><?=$mcondition?></td>
						  <td NOWRAP><?=$georae?></td>
						  </tr>
                      <?
					  }
                     $count++;

                    if ($count>24){   
						
						
						$count=0;?>
						</tbody></table></div>
		                      </div>
					  <?
					
				     } 
					 
				  }

			 }
		?>
		</tbody>
		</table>
		</div>
		</div>


    </p>
			

</body>
<script>
document.getElementById("btnPrint").onclick = function () {
    //printElement(document.getElementById("printThis"));
   var a = document.getElementById("control");
   a.style.display ='none';
   window.print();
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);
    
    var $printSection = document.getElementById("printSection");
    
    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }
    
    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}
</script>
</html>