<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
include("fhd_simple-php-captcha.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Contraseña olvidada</title>
<?php
include("fhd_config.php");
include("includes/header.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
include("includes/functions.php");
$thedomain = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//initilize db
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

//if STEP 2 of the process
if (isset($_GET['action'])) {
	$action = $db->escape( $_GET['action'] );
	$key = $db->escape( $_GET['key'] );
	//check if action is to reset password and that the key is not blank.
	if ($action == "rp") {
		if (!empty($key)){
		$myquery = "SELECT user_id,user_email FROM site_users WHERE user_im_other = '$key' limit 1;";
		$resets = $db->get_row($myquery);
		// if a record is returned then continue
		if ($db->num_rows == 1){
			$user_email = $resets->user_email;
			$user_id = $resets->user_id;
			//generage a new password, set resetcode to blank so link cannot be used again.
			$user_password_plain = generatePassword(8,9);
			$user_password = makepwd( trim( $db->escape( $user_password_plain ) ) );
			//update the password in the database.
			$db->query("UPDATE site_users set user_password = '$user_password',user_im_other = '' WHERE user_id = $user_id limit 1;");

			//send out the message
			$from = FROM_EMAIL;
			$to    = $user_email;
			$subject = 'Su Nueva Clave';
			// message
			$message = '
			<html>
			<body>
			  <p>Nueva clade de la mesa de ayuda</p>
			  <p>Email: ' . $user_email . '</p>
			  <p>Clave: ' .  $user_password_plain. '</p>
			</body>
			</html>
			';
			$headers = "From:" . $from . "\r\n";
			$headers .="Reply-To: " .$from . "\r\n";
			$headers .="X-Mailer: PHP/" . phpversion() ."\r\n";
			$headers .="MIME-Version: 1.0" . "\r\n";
			$headers .="Content-type: text/html; charset=iso-8859-1" . "\r\n";
			mail($to, $subject, $message, $headers);
			$message = "Revise su Email por su nueva clave.";
			//if key is wrong, then no records will be found, give this error.
			} else {
			$message = "Error,Clave de restauracion invalida";
			}
		}else {
		$message = "Error, La clave de restauracion esta en blanco.";
		}
		} else {
		$message = "Error";
		}
$finish = 1;
}

//STEP 1 of the process
// is ?try=true 
if (isset($_POST['try'])) {

	//check the CAPTCHA if enabled.
	if (CAPTCHA_RESET_PASSWORD == "no"){
		$captchasession = $_SESSION['captcha']['code'];
		$captcha = $db->escape(trim($_POST['captcha']));
		if($captchasession <> $captcha) {
			echo "<div class=\"alert alert-danger\" style=\"max-width: 200px;\"><a href='fhd_forgotpassword.php'>Codigo Invalido</a></div>";
			include("includes/footer.php");
			exit;
		}
	}

    // clicked on the submit button
   if(empty($_POST['user_email'])) {
    // At least one of the file is empty, display an error
    echo '<p style="color: red;">Se requiere de la dirrecion Email</p>';
} else {
    // User has filled it all in.
	//run the password reset.
	$user_email = $db->escape( $_POST['user_email'] );

		if( !filter_var($user_email, FILTER_VALIDATE_EMAIL) ) {
			echo "<div class=\"alert alert-danger\" style=\"max-width: 350px;\">esa direccion Email es invalida.</div>";
			include("includes/footer.php");
			exit;
		}

	$finish = 1;

	//check to make sure the email addreess is in the database
	$myquery = "select count(user_id) from site_users where user_email = '$user_email' AND user_pending = 0 limit 1;";
	$count = $db->get_var($myquery);

	//if the email is valid then continue
	if ($count == 1){
		//insert a random code into the database for the user
		$resetpasswordcode = generatePassword(9,4);
		//$resetdate = date("Y-m-d H:i:s");
		$query = "UPDATE site_users set user_im_other = '$resetpasswordcode' WHERE user_email = '$user_email' limit 1;";
		$db->query($query);

		//send out the message
		$from = FROM_EMAIL;
		$to   = $user_email;
		$subject = 'Confirmacion de la mesa de ayuda';
		// message
		$message = '
		<html>
		<body>
		  <p>Aqui esta la clave de restauracion como fue solicitado.</p>
		  <p>Para Restaurar la clave porfavor visite la siguiente direcion, de lo contrario Ignore este Email y no se realizara ningun cambio.</p>
		  <p><a href="http://' . $thedomain . '?action=rp&key='. $resetpasswordcode . '">http://' . $thedomain . '?action=rp&key='. $resetpasswordcode . '</a></p>
		</body>
		</html>
		';
		$headers  = "From:" . $from . "\r\n";
		$headers .= "Reply-To: " .$from . "\r\n";
		$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
		$headers .= 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $message, $headers);
		$message = "Revise su Email para el link de confirmacion(recuerda revisar su bandeja de Spam).";
	} else {
		$message = "Error, La direccion de Email no fue encontrada o su Registro esta en estado Pendiente.";
	}
}
}
?>

<h2>Recuperar Clave </h2>

<?php if ($finish == 1) { ?>
	<p><?php echo $message;?></p>
<?php }else{ ?>

<form action="fhd_forgotpassword.php" method="post" class="form-horizontal" role="form" data-parsley-validate>
<div class="form-group">
    <label for="user_email" class="col-sm-2 control-label">Email</label>
	<div class="col-sm-3">
	<input type="email" class="form-control" name="user_email" id="user_email" placeholder="Ingrese Email" required>
	</div>
</div>

<?php
if (CAPTCHA_RESET_PASSWORD == "no"){
	$_SESSION['captcha'] = simple_php_captcha();
	$captchaimg = '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';
?>  
<div class="form-group">
    <label for="captcha" class="col-sm-2 control-label"><?php echo $captchaimg; ?></label>
	<div class="col-sm-3">
	<input type="text" class="form-control" name="captcha" id="captcha" placeholder="Ingrese Codigo">
	</div>
</div>
<?php } ?>

 <div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	<button type="submit" value="enter" class="btn btn-default">Enviar</button>
	</div>
</div>

<input type="hidden" name="try" value="true">
</form>

<p><a href="index.php">Devolverse a la pagina Inicial</a> &bull; <a href="fhd_forgotpassword.php">Recargar Pagina</a></p>

<?php } 
include("includes/footer.php");