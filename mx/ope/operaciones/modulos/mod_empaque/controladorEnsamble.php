<?
	/*
	 *controladorEnsamble:contiene la instancia de la clase y las variables para cada una de las funciones de las clases
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	
	function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
	}
	switch($_POST['action']){
		/***************************Lote******************************/
		case "mostrarLotes":
			$opt=clean($_POST['opt']);
			$id_usuario=clean($_POST['idUsuario']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$objLote->mostrarLotesProyecto($opt,$id_usuario,$idProyecto);
		break;
		case "consultaDetalleLote":
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$noItem=clean($_POST['item']);
			$opt=clean($_POST['opt']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->consultaDetalleLote($id_lote,$id_proyecto,$noItem,$opt,$idUsuario);
		break;
	}