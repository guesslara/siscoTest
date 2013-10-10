<?php
    include("modeloInventario4.php");
    $obj=new inventario();
    //print_r($_POST);
    switch($_POST["action"]){
        case "listarInventario":
            $obj->mostrarInventario($_POST["campos"]);        
        break;
        case "colocarCabeceras":
            $obj->llenarFiltros($_POST["campos"]);
        break;
        case "llenarFiltro":
            $obj->llenarFiltros($_POST["campo"]);
        break;
    }
?>