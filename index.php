<?php
    include('dbcon.php'); 
    include('check.php');

    if(is_login()){

        if ($_SESSION['user_id'] == 'admin' && $_SESSION['is_admin']==3)
            header("Location: admin.php");
        else 
            header("Location: welcome.php");
    }




 $login_ok = false;

    if ( ($_SERVER['REQUEST_METHOD'] == 'POST') and isset($_POST['login']) )
    {
		$username=$_POST['user_name'];  
		$userpassowrd=$_POST['user_password'];  
        echo $username;


		if(empty($username)){
			$errMSG = "아이디를 입력하세요.";
		}else if(empty($userpassowrd)){
			$errMSG = "패스워드를 입력하세요.";
		}else{
			

			try { 

				$stmt = $con->prepare('select * from users where username=:username');

				$stmt->bindParam(':username', $username);
				$stmt->execute();
			   
			} catch(PDOException $e) {
				die("Database error. " . $e->getMessage()); 
			}

			$row = $stmt->fetch();  
			$salt = $row['salt'];
			$password = $row['password'];
			
			$decrypted_password = decrypt(base64_decode($password), $salt);

			if ( $userpassowrd == $decrypted_password) {
				$login_ok = true;
			}
		}

		
		if(isset($errMSG)) 
			echo "<script>alert('$errMSG')</script>";
		

        if ($login_ok){

            if ($row['activate']==0)
				echo "<script>alert('$username 계정 활성이 안되었습니다. 관리자에게 문의하세요.')</script>";
            else{
					session_regenerate_id();
					$_SESSION['user_id'] = $username;
					$_SESSION['is_admin'] = $row['is_admin'];
					$_SESSION['activate'] = $row['activate'];

					if ($username=='admin' && $row['is_admin']==1 )
						header('location:admin.php');
					else
						header('location:3pl.php');
					session_write_close();
			}
		}
		else{
			echo "<script>alert('$username 인증 오류')</script>";
		}
	}


?>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>이안로지스</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>이안로지스</strong> Login</h1>
                            <div class="description">
                            	<p>
	                            	본 시스템은 이안로지스 임직원, 고객에 한하여 사용하실 수 있습니다. 
	                            	<p>불법적인 접근 및 사용시 관련 법규에 의해 처벌될 수 있습니다. </p>
									[인트라넷 보안지침] 
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>인트라넷 로그인하기</h3>
                            		<p>아이디와 패쓰워드를 입력해주세요.</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="user_name" placeholder="Username..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="user_password" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>

			                        <button  name="login" type="submit" class="btn">로그인</button>
									
									<a class="btn" href="registration.php" style="margin-left: 350px">
			                        <span class="btn">새로운 사용자 등록</span>
			                        </a>
									
			                    </form>
		                    </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>
