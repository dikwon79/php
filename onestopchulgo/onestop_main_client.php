<script>
	function radio1(a) {
		var obj1 = document.getElementsByName('col1')[0].value;

		var obj2 = document.getElementsByName('col2')[0].value;

		if (a === '1') {
			obj1 = today();
			obj2 = today();
		}
		else if(a === '3'){
		   obj1 = document.getElementById("date3").value;
	
		}

		var form = document.createElement("form");

		form.setAttribute("charset", "UTF-8");

		form.setAttribute("method", "Post"); // Get 또는 Post 입력

		form.setAttribute("action", "https://dikwon79.cafe24.com/onestopchulgo/");

        
		var hiddenField = document.createElement("input");

		hiddenField.setAttribute("type", "hidden");

		if( a ==="3"){
		  hiddenField.setAttribute("name", "date3");
		  
		}else {
		  hiddenField.setAttribute("name", "date1");
        }

		hiddenField.setAttribute("value", obj1);

		form.appendChild(hiddenField);

        if( a !=="3"){
		hiddenField = document.createElement("input");

		hiddenField.setAttribute("type", "hidden");

		hiddenField.setAttribute("name", "date2");

		hiddenField.setAttribute("value", obj2);

		form.appendChild(hiddenField);
	    }
		document.body.appendChild(form);
		form.submit();
       


	}

	function today() {
		var today = new Date();
		var year = today.getFullYear();
		var month = ('0' + (today.getMonth() + 1)).slice(-2);
		var day = ('0' + today.getDate()).slice(-2);

		var dateString = year + '-' + month + '-' + day;
		return dateString;


	}
	function condition(){
	 
		$("#tab-1").removeClass('current');
	    $("#tab-2").addClass('current');
		
		
	}
</script>

<? 
   
   if (empty($_POST['date3'])!="1"){

       $tab = 2;
       $today1 = $_POST['date3'];
	   echo $today1;
	
   }
   else
   {
  
	   $today1 = isset($_POST['date1']) ? $_POST['date1'] : date("Y-m-d"); 
	   $today2 = isset($_POST['date2']) ? $_POST['date2'] : date("Y-m-d"); 
   }
 
?>

<div class="container-fluid" ui-view="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-inline">
						<div class="form-group">
							<label>기간 조회:</label>
							<input type="date" name='col1'
								class="form-control input-sm ng-pristine ng-untouched ng-valid" ng-model="startDate"
								value="<?=$today1?>">
							<input type="date" name='col2' class="form-control input-sm ng-pristine ng-valid ng-touched"
								ng-model="endDate" value="<?=$today2?>">
							<div class="btn-group">
								<label class="btn btn-success input-sm" onclick="radio1('1')">당일조회</label>
								<label class="btn btn-success input-sm ng-pristine ng-untouched ng-valid"
									ng-model="optionSearch" btn-radio="'sellDate'" onclick="radio1('2')">기간조회</label>
							</div>
						</div>
						<hr>
						<div class="row">
							<? include('data.php'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>	