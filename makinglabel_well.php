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
    	<h1 class="h2">&nbsp; �󺧹���</h1><hr>
    </div>

    <div id="navhead">
    <form class="navbar" role="search" method="post" action="">
       
       <div class="col-sm-3">
	   
	   <input type="text" id="datePicker" name='search' class="form-control" value="<? echo $value;?>"></div>
       <div class="col-sm-3">
	   <select name="chasu" id="chasu" class="form-control">
			  <? for($i=1;$i<31;$i++){ ?>
			  <option value='<?=$i?>' <? if($chasu ==$i) echo "selected"; ?>><? echo $i.'���۾�'?></option>
			  <?  }  ?>
			  
		</select>
	   
	   
	   </div>
	   <div class="col-sm-3"><button type="button" class="btn btn-danger" onclick="submit()">��ȸ</button>
	   
	   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#MyModal" data-test='aaa'>�ɼ� ����</button>  
	  
	   <button type="button" class="btn btn-primary" onclick="label()">���μ�</div>
	   <div class="col-sm-3"><input class="pt-3" type='file'  id='file' multiple /></div>
     </form>           
   </div>
  
	<!-- ����Ʈ ���� ------------------------------------------------------------------------------------------- -->
   <div class="row">
   

	
    <table id="table" class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
        <thead>  
        <tr>  
            <th><input id="checkall" type="checkBox"/ onclick="checkboxclick()">��</th> 
			<th>��ü�̸�</th>
            <? for ($i=1 ;$i<$chasu;$i++) { ?>
			<th><button type="button" class="btn btn-primary" onclick="windowSize('printchong.php',<?=$i?>,'width=900,height=558')"><?=$i.'��';?></th>

			<? } ?>
            
            <th>�����۾��ð�</th>
          		
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
<div id="side">�غ����Դϴ�. Ŭ������ ������ </div>

<script>
function windowSize(root, value, num) {   
	var popupWidth = 800;
	var popupHeight = 900;
    var processdate = document.getElementById('datePicker').value;
	

    root = root + '?processdate='+processdate+'&chasu='+value;
	var popupX = (window.screen.width / 2) - (popupWidth / 2);
	// ���� �˾�â width ũ���� 1/2 ��ŭ ���������� ���־���

	var popupY= (window.screen.height / 2) - (popupHeight / 2);
	// ���� �˾�â height ũ���� 1/2 ��ŭ ���������� ���־���


     num='toolbar=no,directories=no,status=no, resizable=no,menubar=no,height=800, width=900, left='+ popupX + ', top='+ popupY;
	
	window.open(root, value, num);   
	
	//var status = "toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,width=240, height=200, top=0,left=20";

}
function checkboxclick(){
var check = $("#checkall").prop("checked");
$("input[name=check]").prop("checked", check);
}
function label(){
  alert('�غ����Դϴ�.');

	   }

var processdate = document.getElementById('datePicker').value;
var chasu = document.getElementById('chasu').value;

//check�� ���� ���� �̸��� ��������
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
            var data = evt.target.result;  //�ش� ������, �� �������� ajax�����ŷ� ������ blob ������ �����͸� �־��־ ���� �Ѵ�.
       
			data = new Uint8Array(data);
			
            var workbook = XLSX.read(data, {type : 'array' , cellDates: false});
			


            var sheetName = '';
            workbook.SheetNames.forEach( function(data, idx){   //��Ʈ ��������� �� �ȿ��� �ݺ����� ���� ������ �ȴ�.
                if(idx == 0){
                    sheetName = data;
					
                }
            });
            test1 = workbook;
       
           
			//jason���� ���� ������ 
			
			//alert(JSON.stringify(XLSX.utils.sheet_to_json (workbook.Sheets[sheetName])));
             // ��ü ����
		    
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
                    alert("�����Ͽ����ϴ�."+i);
			   }
			   
			   document.querySelector('#side').innerHTML = _tzs; 
             }
            }

			xhr.send(JSON.stringify({"daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"maindata" : XLSX.utils.sheet_to_json (workbook.Sheets[sheetName],{header:["S","h","e","e_1","t","J","S_1"]})})); 


           	

            //document.getElementById('side').innerHTML=xhr.responseText;;
		   
		   //if (xmlhttp.responseText=="sucess")
		  // {
		  //   alert("�����Ͽ����ϴ�.");
		  // }
		  // else alert("����");
		    


			var toHtml = XLSX.utils.sheet_to_html(workbook.Sheets[sheetName], { header: '' ,});
           
            target.html(toHtml);
            target.find('table').attr({class:'table table-bordered',id:'excelResult  '});  //id�� class�����Ÿ� �� �� �ִ�.
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
    var result= confirm("�����Ͻðڽ��ϱ�?");
	if (result)
	{
	    //document.write("<h1> �����մϴ�. </h1>")
		fileList = $(this)[0].files;  //���� ����� ����Ʈ ���·� �Ѿ�´�.

		for(var i=0;i < fileList.length;i++){
			//var file = fileList[i];
		////const selectedFile = $(this)[0].files[0];
		
		var selectedFile = fileList[i];
		
		
		
		
		var name =selectedFile.name; 
			
		var startpoint = name.lastIndexOf("."); 

        var filename = (name.substring(startpoint+1,selectedFile.length)).trim();

        
        if (filename ==="xlsx" || filename==="xls")
        {
			alert('�����Դϴ�');
			gridExcelToWeb(selectedFile,  $('#grid'+i)); 
        }
		else if (filename ==="txt")
		{
			alert("txt�Դϴ�");
			processFile(selectedFile);
		}
		else{
            alert("ó�������� �ƴմϴ�.");
			return;

		}	
	  } 
	}else{

       $("#file1").val(""); //ũ�ҿ����� �۵� ......ũ�� ����

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
			alert("�����Ͽ����ϴ�."+i);
	   }
	   
	   document.querySelector('#side').innerHTML = _tzs; 
	 }
	}

	xhr.send(JSON.stringify({"daten" : processdate ,"chasu" : chasu , "blackcheck" : blacklist ,"maindata" : obj})); 


    }
}
</script>
</html>