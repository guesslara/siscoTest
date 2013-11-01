<?
        include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
	}
	switch($_POST['action']){
           
	    case "busquedaxParametro":
		$seleccion=clean($_POST['seleccion']);
		$serieOParte=clean($_POST['serieOParte']);
		$objLote->consultaXParametro($seleccion,$serieOParte);
	    break;
	    case "detallesdyr":
		$idItem=clean($_POST['iditem']);
		$objLote->busdetallesdyr($idItem);
		
	    break;
	    case "detallesCC":
		$idItem=clean($_POST['idItem']);
		$objLote->busCC($idItem);
	    break;
	}
?>