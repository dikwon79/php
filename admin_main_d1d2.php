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
			  $("#myInput2").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable2 tr").filter(function() {
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
 <input type="text" name="itext" id="myInput2" class="form-control" placeholder="Search">
 <table  id='table' class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
  <thead>
  <tr>
    <th scope="cols">종류</th>
    <th scope="cols">내용</th>
  </tr>
  </thead>
  <tbody id="myTable2">
  <?
    $stmt = $con->prepare("select * from black_list where kind='D1' or kind='D2'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 
		$D1 = array();
        $D2 = array();
        $yeop = array();

        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);

			?>
             <tr>
				
				<td><?=$kind?></td>
				<td><?=$name?></td>
			 
			 
		    </tr>

			<?
            
        }
        
		
    }
  ?>



 
  
  </tbody>
</table>
</div>