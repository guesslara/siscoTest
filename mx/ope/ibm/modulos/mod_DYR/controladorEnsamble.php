<?
	/*
	 *controlEnsamble: instancia de la clase que se creo en modeloEnsamble del modulo mod_DYR
	  donde tiene como objetivo enlazar cada una de las instancias con sus funciones
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
	}
	switch($_POST['action']){
		case "diagnostica":
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$idUser=clean($_POST['idUser']);
			$opt=clean($_POST['opt']);
			$objLote->diagnostica($idProyecto,$idUser,$opt);
		break;
		case "formDia":
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$idUser=clean($_POST['idUser']);
			$idItem=clean($_POST['idItem']);
			$decide=clean($_POST['decide']);
			$objLote->formDia($idProyecto,$idUser,$idItem,$decide);
		break;
		case "guardaDia":
			$idItem=clean($_POST['idItem']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$idUser=clean($_POST['idUser']);
			$idFabricante=$_POST['idFabricante'];
			$observacionesDia=clean($_POST['observacionesDia']);
			$status=clean($_POST['status']);
			$idTipoRep=clean($_POST['idTipoRep']);
			$cadena=clean($_POST['cad']);
			$tipoEnt=clean($_POST['tipoEnt']);
			$objLote->guarDia($idItem,$idProyecto,$idUser,$idFabricante,$observacionesDia,$status,$idLote,$idTipoRep,$cadena,$tipoEnt);
		break;
		case "muestraSel":
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$idUser=clean($_POST['idUser']);
			$opt=clean($_POST['opt']);
			$objLote->muestraSel($idProyecto,$idUser);
		break;
		case "sendCC":
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$idUser=clean($_POST['idUser']);
			$idItem=clean($_POST['idItem']);
			$objLote->sendCC($idProyecto,$idUser,$idItem);
		break;
		case "consultaDia":
			$idItem=clean($_POST['idItem']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$idUser=clean($_POST['idUser']);
			$objLote->consultaDia($idItem,$idProyecto,$idUser);
		break;
		case "muestraConsultasChk":
			$idItem=clean($_POST['idItem']);
			$idProyecto=clean($_POST['idProyectoSeleccionado']);
			$tbl=clean($_POST['tbl']);
			$objLote->muestraConsultasChk($idItem,$idProyecto,$tbl);
		break;
	}
?>