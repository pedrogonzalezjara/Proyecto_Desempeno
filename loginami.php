<?php 
$timeout=50;
$socket=fsockopen('146.83.181.9','22',$errno,$errstr,$timeout);

if(!$socket){
	$error="No es posible conectarse al servidor: <br>$errstr($errno)";
	echo $error;
}else{
	fwrite($socket,"Action: login\r\n");
	fwrite($socket,"UserName: astadmin\r\n");
	fwrite($socket,"Secret: 123456\r\n\r\n");
	
	fwrite($socket,"Action: Logoff\r\n\r\n");
	
	$wrets="";
	while(!feof($socket)){
		$wrets.=fread($socket,8192);
	}
	
	fclose($socket);
	
	$msg='Conexion exitosa<br><br>'.$wrets;
	
	echo $msg;
}
?>