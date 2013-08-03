<?php
	session_start();
	//print_r($_SESSION);
	if (!$_SESSION){
		echo "Error: Acceso Incorrecto."; exit;
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>control</title>
<base target="contenido">
<style type="text/css">

.style1 {	font-size: 18pt;
	font-weight: bold;
}
body { 	margin: 0px; background-image:url(../img/page_header_bgImage.gif); background-repeat:repeat-x; }
.style2 {color: #FFFFFF}
.style3 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
	font-weight: bold;
}
a:link { color: #FFFFFF; text-decoration:none; }
a:visited { color: #FFFFFF; text-decoration:none; }
a:hover { color: #FFFF00; text-decoration:none; }
a:active { 	color: #FFFFFF; text-decoration:none; }
.Estilo5 {font-size: 10pt}
/*a.external:visited { color: blue; }*/
a.menu:link { color: #FFFFFF; text-decoration:none; }
a.menu:visited { color: #FFFFFF; text-decoration:none; }
a.menu:hover { color: #FFFF00; text-decoration:none; }
a.menu:active { 	color: #FFFFFF; text-decoration:none; }
.fecha { width:300px; float:right;height:18px; text-align:right; padding-right:20px; color:#ffffff; padding-top:5px; font-size:11px; font-weight:bormal;}
.tit{width:350px; left:50%; margin-left:-175px; position:absolute; float:left; height:20px; padding:0px; text-align:center; /*background-color:#999;*/ color:#ffffff;
 padding-top:5px; font-size:13px; font-weight:bold; /*border:#ffcc00 1px solid;*/ top:10px; }
#Layer1 {
	position:absolute; top:4px;
	width:300px;
	height:30px;
	z-index:1;
	left: 13px;
}
</style>
</head>
<body topmargin="0" >

<div style=" background-image:url('img/page_header_bgImage.gif'); font-family:Verdana, Arial, Helvetica, sans-serif; margin:0; padding:0px; font-size:10pt;">
	<div id="Layer1">
		<form name="f0" id="f0" style="margin:0px;" method="post" target="contenido" action="otros/buscador.php">
			<input type="text" name="nds" size="30" id="nds" value="No. Serie" onClick="this.value=''" style="text-align:center; color:#333333;">
			<input type="submit" value="Buscar">
		</form>
	</div>
	<div class="tit">IQe. Sisco - Inventario Lexmark </div> 
	<div class="fecha" ><? 
		include("../conf/fecha.php");
		echo "<b>".$fecha."<b>"; ?>
		<div style="color:#FFFF00;">Usuario: <?=$_SESSION['nombre'];?></div>
	</div>
</div>
</body>
</html>