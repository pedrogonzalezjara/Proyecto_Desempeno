<?php
include('funciones.php');
include('status.php');

$link=conectadb('localhost','root','','db_asterisk');

$sql="SELECT usr_nombre,usr_email,usr_code,usr_status,usr_exten FROM tb_usuarios";
$res=mysql_query($sql);
?>
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo6 {color: #FFFFFF; font-weight: bold; }
-->
</style>

<table border="0" align="center" cellpadding="0" cellspacing="2">
  <tr>
    <td width="221" bgcolor="#FF0000"><div align="center" class="Estilo6"><span class="Estilo3">Nombre</span></div></td>
    <td width="199" bgcolor="#FF0000"><div align="center" class="Estilo6"><span class="Estilo3">Correo</span></div></td>
    <td width="65" bgcolor="#FF0000"><div align="center" class="Estilo6"><span class="Estilo3">Codigo</span></div></td>
    <td width="65" bgcolor="#FF0000"><div align="center" class="Estilo6"><span class="Estilo3">Estatus</span></div></td>
    <td width="69" bgcolor="#FF0000"><div align="center" class="Estilo6"><span class="Estilo3">Extension</span></div></td>
  </tr>
<?php 
while ($row=mysql_fetch_array($res)){
echo "<tr>";
echo "<td>".$row['usr_nombre']."</td>";
echo "<td>".$row['usr_email']."</td>";
echo "<td>".$row['usr_code']."</td>";
echo "<td>".estado($row['usr_exten'])."</td>";
echo "<td><a href='originar_usuarios.php?anexo=".$row['usr_exten']."'>".$row['usr_exten']."</a></td>";
echo "</tr>";
}
?>
</table>
