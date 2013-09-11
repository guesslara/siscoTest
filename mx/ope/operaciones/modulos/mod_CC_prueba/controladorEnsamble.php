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
            case "muestraListado":
		$idProyecto=clean($_POST['idProyecto']);
                $idUserCC=clean($_POST['idUserCC']);
		$objLote->muestraListado($idProyecto,$idUserCC);
            break;
	    case "muestraInfo":
		$idProyecto=clean($_POST['idProyecto']);
                $idUserCC=clean($_POST['idUserCC']);
                $idItem=clean($_POST['idItem']);
		$objLote->muestraInfo($idItem,$idProyecto,$idUserCC);
	    break;
	    case "prueba1":
		$idProyecto=clean($_POST['idProyecto']);
                $idUserCC=clean($_POST['idUserCC']);
                $idItem=clean($_POST['idItem']);
				$idGrupo=clean($_POST['idGrupo']);
                $objLote->prueba1($idItem,$idProyecto,$idUserCC,$idGrupo);
	    break;
	    case "guardaDatos":
		$idUserCC=clean($_POST['idUserCC']);
		$idItem=clean($_POST['idItem']);
		$statusCC=clean($_POST['statusCC']);
		$obserCC=clean($_POST['obserCC']);
		$idsprubsi=clean($_POST['idsprubsi']);
		$idsprubno=clean($_POST['idsprubno']);
		$asegcalidad=clean($_POST['aseg_calidad']);
		$idProyecto=clean($_POST["idProyecto"]);
		$objLote->guardarDatos($idUserCC,$idItem,$statusCC,$obserCC,$asegcalidad,$idsprubsi,$idsprubno,$idProyecto);
	    break;
	    case "muestraReporte":
                $idProyecto=clean($_POST['idProyecto']);
                $idUserCC=clean($_POST['idUserCC']);
                $idItem=clean($_POST['idItem']);
                $objLote->muestraReporte($idItem,$idProyecto,$idUserCC);
            break;
	    case "busquedaxParametro":
		$paraBusqueda=clean($_POST['paraBusqueda']);
		$valor=clean($_POST['valor']);
		$objLote->consultaXParametro($paraBusqueda,$valor);
	    break;				
	}
?>