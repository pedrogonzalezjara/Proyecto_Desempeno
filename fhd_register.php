<?php
session_start();
$_SESSION = array();
include("fhd_simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Registrarse</title>
<?php
include("includes/ajax.php");
include("fhd_config.php");
include("includes/header.php");

if (ALLOW_REGISTER <> "no"){
	echo "<div class=\"alert alert-info\" style=\"width: 175px;\">Registration is Closed</div>";

	include("includes/footer.php");
	exit;
	}
?>
<h1> registrarse</h1>
<table class="<?php echo $table_style_2;?>" style='width: auto;'>
<form action="fhd_register_action.php" method="post" class="form-horizontal">
<tr>
	<td>Su nombre:</td>
	<td><input type="text" name="name" id="name"></td>
</tr>
<tr>
	<td>Nombre de usuario:</td>
	<td><input type="text" name="login" onblur="showResult(this.value)" required> <span id="txtHint"></span></td>
</tr>
<tr>
	<td>email:</td>
	<td><input type="text" id="email" name="email" placeholder="nombre@ejemplo.com"></td>
</tr>
<tr>
	<td>Clave:</td>
	<td><input type="password" id="password" name="password" placeholder="minimo 5 caracteres"></td>
</tr>
<?php
if (CAPTCHA_REGISTER == "yes"){
    $captchaimg = '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA" />';
?>
<tr>
	<td><?php echo $captchaimg;?></td>
	<td>Ingrese codigo<br><input type="text" name="captcha" id="captcha" required></td>
</tr>
<?php } ?>
</table>
<br>
<p><input type="submit" value="Submit" class="btn btn-primary btn-large"></p>
<input type="hidden" name="try" value="true">
</form>
<!-- validation -->
<script type="text/javascript" src="js/livevalidation_standalone.compressed.js"></script>
<style type="text/css">
.LV_valid {
    color: green;
	margin:0 0 0 5px;
}
	
.LV_invalid {
    color:#CC0000;
	margin:0 0 0 5px;
}
</style>
<!-- validation -->
<script type="text/javascript">
var name = new LiveValidation( 'name', {wait: 500, validMessage: "Thank you" } );
name.add( Validate.Presence, { failureMessage: " este dato es requerido" } );
name.add( Validate.Length, { minimum: 2 } );

var email = new LiveValidation( 'email', {wait: 500, validMessage: "Thank you" } );
email.add( Validate.Presence, { failureMessage: " este dato es requerido" } );
email.add( Validate.Email );

var password = new LiveValidation( 'password', {wait: 500, validMessage: "Thank you" } );
password.add( Validate.Presence, { failureMessage: " este dato es requerido" } );
password.add( Validate.Length, { minimum: 5 } );

var captcha = new LiveValidation( 'captcha', {wait: 2000, validMessage: "Thank you" } );
captcha.add( Validate.Presence, { failureMessage: " este dato es requerido" } );
captcha.add( Validate.Length, { minimum: 5 } );
</script>

<h4><i class="fa fa-arrow-left"></i> <a href="index.php">Volver</a></h4>

<?php 
include("includes/footer.php");