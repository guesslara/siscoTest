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
		
	    case "guardaSENC":
			$noParte=clean($_POST['noParte']);
			$SENC=clean($_POST['SENC']);
			$plataF=clean($_POST['plataF']);
			$desSEN=clean($_POST['desSEN']);
			$procSe=clean($_POST['procSe']);
			$objLote->guardaSENC($noParte,$SENC,$plataF,$desSEN,$procSe);
		break;
            case "edittest":
			$objLote->edittest();
		break;
	    case "insertar":
		        $commod=$_POST["comm"];
                        $contax=$_POST["conta"];
		        $objLote->insertar($commod,$contax);
                break;
            case "vercommodity":
		        $objLote->vercommodity();
		break; 
            case "verpruebas":
                        $recup=$_POST["idcomm"];
		        $objLote->verpruebas($recup);
		break;
            case "commoditypruebas":
		        $objLote->commoditypruebas();
		break; 
            case "mostrarpruebas":
                        $recup=$_POST["idcomost"];
		        $objLote->mostrarpruebas($recup);
		break;
            case "eliminar":
                        /*print_r($_POST);
			exit;*/
		        $sellec=$_POST["sell"];
                        $contac=$_POST["conta"];
                        $objLote->eliminar($sellec,$contac);
            break;
            case "commodityfull":
			$objLote->commodityfull();
		break;
	    case "verpruebas2":
                        /*print_r($_POST);
			exit;*/
                        $recup=$_POST["idcommx"];
		        $objLote->verpruebas2($recup);
		break;
            case "insertar2":
		        $commod=$_POST["sell"];
                        $contax=$_POST["conta"];
		        $objLote->insertar2($commod,$contax);
                break;
                                        
	}
?>
