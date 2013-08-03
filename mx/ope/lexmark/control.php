<?php 
	session_start();
	if (!$_SESSION){
		echo "Error: Acceso Incorrecto."; exit;
	}
	$usuario=$_SESSION["nombre"];
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>control</title>
<base target="contenido">
<script type='text/javascript'>
  var mensajeerror = "";
</script>
<style type="text/css">
body { 	margin: 0px; background-image:url(../img/page_header_bgImage.gif); background-repeat:repeat-x; color:#FF0; }
#titulo{ position:absolute; width:400px; left:50%; margin-left:-200px; margin-top:5px; font-size:18px; font-weight:bold; padding:1px; text-align:center; }
#usuario{ font-size:12px; float:right; color:#FFF; font-size:14px; margin-top:7px; text-align:left;}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>
<div id="titulo">M&oacute;dulo de Ingenier&iacute;a Lexmark ver 1.0.0</div>
<div id="usuario"><b>Usuario:</b> <?=$usuario?>.&nbsp;</div>

</body>
</html>