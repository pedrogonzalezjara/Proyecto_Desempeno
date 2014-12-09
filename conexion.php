<?php
$link=mysql_connect("localhost","root","") or die("<b>Problemas en MySQL:</b>");
if ($link)
{
mysql_select_db("db_asterisk",$link);
echo "Esta conectado...";
}
?>