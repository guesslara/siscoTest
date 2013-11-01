<?
	/*
	 *controladorEnsamble:contiene la instancia de la clase y las variables para cada una de las funciones de las clases
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	include("modeloEnsamble.php");
	$objLote=new modeloEnsamble();
	//print_r($_POST);
	header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");
	
	function clean($cadclean){
        $cadclean = mysql_real_escape_string(stripslashes(strip_tags($cadclean)));
        return $cadclean;
	}
	switch($_POST['action']){		
            case "vertabla":
		$objLote->vertabla();
	    break; 
            case "agregaDatos":
                $objLote->nuevoRegistro();
            break;
            case "editarDatos":
                $objLote->editarRegistro($_POST["id"]);
            break;
	    case "actRe":
		$campo_valor=$_POST["campos_valores"];
		$id=$_POST["idd"];
		$objLote->actRe($campo_valor,$id);
	    break;
	
	    case "insertaRe":
		$cam_valo=$_POST["campos_valores"];
		$objLote->insertaRe($cam_valo);
	    break;
	}
?>
