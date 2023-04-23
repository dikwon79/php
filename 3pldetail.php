<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>3pl세부출고상세내역</title>
    <link rel="stylesheet" href="./jquery-ui-1.12.1/jquery-ui.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="./jquery-ui-1.12.1/jquery-ui.min.js"></script>

    <script src="./jquery-ui-1.12.1/datepicker-ko.js"></script>
	<script>

	function format (date) {  
	  if (!(date instanceof Date)) {
		throw new Error('Invalid "date" argument. You must pass a date instance')
	  }

	  const year = date.getFullYear()
	  const month = String(date.getMonth() + 1).padStart(2, '0')
	  const day = String(date.getDate()).padStart(2, '0')

	  return `${year}-${month}-${day}`
    }
	function preMonth(){


	   var now = new Date();
	   var startDt =new Date(now.getFullYear(), now.getMonth() - 1, 1);

	 
	   var endDt = new Date(now.getFullYear(), now.getMonth(), 0);

       $('input[name=col1]').attr('value',format(startDt));
	   $('input[name=col2]').attr('value',format(endDt));
              
			

		

	}
    
	function thisMonth(){

	   var now = new Date();
       var startDt =new Date(now.getFullYear(), now.getMonth(), 1);
       var endDt = new Date(now.getFullYear(), now.getMonth(), now.getDate());
	   $('input[name=col1]').attr('value',format(startDt));
	   $('input[name=col2]').attr('value',format(endDt));

	}
	function thisday(){
       var now = new Date();
	   $('input[name=col1]').attr('value',format(now));
	   $('input[name=col2]').attr('value',format(now));

	}


	</script>
    <link rel="stylesheet" href="3pl.css">
    <link rel="stylesheet" href="3plmodal.css">
</head>
<? 
    include('dbconn.php');
	include('dbcon.php');
	
    include('headitem.php');

	$today1 = isset($_GET['col1']) ? $_GET['col1'] : date("Y-m-d"); 
	$today2 = isset($_GET['col2']) ? $_GET['col2'] : date("Y-m-d");
	
	$from = new DateTime($today1);
	$to = new DateTime($today2);
	$diff = date_diff( $from, $to )->days;
    
    
    if( $diff > 30){
		echo "<script>alert('30일만 조회가능!');</script>";
		$today1 = date("Y-m-d");
        $today2 = date("Y-m-d");
	}
    ?>

