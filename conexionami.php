<?php 
$timeout=50;
$socket=fsockopen('146.83.181.9','22',$errno,$errstr,$timeout);

if(!$socket){
	$error="No es posible conectarse al servidor: <br>$errstr($errno)";
	echo $error;
}else{
	$wrets=fgets($socket,1024);
	$msg='Conexion exitosa<br>'.$wrets;
	echo $msg;
}
?>