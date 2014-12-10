<?php
ob_start();
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksessionadmin.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Editar Usuario</title>
<?php 
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$actionstatus = "";
//<UPDATE>
if (isset($_POST['update'])){
 if ( $_POST['nacl'] == md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;")) ) {
	//authentication verified, continue.
	$url_user_id = valid_user($_POST['url_user_id']);
	$user_date = date(time());
	$user_login = $db->escape($_POST['user_login']);

	//password function here
	$user_password_set = "";
	if( strlen($_POST['user_password'] ) > 4){
		$user_password = makepwd( trim( $db->escape( $_POST['user_password'] ) ) );
		$user_password_set = "user_password='$user_password',";
	}

	$user_name = $db->escape($_POST['user_name']);
	$user_email = $db->escape($_POST['user_email']);
	$user_phone = $db->escape($_POST['user_phone']);
	$user_address = $db->escape($_POST['user_address']);
	$user_city = $db->escape($_POST['user_city']);
	$user_state = $db->escape($_POST['user_state']);
	$user_zip = $db->escape($_POST['user_zip']);
	$user_country = $db->escape($_POST['user_country']);
	$user_level = $db->escape($_POST['user_level']);	

	$user_protect_edit = 0;
	if (isset ($_POST['user_protect_edit']) ) {
		$user_protect_edit_value = $db->escape($_POST['user_protect_edit']);
		if($user_protect_edit_value == 1){$user_protect_edit = 1;};
	}

		$user_msg_send = 0;
	if (isset ($_POST['user_msg_send']) ) {
		$user_msg_send_value = $db->escape($_POST['user_msg_send']);
		if($user_msg_send_value == 1){$user_msg_send = 1;};
	}

		$user_pending = 0;
	if (isset ($_POST['user_pending']) ) {
		$user_pending_value = $db->escape($_POST['user_pending']);
		if($user_pending_value == 1){$user_pending = 1;};
	}

	$db->query("UPDATE site_users SET $user_password_set user_email='$user_email',user_name='$user_name',user_phone='$user_phone',user_address='$user_address',user_city='$user_city',user_state='$user_state',user_zip='$user_zip',user_country='$user_country',user_level=$user_level,user_msg_send=$user_msg_send,user_protect_edit=$user_protect_edit,user_pending=$user_pending where user_id = $url_user_id;");
    $actionstatus = "<div class=\"alert alert-success\" style=\"max-width: 250px;\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    Usuario actualizado correctamente.
    </div>";
	//$db->debug();
 }
}
//</UPDATE>

if (isset($_REQUEST['url_user_id'])){
	$url_user_id = valid_user($_REQUEST['url_user_id']);
	$site_users = $db->get_row("SELECT user_login,user_password,user_name,user_address,user_city,user_state,user_zip,user_country,user_phone,user_email,user_msg_send,user_protect_edit,user_pending,user_level FROM site_users WHERE (user_id = $url_user_id) limit 1;");
	$user_msg_send = $site_users->user_msg_send;
	$user_protect_edit = $site_users->user_protect_edit;
	$user_pending = $site_users->user_pending;
}
$nacl = md5(AUTH_KEY.$db->get_var("select last_login from site_users where user_id = $user_id;"));
echo $actionstatus;?>

<p><a href="fhd_users.php">Usuarios</a></p>

<form action="fhd_edit_user.php" method="post" class="form-horizontal">
<table class="<?php echo $table_style_2;?>" style='width: auto;'>
	<tr><td>Nombre de usuario </td>
	<td><input type="text" name="user_login" value="<?php echo $site_users->user_login;?>"</td></td></tr>
	
	<tr><td>Clave</td>
	<td><input type="text" name="user_password"></td></tr>

	<tr><td>Nivel de usuario</td>
	<td><select name="user_level">
	<option selected value="<?php echo $site_users->user_level;?>"><?php echo show_user_level($site_users->user_level);?></option>
	<option value="1"><?php echo show_user_level(1);?></option>
	<option value="2"><?php echo show_user_level(2);?></option>
	<option value="0"><?php echo show_user_level(0);?></option>
	</select></td></tr>
	
	<tr><td>Nombre</td>
	<td><input type="text" name="user_name" value="<?php echo $site_users->user_name;?>"></td></tr>
	
	<tr><td>Email</td>
	<td><input type="text" name="user_email" value="<?php echo $site_users->user_email;?>" size="25"></td></tr>
	
	<tr><td>Telefono</td>
	<td><input type="text" name="user_phone" value="<?php echo $site_users->user_phone;?>" size="20"></td></tr>

	<tr><td>dirección</td>
	<td><input type="text" name="user_address" value="<?php echo $site_users->user_address;?>" size="20"></td></tr>

	<tr><td>Ciudad</td>
	<td><input type="text" name="user_city" value="<?php echo $site_users->user_city;?>" size="20"></td></tr>


	<tr><td>ID </td>
	<td><?php echo $url_user_id;?></td></tr>

	<tr><td colspan="2"><input type="checkbox" name="user_pending" value="1" <?php if($user_pending == 1){echo " CHECKED";}?>> usuario pendiente?</td></tr>
	<tr><td colspan="2"><input type="checkbox" name="user_msg_send" value="1" <?php if($user_msg_send == 1){echo " CHECKED";}?>> Recibe mensajes de Emails de estado de las consultas?</td></tr>
	<tr><td colspan="2"><input type="checkbox" name="user_protect_edit" value="1" <?php if($user_protect_edit == 1){echo " CHECKED";}?>> Bloqueo de edición de usuario ?</td></tr>

</table>
<input type='hidden' name='url_user_id' value='<?php echo $url_user_id;?>'>
<input type='hidden' name='nacl' value='<?php echo $nacl;?>'>
<input type='hidden' name='update' value='1'>
<input type="submit" value="actualizar" class="btn btn-primary btn-large">
</form>

<?php
if(isset($_SESSION['name'])){
	
	echo "<p><strong>Name:</strong> " . $_SESSION['name'] . "</p>";
}
include("includes/footer.php");	