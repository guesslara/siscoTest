<?php
	session_start();
	include("../../../../../includes/txtAppAlmacen.php");	
	unset($txtApp['session']['name']);	
	unset($txtApp['session']['nivelUsuario']);
	unset($txtApp['session']['loginUsuario']);
	unset($txtApp['session']['passwordUsuario']);
	unset($txtApp['session']['idUsuario']);
	unset($txtApp['session']['nombreUsuario']);
	unset($txtApp['session']['apellidoUsuario']);
	unset($txtApp['session']['origenSistemaUsuario']);
	unset($txtApp['session']['origenSistemaUsuarioNombre']);
	unset($txtApp['session']['cambiarPassUsuario']);
	unset($txtApp['session']['sexoUsuario']);
	unset($txtApp['session']['nominaUsuario']);
	session_destroy();
	//header("Location:mod_login/index.php");
	header("Location: ../inicio/index.php");
	exit;
?>