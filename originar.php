<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include("includes/session.php");
include("includes/checksession.php");
include("includes/checksession_ss.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
	<title>Ticket Details</title>
<?php 
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");?>
        <html xmlns="http://www.w3.org/1999/xhtml"></html>
<?php 
$a=$_POST['bt1'];
$b=$_POST['bt2'];

$timeout=10;
$socket=fsockopen('146.83.181.9','27710',$errno,$errstr,$timeout);

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
		$wrets.=fread($socket,22);
	}
	
	fclose($socket);
	
	$msg='<h1>LLAMANDO A EJECUTIVO'.$b.'</h1><br><br>';
	
	echo $msg;
	
	$lines=explode("/r/n",$wrets);
	foreach($lines as $value){
		echo $value.'<br>';
		}
}
?>