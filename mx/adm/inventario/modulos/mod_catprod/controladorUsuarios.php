<?
	//configuracion
	require_once("../../../../../includes/config.inc.php");
	//se incluye el modelo
	require_once("modeloUsuarios.php");
	//objeto del modelo
	$objModeloUsuarios=new modeloUsuarios($host,$usuario,$pass,$db);
	
	switch($_POST['action']){
		
	        case "consulta":
			$buscador=$_POST['txtBusca'];
			$objLote->consulta($buscador);	
                break;


	}
?>