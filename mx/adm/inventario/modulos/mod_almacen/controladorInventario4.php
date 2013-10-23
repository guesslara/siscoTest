<?php
    include("modeloInventario4.php");
    $obj=new inventario();
    //print_r($_POST);
    switch($_POST["action"]){
        case "listarInventario":
            $obj->mostrarInventario($_POST["campos"],$_POST["nombresCampo"],$_POST["campo"],$_POST["valorAFiltrar"],$_POST["idCliente"]);        
        break;
        case "llenarFiltro":
            $obj->llenarFiltros($_POST["campo"]);
        break;
        case "listarClientes":
            $obj->listarClientes();
        break;
    }
?>