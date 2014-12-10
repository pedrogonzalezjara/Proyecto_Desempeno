<?php
include("includes/session.php");
include ("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Añadir datos de usuario</title>
<?php 
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$actionstatus = "";
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
//<ADD>
if (isset($_POST['nacl'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
	//authentication verified, continue.
	$user_login = $db->escape($_POST['user_login']);
	$user_email = $db->escape($_POST['user_email']);
		//check email exists
		$num = $db->get_var("select count(user_email) from site_users where (user_email = '$user_email');");
		if ($num > 0) {
		echo "<div class='alert alert-danger'><strong>Error:</strong> El Email ya esta Registrado.</div>";
		include("includes/footer.php");
		exit;
		}

	//password function here
	if( strlen($_POST['user_password'] ) > 4){
		$user_password = makepwd( trim( $db->escape( $_POST['user_password'] ) ) );
	}else{
		echo "<div class='alert alert-danger'><strong>Error:</strong> La Clave es muy corta (debe Contener mas de 4 digitos).</div>";
		include("includes/footer.php");
		exit;
	}

	$user_name = $db->escape($_POST['user_name']);
	$user_phone = $db->escape($_POST['user_phone']);	
	$user_address = $db->escape($_POST['user_address']);
	$user_city = $db->escape($_POST['user_city']);
	$user_state = $db->escape($_POST['user_state']);
	$user_zip = $db->escape($_POST['user_zip']);
	$user_country = $db->escape($_POST['user_country']);
	$db->query("INSERT INTO site_users(user_login,user_email,user_password,user_name,user_phone,user_address,user_city,user_state,user_zip,user_country,user_level,user_status)VALUES('$user_login','$user_email','$user_password','$user_name','$user_phone','$user_address','$user_city','$user_state','$user_zip','$user_country',1,1);");
//$db->debug();
        $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    Usuario añadido.
    </div>";
 }
}
//</ADD>

$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
?>

<h4>Añadir Usuario</h4>
<?php echo $actionstatus;?>

<form action="fhd_admin_register.php" method="post" class="form-horizontal" data-parsley-validate>
<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr><td>Nombre De Usuario*</td>
	<td><input type="text" name="user_login" required></td></tr>

	<tr><td>Email*</td>
	<td><input type="text" name="user_email" required data-parsley-type="email"></td></tr>		
	
	<tr><td>Clave*</td>
	<td><input type="text" name="user_password" required  data-parsley-minlength="4"></td></tr>		

	<tr><td>Nombre*</td>
	<td><input type="text" name="user_name" required></td></tr>

	<tr><td>Telefono</td>
	<td><input type="text" name="user_phone" size="15"></td></tr>
	
	<tr><td>Direccion</td>
	<td><input type="text" name="user_address" size="25"></td></tr>
	
	<tr><td>Ciudad</td>
	<td><input type="text" name="user_city" size="25"></td></tr>


</table>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type="submit" value="Añadir usuario" class="btn btn-primary">
</form>

<?php
if(isset($_SESSION['name'])){
	echo "<p><strong>Nombre:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");