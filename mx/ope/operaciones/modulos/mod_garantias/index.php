<?
	/*
	 *Index: es la pagina principal del modulo donde se llaman a las funciones correspondientes para comenzar su uso
	 *Autor: Rocio Manuel Aguilar
	 *Fecha: 20/Nov/2012
	*/
session_start();
	include("../../includes/cabecera.php");
	include("../../includes/txtApp.php");	
	$proceso="";	
	if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}else{
		if($proceso != ""){			
			$sqlProc="SELECT * FROM cat_procesos WHERE descripcion='".$proceso."'";
			$resProc=mysql_query($sqlProc,conectarBd());
			$rowProc=mysql_fetch_array($resProc);
			$proceso=$rowProc['id_proc'];
		}
	}		
	
	function conectarBd(){
		require("../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db($db);
			return $link;
		}				
	}	  
?>

<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js"></script>
<!--se incluyen los recursos para el grid-->
<script type="text/javascript" src="../../recursos/grid/grid.js"></script>
<link rel="stylesheet" type="text/css" href="../../recursos/grid/grid.css" />
<!--fin inclusion grid-->
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-green.css"  title="win2k-cold-1" />
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  
<script type="text/javascript" src="js/calendar.js"></script><!-- librería principal del calendario -->  
<script type="text/javascript" src="js/calendar-es.js"></script><!-- librería para cargar el lenguaje deseado -->   
<script type="text/javascript" src="js/calendar-setup.js"></script><!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript">
	$(document).ready(function(){
		//nuevaPrueba();
		redimensionar();		
	});	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;		
		$("#detalleEmpaque").css("height",altoCuerpo+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#detalleEmpaque").css("width",(anchoDiv-15)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",altoCuerpo+"px");
		
	}

	window.onresize=redimensionar;	
</script>
<?$div="listadoEmpaque";?>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<!--<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />-->
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<META http-equiv="Page-Enter" CONTENT="RevealTrans(Duration=3,Transition=2)">
			<div class="opcionesEnsamble" onclick="clean2();vertabla()" title="Mostrar Pruebas de Commodity">Mostrar</div>	
			<div class="opcionesEnsamble" onclick="clean2();nuevaPrueba()" title="Agregar Pruebas">Agregar</div>						
			<div class="opcionesEnsamble" onclick="clean2();commodityfull()" title="Mostrar Commodity con pruebas">Modificar</div>	

			
		</div>
			<!--<div id="infoEnsamble3">
				
			</div>-->
			<div id="detalleEmpaque" class="ventanaEnsambleContenido" style="font-size:13px; margin: 5px; width: 98%; overflow: auto;"></div>
			<!--<div id="ventanaEnsambleContenido2" class="ventanaEnsambleContenido" style="display:none;"></div>
			<div style="clear:both;"></div>-->
	</div>
</div>
<div id="transparenciaGeneral1" class="transparenciaGeneral" style="display:none;">
	<div id="divMensajeCaptura" class="ventanaDialogo">
		<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('divMensajeCaptura','transparenciaGeneral1')" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
		<div id="listadoEmpaqueValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:89%; overflow:auto;"></div>
	</div>
</div>
<div id="transparenciaOp" class="transparenciaGeneral" style="display:none;">
	<div id="divAgrega" class="ventanaDialogoOp">
		<div id="barraTitulo1Agrega" class="barraTitulo1VentanaDialogoValidacion">Agregar SENC<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('divAgrega','transparenciaOp')" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
		<div id="formaAgrega" style="border:1px solid #CCC; margin:4px; font-size:10px;height:87%; overflow:auto;"></div>
	</div>
</div>
<div id="resultados" class="resultados" style="display:none;">
	<div id="cerrar" onclick="cerrarVentana('resultados')">
		<div id="titulo" style="float: left;width: 80%;height: 20px;text-align: justify;">Da click en el Número de Parte...</div>
		<div id="btnCerrar" style="text-align: right; float: right; width: 15%;height: 20px;"><img src="../../img/cerrar2.png" border="0" /></div>
	</div>
	<div id="msgresultados" class="msgVentanaDialogo1" align="left"><div>
</div>
<div id="ventanaDialogo1" class="ventanaDialogo" style="display:none;">
	<div id="barraTitulo1VentanaDialogo">Opciones...<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('ventanaDialogo1')" title="Cerrar Ventana Dialogo"><img src="../../img/close.gif" border="0" /></a></div></div>
	<div id="msgVentanaDialogo" class="msgVentanaDialogo" style="border: 0px solid #ff0000;height: 89%;overflow: auto;"></div>
	
	<div id="barraBotonesVentanaDialogo" align="center" style="display: none;">
		<input type="button" name="agrega" id="agrega" value="Agrega" onclick="recupera()"><input type="button" name="cerrar" id="cerrar" value="Cerrar" onclick="cerrarVentana('ventanaDialogo1')">
	</div>
</div>
<?
include ("../../includes/pie.php");
?>
