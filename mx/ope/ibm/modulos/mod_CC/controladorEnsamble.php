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
                $idParte=clean($_POST['idParte']);
                $objLote->muestraInfo($idParte,$idProyecto,$idUserCC);
	    break;
	    case "prueba1":
		$idProyecto=clean($_POST['idProyecto']);
                $idUserCC=$_POST['idUserCC'];
                $idParte=$_POST['idParte'];
		$idGrupo=$_POST['idGrupo'];
                $objLote->prueba1($idParte,$idProyecto,$idUserCC,$idGrupo);
	    break;
	    case "guardaDatos":
		$idProyecto=$_POST['idProyecto'];
                $idUserCC=$_POST['idUserCC'];
                $idParte=$_POST['idParte'];
		$cosmetica=$_POST['cosmetica'];
		$limpieza=$_POST['limpieza'];
		$piezasFaltantes=$_POST['piezasFaltantes'];
		$partesSueltas=$_POST['partesSueltas'];
		$pantallaFisica=$_POST['pantallaFisica'];
		$enciende=$_POST['enciende'];
		$serial=$_POST['serial'];
		$saHDMI=$_POST['saHDMI'];
		$saDVI=$_POST['saDVI'];
		$bocinas=$_POST['bocinas'];
		$pruebaFunc=$_POST['pruebaFunc'];
		$inspID=$_POST['inspID'];
		$statusCC=$_POST['statusCC'];
		$date=$_POST['date'];
		$hr=$_POST['hr'];
		$min=$_POST['min'];
		$idLote=$_POST['idLote'];
		$obserCC=$_POST['obserCC'];
		$objLote->guardarDatos($idProyecto,$idUserCC,$idParte,$idLote,$cosmetica,$limpieza,$piezasFaltantes,$partesSueltas,$pantallaFisica,$enciende,
		$serial,$saHDMI,$saDVI,$bocinas,$pruebaFunc,$inspID,$statusCC,$date,$hr,$min,$obserCC);
	    break;
	    case "muestraReporte":
                $idProyecto=$_POST['idProyecto'];
                $idUserCC=$_POST['idUserCC'];
                $idParte=$_POST['idParte'];
                $objLote->muestraReporte($idParte,$idProyecto,$idUserCC);
            break;
					
	}
?>