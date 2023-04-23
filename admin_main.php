<script>
	function editclick(){
        const a = $("input:checkbox[name=is_check]:checked").length;
		if (a<1)
		{
			alert('체크박스를 한개만 선택하세요.');
		}
        
        $("input:checkbox[name=is_check]:checked").each(function(){
			var checkVal = $(this).val();	
			location.href="admin_inputmain.php?id="+checkVal;
			
		});
		


}
function del(){

        const a = $("input:checkbox[name=is_check]:checked").length;
		if (a<1)
		{
			alert('체크박스를 한개만 선택하세요.');
		}
        
        $("input:checkbox[name=is_check]:checked").each(function(){
			    var checkVal = $(this).val();	
			    var r = confirm("정말 삭제 하시겠습니까?");
				if (r == true) {
				   location.href="admin_black_del.php?id="+checkVal;
				   alert('삭제하였습니다.');
				} else {
				  alert('취소하였습니다.');
				}
			
	    });
		
	  


}


</script>
<div class="container">
<!-- 탭 메뉴 상단 시작 -->
	<ul class="tabs">
		<li class="tab-link current" data-tab="tab-1">블랙업장</li>
		<li class="tab-link" data-tab="tab-2">D1D2정보</li>
		<li class="tab-link" data-tab="tab-3">품목블랙</li>
        <li class="tab-link" data-tab="tab-4">사용중단</li>
		<a class="btn btn-primary" href="admin_inputmain.php" ><span class="glyphicon glyphicon-pencil" style="text-align:right"></span> 신규입력</a>
		<button class="btn btn-success" onclick="editclick()"><span class="glyphicon glyphicon-pencil"></span> Edit</button>
		<button class="btn btn-warning" onclick="del()"><span class="glyphicon glyphicon-remove"></span> Del</button>
		

	</ul>
<!-- 탭 메뉴 상단 끝 -->
<!-- 탭 메뉴 내용 시작 -->
	<div id="tab-1" class="tab-content current">
    <h1>업장 블랙리스트</h1>
							   
    <p>
	<? include 'admin_main_client.php' ?>

	</div>
	<div id="tab-2" class="tab-content">
	<h1> D1,D2설정정보 </h1>
    <p><? include 'admin_main_d1d2.php' ?>
  
	</div>
	<div id="tab-3" class="tab-content">
	<h1> 품목블랙리스트 </h1>
    <p><? include 'admin_main_item.php' ?>
	</div>

    <div id="tab-4" class="tab-content">
	<h1> 사용중단리스트 </h1>
    <p><? include 'admin_main_stop.php' ?>
    </div>

<!-- 탭 메뉴 내용 끝 -->
</div>