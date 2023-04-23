<?php
  
    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 

 
    include('headitem.php');
    

    if(isset($_GET['search']))
	{
	   $getdate = $_GET['search'];
	   //echo substr($getdate,2,10);
       $value =  date("Y-m-d", strtotime(substr($getdate,2,10))); 
	   //echo $value;
	   //$value = new DateTime($getdate); 
	}
	else{
	   $value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
    }
	
	try { 

                $sql = "SELECT MAX(chasu) from labelcjimsi where idate ='$value'";
				$stmt = $con->prepare($sql);

				$stmt->execute();
			   
			} catch(PDOException $e) {
				die("Database error. " . $e->getMessage()); 
			}

			$row = $stmt->fetch();  
			$chasu = $row['MAX(chasu)']+1;
		   
	?>

<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 라벨발행</h1><hr>
    </div>

    <div id="navhead">
    <form class="navbar" role="search" method="post" action="">
       
       <div class="col-sm-3">
	   
	   <input type="text" id="datePicker" name='search' class="form-control" value=<?=$value;?>></div>
       <div class="col-sm-3">
	   <select name="chasu" id="chasu" class="form-control">
			  <? for($i=1;$i<31;$i++){ ?>
			  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?>><? echo $i.'차작업'?></option>
			  <?  }  ?>
			  
		</select>
	   
	   
	   </div>
	   <div class="col-sm-3"><button type="button" class="btn btn-danger" onclick="submit()">조회</button>
	   
	   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#my80sizeCenterModal">유통이력</button>
	  
	   <button type="button" class="btn btn-primary" onclick="label()">라벨발행</button>
	   </div>
	   <div class="col-sm-3"><input class="pt-3" type='file' webkitdirectory directory id='file' multiple /></div>
     </form>           
   </div>
 			 
   <div id="option">
   <div class="col-sm-2"><label>1.CJ프레시 웨이</label></div>
  
  
	   <?  
	      $sql = "SELECT companyname,grouping from print_info where companyname='cj' group by companyname, grouping";		 
	      $stmt = $con->prepare($sql);
		  $stmt->execute();
		  if ($stmt->rowCount() > 0)
          {
	           $num=0;
			   while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	           {
		       extract($row); 
			   
			 
       ?>
	   <div class="col-sm-2"><?=$grouping?> : <input type='checkbox' id='cut<?=$num?>' name='cut' value='<?=$grouping?>' style="width:20px;height:20px;"> </label></div>
      
       <?  
	      $num++;
	     }  }?>
       <div class="col-sm-2"></div>
	   
	 
   </div>
   <div id="option">
   <div class="col-sm-2"><label>2.신세계</label></div>
  
  
	   <?  
	      $sql = "SELECT companyname,grouping from print_info where companyname='shinsegye' group by companyname, grouping";		 
	      $stmt = $con->prepare($sql);
		  $stmt->execute();
		  if ($stmt->rowCount() > 0)
          {
	           while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	           {
		       extract($row);
			 
       ?>
	   <div class="col-sm-2"><?=$grouping?> : <input type='checkbox' name='cut' value='<?=$grouping?>' style="width:20px;height:20px;"> </label></div>
      
       <?  
	   
	     }  }?>
       <div class="col-sm-2"></div>
	   <div class="col-sm-2"></div>
	   <div class="col-sm-2"></div>
   </div>
	<!-- 프린트 영역 --------------------------------------------------------------------------------------------->
   <div class="row">
   

	
    <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th style="width : 50px">No.</th>          
	 		<th style="width : 70px"><input id="checkall" type="checkbox" onclick="checkboxclick()">체크시블랙제외</th> 
			<th style="width : 300px">업체이름</th>
            <? for ($i=1 ;$i<$chasu;$i++) { ?>
			<th><button type="button" class="btn btn-primary" onclick="windowSize('printchong.php',<?=$i?>,'width=900,height=558')"><?=$i.'차';?></button>
			<a class="btn btn-warning" href="workdelete.php?idate='<?=$value?>'&chasu='<?=$i?>'" onclick="return confirm('<?php echo $i ?> 차수를 삭제할까요?')">
			Del</a></th>

			<? } ?>
            
            <th>최종작업시간</th>
          		
        </tr>  
        </thead>  
  
        <?php  
        //$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
	    $sql = "SELECT y.blk,x.geocode,x.geoname,";
		
		for ($i=1 ;$i<$chasu;$i++) { 
			$sql .="MAX(case when y.chasu = '$i' then y.cha ELSE '' END) as col$i,"; 
		}
		$sql = rtrim($sql, ','); // remove last separator
		$sql .=" ,y.worktime FROM (SELECT * FROM geoinfo WHERE tpl='Y')x LEFT JOIN (SELECT x.blk,ifnull(a.geocode,'100') as 'geo',COUNT(x.chasu) as 'cha' , x.chasu,x.worktime FROM (SELECT blk,itemcode, b.chasu,b.worktime from labelcjimsi b where idate='$value')x LEFT JOIN iteminfo a ON x.itemcode = a.itemcode GROUP BY a.georae,x.chasu)y ON x.geocode = y.geo GROUP BY x.geoname order by y.chasu desc,x.pid asc";
		

			   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		 

       /*
         //과거 버ㅂ



	    //$stmt = $con->prepare("SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
	    $sql = "SELECT y.blk,x.geocode,x.geoname,";
		
		for ($i=1 ;$i<$chasu;$i++) { 
			$sql .="MAX(case when y.chasu = '$i' then y.cha ELSE '' END) as col$i,"; 
		}
		$sql = rtrim($sql, ','); // remove last separator
		$sql .=" ,y.worktime FROM (SELECT * FROM geoinfo WHERE tpl='Y')x LEFT JOIN (SELECT blk,geocode,COUNT(b.chasu) as cha , b.chasu,b.worktime from labelmain b where idate='$value' group BY b.chasu)y ON x.geocode = y.geocode GROUP BY x.geoname";
		

			   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		*/
		
		$stmt = $con->prepare($sql);
	
		
	    $stmt->execute();
 
	    if ($stmt->rowCount() > 0)
            {
                $nocount =0;
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	            {
		           extract($row);
				   $nocount++;
       
	
		?>  
			<tr> 
			<td><?=$nocount?></td>
			<td><input name='check' type='checkbox' style="width:20px;height:20px;" value='<?=$geocode?>' <? if ($blk=='Y') { ?> checked <? }; if($blk=='') {?> checked <? } 
		   
		
		       ?>></td>
			<td><?php echo $geoname;  ?></td> 
			<? for ($i=1 ;$i<$chasu;$i++) { ?>
			<td><? 
			
		      $col = 'col'.$i;
		 
		       echo $$col ;?></td>

			<? } ?>
			<td><?php echo $worktime;  ?></td> 
			</tr>
		
        <?php
			
                }
             }
        ?>  
        </table>  
