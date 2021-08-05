<?php  
 require_once('database/db.php');

 session_start();


 if (isset($_SESSION['user_login'])) {
	 header("location: index.php");
 }

 if (isset($_REQUEST['btn_login'])) {
	 $username = strip_tags($_REQUEST['txt_username']);
	 $password = strip_tags($_REQUEST['txt_password']);

	 if (empty($username)) {
		 $errorMsg[] = "Please enter username ";
	 } else if (empty($password)) {
		 $errorMsg[] = "Please enter password";
	 } else {
		 try {
			 $select_stmt = $db->prepare("SELECT * FROM user WHERE username = :uname AND password = :password");
			 $select_stmt->execute(array(':uname' => $username, ':password' => $password));
			 $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

			 if ($select_stmt->rowCount() > 0) {
				 if ($username == $row['username']) {
					 if (($password == $row['password'])) {
						 $_SESSION['user_login'] = $row['user_id'];
						 $loginMsg = "Login......";
						 header("refresh:2;index.php");
					 } else {
						 $errorMsg[] = "Wrong password!";
					 }
				 } else {
					 $errorMsg[] = "Wrong username ";
				 }
			 } 
		 } catch(PDOException $e) {
			 echo $e->getMessage();
		 }
	 }
 }
?>  
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Plus </title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="node_modules/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="node_modules/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="node_modules/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="node_modules/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="node_modules/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="node_modules/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="node_modules/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="node_modules/css/util.css">
	<link rel="stylesheet" type="text/css" href="node_modules/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('node_modules/images/login.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form method="post">
					<div class="login100-form-avatar">
						<img src="node_modules/images/avatar-01.png" alt="AVATAR">
					</div>
					
			
					<span class="login100-form-title p-t-20 p-b-45">
						
						Login User <hr>
						<?php 
							if (isset($errorMsg)) {
								foreach($errorMsg as $error) {
						?>
							<div class="alert alert-danger mb-2">
								<strong>ERORR! <?php echo $error; ?></strong>
							</div>
						<?php }} ?>
						<?php 
							if (isset($loginMsg)) {
						?>
							<div class="alert alert-success mb-1" role="alert">
								<strong>กำลังเข้าสู่ระบบ! <?php echo $loginMsg; ?></strong>
							</div>
							<hr>
    <?php } ?>	
					</span>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="txt_username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="txt_password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>

					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" type="submit" name="btn_login" value="login">Login</button>
					</div>

					<div class="text-center w-full p-t-25 p-b-230">
						<a href="#" class="txt1">
							
						</a>
					</div>

					<div class="text-center w-full">
						
						<a class="txt1" href="#">
							
												
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="node_modules/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="node_modules/vendor/bootstrap/js/popper.js"></script>
	<script src="node_modules/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="node_modules/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="node_modules/js/main.js"></script>
<!--===============================================================================================-->
</body>
</html>