<?php
	include("../../../../../includes/config.inc.php");
	$link=@mysql_connect($host,$usuario,$pass) or die("No se pudo conectar al servidor.<br>");	
//	$sql_inv="iqe_lex_inv_2010";	// DB INVENTARIO.
	$sql_inv=$db;	// DB INVENTARIO.
//	$sql_ing="iqe_lex_ing_2010";	// DB INGENIERIA.
	$sql_ing="--";	// DB INGENIERIA.	
	
	$sql_iqe_inv="--";	// DB DEL SISTEMA DE INVENTARIOS IQ. 
	$dbcompras="--";	// DB DEL SISTEMA DE COMPRAS IQ. 
	$ialm=1;
	$calm0="a_1_Producto_Recibido";
	$cexi0="exist_$ialm";
	$ctra0="trans_$ialm";
	
	$id_almacen_ingenieria=2;
	$nombre_almacen_ingenieria="a_2_ingenieria";
	
	if(!$link){
		echo "Error al conectar con la Base de Datos";
		exit;
	}else{
		mysql_select_db($sql_inv);
	}
?>