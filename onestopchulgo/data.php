<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://uicdn.toast.com/grid/latest/tui-grid.css" />
    <script src="https://uicdn.toast.com/grid/latest/tui-grid.js"></script>
	

</head>
<body>
	<div id="grid"></div>    
	<script>
		

		const grid = new tui.Grid({
		  el: document.getElementById('grid'),
		  data: {
			api: {
			  readData: { url: "dataquery.php?date1=<?=$today1?>&date2=<?=$today2?>", method: 'GET' }
			}
		  },
		  rowHeaders: ['rowNum'],
		  scrollX: false,
		  scrollY: true,
		  bodyHeight: 500,
		  columns: [
			{
			  header: '출고일',
			  name: 'idate',
			  sortingType: 'asc',
              sortable: true,
			  filter: { type: 'text', showApplyBtn: true, showClearBtn: true }
			},
			{
			  header: 'CJ코드',
			  name: 'itemcode',
			  width: 100,
			  sortingType: 'asc',
              sortable: true,
			  filter: { type: 'text', showApplyBtn: true, showClearBtn: true }
			},
			{
			  header: '품명',
			  name: 'itemname',
			  width: 400,
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '수량',
			  name: 'chaivalue'
			},
            {
			  header: '단위',
			  name: 'unit',
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '경로',
			  name: 'companyname',
			  sortingType: 'asc',
              sortable: true
			}
		  ]
		});


		var Grid = tui.Grid;

        Grid.applyTheme('striped');
		


		
 
	</script>


</body>
</html>