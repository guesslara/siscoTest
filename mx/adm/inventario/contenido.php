<?php
	session_start();
	if (!$_SESSION){	echo "Error: Acceso Incorrecto."; exit;		}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>contenido</title>
<style type="text/css">
<!--
body {
	background-image: url(); margin:0px;
}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #666666;
	font-weight: bold;
}
.Estilo5 {font-weight: bold}
.Estilo7 {
	font-size: 24px;
	font-weight: bold;
}
.style1 {
	font-size: 18pt;
	font-weight: bold;
}
a:link {
	color: #000000; text-decoration:none;
}
a:visited {
	color: #000000; text-decoration:none;
}
a:hover {
	color: #ff0000; text-decoration:none;
}
a:active {
	color: #000000; text-decoration:none;
}
-->
</style>
</head>
<body>
<?php include("menu/menu0.php");	//print_r($_SESSION); ?>
<br>
<p align="center" class="Estilo7">Bienvenido <?=$_SESSION['nombre']?></p>
<p align="center"><img src="../img/iq_g2.jpg" style="margin-left:20px; margin-top:20px;" /></p>
<p style="text-align:center; font-size:20px;">IQe. Sisco - Inventario Lexmark ver 1.0.0 </p>

<?php include('../f.php'); ?>
</body>
</html>