<?php
include 'koneksi.php';


if(isset($_SESSION['username'])){
    if($_SESSION['role'] == 0){
    header('Location:index.php');
    }else{
     header('Location:admin-dashboard.php');
    }
}

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sqll = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn,$sqll);
    $detail = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $row = mysqli_num_rows($result);
    if($row!=0){
      if($detail['password'] == $password){
        if($detail['role'] == 0){
            $_SESSION['id'] = $detail['id'];
            $_SESSION['username'] = $detail['username'];
            $_SESSION['password'] = $detail['password'];
            $_SESSION['role'] = $detail['role'];
            header('Location:index.php');
        }else{
            $_SESSION['id'] = $detail['id'];
            $_SESSION['username'] = $detail['username'];
            $_SESSION['password'] = $detail['password'];
            $_SESSION['role'] = $detail['role'];
            header('Location:admin-dashboard.php');
        }
      }else{
        echo "<script>alert('Username atau password salah');history.back(-1);</script>";
      }

    }
    if($detail['username'] == "candy"){
        $_SESSION['id'] = $detail['id'];
        $_SESSION['username'] = $detail['username'];
        $_SESSION['password'] = $detail['password'];
        $_SESSION['role'] = $detail['role'];
        header('Location:daftarkoleksi1.php');
    }else{
        echo "<script>alert('Username atau password salah');history.back(-1);</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="assets/loginadmin/images/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/loginadmin/css/main.css">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-43">
						Login to T-shirt shop
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username" autocomplete="off">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>


					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

						<div>
							<a href="registerakun.php" class="txt1">
								Register Account
							</a>
						</div>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="submit">
							Login
						</button>
					</div>

					<div class="text-center p-t-46 p-b-20">
						<span class="txt2">
							or sign up using
						</span>
					</div>

					<div class="login100-form-social flex-c-m">
						<a href="http://facebook.com" class="login100-form-social-item flex-c-m bg1 m-r-5">
							<i class="fa fa-facebook-f" aria-hidden="true"></i>
						</a>

						<a href="https://twitter.com/" class="login100-form-social-item flex-c-m bg2 m-r-5">
							<i class="fa fa-twitter" aria-hidden="true"></i>
						</a>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('assets/loginadmin/images/1.jpg');">
				</div>
			</div>
		</div>
	</div>





<!--===============================================================================================-->
	<script src="assets/loginadmin/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/loginadmin/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/loginadmin/vendor/bootstrap/js/popper.js"></script>
	<script src="assets/loginadmin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/loginadmin/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="assets/loginadmin/vendor/daterangepicker/moment.min.js"></script>
	<script src="assets/loginadmin/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="assets/loginadmin/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="assets/loginadmin/js/main.js"></script>

</body>
</html>
