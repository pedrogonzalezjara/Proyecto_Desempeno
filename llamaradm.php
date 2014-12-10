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
	<title>Llamar a Ejecutivo</title>
<?php 
include("fhd_config.php");
include("includes/header.php");
include("includes/all-nav.php");
include("includes/functions.php");
include("includes/ez_sql_core.php");
include("includes/ez_sql_mysqli.php");?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<body>
    <h4><i class='fa fa-tag'></i> Responder Llamadas</h4>

<form id="form1" name="form1" method="post" action="originar.php" action="fhd_search.php" class="form-horizontal">
<table class="<?php echo $table_style_3;?>" style='width: auto;'>

	<td>Responder LLamadas Pendientes</td>
	</tr>		
			
	
</table>
    <input type="hidden" name="search" value="1">
            <input type="submit" value="Responder" class="btn btn-primary">
                
            </input>


</body>
</html>
