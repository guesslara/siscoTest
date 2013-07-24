<?php
	session_start();
	if (!$_SESSION){
		echo "Error: Acceso Incorrecto."; exit;
	}
?>
<html>
<style type="text/css">
body,document,frameset { margin:0px;}
</style>
<head>

<title>IQe. Sisco - M&oacute;dulo Inventario Lexmark ver 1.0.0 </title>
</head>
<frameset rows="37,*" cols="*" framespacing="0" border="0" frameborder="0">
  
  <frame name="control" src="control.php" scrolling="no" noresize="noresize">
  <frame name="contenido" target="contenido" src="contenido.php">
  <noframes>
  <body>
  <p>Esta página utiliza marcos, pero su explorador no las admite.</p>
  </body>
  </noframes>
</frameset>
</html>