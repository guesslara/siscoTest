<?
	session_start();
// incluir motor de autentificación.
/*require("login/aut_verifica.inc.php");
$nivel_acceso=10; // definir nivel de acceso para esta página.
if ($nivel_acceso < $_SESSION['usuario_nivel']){
header ("Location: $redir?error_login=5");
exit;
}
$usuario=$_SESSION['usuario_login'];
$nombre=$_SESSION['nombre'];
$apaterno=$_SESSION['apaterno'];
*/
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>IQe. Sisco - M&oacute;dulo de Ingenieria Black &amp; Descker Ver 1.0.0</title>
<link rel="icon" href="../img/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="" type="image/x-icon" />
</head>
<frameset rows="37,*" cols="*" framespacing="0" border="0" frameborder="0">                  
  <frame name="control" src="control.php?usuario=<?=$usuario;?>&n=<?=$nombre;?>&a=<?=$apaterno;?>" scrolling="no" noresize="noresize">
  	<frame name="contenido" target="contenido" src="contenido.php">
  	<noframes>
  	<body>
  		<p>Esta página utiliza marcos, pero su explorador no las admite.</p>
  	</body>
  	</noframes>
</frameset>
</html>