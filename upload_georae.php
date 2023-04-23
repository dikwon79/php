<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>거래처 일괄 업로드</title>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>
<script>
function excelExport(event){
	excelExportCommon(event, handleExcelDataAll);
}
function excelExportCommon(event, callback){
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var fileData = reader.result;
        var wb = XLSX.read(fileData, {type : 'binary' ,cellDates: true , dateNF: 'mm/dd/yyyy;@'});
        var sheetNameList = wb.SheetNames; // 시트 이름 목록 가져오기 
        var firstSheetName = sheetNameList[0]; // 첫번째 시트명
        var firstSheet = wb.Sheets[firstSheetName]; // 첫번째 시트 
        callback(firstSheet);      
    };
    reader.readAsBinaryString(input.files[0]);
}
function handleExcelDataAll(sheet){
	//handleExcelDataHeader(sheet); // header 정보 
	//handleExcelDataJson(sheet); // json 형태
	//handleExcelDataCsv(sheet); // csv 형태
	handleExcelDataHtml(sheet); // html 형태
}
function handleExcelDataHeader(sheet){
    var headers = get_header_row(sheet);
    $("#displayHeaders").html(JSON.stringify(headers));
}
function handleExcelDataJson(sheet){
    $("#displayExcelJson").html(JSON.stringify(XLSX.utils.sheet_to_json (sheet)));
}
function handleExcelDataCsv(sheet){
    $("#displayExcelCsv").html(XLSX.utils.sheet_to_csv (sheet));
}
function handleExcelDataHtml(sheet){
    $("#displayExcelHtml").html(XLSX.utils.sheet_to_html (sheet));

    var xhr = new XMLHttpRequest();
  
	xhr.open('POST', 'upload_georaepost.php');
	 
	xhr.setRequestHeader("Content-Type", "application/json");
	   
	xhr.send(JSON.stringify({"maindata" : (XLSX.utils.sheet_to_json (sheet))})); 
	xhr.onreadystatechange = function(){
	if(xhr.readyState === 4 && xhr.status === 200){
	
	
	   var _tzs = xhr.responseText;
	   if (_tzs)
	   {
			alert(_tzs);
			location.reload();
	   }
	   
	  
	   
	 }
	}





}

function get_header_row(sheet) {
    var headers = [];
    var range = XLSX.utils.decode_range(sheet['!ref']);
    var C, R = range.s.r; /* start in the first row */
    /* walk every column in the range */
    for(C = range.s.c; C <= range.e.c; ++C) {
        var cell = sheet[XLSX.utils.encode_cell({c:C, r:R})] /* find the cell in the first row */

        var hdr = "UNKNOWN " + C; // <-- replace with your desired default 
        if(cell && cell.t) hdr = XLSX.utils.format_cell(cell);

        headers.push(hdr);
    }
    return headers;
}

function downget(){
         window.location.assign('../down/centerupload.xlsx');
}
</script>
</head>
<?php

    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==3) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 

 
    include('headitem.php');
?>


<body>
<div class="container">
	<div class="page-header">
    	<h1 class="h2">&nbsp; 거래처 일괄업로드</h1><hr>
    </div>
<div class="row">


파일 선택 : <input type="file" id="excelFile" onchange="excelExport(event)"/>

<h1>엑셀만 업로드 가능합니다.</h1>
<button type="button" class="btn btn-default" onclick="fnExcelReport('table', '거래처업로드')">거래처업로드엑셀</button>
<!-- <button type="button" class="btn btn-primary" onclick="downget()">샘플다운</button> -->
<div id="displayExcelHtml"></div>
<div>
	<?
    try { 

                $sql = "SELECT useY,tpl,geocode,geoname,labeltype,geobunryu,geogubun,geoboss,businessNum,tel,fax,posnum,address,yeop,jongmok,gita,account1,account2,account3
,recharger1,recharger2,recharger3,startdate from geoinfo";
				$stmt = $con->prepare($sql);

				$stmt->execute();
			   
			} catch(PDOException $e) {
				die("Database error. " . $e->getMessage()); 
			}

			$row = $stmt->fetch();  
	?>	
	 <table id="table" class="table table-bordered table-hover table-striped" style="ml-0 table-layout: fixed ; width: 100%">
				<thead>  
				<tr style="border: solid 1px;"> 
				    <th style="border: solid 1px ; padding:0px;" NOWRAP>useY</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>tpl</th>  
					<th style="border: solid 1px ; padding:0px;" NOWRAP>geocode</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>geoname</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>labeltype</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>geobunryu</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>geogubun</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>geoboss</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>businessNum</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>tel</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>fax</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>posnum</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>address</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>yeop</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>jongmok</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>gita</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>account1</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>account2</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>account3</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>recharger1</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>recharger2</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>recharger3</th>
					<th style="border: solid 1px ; padding:0px;" NOWRAP>startdate</th>		
                </tr>
				</thead>

                <?  $stmt = $con->prepare($sql);
	
		
					$stmt->execute();
			 
					if ($stmt->rowCount() > 0)
						{
							$i=0;
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
							   extract($row);
				        
							   $i++;
				
					?>  



				<tbody>
                <tr style="border: solid 1px;"> 
				    <!--<td style="border: 1px solid; padding:0px;"><input type='text' id='in_5_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$companyname?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_1_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$center?>'></td>  
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_2_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$centername?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_3_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$grouping?>'></td>
					<td style="border: 1px solid; padding:0px;"><input type='text' id='in_4_<?=$i?>' size="20" style="width:100%; height :33px;border:0;" value='<?=$printinfo?>'></td>
		             -->   
                  
		            <td style="border: 1px solid; padding:0px;"><?=$useY?></td>
					<td style="border: 1px solid; padding:0px;"><?=$tpl?></td>  
					<td style="border: 1px solid; padding:0px;"><?=$geocode?></td>
					<td style="border: 1px solid; padding:0px;"><?=$geoname?></td>
					<td style="border: 1px solid; padding:0px;"><?=$labeltype?></td>
					<td style="border: 1px solid; padding:0px;"><?=$geobunryu?></td>
					<td style="border: 1px solid; padding:0px;"><?=$geogubun?></td>
					<td style="border: 1px solid; padding:0px;"><?=$geoboss?></td>
					<td style="border: 1px solid; padding:0px;"><?=$businessNum?></td>
					<td style="border: 1px solid; padding:0px;"><?=$tel?></td>
					<td style="border: 1px solid; padding:0px;"><?=$fax?></td>
					<td style="border: 1px solid; padding:0px;"><?=$posnum?></td>
					<td style="border: 1px solid; padding:0px;"><?=$address?></td>
					<td style="border: 1px solid; padding:0px;"><?=$yeop?></td>
					<td style="border: 1px solid; padding:0px;"><?=$jongmok?></td>
					<td style="border: 1px solid; padding:0px;"><?=$gita?></td>
					<td style="border: 1px solid; padding:0px;"><?=$account1?></td>
					<td style="border: 1px solid; padding:0px;"><?=$account2?></td>
					<td style="border: 1px solid; padding:0px;"><?=$account3?></td>
					<td style="border: 1px solid; padding:0px;"><?=$recharger1?></td>
					<td style="border: 1px solid; padding:0px;"><?=$recharger2?></td>
					<td style="border: 1px solid; padding:0px;"><?=$recharger3?></td>
					<td style="border: 1px solid; padding:0px;"><?=$startdate?></td>

                </tr>
				<? }  }?>
				</tbody>
          </table>




</div>

</div>
</div>

</body>
</html>