<?php
include_once('php/connexion.php');

if ($_SESSION['id'] == "" || $_SESSION['login'] == "")
{
	header('Location: /');
	exit;
}

if (isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['email']) && $_POST['email'] != "")
{
	$email = htmlspecialchars($_POST['email']);
	$passwd = htmlspecialchars($_POST['password']);
	$passwd = hash("whirlpool", htmlspecialchars($passwd));

	$req = $bdd->prepare('SELECT * FROM users WHERE email = ? AND passwd = ? AND id_user = ?');
	$req->execute(array($email, $passwd, $_SESSION['id']));
	if($req->rowCount() == 1)
	{
		$data = $req->fetch();
		$req2 = $bdd->prepare('DELETE FROM users WHERE id_user=:id');
		$req2->bindParam(':id', $data['id_user'], PDO::PARAM_INT);
		$req2->execute();
		header('Location: php/logout.php');
	}
	else{
		echo "<style>#alert_div { background-color: #568456!important;} </style>";
		$txt =  '<div id="alert_div"><p id="text_alert">'.$lang['account_delete_wrong'].'</p><span class="closebtn" onclick="del_alert()">&times;</span></div>';
	}
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

<!-- ******* FORMULAIRE ***************** -->
	<section class="template_delete">
		<!-- Form -->
			<form action="#" onsubmit="return false" accept-charset="utf-8" class="form">

			<label for="email"><p><?php echo $lang['account_delete_email'] ?></p></label>
			<br/>
			<input type="email" name="email" maxlength="40" required />
			
			<label for="password"><p><?php echo $lang['account_delete_password'] ?></p></label>
			<br/>
			<input type="password" name="password" maxlength="20" required />

			<!-- SIGN IN -->
			<input type="submit" name="go_delete_account" value="<?php echo $lang['account_delete_delete'] ?>" class="submit" style="margin-top: 25px;" onclick="del_account()" />
			</form>
			<!-- /end Form -->
	</section>


	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</body>
</html>