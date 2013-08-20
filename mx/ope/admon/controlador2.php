<?php
    /*
     *Nueva configuracion del controlador del modulo
    */
    include("modelo2.php");            
    $objMenu=new modeloUsuario();
    $action=$_POST["action"];
    switch($action){
        case "mostrarOpcionesMenu":      
            $objMenu->mostrarOpcionesMenu();
        break;
        case "guardaRegFuncion":            
	    $txtModulo=$_POST['txtModulo'];            
            $txtMenu=$_POST['txtMenu'];
	    $idCliente=$_POST["idCliente"];	    
            $objMenu->guardarFuncion($txtModulo,$txtMenu,$idCliente);
        break;
	case "mostrarMenu":
	    $objMenu->mostrarOpcionesMenu($_POST["idCliente"]);
	break;
	case "modificarMenuTitulo":
	    //print_r($_POST);
	    $objMenu->modificaMenuTitulo($_POST["idMenuTitulo"],$_POST["idCliente"]);
	break;
	case "guardarModificarMenuTitulo":
	    $objMenu->guardarModificacionMenuTitulo($_POST["nombreMenuTitulo"],$_POST["numeroMenuAct"],$_POST["idElementoAct"],$_POST["idCliente"]);
	break;
	case "eliminaMenu":
	    $objMenu->eliminaMenu($_POST["idMenu"],$_POST["idCliente"]);
	break;
	case "agregarItemSubMenu":
	    $objMenu->agregarItemSubmenu($_POST["idElemento"],$_POST["idCliente"]);
	break;
	case "guardarSubMenu":
	    $idElemento=$_POST["idElemento"];
	    $txtNombreSubMenu=$_POST["txtNombreSubMenu"];
	    $txtRuta=$_POST["txtRuta"];
	    $cboStatusSubmenu=$_POST["cboStatusSubmenu"];
	    $idCliente=$_POST["idCliente"];
	    $objMenu->guardarSubmenu($idElemento,$txtNombreSubMenu,$txtRuta,$cboStatusSubmenu,$idCliente);
	break;
	case "listarModulos":
	    $objMenu->listarModulos($_POST["idCliente"]);
	break;
	case "modificarSubMenu":
	    $objMenu->modificarSubmenu($_POST["id"],$_POST["idCliente"]);
	break;
	case "guardarSubMenuAct":
	    $idElementoAct=$_POST["idElementoAct"];
	    $txtNombreSubMenuAct=$_POST["txtNombreSubMenuAct"];
	    $txtRutaAct=$_POST["txtRutaAct"];
	    $cboStatusSubmenuAct=$_POST["cboStatusSubmenuAct"];
	    $idCliente=$_POST["idCliente"];
	    $objMenu->guardarSubmenuAct($idElementoAct,$txtNombreSubMenuAct,$txtRutaAct,$cboStatusSubmenuAct,$idCliente);
	break;
	case "eliminaSubMenu":
	    $objMenu->eliminaSubMenu($_POST["idSubMenu"],$_POST["idCliente"]);
	break;
    }
?>