</div>
<!-- 80%size Modal at Center -->
<div class="modal modal-center fade" id="my80sizeCenterModal" tabindex="-1" role="dialog" aria-labelledby="my80sizeCenterModalLabel">
  <div class="modal-dialog modal-80size modal-center" role="document">
    <div class="modal-content modal-80size">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">유통이력 입력하기</h4>
      </div>
      <div class="modal-body">
       <table id="table" class="table table-bordered table-hover table-striped" style="border: 1px solid; border-collapse: collapse;">
        <thead>  
        <tr style="border: solid 1px;">  
            <th style="border: solid 1px;"><input type='checkbox'></th> 
			<th style="border: solid 1px ; padding:0px;" NOWRAP>품목코드</th>  
            <th style="border: solid 1px ; padding:0px;" NOWRAP>품목명</th>
    
			<th style="border: solid 1px ; padding:0px;" NOWRAP>제조일자</th>
			<th style="border: solid 1px ; padding:0px;" NOWRAP>개월</th>
			<th style="border: solid 1px ; padding:0px;" NOWRAP>비고</th>
			
        </tr>
		</thead>  
		<tbody id="my-tbody">

		 <?  
	      $sql = "SELECT itemcode,itemname,productiondate,expire from iteminfo where productiondate!='' ";		 
	      $stmt = $con->prepare($sql);
		  $stmt->execute();
		  if ($stmt->rowCount() > 0)
          {
	           while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	           {
		       extract($row);
			 
          ?>
		<tr style="border: solid 1px;">
		    <td style="border: 1px solid;"><input type='checkbox'></td> 
			<td style="border: 1px solid; padding:0px;"><input type='text' size="35" style="width:100%; height :33px;border:0;" value="<?=$itemcode?>"></td>  
            <td style="border: 1px solid; padding:0px;"><input type='text' size="80" style="width:100%;height :33px;border:0;" value="<?=$itemname?>"></td>
            <td style="border: 1px solid; padding:0px;"><input type='text' size="20" style="width:100%; height :33px;border:0;" value="<?=$productiondate?>"></td>
            <td style="border: 1px solid; padding:0px;"><input type='text' size="20" style="width:100%; height :33px;border:0;" value="<?=$expire?>"></td>
            <td style="border: 1px solid; padding:0px;"><input type='text' size="50" style="width:100%; height :33px;border:0;" value="<?=etc?>"></td>
		
        
		</tr>
		<?
			   }
		  }
			?>
		</tbody>
     </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>
