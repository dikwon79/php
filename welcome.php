<?php
    include('dbcon.php');
    include('check.php');

    if (is_login()){

        if ($_SESSION['activate']==1) 
            header("Location: 3pl.php");
        else
            header("Location: 3pl.php");
    }else
        header("Location: 3pl.php"); 
  

	//include('headitem.php');
?>
<div class="jumbotron">
  <div class="container text-center">
    <h1>이안로지스 이천물류센터</h1>      
    <p>Mission, Vission & Values</p>
  </div>
</div>
<? include('headitem.php'); ?>
<div align="center">
<?php
	$user_id = $_SESSION['user_id'];

	try { 
		$stmt = $con->prepare('select * from users where username=:username');
		$stmt->bindParam(':username', $user_id);
		$stmt->execute();

   } catch(PDOException $e) {
		die("Database error: " . $e->getMessage()); 
   }

   $row = $stmt->fetch();
   
   echo($row['regtime']);
?>



<?php echo $user_id; ?>로 로그인했습니다.
</div>
<div class="container">
    <article class="boardArticle">

		<h3>공지사항</h3>

		<table class="table table-bordered">
            <thead>

				<tr>

					<th scope="col" class="no">1. 07월17일 프로그램이 업데이트 되었습니다.</th>

					

				</tr>

			</thead>

			<tbody>

					<?php
                        $stmt = $con->prepare('select * from board_free order by b_no desc');
		                //$stmt->bindParam(':username', $user_id);
		               
                        //$stmt = $con->prepare($sql);
							
						$stmt->execute();
						 
						if ($stmt->rowCount() > 0)
						{
							while($row=$stmt->fetch(PDO::FETCH_ASSOC))
							{
							    extract($row);   


								$datetime = explode(' ', $row['b_date']);

								$date = $datetime[0];

								$time = $datetime[1];

								if($date == Date('Y-m-d'))

									$row['b_date'] = $time;

								else

									$row['b_date'] = $date;

					?>

							<tr>

								<td class="no"><?php echo $row['b_no']?></td>

								<td class="title"><?php echo $row['b_title']?></td>

								<td class="author"><?php echo $row['b_id']?></td>

								<td class="date"><?php echo $row['b_date']?></td>

								<td class="hit"><?php echo $row['b_hit']?></td>

							</tr>

					<?php
							}
						}

					?>

			</tbody>

		</table>

	</article>


</div>
</body>
</html>