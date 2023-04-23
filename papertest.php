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
			  readData: { url: 'paperget.php?date=<?=$value?>', method: 'GET' }
			}
		  },
		  rowHeaders: ['rowNum'],
		  scrollX: false,
		  scrollY: true,
		  bodyHeight: 500,
		  columns: [
			{
			  header: '재고코드',
			  name: 'mappingcode',
			  sortingType: 'asc',
              sortable: true,
			  filter: { type: 'text', showApplyBtn: true, showClearBtn: true }
			},
			{
			  header: '상품명',
			  name: 'itemname',
			  width: 450,
			  sortingType: 'asc',
              sortable: true,
			  filter: { type: 'text', showApplyBtn: true, showClearBtn: true }
			},
			{
			  header: '렉',
			  name: 'lek',
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '재고단위',
			  name: 'unit'
			},
            {
			  header: '전일재고',
			  name: '전일재고',
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '입고',
			  name: '입고',
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '출고',
			  name: '출고',
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '현재고',
			  name: '현재고',
			  sortingType: 'asc',
              sortable: true
			},
			{
			  header: '업체명',
			  name: 'georae',
			  sortingType: 'asc',
              sortable: true,
			  filter: 'select'
			}
		  ],
		   summary: {
			position: 'top',
			height: 50,  // by pixel
			columnContent: {
			  입고: {
				template(summary) {
				   return 'sum: ' + summary.sum;
				}
			  },
			  출고: {
				template(summary) {
				  return 'sum: ' + summary.sum;
				}
			  },
              현재고: {
				template(summary) {
				  return 'sum: ' + summary.sum;
				}
			  },
			  전일재고: {
				template(summary) {
				  return 'sum: ' + summary.sum;
				}
			  }
			},
			
		  }
		});


		var Grid = tui.Grid;

        Grid.applyTheme('striped');
		


		
 
	</script>


</body>
</html>