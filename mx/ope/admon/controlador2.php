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
            $txtPer=$_POST['txtPer'];
            $txtMenu=$_POST['txtMenu'];
	    $idCliente=$_POST["idCliente"];
            $objMenu->guardarFuncion($txtModulo,$txtPer,$txtMenu,$idCliente);
        break;	
    }
    
?>