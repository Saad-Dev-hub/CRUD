<?php
session_start();
include_once 'auth/Verified.php';
if ($_POST) {
	$errors = [];
	// check for name input
	if ($_POST['name'] == '') {
		$errors['empty'] = "<div class='alert alert-danger'>This Field Can't Be Blank</div>";
	}
	if ($_POST['name'] != strip_tags($_POST['name'])) {
		$errors['invalid-string'] = "<div class='alert alert-danger'>Please Enter valid Name</div>";
	}
	if ((strlen($_POST['name']) < 3 ||  strlen($_POST['name']) > 20 and ($_POST['name']) != '')) {
		$errors['wrong-lenght'] = "<div class='alert alert-danger'>Your Name must be greater than 3 letters and less than 20 letters </div>";
	}
	if (is_numeric($_POST['name'])) {
		$errors['string'] = "<div class='alert alert-danger'> Your name must be string</div>";
	}
	$pattern = '/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
	if (preg_match($pattern, $_POST['name'])) {
		$errors['special-charcters'] = "<div class='alert alert-danger'>Please Enter Name as only String Format.</div>";
	}
	// check for email
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['wrong-email-format'] = "<div class='alert alert-danger'> Wrong Email Format</div>";
	}
	// check for Password
	if (strlen($_POST["password"]) <= 8 || strlen($_POST["password"]) > 40) {
		$errors['pass-lenght'] = "<div class='alert alert-danger'>Your Password Must Contain At Least 8 Characters! And At Most 30 Characters! </div>";
	}
	// password should contain 1 Number
	else if (!preg_match("#[0-9]+#", $_POST['password'])) {
		$errors['pass-num'] = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Number!</div>";
	}
	//Password must contain 1 capital letter
	else if (!preg_match("#[A-Z]+#", $_POST['password'])) {
		$errors['pass-Capital'] = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Capital Letter!</div>";
	}
	//Password must contain 1 small letter 
	else if (!preg_match("#[a-z]+#", $_POST['password'])) {
		$errors['pass-Small'] = "<div class='alert alert-danger'>Your Password Must Contain At Least 1 Lowercase Letter!</div>";
	}

	//check Comfirm Password
	if ($_POST['password'] != $_POST['re_password']) {
		$errors['confirm'] = "<div class='alert alert-danger'> Please Enter the above Password</div>";
	}
	//INSERT USERS INTO DATABASE
	if (empty($errors)) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$con = mysqli_connect('localhost', 'root', '', 'ecommerce');
		if ($con->connect_error) {
			echo 'Connection Failed';
		}
		else{
			$existQuery="SELECT `users`.`email` FROM `users` where email='$email'";//if user try to register twice			
			$existUser=mysqli_query($con,$existQuery);
			if (mysqli_num_rows($existUser)>0) {		
					$errors['User-Exist']="<div class='alert alert-danger'> Email Already Exist</div>";
			}
			else {
				$insertQuery = "INSERT INTO `ecommerce`.`users`(`name`,`email`,`password`) VALUES('$name','$email','$password')";
				$validUser = mysqli_query($con, $insertQuery);
				// Insert last registerd user into session 
				$id=mysqli_insert_id($con);
				$query="SELECT * FROM `users` where id =$id";
				$runQuery=mysqli_query($con,$query);
				$user=mysqli_fetch_assoc($runQuery);
				// print_r($user);die;
				$_SESSION['user']=$user;
				header('location:home.php');
			}
			
		}
		$con->close();

	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Register</h4>
							<?php
							if (isset($errors['User-Exist'])) {
								echo $errors['User-Exist'];
							}
							?>
							<form method="POST" class="my-login-validation" novalidate>
								<div class="form-group">
									<label for="name">Name</label>
									<input id="name" type="text" class="form-control" name="name" required autofocus>
								</div>
								<?php
								if (isset($errors['empty'])) echo $errors['empty'];
								else echo '';
								if (isset($errors['invalid-string'])) echo $errors['invalid-string'];
								else echo '';
								if (isset($errors['wrong-lenght'])) echo $errors['wrong-lenght'];
								else echo '';
								if (isset($errors['string'])) echo $errors['string'];
								else echo '';
								if (isset($errors['special-charcters'])) echo $errors['special-charcters'];
								else echo '';

								?>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" required>
								</div>
								<?php
								if (isset($errors['wrong-email-format'])) echo $errors['wrong-email-format'];
								else echo '';
								?>

								<div class="form-group">
									<label for="password">Password</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								</div>
								<?php
								if (isset($errors['pass-lenght'])) echo $errors['pass-lenght'];
								else echo '';
								if (isset($errors['pass-num'])) echo $errors['pass-num'];
								else echo '';
								if (isset($errors['pass-Capital'])) echo $errors['pass-Capital'];
								else echo '';
								if (isset($errors['pass-Small'])) echo $errors['pass-Small'];
								else echo '';

								?>
								<div class="form-group">
									<label for="re-password">Confirm Your Password
									</label>
									<input id="re-password" type="password" class="form-control" name="re_password" required data-eye>
								</div>
								<?php
								if (isset($errors['confirm'])) echo $errors['confirm'];
								else echo '';
								?>
								<div class="form-group">
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
										<label for="agree" class="custom-control-label">I agree to the <a href="#">Terms and Conditions</a></label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Register
									</button>
								</div>
								<div class="mt-4 text-center">
									Already have an account? <a href="index.php">Login</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>

</html>