<?
	include("modeloEnsamble.php");
	$objBusqueda=new modeloBusqueda();
	//print_r($_POST);
	switch($_POST['action']){
		case "mostrarFormularioBusqueda":
			$objBusqueda->mostrarFormulario();
		break;
		case "busquedaProd":
			$objBusqueda->busquedaProd($_POST["parametro"]);
		break;
	}
?>