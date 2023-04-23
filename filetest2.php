<button onclick="openTextFile()">Open</button>

 <div id="T1"></div>

 <script>
     function openTextFile(){
	var input = document.createElement("input");
	
	console.log(input);
	input.type = "file";
	// html일 경우 text/html로 
    input.accept = "text/plain, text/html, .jsp";

	 input.click();
	 input.onchange = function (event) {
	        processFile(event.target.files[0]);
	    };
	    
}


function processFile(file){
	var reader = new FileReader();
	reader.readAsText(file,"EUC-KR");
	
	reader.onload = function () {
	var table = '<TABLE WIDTH="100%" CELLSPACING=0 border="1"><TR>';	
    var filedata = reader.result;
    
	var fileArray = filedata.split('\n');
	 

	
	    
	for (var i=0; i<fileArray.length; i++) {
	var rowArray = fileArray[i].split('	');
	
	var row = '';
	for (var j=0; j<rowArray.length; j++) {					
		row += '<TD><FONT SIZE=2> <P>' + rowArray[j] + '</FONT></TD>';
	}
	table += '<TR VALIGN=TOP>' + row  + '</TR>';	
    }
    table += '</table>';
	
	document.getElementById('T1').innerHTML = table;
	
	
	
	
	
	
	}
	
	
	
	
    
          
    
	};

	



 </script>