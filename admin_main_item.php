<style>
table.type09 {
  border-collapse: collapse;
  text-align: left;
  line-height: 1.5;

}
table.type09 thead th {
  padding: 10px;
  font-weight: bold;
  vertical-align: top;
  color: #369;
  border-bottom: 3px solid #036;
  background: #ffffff;
}
table.type09 tbody th {
  width: 150px;
  padding: 10px;
  font-weight: bold;
  vertical-align: top;
  border-bottom: 1px solid #ccc;
  
}
table.type09 td {
  width: 350px;
  padding: 10px;
  vertical-align: top;
  border-bottom: 1px solid #ccc;
}
</style>
<script type="text/javascript">
		//전체 tr에서 찾는거
            $(document).ready(function(){
			  $("#myInput3").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable3 tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });
			});
		  
            /*
			//일정 td에서만 찾는 방법
			 $(document).ready(function() {
				$("#myInput").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#myTable > tr").hide();
					var temp = $("#myTable > tr > td:nth-child(15n+12):not(:contains('" + value + "'))");

					//var temp = $("#myTable > tr > td:nth-child(15n+3):contains('" + value + "')");


					
					$(temp).parent().show();
				});
			
			});
            */  
</script>	
<div>
 <input type="text" name="itext" id="myInput3" class="form-control" placeholder="Search">
 <table  id='table' class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
  <thead>
  <tr>
    <th scope="cols">블랙코드</th>
    <th scope="cols">블랙품목명</th>
  </tr>
  </thead>
  <tbody id="myTable3">
  <?
    $stmt = $con->prepare("select * from iteminfo where itemblack='Y' ");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
  

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

			?>
             <tr>
				
				<td><?=$itemcode?></td>
				<td><?=$itemname?></td>
			 
			 
		    </tr>

			<?
            
        }
        
		
    }
  ?>



 
  
  </tbody>
</table>
</div>