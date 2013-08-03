<?php 
	session_start();
	include("../../conf/validar_usuarios.php");
	validar_usuarios(0,1,2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
	body,document{ background-image:url(../../../../../img/transparente.png); margin:0px 0px 0px 0px; padding:0px 0px 0px 0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
	#menu777{ font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; border:#333333 4px solid; background-color:#FFFFFF;
	position:absolute; width:600px; height:400px; top:50%; left:50%; margin-left:-300px; margin-top:-200px;
	background-image:url(../../../../../img/advanced-256.png); background-repeat:no-repeat; background-position:right;}
	#t1{ text-align:center; font-size:18px; font-weight:bold; margin-top:40px; margin-bottom:110px;}
	li{ margin:3px 0px 3px 0px;}
	a:link{ text-decoration:none; color:#000000;}
	a:hover{ text-decoration:none; color:#333333;}
	a:visited{ text-decoration:none; color:#000000;}
</style>
</head>

<body>
<?php include("../menu/menu.php"); ?>
<div id="menu777">
	<p id="t1">EDICI&Oacute;N DE MOVIMIENTOS </p>
	<ul>
		<li><a href="mover_productos_movimientos.php">Mover productos entre Movimientos.</a></li>
		<li>Agregar productos a un  Movimiento.</li>
		<li><a href="eliminar_movimiento.php">Eliminar Movimientos (Vac&iacute;os).</a></li>
	</ul>
</div>
</body>
</html>
