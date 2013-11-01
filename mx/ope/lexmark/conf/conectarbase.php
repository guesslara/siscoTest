<?php
	include("../../../../../includes/config.inc.php");
	$link=@mysql_connect($host,$usuario,$pass) or die("No se pudo conectar al servidor.<br>");
//	$sql_inv="iqe_lex_inv_2010";	// DB INVENTARIO.
	$sql_inv=$db;	// DB INVENTARIO.
//	$sql_ing="iqe_lex_ing_2010";	// DB INGENIERIA.
	$sql_ing="2012_iqe_lex_ing";	// DB INGENIERIA.	
	
	$sql_iqe_inv="2012_iqe_inv";	// DB DEL SISTEMA DE INVENTARIOS IQ. 
	$dbcompras="2012_iqe_com";	// DB DEL SISTEMA DE COMPRAS IQ. 
	$ialm=1;
	$calm0="a_1_Producto_Recibido";
	$cexi0="exist_$ialm";
	$ctra0="trans_$ialm";
	
	$id_almacen_ingenieria=4;
	$nombre_almacen_ingenieria="a_4_ingenieria";
	if(!$link){
		echo "Error de Conexion";
		exit();
	}else{
		mysql_select_db($db);
	}
?>