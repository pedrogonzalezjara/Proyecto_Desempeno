<?php
function conectadb($server,$user,$pass,$db)
{
	$link=mysql_connect($server,$user,$pass);
	mysql_select_db($db,$link);
	return $link;
}
?>