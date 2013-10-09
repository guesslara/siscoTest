<?php
    //generacion del listado del inventario
    //se incluyen las clases
    include("../../../../../clases/claseGrid3.php");
    include("../../../../../includes/config.inc.php");
    
    $grid= new grid3($host,$usuario,$pass,$db);
    
    /*Lista de Parametros*/
    $registrosAMostrar=25;
    //nombres de las columnas del Grid
    $camposTitulo=array("Id","No Parte","Familia","Subfamilia","Descripcion","Linea","Ctrl Alm.");
    //los campos de la tabla
    $campos=" id,noParte,familia,subfamilia,descripgral,linea,control_alm";    
    $campoOrden="id";//campo por el que se van a ordenar
    $condiciones="";    
    $from=" FROM catprod";
    $param="";    
    $tituloReporte="Listado de Productos ";
    $fechaInicial="";
    $fechaTermino="";
    $tipoOrden=" ASC ";
    if(empty($_REQUEST["pagina"])){
        $pagina=0;
    }else{
        $pagina=$_REQUEST["pagina"];
    }	    
    /*Fin de los parametros*/
    $grid->mostrarListado($camposTitulo,$fechaInicial,$fechaTermino,$campos,$campoOrden,$tipoOrden,$condiciones,$registrosAMostrar,$from,$where,$tituloReporte,$pagina,$param);	
?>