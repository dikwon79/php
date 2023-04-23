<?php
   
    include('dbcon.php');
    //include('check.php');


    if(isset($_POST['id'])) $id = $_POST['id'];
	$kind = $_POST['kind'];
	$name = $_POST['name'];		
    $common = 'common';	
    
	//echo $id;
    if($id)
	{

		    $stmt = $con->prepare('UPDATE black_list SET center=:center, kind=:kind, name=:name WHERE pid=:id');
			$stmt->bindParam(':id',$id);
			$stmt->bindParam(':center',$common);
          
			$stmt->bindParam(':kind',$kind);		
			$stmt->bindParam(':name',$name);	
			
			if($stmt->execute()){
				?>
                                <script>
				alert('업데이트 성공');
				window.location.href='admin_black.php';
				</script> 
                <?php
			}
			else{
				$errMSG = "업데이트 실패";
			}
					



	}
	else{
			try { 
					$stmt = $con->prepare("select * from black_list where kind='$kind' AND name='$name' ");
					
					$stmt->execute();

			   } catch(PDOException $e) {
					die("Database error: " . $e->getMessage()); 
			   }

			   $row = $stmt->fetch();
			   $numberofrows = $stmt->rowCount();

			
			   if($numberofrows < 1)
				{
					try{
					$stmt = $con->prepare('INSERT INTO black_list(center, kind, name) VALUES(:center, :kind, :name)');
					$stmt->bindParam(':center',$common);
				  
					$stmt->bindParam(':kind',$kind);		
					$stmt->bindParam(':name',$name);		

					if($stmt->execute())
					{
						$successMSG = "새로운 데이타를 추가했습니다.";
						?>
						<script>
						   alert('새로운 데이타를 추가');
						   window.location.href='admin_black.php';
						</script> 
						<?php
					}
					else
					{
						$errMSG = "사용자 추가 에러";
					}
							 } catch(PDOException $e) {
								die("Database error: " . $e->getMessage()); 
							 }
				}	
	  

	  }

	  echo $errMSG;

	  include('getjson2.php');



	  ?>