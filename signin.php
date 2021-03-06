<?php 
include_once('php/connexion.php');

if (!isset($_GET['el']))
	$_GET['el'] = "";

if ($_SESSION['id'] != "" || $_SESSION['login'] != "")
{
	header('Location: /');
	exit;
}

if ($_GET['el'] === "register") {
	$type = '<script type="text/javascript">
				$(".template_login").hide();
				$(".template_register").show();
				$(".template_passwd_forgot").hide();
			</script>';
}
else{
	$type = '<script type="text/javascript">
				$(".template_login").show();
				$(".template_register").hide();
				$(".template_passwd_forgot").hide();
			</script>';
}

?>

<!DOCTYPE html>
<html lang="<?php echo $lang['html'] ?>">
<head>
	<?php include_once('meta.php'); ?>

<!-- ******* CSS ***************** -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<style type="text/css">
		.search_form{
			display: none;
		}
	</style>
	
</head>

<body>
	
	<?php include_once('header.php'); ?>

<!-- ******* LOGIN ***************** -->
	<section class="template_login">
		<form action="#" onsubmit="return false" accept-charset="utf-8" class="form">

			<label for="login_login"><p><?php echo $lang['signin_login'] ?></p></label>
			<br/>
			<input type="login" name="login_login" maxlength="40" required/>

			<label for="password_login"><p><?php echo $lang['signin_password'] ?></p></label>
			<br/>
			<input type="password" name="password_login" maxlength="20" required />

			<p class="forgot"><?php echo $lang['signin_forgot'] ?></p>
			<input type="submit" value="<?php echo $lang['signin_signin'] ?>" class="submit transition" onclick="login()" />
		</form>
		<div class="l-landing-button-wrapper">
			<a href="/php/facebook_connect.php" target="_blank">
				<button class="o-button--fb o-button--large transition">
				CONNECT WITH FACEBOOK
				</button>
			</a>
		</div>
		<div class="l-landing-button-wrapper">
			<a href="/php/42_connect.php" target="_blank">
				<button class="o-button--42 o-button--large transition">
					CONNECT WITH 42
				</button>
			</a>
		</div>
	</section>

<!-- ******* REGISTER ***************** -->
	<section class="template_register">
		<form action="#" onsubmit="return false" accept-charset="utf-8" class="form">
			<label for="email"><p><?php echo $lang['signin_email'] ?></p></label>
			<br/>
			<input type="email" name="email" maxlength="40" required />
			
			<label for="login"><p><?php echo $lang['signin_login'] ?></p></label>
			<br/>
			<input type="login" name="login" maxlength="40" required />

			<label for="first_name"><p><?php echo $lang['signin_first_name'] ?></p></label>
			<br/>
			<input type="text" name="first_name" maxlength="40" required />
			
			<label for="last_name"><p><?php echo $lang['signin_last_name'] ?></p></label>
			<br/>
			<input type="text" name="last_name" maxlength="40" required />

			<label for="password"><p><?php echo $lang['signin_password'] ?></p></label>
			<br/>
			<input type="password" name="password" maxlength="20" minlength="5" required />
			
			<label for="password_conf"><p><?php echo $lang['signin_confirmation'] ?></p></label>
			<br/>
			<input type="password" name="password_conf" maxlength="20" minlength="5" required />
			
			<input type="submit" value="<?php echo $lang['signin_create'] ?>" class="submit transition" onclick="register()" />
		</form>
	</section>

<!-- ******* PASSWD FORGOT ***************** -->
	<section class="template_passwd_forgot">
		<form action="#" onsubmit="return false" accept-charset="utf-8" class="form">

			<label for="email_forgot"><p><?php echo $lang['signin_email'] ?></p></label>
			<br/>
			<input type="email" name="email_forgot" required />

			<input type="submit" value="<?php echo $lang['signin_send'] ?>" class="submit transition" onclick="forgot_passwd()" />
		</form>
	</section>

<!-- ******* JAVASCRIPT ***************** -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript">
	function login(){

		var formData = {
			'login'				: $('input[name=login_login]').val(),
			'password'			: $('input[name=password_login]').val(),
			'submit'			: "login"
		};

		$.ajax({
			type		: 'POST',
			url			: 'php/login_register.php',
			data		: formData,
			encode		: true,
			success		: function(data){
				$('#alert').html(data);
				$('input[name=password_login]').val('');
			}
		})
	}

	function register(){

		var formData = {
			'login'				: $('input[name=login]').val(),
			'password'			: $('input[name=password]').val(),
			'password_conf'		: $('input[name=password_conf]').val(),
			'email'				: $('input[name=email]').val(),
			'first_name'		: $('input[name=first_name]').val(),
			'last_name'			: $('input[name=last_name]').val(),
			'submit'			: "register"
		};

		$.ajax({
			type		: 'POST',
			url			: 'php/login_register.php',
			data		: formData,
			encode		: true,
			success		: function(data){
				$('#alert').html(data);
				$('input[name=password]').val('');
				$('input[name=password_conf]').val('');
			}
		})
	}

	function forgot_passwd(){

		var formData = {
			'email'				: $('input[name=email_forgot]').val(),
			'submit'			: "forgot"
		};

		$.ajax({
			type		: 'POST',
			url			: 'php/login_register.php',
			data		: formData,
			encode		: true,
			success		: function(data){
				$('#alert').html(data);
			}
		})
	}



	$(".template_login").hide();
	$(".template_register").hide();
	$(".template_passwd_forgot").hide();

	$("#login_nav").click(function(){
		$(".template_login").show();
		$(".template_register").hide();
		$(".template_passwd_forgot").hide();
	});

	$("#register_nav").click(function(){
		$(".template_register").show();
		$(".template_login").hide();
		$(".template_passwd_forgot").hide();
	});

	$(".forgot").click(function(){
		$(".template_passwd_forgot").show();
		$(".template_register").hide();
		$(".template_login").hide();
	});

</script>
<?php echo $type;?>
</body>
</html>
