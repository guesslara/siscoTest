<?php 
if (!$_SESSION) header("Location: ../index.php");
if (!$_SESSION['sistema']=="bd") header("Location: ../index.php");
//print_r($_SESSION);		
function validar_usuarios()
{
 	$num_args = func_num_args();
    for ($i=0;$i<$num_args;$i++) {
    	$arg=func_get_arg($i);
		$validado=false;
		if ($_SESSION['usuario_nivel']==$arg){
			$validado=true;
			break;
		}
	}	
	if (!$validado)
	{
		echo "<center><br><br><img src='../../img/stop.png'><br>Acceso no autorizado para el usuario: <b>".$_SESSION['nombre']."</b><br><a href='javascript:history.back();' style='text-decoration:none;'>Volver</a></center>";
		exit();	
	}
}
?>
