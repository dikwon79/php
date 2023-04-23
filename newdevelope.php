 <? 
    include('dbcon.php'); 
    include('check.php');
   
    if (is_login()){

        if ($_SESSION['activate']==1) 
            ;
        else
            header("Location: welcome.php");
    }else
        header("Location: index.php"); 
 
    include('headitem.php');?>

<!DOCTYPE html>
<html>
	<head>
	    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.3/xlsx.full.min.js"></script>
		<script type="text/javascript">
           
		

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
			var jsondata= XLSX.utils.sheet_to_json (sheet);

			$("#displayExcelJson").html(jsondata[0]['itemname']);

			
			//$("#displayExcelJson").html(jsondata.length);
            //$("#displayExcelJson").html(jsondata);

		}
		function handleExcelDataCsv(sheet){
			$("#displayExcelCsv").html(XLSX.utils.sheet_to_csv (sheet));
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
		</script>

       
		
        <style>
        
		  html {
			height: 100%;
			}
			.container{
                width: 95%;
			}
			body {
			margin: 0;
			height: 100%;
			
		 
			}	
			section{
			   position :relative;
			   min-height:75%; 
			}
			#navitem{
               width : 98.5%;
			}
			footer {
			position: relative;
			bottom: 0;
			left: 0;
			right: 0;
			color: white;
			background-color: #333333;
			}
            

		</style>
        
	</head>



	<body>

       <div class="container">
       <section id="main">
					<div class="col-md-2 my-2">
						<div class="list-group">

							<a href="printLabel.php" class="list-group-item active">라벨발행</a>
							<a href="ipgo.php" class="list-group-item">입고입력</a>
							<a href="ipgolist.php" class="list-group-item">입고조회</a>
							<a href="paperofinventory2.php" class="list-group-item">재고장</a>
							<a href="checktodaywork.php" class="list-group-item">출고검증</a>
							<a href="index.html" class="list-group-item">월별통계</a>
							<a href="setting.html" class="list-group-item">setting</a>
						
						</div>
					
					    <div class="p-0 my-2">
							<div class="card text-center pt-2 bg-light">
								<h5 class="pt-2 pb-2">기타 사이트</h5>
								<ul class="list-group">
									<li class="list-group-item">메일</li>
									<li class="list-group-item">cj프레시웨이</li>
									<li class="list-group-item">네이버</li>
									<li class="list-group-item">구글</li>
									<li class="list-group-item">이안로지스</li>
									<li class="list-group-item">송림푸드</li>

								</ul>
							
							</div>
						</div>
					</div>

					<div class="col-md-10 my-2">
                      
							파일 선택 : <input type="file" id="excelFile" onchange="excelExport(event)"/>
							<h1>Header 정보 보기</h1>
							<div id="displayHeaders"></div>
							<h1>JSON 형태로 보기</h1>
							<div id="displayExcelJson"></div>
							<h1>CSV 형태로 보기</h1>
							<div id="displayExcelCsv"></div>
							<h1>HTML 형태로 보기</h1>
							<div id="displayExcelHtml"></div>








              	
				    </div>
				   
	   </section>
       </div>
	   
	    <footer class="footer" style="background-color:#0756b2; color:#ffffff">
        <div class="container">
          <br>
          <div class="row">
            <div class="col-sm-2" style="text-align: center;"><h3>(주)이안로지스</h3></div>
            <div class="col-sm-8">
             본사: 신둔<p>
             제2창고: 백암<p>
             사업자등록번호 :100-00-00000 | TEL:070-0000-0000 | FAX:031-000-0000 | E-mail : dikwon79@naver.com<p>
             COPYRIGHT ⓒ 2020 BY sam , ALL RIGHTS RESERVED.

            </div>
            <div class="col-sm-2" style="text-align: center">
              <div class="list-group">
                <a href="#" class="list-group-item">이메일</a>
                <a href="#" class="list-group-item">본사</a>
                <a href="#" class="list-group-item">지사</a>
              </div>
            </div>
          </div>
        </div>



      </footer>
		
       <?
         //6. 연결 종료
        
		 
		 ?>
		
	
		
 
	</body>
</html> 
