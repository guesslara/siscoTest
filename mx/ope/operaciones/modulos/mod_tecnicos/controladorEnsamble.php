<?
	/*
	 *controlEnsamble: contiene las instancias de la clase de modeloEnsamble para las funciones de la consulta, inserción, agregado y modificacion de datos
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:29/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	function clean($cadclean){
		$cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
		return $cadclean;
	}
	switch($_POST['action']){
		case "mostrarLotes":
			$opt=clean($_POST['opt']);
			$id_usuario=clean($_POST['idUsuario']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$objLote->mostrarLotesProyecto($opt,$id_usuario,$idProyecto);
		break;
		case "consultaDetalleLote":
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$opt=clean($_POST['opt']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->consultaDetalleLote($id_lote,$id_proyecto,$opt,$idUsuario);
		break;
		case "guardaTec":
			$id_tecnico=clean($_POST['valorSeleccionado']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$idItem=clean($_POST['idItem']);
			$idLote=clean($_POST['idLote']);
			$idUsuario=clean($_POST['idUsuario']);
			$opt=clean($_POST['opt']);
			$objLote->guardaTec($id_tecnico,$id_proyecto,$idItem,$idLote,$idUsuario,$opt);
		break;
		case "AB":
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$usuario=clean($_POST['usuario']);
			$objLote->AB($usuario,$id_proyecto);
		break;
		case "Status":
			$status=clean($_POST['valorAsignado']);
			$ID=clean($_POST['ID']);
			$usuario=clean($_POST['usuario']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$objLote->status($status,$ID,$usuario,$id_proyecto);
		break;
	}
?>
