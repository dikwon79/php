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
			  $("#myInput").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$("#myTable tr").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
			  });

             



			});
		    function editbutton(id){
				 //alert('체크박스 클릭'+ id);
				 var count = $("input:checkbox[name=is_check]:checked").length;
				 if (count>1)
				 {
					alert('중복체크불가합니다');
					$("input:checkbox[id="+id+"]:checkbox").prop("checked", false);
				 }
			 
			}

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
 <input type="text" name="itext" id="myInput" class="form-control" placeholder="Search">
 <table  id='table' class="table table-bordered table-hover table-striped" style="table-layout: fixed">  
  <thead>
  <tr>
    <th width='10%' scope="cols">선택</th>
    <th width='15%' scope="cols">타이틀</th>
    <th scope="cols">내용</th>
  </tr>
  </thead>
  <tbody id="myTable">
  <?
    $stmt = $con->prepare("select * from black_list where kind='yeop'");
    $stmt->execute();

    if ($stmt->rowCount() > 0)
    {
        $data = array(); 
		$D1 = array();
        $D2 = array();
        $yeop = array();
        
		$s=0;
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
            $s++;
			?>
             <tr>
								
                <input type='hidden' id='id<?=$s?>' value='<?=$pid?>'>	
                <td width='9%'>	<label class="btn btn-primary">
							<input name='is_check' type="checkbox" id="chk<?=$s?>" value='<?=$pid?>' onclick="editbutton('chk<?=$s?>')">선택
						</label></td>
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