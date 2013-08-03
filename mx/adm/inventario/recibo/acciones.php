<?php 
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");
print_r($_POST);	echo "<hr>";	
$ac=$_POST["ac"];
switch ($ac){
	case "movimiento_nuevo":
		include("clase_movimiento.php");
		$m=new movimiento();
		$m->nuevo();
		break;
		
	default:
		echo "&nbsp;Accion no registrada.";
		break;
}
?>
