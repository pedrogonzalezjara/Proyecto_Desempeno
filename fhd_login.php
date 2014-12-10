<?php include("includes/session.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Mesa de Ayuda</title>
<?php
$is_valid = 0;
include("fhd_config.php");
include("includes/header.php");
include("includes/functions.php");

if (!isset($_SESSION['auth'])) {
	echo "<p>Error de autentificacion</p><p><i class='fa fa-lock'></i></p>";
	include("includes/footer.php");
	exit;
}

//limit login tries.
if (isset ( $_SESSION['hit'] ) ) {
	$_SESSION['hit'] += 1;
	if ($_SESSION['hit'] > LOGIN_TRIES){
		echo "<p><i class='fa fa-lock fa-2x pull-left'></i> Acceso bloqueado</p>";
		include("includes/footer.php");
		exit;
	}
}else{
	$_SESSION['hit'] = 0;
}

include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);

if (isset($_POST['user_login'])) {
	$user_login = trim( $db->escape( $_POST['user_login'] ));
}else{
	echo "<div class='alert alert-warning' style='width: 375px;'><i class='glyphicon glyphicon-info-sign'></i> Se requiere Nombre de usuario/Email.</div>";
	include("includes/footer.php");
	exit;
}

if (isset($_POST['user_password'])) {
	$user_password = trim( $db->escape( $_POST['user_password'] ));
	$is_valid = checkpwd($user_password,$user_login);
}

//uesrs can login with either login name or email address.
$pos = strrpos($user_login, "@");
if ($pos === false) { // note: three equal signs 
    $checkusing = "user_login";
}else{ 
    $checkusing = "user_email";
}

$is_pending = $db->get_var("select user_pending from site_users where user_login = '$user_login' OR user_email = '$user_login' limit 1;");
if ($is_pending ==1) {
	//if user is pending, then set invalid to 0
	$is_valid = 0;
}


if ($is_valid <> 1){
	$_SESSION['hit'] += 1;
	echo "<div class='alert alert-warning' style='width: 375px;'><i class='glyphicon glyphicon-info-sign'></i> Usuario incorrecto,o su registracion esta pendiente.</div>";
	include("includes/footer.php");
	exit;
}

$site_users = $db->get_row("select user_id,user_name,user_level from site_users WHERE $checkusing = '$user_login' limit 1;");
$user_id = $site_users->user_id;
$user_name = $site_users->user_name;
$user_level = $site_users->user_level;

if ($user_level == 0){
	$_SESSION['admin']=1;
}else{
	$_SESSION['user']=1;
}

$_SESSION['user_id']=$user_id;
$_SESSION['user_name']=$user_name;
$_SESSION['user_level']=$user_level;
$_SESSION['hit'] = 0;

include("includes/all-nav.php");

echo "<!-- <p>$user_id</p> -->";
echo "<h2>Bienvenido, $user_name</h2>";

//record some details about this login
$lastip = $_SERVER['REMOTE_ADDR'];

//$last_login = mktime($dateTime->format("n/j/y g:i a"));
$last_login = date(time());
//echo $dateTime->format("Y-m-d h:i:s");

$db->query("UPDATE site_users SET last_ip = '$lastip',last_login = '$last_login' WHERE user_id = $user_id;");
//$d_last_login = $db->get_var("select last_login from site_users where user_id = $num limit 1;");
?>

<h3><a href="fhd_user_call_add.php" class="btn btn-large btn-primary btn-success">Consultas abiertas</a></h3>

<h3><a href="fhd_calls.php" class="btn btn-large btn-primary">Ver consultas</a></h3>

<?php include("includes/footer.php");
