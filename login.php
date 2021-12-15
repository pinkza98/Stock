<?php  
require_once('database/db.php');
session_start();
	if (isset($_SESSION['user_login'])) {
		header("location: index");
	}
	if (isset($_REQUEST['btn_login'])) {
		$username = strip_tags($_REQUEST['txt_username']);
		$password = strip_tags($_REQUEST['txt_password']);
		
		if (empty($username)) {
			$errorMsg[] = "Please enter username ";
		} else if (empty($password)) {
			$errorMsg[] = "Please enter password";
		}
		else {
			try { //
				$username=trim($username);
				$select_stmt = $db->prepare("SELECT user_id,username,password FROM user WHERE username = :uname");
				$select_stmt->execute(array(':uname' => $username));
				$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
				if ($select_stmt->rowCount() > 0) {
					if ($username == $row['username']) {
						if (password_verify($password , $row['password'])) {
							$_SESSION['user_login'] = $row['user_id'];
							if (!empty($_POST['remember'])) {
								setcookie('user_login', $_POST['txt_username'], time() + (10 * 365 * 24 * 60 * 60));
								setcookie('user_password', $_POST['txt_password'], time() + (10 * 365 * 24 * 60 * 60));
							} else {
								if (isset($_COOKIE['user_login'])) {
									setcookie('user_login', '');
				
									if (isset($_COOKIE['user_password'])) {
										setcookie('user_password', '');
									}
								}
							}
							$loginMsg = "Login......";
							header("refresh:2;index");
							}else{
								$errorMsg[] = "รหัสผ่านไม่ถูกต้อง ";
							}
						}else{
							$errorMsg[] = "ไม่พบ user ในระบบ ";
						}
					}else{
						$errorMsg[] = "ไม่พบ user ในระบบ ";
					}
				} 
				catch(PDOException $e) {
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
<link rel="icon" type="image/png" href="components/images/tooth.png"/>
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
<script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
<!--===============================================================================================-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('node_modules/images/login.jpg');">
			<div class="wrap-login100 p-t-190 p-b-30">
				<form method="post">
					<div class="login100-form-avatar">
						<img src="node_modules/images/avatar-01.png" alt="AVATAR">
					</div>
					<span class="login100-form-title p-t-20 p-b-45">Login User <a>Version 1.4</a>  <hr>
						<?php 
							if (isset($errorMsg)) {
								foreach($errorMsg as $error) {
						?>
							<div class=" mb-2">
								<!-- <strong>ERORR! <?php echo $error; ?></strong> -->
								<script>
									Swal.fire({
								position: 'center',
								icon: 'error',
								title: 'ข้อมูลไม่ถูกต้อง!!',
								showConfirmButton: false,
								timer: 1500
								})
								</script>
							</div>
						<?php	}?>
						<?php	} ?>
						<?php 
							if(isset($loginMsg)) {
						?>
							<div class=" mb-1" role="alert">
								<!-- <strong>กำลังเข้าสู่ระบบ! <?php echo $loginMsg; ?></strong> -->
								<script>
									Swal.fire({
								position: 'center',
								icon: 'success',
								title: 'กำลังเข้าสู่ระบบ',
								showConfirmButton: false,
								timer: 1500
								})
								</script>
							</div>
    					<?php } ?>	
					</span>
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="txt_username" value="<?php if(isset($_COOKIE['user_login'])){echo $_COOKIE['user_login'];}?>" placeholder="E-mail">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="txt_password" value="<?php if(isset($_COOKIE['user_login'])){echo $_COOKIE['user_password'];}?>" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock"></i>
						</span>
					</div>
					<div  class="form-check form-switch ml-1">
						<input type="checkbox"class="form-check-input" name="remember" <?php if (isset($_COOKIE['user_login'])) { ?> checked <?php } ?> id="remember">
						<label class="form-check-label" for="remember">จดจำรหัสผ่านไว้?</label>
					</div>
					<div class="container-login100-form-btn p-t-10">
						<button class="login100-form-btn" type="submit" name="btn_login" value="login">Login</button>
					</div>
					<div class="text-center w-full p-t-25 p-b-230">
						<a href="#" class="txt1">
						</a>
					</div>
					<div class="text-center w-full">
						<a class="txt1" href="#"></a>
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

