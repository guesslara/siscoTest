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
		case "formLotes":
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$idUsuario=clean($_POST['idUsuario']);
			$idMov=clean($_POST['idMov']);
			$objLote->formLotes($id_proyecto,$idUsuario,$idMov);
		break;
		case "addLote":
			$noPO=clean($_POST['noPO']);
            $fechaPO=clean($_POST['fechaPO']);
			$noItem=clean($_POST['noItem']);
			$diasTAT=clean($_POST['diasTAT']);
			$observaciones=clean($_POST['observaciones']);
			$id_proyecto=clean($_POST['id_proyecto']);
			$idUsuario=clean($_POST['idUsuario']);
			$idMov=clean($_POST['idMov']);
			$objLote->agregarLote($noPO,$fechaPO,$noItem,$diasTAT,$observaciones,$idUsuario,$id_proyecto,$idMov);
		break;
		case "formModificaLote":
			$idLote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$id_usuario=clean($_POST['id_usuario']);
			$objLote->formModificaLote($idLote,$id_proyecto,$id_usuario);
		break;
		case "modificaLote":
			$noPO=clean($_POST['noPO']);
                        $fechaPo=clean($_POST['fechaPo']);
			$noItem=clean($_POST['noItem']);
			$fechaReg=clean($_POST['fechaReg']);
			$horaReg=clean($_POST['horaReg']);
			$diasTAT=clean($_POST['diasTAT']);
			$observaciones=clean($_POST['observaciones']);
			$idLote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$id_usuario=clean($_POST['id_usuario']);
			$objLote->modificaLote($noPO,$fechaPo,$noItem,$fechaReg,$horaReg,$diasTAT,$observaciones,$idLote,$id_proyecto,$id_usuario);
		break;
		case "eliminaLote":
			$idLote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$id_usuario=clean($_POST['id_usuario']);
			$objLote->eliminaLote($idLote,$id_proyecto,$id_usuario);
		break;
	/********************************Detalle Lote***********************************/
		/*funcion para la busqueda del no Parte*/
		case "FindSEC":
			$likeNoParte=clean($_POST['likeNoParte']);
			$enter=clean($_POST['enter']);
			$objLote->FindSEC($likeNoParte,$enter);
		break;
		/*Fin de la busqueda del noParte*/
		case "consultaDetalleLote":
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$noItem=clean($_POST['item']);
			$opt=clean($_POST['opt']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->consultaDetalleLote($id_lote,$id_proyecto,$noItem,$opt,$idUsuario);
		break;
	
		case "formAgrega":
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$noItem=clean($_POST['noItem']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->formAgrega($id_lote,$id_proyecto,$noItem,$idUsuario);
		break;
		case "addDetalleLote":
			$id_modelo=clean($_POST['modelo']);
			$codeType=clean($_POST['codeType']);
			$flowTag=clean($_POST['flowTag']);
			$numSerie=clean($_POST['numSerie']);
			$desc=clean($_POST['desc']);
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$noItem=clean($_POST['item']);
			$idSENC=clean($_POST['idSENC']);
			$idTipoComodity=clean($_POST['idTipoComodity']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->agregar($id_modelo,$codeType,$flowTag,$numSerie,$desc,$id_lote,$id_proyecto,$noItem,$idSENC,$idTipoComodity,$idUsuario);
		break;
		case "formModifica":
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$idItem=clean($_POST['idItem']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->formModifica($id_lote,$id_proyecto,$idItem,$idUsuario);
		break;
		case "modifica":
			$modelo=clean($_POST['modelo']);
			$codeType=clean($_POST['codeType']);
			$flowTag=clean($_POST['flowTag']);
			$numSerie=clean($_POST['numSerie']);
			$fechaReg=clean($_POST['fechReg']);
			$horaReg=clean($_POST['horaReg']);
			$desc=clean($_POST['desc']);
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$idItem=clean($_POST['idItem']);
			$idTipoComodity=clean($_POST['idTipoComodity']);
			$idUsuario=clean($_POST['idUsuario']);
            $idSENC=clean($_POST['idSENC']);
			$objLote->modifica($modelo,$codeType,$flowTag,$numSerie,$fechaReg,$horaReg,$desc,$id_lote,$id_proyecto,$idItem,$idTipoComodity,$idUsuario,$idSENC);
		break;
		case "exportar":
			$id_lote=clean($_POST['idLote']);
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$noItem=clean($_POST['item']);
			$idUsuario=clean($_POST['idUsuario']);
			$idMov=clean($_POST["idMov"]);
?>
			<script type="text/javascript">
				window.location.href="archivo.php?idLote=<?=$id_lote?>&idProyecto=<?=$id_proyecto?>&noItem=<?=$noItem?>&idUsuario=<?=$idUsuario?>&idMov=<?=$idMov?>";
			</script>
<?
		break;

		case "formSENC":
			$noParte=clean($_POST['noParte']);
			$objLote->formSENC($noParte);
		break;
		case "guardaSENC":
			$noParte=clean($_POST['noParte']);
			$SENC=clean($_POST['SENC']);
			$plataF=clean($_POST['plataF']);
			$desSEN=clean($_POST['desSEN']);
			$procSe=clean($_POST['procSe']);
			$objLote->guardaSENC($noParte,$SENC,$plataF,$desSEN,$procSe);
		break;
		case "listaMov":
			$id_proyecto=clean($_POST['idProyectoSeleccionado']);
			$idUsuario=clean($_POST['idUsuario']);
			$objLote->listaMov($id_proyecto,$idUsuario);
		break;
		case "muestraDetalles":
			$idItem=clean($_POST["idItem"]);
			$objLote->muestraDetalles($idItem);
		break;

	}
?>
