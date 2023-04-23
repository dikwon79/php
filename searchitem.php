<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; 
    charset=UTF-8" />
<title>검색</title>

<link rel="stylesheet" href="bootstrap/css/iaan.css">
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Bootstrap cdn 설정 -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
a:link {
  color : black;
}
a:visited {
  color : black;
}
a:hover {
  color : black;
}
a:active {
  color : black;
}
</style>
<script>
 
	function goAction(val1,mapval1,val2,nIpsu,ipgo,number,menu,count,georae){
    
	
    
    var row = Number(document.getElementById('numValue').value);
	var NumberCount = Number(count);
  
	if (row < NumberCount){
          
		 
		 let numValue = Number(row) + 1;
	     
         document.getElementById('numValue').value = numValue;
		 
       
	}else{
	    row = opener.document.getElementById('my-tbody').rows.length;
        opener.add_row();
	}
	//alert(number);
	//alert(window.opener);
	//window.opener.document.board_form.market_name.value = val;
    opener.document.getElementById('row_code'+row).value = val1; //일반적인 방법
	opener.document.getElementById('row_mappingcode'+row).value = mapval1; //일반적인 방법
	opener.document.getElementById('row_name'+row).value = val2; //일반적인 방법
	opener.document.getElementById('row_ipsu'+row).value = nIpsu; //일반적인 방법
	opener.document.getElementById('row_rule'+row).value = nIpsu.concat('/', georae); //일반적인 방법

    opener.document.getElementById('row_price'+row).value = ipgo; //일반적인 방법
    opener.document.getElementById('row_supply'+row).value = 0; //일반적인 방법
    opener.document.getElementById('row_tax'+row).value = 0; //일반적인 방법
    opener.document.getElementById('row_hap'+row).value = 0; //일반적인 방법
   
	if (row < NumberCount-1){

		 


        row = row+1;
        opener.document.getElementById('row_code'+row).focus();
		if(menu !==""){
		  self.close();
		}
	}
	else{

		 


		if(menu){
		
		  row = row+1;
          opener.document.getElementById('row_code'+row).focus();
		  }else{
				opener.document.getElementById('row_box'+row).focus();

		  }
	    	
    
		if (number){
			if(menu !==""){
				//opener.add_row();  
				
				self.close();
			}
		   
		}    
	}
	
//	window.close();

	}
	function sorting(itemname,num,opt){
       
	    
	   $('#table tr:not(:first)').remove();


	   if(opt ==='1'){
           
            $("#sortinfo2").val("0").prop("selected", true); 
			$("#sortinfo3").val("0").prop("selected", true); 
			$("#sortinfo4").val("0").prop("selected", true); 
			
       }else if (opt ==="2")
       {
		    $("#sortinfo1").val("0").prop("selected", true); 
			$("#sortinfo3").val("0").prop("selected", true); 
            $("#sortinfo4").val("0").prop("selected", true); 
			
	   }else if (opt ==="3")
	   {
            $("#sortinfo1").val("0").prop("selected", true); 
			$("#sortinfo2").val("0").prop("selected", true); 
            $("#sortinfo4").val("0").prop("selected", true); 
			
	   }

	   else{

		   $("#sortinfo1").val("0").prop("selected", true); 
		   $("#sortinfo2").val("0").prop("selected", true);
		   $("#sortinfo3").val("0").prop("selected", true); 
          
	   }
	   const sortinfo  = document.getElementById("sortinfo1").value;
	   const sortinfo2 = document.getElementById("sortinfo2").value;
	   const sortinfo3 = document.getElementById("sortinfo3").value;
       const sortinfo4 = document.getElementById("sortinfo4").value;
       
	  
       var xmlhttp=new XMLHttpRequest();
	   var inameD= "table";
   
       xmlhttp.open("GET","searchitem_sort.php?item=" + itemname +"&num="+num+"&sort1="+sortinfo+"&sort2="+sortinfo2+"&sort3="+sortinfo3+"&sort4="+sortinfo4,false);
       xmlhttp.send(null);

	   
   
       document.getElementById(inameD).innerHTML=xmlhttp.responseText;;
 




	   //location.href="http://dikwon79.cafe24.com/searchitem.php?item=" + itemname +"&num="+num+"&sort1="+sortinfo+"&sort2="+sortinfo2+"&sort3="+sortinfo3;
	}

</script>


</head>
<?php

    include('dbcon.php'); 
    //include('check.php');
   	
	$itemsearch = $_GET['item'];
	$num = $_GET['num'];
	$menu = $_GET['menu'];
    $sort1 = $_GET['sort1'];
    $sort2 = $_GET['sort2'];
    $sort3 = $_GET['sort3'];
    $sort4 = $_GET['sort4'];

	$tablecount = $_GET['count'];

 
  
	?>

