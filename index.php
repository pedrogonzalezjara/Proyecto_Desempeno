<?php include("includes/session.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Mesa de Ayuda</title>
<?php
$_SESSION['auth'] = md5(uniqid(microtime()));
//check for fhd_config
$filename = 'fhd_config.php';
if (!file_exists($filename)) {
	define('css', 'css/bootstrap.min.css');
    echo "<p></p><strong>Información:</strong> Se necesita configuracion del software</p>";
    echo "<p>Porfavor revise el archivo<strong>fhd_config.php</strong> .</p>";
    echo "<p>Si esto es una instalación, Usted puede cambiar el nombre del archivo <strong>rename fhd_config_sample.php a fhd_config.php</strong></p>";
    echo "<p>Abrir fhd_config.php en el editor de texto y <strong> ajustar la configuracion</strong>.</p>";
    echo "<p>Para mas información, porfavor revisar el archivo readme <a href='readme.htm' target='_blank'>.</a>.</p>";
	include("includes/footer.php");
	exit;
}

include("fhd_config.php");
include("includes/header.php");

//check database settings.
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");
$db = new ezSQL_mysqli(db_user,db_password,db_name,db_host);
$SCHEMA_NAME = $db->get_var("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '".db_name."';");
if ($SCHEMA_NAME <> db_name) {
    echo "<p></p><strong>Información:</strong> Se necesita configuracion del software</p>";
	echo "<p>La base de dato especificada en fhd_config.php [ ".db_name." ] no existe, porfavor revisar el archivo <a href='readme.htm' target='_blank'></a>.</p>";
	include("includes/footer.php");
	exit;
}

//check if tables actually exist.
$user_table_exists = $db->get_var("SHOW TABLES LIKE 'site_users';");
if ($user_table_exists <>  "site_users") {
    echo "<p></p><strong>Información:</strong>Se necesita configuracion del software</p>";
	echo "<p>Una o mas tablas de la base de dato no se encuentran (named: ".db_name."). Porfavor ejecute <strong>site.sql</strong> con su base de datos para crear las tablas. porfavor revisar el archivo <a href='readme.htm' target='_blank'>.</a></p>";
	include("includes/footer.php");
	exit;
}

//create upload table if it does not exist.
$upload_exists = $db->get_var("SHOW TABLES LIKE 'site_upload';");
if ($upload_exists <>  "site_upload") {
	$db->query("CREATE TABLE `site_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `call_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_ext` varchar(4) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `call_id` (`call_id`)
) ;");
}

//create options table if it does not exist.
$options_exists = $db->get_var("SHOW TABLES LIKE 'site_options';");
if ($options_exists <>  "site_options") {
	$db->query("CREATE TABLE `site_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` varchar(500) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `option_name` (`option_name`)
) ;");
	$db->query("INSERT INTO site_options(option_name) VALUES ('encrypted_passwords');");
	}

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
	include("includes/all-nav.php");
	echo "<p>Bienvenido</p>";
	echo "<p><a href='fhd_dashboard.php'>Plataforma de Mesa de ayuda</a></p>";
}else{
?>	

<?php
//limit login tries.
if (isset ( $_SESSION['hit'] ) ) {
	if ($_SESSION['hit'] > LOGIN_TRIES){
		echo "<p><i class='fa fa-lock fa-2x pull-left'></i> Acceso bloqueado</p>";
		include("includes/footer.php");
		exit;
	}
}
?>

<h2><?php echo 'Mesa De Ayuda';?></h2>

<?php
if ( isset ($_GET['loggedout']) ) {
echo "<div class=\"alert alert-success\" style=\"max-width: 350px; text-align: center;\"><strong> Desconectado </strong><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";
}
?>

<?php
if (ALLOW_ANY_ADD == 'yes') {
	echo "<h4><a href='fhd_any_call_add.php' class='btn btn-success'>Consultas abiertas <i class='glyphicon glyphicon-new-window'></i></a></h4>";
	echo "<hr>";
	echo "<p>or Login</p>";
}
?>

<form action="fhd_login.php" method="post" class="form-horizontal" role="form">

<div class="form-group">
	<label class="col-sm-2 control-label" for="inputEmail">Email</label>
	<div class="col-sm-3">
	<input type="text" id="inputEmail" name="user_login" placeholder="Nombre de Usuario/Email" required>
	</div>
</div>

<div class="form-group">
	<label class="col-sm-2 control-label" for="inputPassword">Clave</label>
	<div class="col-sm-3">
	<input type="password" id="inputPassword" name="user_password" placeholder="Clave" required>
	</div>
</div>

 <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">Conectarse</button>
    </div>
  </div>
</form>

<p><?php if (ALLOW_REGISTER == "no"){?>
<a href="fhd_register.php" class="btn btn-default">register</a>  
<?php } ?> <a href="fhd_forgotpassword.php" class="btn btn-default">Olvido su clave?</a></p>
<?php }?>

<?php include("includes/footer.php");?>	
