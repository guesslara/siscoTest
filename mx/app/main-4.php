<?php
    session_start();
    //print_r($_SESSION);
    if($_SERVER['HTTP_REFERER']==""){
	header("Location: mod_login/index.php");
	exit;
    }
    //archivocon las varables de configuracion para cada aplicacion
    $archivoConf="../../includes/txtApp".$_SESSION["nombreApp"].".php";
    //inclusion de clases
    include("../../clases/permisosUsuario.php");
    include("../../clases/cargaInicial.php");
    include("../../clases/cargaActualizaciones.php");
    include("../../clases/funcionesGUI.php");
    include($archivoConf);    
    if(!isset($_SESSION[$txtApp['session']['idUsuario']])){	
	echo "<script type='text/javascript'> window.location.href='cerrar_sesion.php'; </script>";
	exit;
    }
    //generacion de instancias de las diferentes clases
    $objFuncionesGUI=new funcionesInterfazPrincipal();
    $objActualizaciones= new verificaActualizaciones();
    $objCargaInicial=new verificaCargaInicial();
    $objPermisos = new permisosUsuario();    
    $numeroActualizaciones=$objFuncionesGUI->buscaActualizacionesNuevas();
    $objActualizaciones->verificaActualizacionesSistema();    
    $objCargaInicial->verificaPassword($_SESSION[$txtApp['session']['cambiarPassUsuario']]);    
    if($_SESSION["nombreApp"]=="Almacen"){//se verifica el cliente seleccionado
	$idCliente=999;
    }else{
	$idCliente=$objCargaInicial->dameIdCliente($txtApp['appSistema']['nombreSistemaActual']);
    }    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link type="text/css" href="../../css/guiPrincipal.css" rel="stylesheet" />
    <link type="text/css" href="../../css/auxLoginApp.css" rel="stylesheet" />
    <link type="text/css" href="../../css/menu/estilosMenu.css" rel="stylesheet" />
    <title><?=$txtApp['login']['tituloAppPrincipal'];?></title>
    <script type="text/javascript" src="../../clases/jquery.js"></script>    
    <script type="text/javascript" src="js/funcionesMain.js"></script>
    <script type="text/javascript">	
	$(document).ready(function (){	    
	    contenedorPrincipal();
	});
	ClosingVar =true
	//window.onbeforeunload = ExitCheck;
	function ExitCheck(){  
		///control de cerrar la ventana///
	 	if(ClosingVar == true){
			ExitCheck = false
			return "<?=$txtApp['mensajeError']['salirApp'];?>";
	  	}
	}	
	setInterval(vMantto,10000);
        setInterval(vActNuevas,10000);
	setInterval(vActSistema,10000);
	//setInterval(vSesion,1500000);
	window.onresize=contenedorPrincipal;
        function contenedorPrincipal(){
            var altoDoc=$("#contenedorAppMain").height();	    
            document.getElementById("contenedorVentanaMDI").style.height=(altoDoc-97)+"px";
        }
	var fullscreenElement = document.fullScreenElement || document.mozFullScreenElement || document.webkitFullScreenElement;
	var fullscreenEnabled = document.fullScreenEnabled || document.mozScreenEnabled || document.webkitScreenEnabled;
	
	// Encuentra el método correcto, llama al elemento correcto
	function launchFullScreen(element) {
	  if(element.requestFullScreen) {
	    element.requestFullScreen();
	  } else if(element.mozRequestFullScreen) {
	    element.mozRequestFullScreen();
	  } else if(element.webkitRequestFullScreen) {
	    element.webkitRequestFullScreen();
	  }
	}

	function cancelFullscreen() {
	  if(document.cancelFullScreen) {
	    document.cancelFullScreen();
	  } else if(document.mozCancelFullScreen) {
	    document.mozCancelFullScreen();
	  } else if(document.webkitCancelFullScreen) {
	    document.webkitCancelFullScreen();
	  }
	}
	
	cancelFullscreen();
	function cambiarModo(){
	    launchFullScreen(document.documentElement);
	}
