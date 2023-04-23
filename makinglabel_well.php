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
    

    
	
	$value = isset($_POST['search']) ? $_POST['search'] : date("Y-m-d");
   
	try { 

                $sql = "SELECT MAX(chasu) from labelmain where idate ='$value'";
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
	   
	   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
       <div class="col-sm-3">
	   <select name="chasu" id="chasu" class="form-control">
			  <? for($i=1;$i<31;$i++){ ?>
			  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?>><? echo $i.'차작업'?></option>
			  <?  }  ?>
			  
		</select>
	   
	   
	   </div>
	   <div class="col-sm-3"><button type="button" class="btn btn-danger" onclick="submit()">조회</button>
	   
	   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MyModal" data-test='aaa'>옵션 보기</button>  
	  
	   <button type="button" class="btn btn-primary" onclick="label()">라벨인쇄</div>
	   <div class="col-sm-3"><input class="pt-3" type='file'  id='file' multiple /></div>
     </form>           
   </div>
  
	<!-- 프린트 영역 ------------------------------------------------------------------------------------------- -->
   <div class="row">
   

	
    <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th><input id="checkall" type="checkBox"/ onclick="checkboxclick()">블랙</th> 
			<th>업체이름</th>
            <? for ($i=1 ;$i<$chasu;$i++) { ?>
			<th><button type="button" class="btn btn-primary" onclick="windowSize('printchong.php',<?=$i?>,'width=900,height=558')"><?=$i.'차';?></th>

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
		$sql .=" ,y.worktime FROM (SELECT * FROM geoinfo WHERE tpl='Y')x LEFT JOIN (SELECT blk,geocode,COUNT(b.chasu) as cha , b.chasu,b.worktime from labelmain b where idate='$value' group BY b.chasu)y ON x.geocode = y.geocode GROUP BY x.geoname";
		

			   //SELECT a.itemcode,a.itemname,a.lek,a.inventory,B.outstock,B.nowstock  FROM iteminfo a,(select * from nowinven b)B where a.itemcode = B.itemcode AND B.idate=:var_idate");
		
		
		$stmt = $con->prepare($sql);
	
		
	    $stmt->execute();
 
	    if ($stmt->rowCount() > 0)
            {
                while($row=$stmt->fetch(PDO::FETCH_ASSOC))
	            {
		           extract($row);
       
	
		?>  
			<tr>  
			<td><input name='check' type='checkbox' value='<?=$geocode?>' <? if ($blk=='Y') { ?> checked <? }; if($blk=='') {?> checked <? } 
		   
		
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
<div id="side">준비중입니다. 클릭하지 마세요 </div>

<script>
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
  alert('준비중입니다.');

	   }

var processdate = document.getElementById('datePicker').value;
var chasu = document.getElementById('chasu').value;

//check를 가진 값의 이름을 가져오기
var blacklist = new Array();
var size = document.getElementsByName("check").length;
for(var i = 0; i < size; i++){
	 if(document.getElementsByName("check")[i].checked == true){  
	
		 blacklist.push(document.getElementsByName("check")[i].value);
		 
	}
}


function gridExcelToWeb(file, target){
    
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
       
           
			//jason으로 파일 보내기 
			
			//alert(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));
             // 객체 생성
		    
				//alert(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));   
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'json_labeldata.php');
			 
			xhr.setRequestHeader("Content-Type", "application/json");
			//xhr.send(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));   
           
            xhr.onreadystatechange = function(){
            if(xhr.readyState === 4 && xhr.status === 200){
            
			
			   var _tzs = xhr.responseText;
               if (_tzs ==="success")
               {
                    alert("저장하였습니다."+i);
			   }
			   
			   document.querySelector('#side').innerHTML = _tzs; 
             }
            }

			xhr.send(JSON.stringify({"daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"maindata" : XLSX.utils.sheet_to_json (workbook.Sheets[sheetName],{header:["S","h","e","e_1","t","J","S_1"]})})); 


           	

            //document.getElementById('side').innerHTML=xhr.responseText;;
		   
		   //if (xmlhttp.responseText=="sucess")
		  // {
		  //   alert("저장하였습니다.");
		  // }
		  // else alert("에러");
		    


			var toHtml = XLSX.utils.sheet_to_html(workbook.Sheets[sheetName], { header: '' ,});
           
            target.html(toHtml);
            target.find('table').attr({class:'table table-bordered',id:'excelResult  '});  //id나 class같은거를 줄 수 있다.
            test2 = toHtml;
            $('#excelResult').find('tr').each(function(idx){
                if(idx < 1 ){ 
                    $(this).css({'background-color':'#969da5a3'});
                }
            });
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
			alert('엑셀입니다');
			gridExcelToWeb(selectedFile,  $('#grid'+i)); 
        }
		else if (filename ==="txt")
		{
			alert("txt입니다");
			processFile(selectedFile);
		}
		else{
            alert("처리파일이 아닙니다.");
			return;

		}	
	  } 
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
	xhr.open('POST', 'makinglabel_spc.php');
	 
	xhr.setRequestHeader("Content-Type", "application/json");
	//xhr.send(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));   
   
	xhr.onreadystatechange = function(){
	if(xhr.readyState === 4 && xhr.status === 200){
	
	
	   var _tzs = xhr.responseText;
	   if (_tzs ==="success")
	   {
			alert("저장하였습니다."+i);
	   }
	   
	   document.querySelector('#side').innerHTML = _tzs; 
	 }
	}

	xhr.send(JSON.stringify({"daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"maindata" : obj})); 


    }
}
</script>
</html>