<?php
session_start();
include_once 'auth/Verified.php';

if ($_POST) {
	$errors = [];
	if ($_POST['email'] == '') {
		$errors['required'] = "<div class='alert alert-danger'> This Field Is Required</div>";
	} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
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
	if (empty($errors)) {
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$con = mysqli_connect('localhost', 'root', '', 'ecommerce');
		$query = "SELECT `users`.`name`,`users`.`email`,`users`.`password`,`users`.`role` FROM `users` where email='$email' and password='$password'";
		$result = mysqli_query($con, $query);
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
			if ($row['role']=='Admin') {
				$_SESSION['Admin']=$row;
				header('location:products.php');
			}
			else if ($email == $row['email'] && $password == $row['password']) {
				$_SESSION['user']=$row;
				// print_r($_SESSION['user']);die;
				header('location:home.php');
			}
			 

		}
		 else {
			$invalidUser="<div class='alert alert-danger'>Please Make Sure You Entered Email and Password Correctly</div>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body class="my-login-page">
	<?php
	include_once 'includes/nav.php';
	?>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center ">
				<div class="card-wrapper">
					<div class="brand ">
						<img src="img/logo.jpg" alt="logo">
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Login</h4>
							<form method="POST" class="my-login-validation" novalidate>
								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" value="" required autofocus>

								</div>
								<?php
								if (isset($errors['required'])) {
									echo $errors['required'];
								}
								if (isset($errors['wrong-email-format'])) echo $errors['wrong-email-format'];
								else echo '';
								?>

								<div class="form-group">
									<label for="password">Password
										<a href="forgot.php" class="float-right">
											Forgot Password?
										</a>
									</label>
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
									<div class="custom-checkbox custom-control">
										<input type="checkbox" name="remember" id="remember" class="custom-control-input">
										<label for="remember" class="custom-control-label">Remember Me</label>
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
								<div class="mt-4 text-center">
									Don't have an account? <a href="register.php">Create One</a>
								</div>
								<?php
								if (isset($invalidUser)) {
									echo $invalidUser;
								}
								?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>