<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>출고검증데이타 점검</title>

	<style>
	  .command_bar {
		  font-size: 12pt;
		  background-color: #FEFFD2;
		  border: 1px solid #AF9E29;
		  padding: 5px;
		  margin-bottom: 10px;
		}
	</style>
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
			handleExcelDataHeader(sheet); // header 정보 
			handleExcelDataJson(sheet); // json 형태
			handleExcelDataCsv(sheet); // csv 형태
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
		  
			xhr.open('POST', 'upload_chulgocheckpost.php');
			 
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

        function compare(geocode)
		{
		  
		   var xmlhttp=new XMLHttpRequest();
		   var inameD= "myTable";
		   
		   xmlhttp.open("GET","upload_chulgocheckpost.php?geocode="+geocode,false);
		   xmlhttp.send(null);
		   
		   document.getElementById(inameD).innerHTML=xmlhttp.responseText;;
		 

		}
	    $(document).ready( function() {
		$('#file').change( function(){
			var result= confirm("실행하시겠습니까?");
			if (result)
			{
				//document.write("<h1> 실행합니다. </h1>")
				fileList = $(this)[0].files;  //파일 대상이 리스트 형태로 넘어온다.
				var count = fileList.length-1;
				
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
					   var center =(name.substring(sPandan+4,sPandan+7)).trim();
					}
					
					
				
					//gridExcelToWeb(selectedFile, center, $('#grid'+i),i,count); 
						 

				}
				
				else{
					alert("처리파일이 아닙니다.");
					return;

				}	
			  } 
			  $("#file").val("");



			 
			}else{

			   $("#file").val(""); //크롬에서만 작동 ......크롬 권장

			}

			

		});
        });
	</script>
</head>

<body>
<div class="command_bar">
 <div class="row">	출고검증용 엑셀을 업로드해주세요.</div>
   <div class="row">
   <div class="col-sm-6"><input type="file" id="file2" onchange="excelExport(event)"/></div>
   <div class="col-sm-2"><input class="pt-3" type='file'  id='file' multiple /></div>  <!-- webkitdirectory directory -->
   <div class="col-sm-6"><button type="button" class="btn btn-primary" onclick="">비교검색</button></div>
  </div>
  
</div>
준비중, 세부데이타에서 출고검증 엑셀 다운 가능합니다.