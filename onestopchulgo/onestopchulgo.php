<style>
#excelFile { float: right; clear: both; 
             margin-left: 3px; 
			 height : 34px; 
			 margin-right:14px;
			 padding: 3px}
</style>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>
<script>
 $(document).ready(function(){
	           
	
				$('ul.tabs li').click(function(){							//선택자를 통해 tabs 메뉴를 클릭 이벤트를 지정해줍니다.
					var tab_id = $(this).attr('data-tab');
					

					$('ul.tabs li').removeClass('current');			//선택 되있던 탭의 current css를 제거하고 
					$('.tab-content').removeClass('current');		

					$(this).addClass('current');								////선택된 탭에 current class를 삽입해줍니다.
					$("#" + tab_id).addClass('current');
				})

			});
				
function excelExport(event){
	excelExportCommon(event, handleExcelDataAll);
}
function excelExportCommon(event, callback){
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function(){
        var fileData = reader.result;
        var wb = XLSX.read(fileData, {type : 'binary' ,cellDates: false , dateNF: 'mm/dd/yyyy;@'});
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
  
	xhr.open('POST', 'onestopchulgopost.php');
	 
	xhr.setRequestHeader("Content-Type", "application/json");
	   
	xhr.send(JSON.stringify({"maindata" : (XLSX.utils.sheet_to_json (sheet))})); 
	xhr.onreadystatechange = function(){
	if(xhr.readyState === 4 && xhr.status === 200){
	
	
	   var _tzs = xhr.responseText;
	   if (_tzs)
	   {
			alert(_tzs);
			document.querySelector('#side').innerHTML = _tzs;
			//location.reload();
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
         window.location.assign('../down/basic.xlsx');
}
		

</script>
<div class="container">
<!-- 탭 메뉴 상단 시작 -->
	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1">조회</li>
		<li class="tab-link" data-tab="tab-2">데이타관리</li>
	</ul>
<!-- 탭 메뉴 상단 끝 -->
<!-- 탭 메뉴 내용 시작 -->
	<div id="tab-1" class="tab-content current">
		<h1>출고 엑셀 스타일 조회</h1>
		<div class="text-right">
			<button class="btn btn-success" onclick="editclick()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
			<button class="btn btn-warning" onclick="del()"><span class="glyphicon glyphicon-remove"></span> Del</button>
			<input class="btn btn-primary" type="file" id="excelFile" onchange="excelExport(event)"/>
		</div>
		<div id="side"></div>
		<p><? include 'onestop_main_client.php' ?>
	</div>
	
	<div id="tab-2" class="tab-content">
		<h1>데이타 입력히스토리</h1>
		<p><? include 'onestop_sub_client.php' ?>
  
	</div>
	
  
<!-- 탭 메뉴 내용 끝 -->
<div>