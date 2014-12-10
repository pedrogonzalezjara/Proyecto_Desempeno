<?php include("includes/session.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Registrarse</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
//initilize db
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

if (ALLOW_REGISTER <> "no"){
	echo "<p>El registro esta cerrado</p>";
}

if (CAPTCHA_REGISTER == "yes"){
$captchasession = $_SESSION['captcha']['code'];
$captcha = $db->escape(trim($_POST['captcha']));
	if($captchasession <> $captcha) {
	echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">Codigo captcha invalido.</div>";
	include("includes/footer.php");
	exit;
	}
}

//IP and DATE field
$ip = $_SERVER['REMOTE_ADDR'];


//EMAIL address
$email = $db->escape(trim($_POST['email']));

if( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
	echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">El email es invalido.</div>";
	include("includes/footer.php");
	exit;
}

if ($email) {
	//check if email already exists.
	$num = $db->get_var("select count(user_email) from site_users where user_email = '$email';");
		if ($num > 0) {
			echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">El Email ya esta registrado.</div>";
			include("includes/footer.php");
			exit;
		}
}else {
	echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">Porfavor revise la direccion de EmailP.</div>";
	include("includes/footer.php");
	exit;
}

//NAME FIELD
$name = $db->escape(trim(strip_tags($_POST['name'])));
	$strlen = (strlen($name));
	if ($strlen < 3) {
		echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">El nombre necesita minimo 3 caracteres.</div>";
		include("includes/footer.php");
    	exit;
		}

//LOGIN NAME FIELD
$login = $db->escape(trim(strip_tags($_POST['login'])));
	//make sure search length is at least 15 chars.
	$strlen = (strlen($login));
	if ($strlen < 3) {
		echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">El nombre de usuario necesita minimo 3 caracteres.</div>";
		include("includes/footer.php");
    	exit;
		}
	//check if login name is unique.
	$num = $db->get_var("select count(user_login) from site_users where user_login = '$login';");
		if ($num > 0) {
			echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">El nombre de usuario ya esta registrado.</div>";
			include("includes/footer.php");
			exit;
		}

//PASSWORD FIELD
$password = $db->escape(trim(strip_tags($_POST['password'])));
if ($password) {
	$passwordlength = strlen($password);
	if($passwordlength >= 5){
		$user_password = makepwd( trim( $db->escape( $password ) ) );
	} else {
		echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">La clave debe ser minimo 5 caracteres.</div>";
		include("includes/footer.php");
		exit;
	}
}

//pending
if (REGISTER_APPROVAL == "no"){
	$user_pending = 1;
	}
        else{
	$user_pending = 0;
}

//user_msg_send
$user_msg_send = 1;

$query = "INSERT into site_users(user_login,user_email,user_name,user_password,last_ip,user_status,user_level,user_pending,user_msg_send)VALUES('$login','$email','$name','$user_password','$ip',1,1,$user_pending,$user_msg_send);";
$db->query($query);
//notify admin
$from	 = FROM_EMAIL;
$to      = TO_EMAIL;
$subject = FHD_TITLE . ' New Registration';
// message
$message = '
<html>
<head>
  <title>Nuevo registro </title>
</head>
<body>
  <p>Ingrese sus datos</p>
  <p>nombre: ' . $name . '</p>
  <p>nombre de usuario: ' . $login . '</p>
  <p>Email: ' .  $email. '</p>
</body>
</html>
';
$headers = "From:" . $from . "\r\n";
$headers .="Reply-To: " .$from . "\r\n";
$headers .="X-Mailer: PHP/" . phpversion() ."\r\n";
$headers .="MIME-Version: 1.0" . "\r\n";
$headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
mail($to, $subject, $message, $headers);
?>

<h3>Registro recibido</h3>

<h4><a href="index.php">Conectarse</a></h4>

<?php include("includes/footer.php");