<?
	if($_SERVER['HTTP_REFERER']==""){
		header("Location: ../inicio/");
		exit();
	}else{
		include("funcionesAcceso.php");
		$objFunciones=new funcionesAcceso();
		$objFunciones->noCache();
		$ap=$objFunciones->verificarNombreAp($_GET["ap"]);
		if($ap == ""){		
			$objFunciones->registrarEventosErroneos($_GET["ap"]);
			header("Location: ../inicio/");
			exit();
		}
		$archivoConf="../../includes/txtApp".$ap.".php";		
		if(!file_exists($archivoConf)){
			echo "<script type='text/javascript'> alert('Configuracion Incompleta, consulte al Administrador.'); </script>";		
			header("Location: ../inicio/");
			exit();
		}
		include($archivoConf);
		include("../../clases/about.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../css/auxLogin.css">
<title>Acceso Intranet</title>
<script type="text/javascript" src="../../clases/jquery.js"></script>
<script type="text/javascript" src="js/funcionesLogin.js"></script>
<script> 
	$(document).ready(function(){
		document.getElementById("txtUsuario").focus();
	});
</script>
<style type="text/css">

</style>
</head>

<body>
<div id="contenedor">	
	<div id="mostrarActualizaciones"><a href="../mod_controlCambios/index.php" target="_blank" title="Mostrar Actualizaciones" style="text-decoration:none;color:#000;">Mostrar Actualizaciones</a></div>
    <div id="logIn">
    	<form name="frmAccesoIntranet" id="frmAccesoIntranet" method="post" action="controladorLogin.php">
        <input type="hidden" name="action" id="action" value="datosIniciales" />
        <div id="msgLogIn"><?=$txtApp['login']['tituloAppPrincipal'];?></div>
    	<div id="contenedorLogIn">
        	<div id="imgLogIn"><img src="../../img/Finder.png" width="80" height="80" border="0" /></div>
            <div id="accesoLogIn">
            	<div id="datosLogIn">
                    <div><?=$txtApp['login']['tituloUsuario'];?></div>
                    <div><input type="text" id="txtUsuario" name="txtUsuario" style="width:150px;" /></div>
                    <div><?=$txtApp['login']['tituloPass'];?></div>
                    <div id="divPassword"><input type="password" id="txtPassword" name="txtPassword" style="width:150px;" /></div>
                    <div id="divBoton"><input type="submit" value="<?=$txtApp['login']['btnApp']?>" id="boton" /></div>           
                </div>
            </div>            
        </div>
	<input type="hidden" name="hdnAppNombre" id="hdnAppNombre" value="<?=$ap;?>">
        </form>
    </div>
    
    <div id="pieLogIn">
    	<div id="infoApp"><? if($_GET['error']=="0") echo "Acceso No Autorizado";?></div>
        <div id="infoPieAbout"><a href="#" onclick="about()" style="color:#000;font-weight:bold; text-decoration:none;"><?=$txtApp['login']['tituloAbout'];?></a></div>
    	<div id="infoPieLogIn"><?=$txtApp['login']['pieLogin'];?></div>
    </div>    
</div>
<div id="aboutApp" style="display:none;"></div>
<div id="cargando" style=" display:none;position: absolute; left: 0; top: 0; width: 100%; height: 100%; background:url(../../../../img/desv.png) repeat">
	<div id="msgCargador"><div style="padding:10px;"><img src="../../../../img/cargador.gif" border="0" /></div></div>
</div>
</body>
</html>