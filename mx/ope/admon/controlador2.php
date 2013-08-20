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
    }
?>