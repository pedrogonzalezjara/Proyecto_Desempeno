
<?php 
$a='3001';
$b=$_GET['anexo'];

$timeout=10;
$socket=fsockopen('146.83.181.9','22',$errno,$errstr,$timeout);

if(!$socket){
	$error="No es posible conectarse al servidor: <br>$errstr($errno)";
	echo $error;
}else{
	fwrite($socket,"Action: login\r\n");
	fwrite($socket,"UserName: astadmin\r\n");
	fwrite($socket,"Secret: 123456\r\n\r\n");
	
	fwrite($socket,"Action: originate\r\n");
	fwrite($socket,"Channel: SIP/".$a."\r\n");
	fwrite($socket,"Exten: ".$b."\r\n");
	fwrite($socket,"Context: local\r\n");
	fwrite($socket,"Priority: 1\r\n");
	fwrite($socket,"Timeout: 10000\r\n");
	fwrite($socket,"Callerid: ".$a."\r\n\r\n");
	
	fwrite($socket,"Action: Logoff\r\n\r\n");
	
	$wrets="";
	while(!feof($socket)){
		$wrets.=fread($socket,8192);
	}
	
	fclose($socket);
	
	$msg='<h1>LLAMANDO A '.$b.'</h1><br><br>';
	
	echo $msg;
	
	$lines=explode("/r/n",$wrets);
	foreach($lines as $value){
		echo $value.'<br>';
		}
}
?>