<body>

    <div class="container">
        <section id="main">

            <div class="col-md-2 my-2">
                <div class="list-group">

                    <a href="3pl.php" class="list-group-item">재고현황</a>
					<a href="3plexpire.php" class="list-group-item">유통기한현황</a>
                    <a href="3pldetail.php" class="list-group-item active">출고상세내역</a>



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



                <div class="col-md-10">
				
                    <form class="navbar-form pull-left" method="get" action="">

					    
                        <!-- action 을 비워놔야 자신을 가리킨다 -->
                        <div class="form-group">
                            <div class="form-group">
							<? if($_SESSION['is_admin'] > '0'){ ?>
                                <select name='inventory' class="input-large form-control">
                                    <option value="전체">전체</option>
                                    <?
                                $sql = "select * from iteminfo group by georae";
													
								$result = mysqli_query($connect,$sql);
								$count = mysqli_num_rows($result);
						
								if ($count > 0)
									{
										while ($row = $result->fetch_assoc()) 
										{
									      
                                          if($row[georae] =="") continue;

										 
										  
										  ?>


                                        <option value="<?=$row[georae]?>" <? if
                                        (trim($row[georae])==trim($_GET['inventory'])) { ?>
                                        selected
                                        <? } ?>><?=$row[georae]?></option>
                                    <?  }  }?>
                                </select>
                                <? } 
								   else{ ?>
                                   <select name="inventory" class="form-control" readonly>
									<option value=<?=$_SESSION['user_id']?> selected><?php echo $_SESSION['user_id']; ?></option>

								   </select>

                                 <?
								   }
								?>
                            </div>

                            <input type="date" name='col1'
                                class="form-control input-sm ng-pristine ng-untouched ng-valid" ng-model="startDate"
                                value="<?=$today1?>">
								
                            <input type="date" name='col2' class="form-control input-sm ng-pristine ng-valid ng-touched"
                                ng-model="endDate" value="<?=$today2?>">
                            <div class="btn-group">
                                <input type="submit" value="조회">
								<input type="button" onclick="preMonth()" value="전월">
								<input type="button" onclick="thisMonth()" value="당월">
								<input type="button" onclick="thisday()" value="당일">
								
                            </div>
                        </div>

                    </form>
                </div>

                <div class="col-md-2" style="padding-top: 10px">
				<button type="button"
				class="btn btn-default" onclick="fnExcelReport('table', '출고상세내역')">Excel download</button>
                    

                </div>

                <?php 
                        
					
						/*
					    $sql = "select pid from ipgo where itemname like '%$search_word%' group by ipgodate,ipgonum order by ipgodate desc,ipgonum desc";
					    $stmt = $con->prepare($sql);

                        $stmt->execute();
						$num=$stmt->rowCount();	   
                        $page = isset($_GET['page'])?$_GET['page']:1;
     
                        
  
                       
					    $list=13;
						$block = 3;
					    $pageNum = ceil($num/$list); // 총 페이지
					    $blockNum = ceil($pageNum/$block); // 총 블록
					    $nowBlock = ceil($page/$block);


												
						$s_page = ($nowBlock * $block) - 2;

						if ($s_page <= 1) {
							$s_page = 1;
						}

						$e_page = $nowBlock*$block;
						if ($pageNum <= $e_page) {
							$e_page = $pageNum;
						}



                        $s_point = ($page-1) * $list;



                        //$sql = "SELECT * FROM ipgo where itemname LIKE '%$search_word%' "; 

					    if ($search_word)
						{
						    $sql = "select concat(ipgodate,'/',ipgonum) as 'seq' ,geocode, geoname, concat(itemname,' 외 ',count(*),'건') as 'title', sum(surang) as 'tsurang' ,sum(hap) as 'total' ,changocode,changoname,'회계','인쇄',charger from ipgo where itemname like '%$search_word%' group by ipgodate,ipgonum order by ipgodate desc,ipgonum desc limit  $s_point ,$list";
						}
						else{
                            $sql = "select '선택' as 'num' ,concat(ipgodate,'/',ipgonum) as 'seq' ,geocode,geoname, concat(itemname,' 외 ',count(*),'건') as 'title', sum(surang) as 'tsurang' ,sum(hap) as 'total' ,changocode,changoname,'회계','인쇄',charger from ipgo where 1 group by ipgodate,ipgonum order by ipgodate desc,ipgonum desc 
							limit $s_point ,$list";


						}
                      
					    */



						// 테이블 생성
                     
						//$item=$_POST['itemcode'];
						//$idate=$_POST['idate1']."-".$_POST['idate2']."-".$_POST['idate3'];
						//$idate = "2022-12-11";
						 
						$selectname = isset($_GET['inventory']) ? $_GET['inventory'] : '시작';

						if($_SESSION['is_admin'] < '2'){

								$selectname = $_SESSION['user_id'];
						}
						
						if ($selectname=='시작' or $selectname=='전체'){
							 echo "<script>alert('전체모드는 데이타양이 많아 제공되지 않습니다.');</script>";
                             exit;
						}
						else{
							 $selectbox =$selectname;
						} 
						$sql = "SELECT * FROM (SELECT B.companyname, B.idate, a.itemcode,B.itemcode as 'item',B.mappingcode, 
						a.itemname,B.customer,B.unit, SUM(CASE WHEN B.unit = 'BOX' THEN a.packsu*B.surang ELSE B.surang END) AS 'surang'
						,a.georae FROM iteminfo a,(SELECT '라벨' AS 'list', idate, center AS 'companyname',itemcode, mappingcode,customer
						, chaivalue AS 'surang',unit AS 'unit' FROM labelmain b WHERE (idate >= '$today1' and idate <='$today2')
						UNION ALL
						SELECT '출고' AS 'list', idate, companyname,itemcode, mappingcode, customer, chaivalue AS 'surang',unit AS 'unit'
						FROM labelXmain c WHERE (idate >= '$today1' and idate <='$today2'))B
						WHERE a.itemcode=B.mappingcode AND labelY='Y' AND a.georae='$selectbox'
						GROUP BY mappingcode, customer,idate
						ORDER BY idate asc, mappingcode asc, companyname asc, surang asc)C";
						
						
						//echo $sql;
						$result = mysqli_query($connect,$sql);
						$count = mysqli_num_rows($result);
						
						  if ($count > 0)
						  {
		 
		   
						   echo "<table id='table' class='table table-bordered'>
						   <tr style='background-color:#c5d0ed'><td>출고일</td><td NOWRAP>품목코드</td><td NOWRAP>맵핑코드</td><td>품목명</td><td>수량</td><td>단위</td>
						   <td>경로</td><td>업장명</td><td NOWRAP>거래처</td><tr>";   
						   
						   //$sql2 = select *		
						   while ($row = $result->fetch_assoc()) 
						   {
						  
								
							   /*
							   <td>".$row['itemcode']."</td>
									   <td>".$row['mappingcode']."</td>
									   <td>".$row['itemname']."</td>

									   */


								echo "
									   <tr>
									   <td NOWRAP>".$row['idate']."</td>
									   <td>".$row['item']."</td>
									   <td>".$row['mappingcode']."</td>
									   <td>".$row['itemname']."</td>
									   <td>".$row['surang']."</td>
									   <td>EA</td>
									   <td>".$row['companyname']."</td>
									   <td>".$row['customer']."</td>
									   
									   
									  
									   
									   <td>".$row['georae']."</td>
								
									   </tr>";

						   }
						   echo "</table>";
		  
						  }
						  else{
							  echo " <span onclick='closemodal()' class="."close".">&times.</span>"; 


						  }
								
                        

						  ?>


                <div class="col-md-12 text-center">
                    <ul class="pagination">


                        <li class="page-item"><a class="page-link" href="?page=<? if($s_page-1<0){ echo " 1"; }else{
                                echo $s_page; }?>">Previous</a></li>

                        <?
							for ($p=$s_page; $p<=$e_page; $p++) {
                            ?>



                        <li class="page-item"><a class="page-link" href="?page=<?=$p?>"><?=$p?></a></li>

                        <? } ?>
                        <li class="page-item"><a class="page-link" href="?page=<? if($e_page+1 >$pageNum) { echo $pageNum; }
							 else {echo $e_page+1;}?>">Next</a></li>
                    </ul>
                </div>



            </div>




        </section>
    </div>

    <footer class="footer" style="background-color:#0756b2; color:#ffffff">
        <div class="container">
            <br>
            <div class="row">
                <div class="col-sm-2" style="text-align: center;">
                    <h3>(주)이안로지스</h3>
                </div>
                <div class="col-sm-8">
                    본사: 신둔<p>
                        제2창고: 백암<p>
                            사업자등록번호 :100-00-00000 | TEL:070-0000-0000 | FAX:031-000-0000 | E-mail : dikwon79@naver.com
                            <p>
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