<!-- 80%size Modal at Center -->
<div id="side">준비중입니다. 클릭하지 마세요 </div>

<script>

$(document).ready(function(){
    for (var i = 0; i < sessionStorage.length; i++) {
 

	var n = sessionStorage.getItem("cut"+i);

    if (n==='Y')
    {
		$("input:checkbox[id=cut"+i+"]").prop("checked", true);
    }
	else {

        $("input:checkbox[id=cut"+i+"]").prop("checked", false);

	}
    }
    //if($("input:checkbox[id='" + chkValue + "']").is(":checked")){ // 체크했을 때,

});
$("input:checkbox").on('click', function() { 
	 if( $(this).prop('checked') ){


	  $(this).prop("checked", true);
	  var click_val =  $(this).attr('id');
      sessionStorage.setItem(click_val, "Y"); 
       
     }
     else {
       $(this).prop("checked", false);
	   var click_val =  $(this).attr('id');
       sessionStorage.setItem(click_val, "N"); 

    }
 });
function windowSize(root, value, num) {   
	var popupWidth = 800;
	var popupHeight = 900;
    var processdate = document.getElementById('datePicker').value;
	

    root = root + '?processdate='+processdate+'&chasu='+value;
	var popupX = (window.screen.width / 2) - (popupWidth / 2);
	// 만들 팝업창 width 크기의 1/2 만큼 보정값으로 빼주었음

	var popupY= (window.screen.height / 2) - (popupHeight / 2);
	// 만들 팝업창 height 크기의 1/2 만큼 보정값으로 빼주었음


     num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=800, width=900, left='+ popupX + ', top='+ popupY;
	
	window.open(root, value, num);   
	
	//var status = "toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,width=240, height=200, top=0,left=20";

}
function checkboxclick(){
var check = $("#checkall").prop("checked");
$("input[name=check]").prop("checked", check);
}

function label(){
  var processdate = document.getElementById('datePicker').value;
  var chasu = document.getElementById('chasu').value-1;
  location.href="iaanlabel://"+processdate+','+chasu;  

}

var processdate = document.getElementById('datePicker').value;
var chasu = document.getElementById('chasu').value;