</script>
</head>
<body>
    <div id="session"></div>
    <div id="cargaPerfil"></div>
    <div id="contenedorAppMain">
        <div id="barraHerramientasUsuario">
            <div class="estiloMensajeModulo"><? echo $txtApp['appPrincipal']['msgModulo'];?> <span style="color: orange;font-weight: bold;">BETA</span></div>            
            <div class="iconoUsuarioAppCerrar"><a href="cerrar_sesion.php?<?=$SID;?>" id="" title="<?=$txtApp['appPrincipal']['cerrarSesion'];?>" ><img src="../../img/shutdown1.png" border="0" width="35" height="36" /></a></div>
            <div class="iconoUsuarioApp">&nbsp;</div>
            <div class="datosUsuarioAppPrincipal" onclick="mostrarPerfilUsuario()" title="Ver Perfil del Usuario"><?=$_SESSION[$txtApp['session']['nombreUsuario']]." ".$_SESSION[$txtApp['session']['apellidoUsuario']];?></div>
        </div>
        <div id="menu" class="barraMenu" style="z-index: 50;height: 25px;">
<?          $objPermisos->construyeMenuNuevo2($_SESSION[$txtApp['session']['idUsuario']],$idCliente);?>
	    <div class="estiloImgBuscador" title="Mostrar Buscador" onclick="mostrarBuscadorEquipos()">
		<img src="../../img/search-icon.png" border="0">
	    </div>
        </div>
	
	<!--Adpatacion de la capa del buscador-->	
	<div id="buscadorEquiposUI" style="display: block;">
	    <div id="estiloDivBusqueda">
		<span class="estiloTituloBuscar">Buscar:</span>
		<input type="text" name="txtBusquedaPrincipal" id="txtBusquedaPrincipal" onkeypress="verificaTeclaImeiBusquedaPrincipal(event)">
		<!--<input type="radio" id="filtroImei" name="filtroBusqueda" value="id" checked="checked" ><label for="filtroImei">Id</label>-->
		<input type="radio" id="filtroSerie" name="filtroBusqueda" value="noParte" checked="checked"><label for="filtroSerie">No Parte</label>
		<div id="estiloBtnCerrarDiv"><a href="#" onclick="cerrarBusquedaPrincipal()"><img src="../../img/close-icon.png"></a></div>
	    </div>	    
	    <div id="divResultadosBusquedaPrincipal"></div>
	</div>	
	<!--fin adaptacion del buscador-->
        
	<div id="contenedorVentanaMDI">
            <iframe id="contenedorVentana" name="contenedorVentana" class="contenedorVentanaMDIApp"></iframe>
        </div>
        <div id="barraestado2">
	    <div onclick="cambiarModo()" class="estiloPantallaCompleta"><div class="estiloDivIzqPCompleta"><img src="../../img/ampliar.jpg" border="0" width="32" height="25"></div><div class="estiloDivDerPCompleta">Pantalla Completa</div></div>
            <div id="contenedorBug">
		<div id="id" class="estiloDivContenedor">
			<a href="#" onclick="abrirFormBug()" title="<?=$txtApp['appPrincipal']['msgReportarError'];?>" style="color:blue;text-decoration: none;"><?=$txtApp['appPrincipal']['msgReportarError'];?></a>
		</div>
		<div id="frmContenedorBug"><div id="divFormularioBug"></div></div>
            </div>
            <div id="listadoActualizacionesApp"><a href="mod_controlCambios/index.php" target="_blank" style="color: blue;text-decoration: none;"><?=$txtApp['appPrincipal']['msgActualizaciones'];?> <strong><span id="numeroActualizacionesActuales" class="estiloTextoActualizaciones"><?=$numeroActualizaciones;?></span></a></strong></div>
            <div id="cargadorApp" class="estiloCargadorApp"><?=$txtApp['appPrincipal']['msgBarraCarga'];?></div>
        </div>
	<div id="verificaMantto"></div>
    </div>
    <!--<div style="position: absolute;width: 180px;height: 300px;border: 1px solid #CCC;background: #e1e1e1;top: 75px;right: 10px;">
	<div style="height: 20px;padding: 3px;border: 1px solid #ccc;background: #ccc;text-align: center;font-weight: bold;font-size: 12px;">Informaci&oacute;n</div>
	<div id="divActSistema" style="border: 1px solid #ccc;background: #fff;width: 99%;height: 270px;overflow-y: auto;">&nbsp;</div>
    </div>-->
</body>
</html>