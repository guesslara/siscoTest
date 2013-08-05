<?php
    /*
     *Nueva configuracion del controlador del modulo
    */
    $action=$_POST["action"];
    switch($action){
        case "mostrarOpcionesMenu":
            include("modelo2.php");            
            $objMenu=new modeloUsuario();
            $objMenu->mostrarOpcionesMenu();
        break;
        case "guardaRegFuncion":            
	    $txtModulo=$_POST['txtModulo'];
            $txtPer=$_POST['txtPer'];
            $txtMenu=$_POST['txtMenu'];            
            $objModeloUsuarios->guardarFuncion($txtModulo,$txtPer,$txtMenu);
        break;
    }
    
?>