function gridExcelToWeb(file, center, target,filenum){
    
	var reader = new FileReader(); 
    reader.onload = function (evt) {
        if (evt.target.readyState == FileReader.DONE) {
            var data = evt.target.result;  //해당 데이터, 웹 서버에서 ajax같은거로 가져온 blob 형태의 데이터를 넣어주어도 동작 한다.
       
			data = new Uint8Array(data);
			
            var workbook = XLSX.read(data, {type : 'array' , cellDates: false});
			


            var sheetName = '';
            workbook.SheetNames.forEach( function(data, idx){   //시트 여러개라면 이 안에서 반복문을 통해 돌리면 된다.
                if(idx == 0){
                    sheetName = data;
					
                }
            });
            test1 = workbook;
          
            var jsondata= XLSX.utils.sheet_to_json (workbook.Sheets[sheetName],{skipHeader: true});
			//jason으로 파일 보내기 
			
            
			//check를 가진 값의 이름을 가져오기
			var blacklist = new Array();
			var size = document.getElementsByName("check").length;
			for(var i = 0; i < size; i++){

				 if(document.getElementsByName("check")[i].checked == true){  
					
					 blacklist.push(document.getElementsByName("check")[i].value);
					 
				}
			}
			//센터별 인쇄시 컷팅정보

			var cuttinglist = new Array();
			var cutsize = document.getElementsByName("cut").length;
			for(var i = 0 ; i <cutsize ;i++){

				if(document.getElementsByName("cut")[i].checked == true){
					cuttinglist.push(document.getElementsByName("cut")[i].value);
				
				}


				
			}
			var xhr = new XMLHttpRequest();
     
			if (jsondata[0]['1차 가마감']==='입고장')
			{
                xhr.open('POST', 'label_welstory.php');
			}
			else if (jsondata[0]['주문KEY'])
			{
                xhr.open('POST', 'label_spc.php');
			}
			else{
			xhr.open('POST', 'json_labeldata.php');}
			 
			xhr.setRequestHeader("Content-Type", "application/json");
			   
            xhr.send(JSON.stringify({"filenum" : filenum , "daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"cuttinglist" : cuttinglist ,"maindata" : jsondata})); 
            xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
            
			
			   var _tzs = xhr.responseText;
               if (_tzs)
               {
                    alert(_tzs);
					location.reload();
			   }
			   
			   document.querySelector('#side').innerHTML = _tzs;
               
             }
            }

        
	
        }
    };
    reader.readAsArrayBuffer(file);
 

	

}   
 
$('#file').change( function(){
    var result= confirm("실행하시겠습니까?");
	if (result)
	{
	    //document.write("<h1> 실행합니다. </h1>")
		fileList = $(this)[0].files;  //파일 대상이 리스트 형태로 넘어온다.

		for(var i=0;i < fileList.length;i++){
			//var file = fileList[i];
		////const selectedFile = $(this)[0].files[0];
		
		var selectedFile = fileList[i];
		
		var name =selectedFile.name; 
			
		var startpoint = name.lastIndexOf("."); 

        var filename = (name.substring(startpoint+1,selectedFile.length)).trim();

       

        if (filename ==="xlsx" || filename==="xls")
        {
			
				 //	평/왜/용/광
			var sPandan = name.indexOf("xlsx");
			if (sPandan > 0)
			{
			   var center =(name.substring(sPandan+4,sPandan+8)).trim();
			}
			
			gridExcelToWeb(selectedFile, center, $('#grid'+i),i); 
			

        }
		else if (filename ==="txt")
		{
			processFile(selectedFile);
		}
		else{
            alert("처리파일이 아닙니다.");
			return;

		}	
	  } 
	  $("#file1").val("");
	 
	}else{

       $("#file1").val(""); //크롬에서만 작동 ......크롬 권장

	}

       
});
//text file process
function processFile(file){
	var reader = new FileReader();
	reader.readAsText(file,"euc-kr");
	
	reader.onload = function () {
	//var table = '<TABLE WIDTH="100%" CELLSPACING=0 border="1"><TR>';	
    var filedata = reader.result;
    
	var cells = filedata.split('\n').map(function (el) { return el.split('	'); });
	 
    //var headings = cells.shift();
    //var headings = ['no','gubun','itemcode','itemname','ddate','state','kindof','temp','palzu','customercode',	'customer','ipsu','ipgoplace1','ipgozone1','bus1','surang1','deliver1','special1','ipgoplace2','ipgozone2',	'bus2','surang2','deliver2','special2','change','changsu','unit','diffnum','alzunum','palzuitem',	'ordernum','orderitmenum','done','sorter'];
	var headings = cells[2];
    cells.splice(0,3);
	
    
	var obj = cells.map(function (el) {
	var obj = {};
	

	for (var i = 0, l = el.length; i < l; i++) {
		obj[headings[i]] = isNaN(Number(el[i])) ? el[i] : +el[i];
	
	}
	  return obj;
	});


    var xhr = new XMLHttpRequest();
	xhr.open('POST', 'label_shinsegye.php');
	 
	xhr.setRequestHeader("Content-Type", "application/json");
	//xhr.send(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));   
	xhr.send(JSON.stringify({"daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"maindata" : obj})); 
    xhr.onreadystatechange = function(){
	if(xhr.readyState === 4 && xhr.status === 200){
	
	
	   var _tzs = xhr.responseText;
	   if (_tzs)
	   {
			alert(_tzs);
	   }
	   
	   document.querySelector('#side').innerHTML = _tzs; 
	 }
	}

   }
}
</script>
</html>