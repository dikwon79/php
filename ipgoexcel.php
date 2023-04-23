<html>
<head>
  <title>엑셀업로드</title> 
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>
  <script>
    var datacount = 0;
    function printNow() {
	  var section1s = document.getElementsByClassName("command_bar");  
	  for(var i = 0; i < section1s.length; i++ ){ 
		  var section1 = section1s.item(i); 
		  section1.style.display = 'none'; }
    }
  
		
	function excelExport(event){
		excelExportCommon(event, handleExcelDataAll);
	}
	function excelExportCommon(event, callback){
		var input = event.target;
		var reader = new FileReader();
		reader.onload = function(){
			var fileData = reader.result;
			var wb = XLSX.read(fileData, {type : 'binary'});
			var sheetNameList = wb.SheetNames; // 시트 이름 목록 가져오기 
			var firstSheetName = sheetNameList[0]; // 첫번째 시트명
			var firstSheet = wb.Sheets[firstSheetName]; // 첫번째 시트 
			callback(firstSheet);      
		};
		reader.readAsBinaryString(input.files[0]);
	}
	function handleExcelDataAll(sheet){
	
		handleExcelDataJson(sheet); // json 형태
		handleExcelDataHtml(sheet);
		
	}
	
	function handleExcelDataJson(sheet){
		var jsondata= XLSX.utils.sheet_to_json (sheet);

		//$("#displayExcelJson").html(jsondata[0]['itemname']);

		
		$("#displayExcelJson").html('총 데이타 수 :'+jsondata.length);
		//$("#displayExcelJson").html(jsondata);
        datacount = jsondata.length;
	}
	
	function handleExcelDataHtml(sheet){
		$("#displayExcelHtml").html(XLSX.utils.sheet_to_html (sheet)); 
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
	function removeComma(str)
	{

		if (str==="")
        {		
			return 0;
        }

		n = parseInt(str.replace(/,/g,""));
        
		return n;


	}
	function upload(){
           for (var i=1;i<datacount+1;i++ )
           {
			    opener.add_row();
				var row = Number(i+1);
				opener.document.getElementById('row_code'+i).value = document.getElementById('sjs-A'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_mappingcode'+i).value = document.getElementById('sjs-A'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_name'+i).value = document.getElementById('sjs-B'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_box'+i).value = removeComma(document.getElementById('sjs-D'+row).innerText); //일반적인 방법
                opener.document.getElementById('row_ea'+i).value = removeComma(document.getElementById('sjs-E'+row).innerText); //일반적인 방법

				
				opener.document.getElementById('row_surang'+i).value = removeComma(document.getElementById('sjs-F'+row).innerText); //일반적인 방법
				opener.document.getElementById('row_price'+i).value = document.getElementById('sjs-G'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_supply'+i).value = document.getElementById('sjs-H'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_tax'+i).value = document.getElementById('sjs-I'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_expire'+i).value = document.getElementById('sjs-J'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_hap'+i).value = document.getElementById('sjs-K'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_etc'+i).value = document.getElementById('sjs-L'+row).innerText; //일반적인 방법
				opener.document.getElementById('row_code'+row).focus();
           }       
           self.close();
   



    }	
    function downget(){
         window.location.assign('../down/ipgoexcel.xlsx');
	}
  </script>
  <style>
  .command_bar {
	  font-size: 12pt;
	  background-color: #FEFFD2;
	  border: 1px solid #AF9E29;
	  padding: 5px;
	  margin-bottom: 10px;
	}
  </style>
</head>

<body>
<div class="command_bar">
 업로드하고자 하는 파일을 선택하세요. &nbsp;<input type="file" id="excelFile" onchange="excelExport(event)"/><input type="button" value="닫기" onclick="window.close()" />
</div>
<div id="displayExcelJson"></div>
<div id="displayExcelHtml"></div>
<div><button type="button" class="btn btn-primary" onclick="upload()">업로드하기</button><button type="button" class="btn btn-primary" onclick="downget()">입고샘플다운</button></div>
<div><a href="down/ipgoexcel.xlsx" download>샘플다운 </a></div>
</body>

</html>