<div class="container">
	
   
   <div class="row">
   

	
    <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
		    <th style="width :25%">다중선택</th> 
           
			<th style="width :30%">업체명<select id="sortinfo4" onchange="sorting('<?=$itemsearch?>','<?=$num?>','4')">
				<option value="0" <? if ($sort4=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort4=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort4=="2") echo "selected" ?>>▼</option></select></th>  
			
			<th style="width :50%">거래처품목명<select id="sortinfo3" onchange="sorting('<?=$itemsearch?>','<?=$num?>','3')">
				<option value="0" <? if ($sort3=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort3=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort3=="2") echo "selected" ?>>▼</option></select></th>  
			
			<th style="width :25%">품목코드<select id="sortinfo1" onchange="sorting('<?=$itemsearch?>','<?=$num?>','1')">
				<option value="0" <? if ($sort1=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort1=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort1=="2") echo "selected" ?>>▼</option>
				</select></th>
			<th style="width :20%">맵핑</th> 
			<th style="width :50%">품목명<select id="sortinfo2" onchange="sorting('<?=$itemsearch?>','<?=$num?>','2')">
				<option value="0" <? if ($sort2=="0") echo "selected" ?>>◎</option>
				<option value="1" <? if ($sort2=="1") echo "selected" ?>>▲</option>
				<option value="2" <? if ($sort2=="2") echo "selected" ?>>▼</option></select></th>
			
			<th style="width :10%">단위</th>  
            <th style="width :10%">입수</th>
			<th style="width :20%">구매가</th> 
            <input type="hidden" id="numValue" value="<?=$num?>">          
			
        </tr>  
        </thead>  
  
        <?php  
	   
		$sql = "SELECT * from iteminfo where labelY='Y' and (itemnameGeo like '%$itemsearch%' or itemname like '%$itemsearch%' or itemcode like '%$itemsearch%' or georae like '%$itemsearch%')    ";
	    
		
		$sql .= "order by georae asc";
		
		if($sort1 > 0) $sql .=","; 
		if($sort1 == "1"){
		    $sql .= " itemcode asc";
		}else if($sort1 == "2"){
            $sql .= " itemcode desc";
		}
        
		if($sort2 > 0) $sql .=","; 
        if($sort2 == "1"){
		    $sql .= " itemname asc";
		}else if($sort2 == "2"){
            $sql .= " itemname desc";
		}
        if($sort3 > 0) $sql .=","; 
		if($sort3 == "1"){
		    $sql.= " itemnameGeo asc";
		}else if($sort3 == "2"){
            $sql.= " itemnameGeo desc";
		}
		if($sort4 > 0) $sql .=","; 
		if($sort4 == "1"){
		    $sql.= " georae asc";
		}else if($sort4 == "2"){
            $sql.= " georae desc";
		}
        
		$sql =  rtrim($sql,','); 
		//echo $sql;
		$stmt = $con->prepare($sql);
	
	    $stmt->execute();
        $number =0;
	    if ($stmt->rowCount() > 0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	        {
		    extract($row);
            $number++;
            if (trim($mappingcode)=="#N/A"){

                    $mappingcode = $itemcode;
			}
			else if (trim($mappingcode)==""){

                    $mappingcode = $itemcode;
			}


		if ($username != 'admin'){
		?>  
			<tr>
			<td><a href='#a<?=$itemcode?>' onClick="goAction('<?=$itemcode?>','<?=$mappingcode?>','<?=$itemnameGeo?>','<?=$ipsu?>','<?=$ipgoprice?>','<?=$num?>','','<?=$tablecount?>','<?=$georae?>')">선택</a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$georae?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$itemnameGeo?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$itemcode?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$mappingcode?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$itemname?></a></td>
			
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$unit?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$ipsu?></a></td>
			<td><a href='#' onClick='goAction("<?=$itemcode?>","<?=$mappingcode?>","<?=$itemnameGeo?>","<?=$ipsu?>","<?=$ipgoprice?>","<?=$num?>","<?=$menu?>","<?=$tablecount?>","<?=$georae?>")'><?=$ipgoprice?></a></td>
			
			</tr>
		
        <?php
			}
                }
             }
        ?>  
        </table>  
</div>

</body>
<div id='control' class="control">
    <button id="btnPrint" type="button" class="btn btn-default">신규</button>
	<button id="close" type="button" class="btn btn-default">닫기</button>
   
</div>
</html>