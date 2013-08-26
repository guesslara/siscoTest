<?php
	/*
	Verificacion del usuario en la base de datos metodos a llamar en GUI
	Fecha de creacion:10 - Junio - 2010
	Autor: Gerardo Lara
	*/
	include("modeloLogin.php");
	include("../../clases/about.php");
	$objLogin=new modeloLogin();

	//se llama al modelo
	if($_POST['action']=="datosIniciales"){
		$usuarioEntrante=$_POST['txtUsuario'];
		$passEntrante=$_POST['txtPassword'];
		$appNombre=$_POST['hdnAppNombre'];
		if($usuarioEntrante=="" || $passEntrante=="" || $appNombre==""){
			header("Location: index.php?error=0");
			exit;
		}else{
			$objLogin->verificaInfo($usuarioEntrante,$passEntrante,$appNombre);
		}
	}
	if($_GET['action']=="about"){
		$objAbout=new aboutCompras();
		$objAbout->about();
	}
?>