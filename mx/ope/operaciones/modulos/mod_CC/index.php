<?
	/*
	 *Index: es la pagina principal del modulo donde se llaman a las funciones correspondientes para comenzar su uso
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:
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
		muestraLista('<?=$_SESSION[$txtApp['session']['idProyectoSeleccionado']];?>','<?=$_SESSION[$txtApp['session']['idUsuario']];?>');
		redimensionar();		
	});	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;		
		$("#detalleEmpaque").css("height",altoCuerpo+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#detalleEmpaque").css("width",(anchoDiv-400)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",altoCuerpo+"px");
	}	
	window.onresize=redimensionar;	
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />
<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">
		<div id="barraOpcionesEnsamble">
			<!--<div class="opcionesEnsamble" onclick="clean2();diagnostica('<?=$_SESSION[$txtApp['session']['idProyectoSeleccionado']];?>','<?=$_SESSION[$txtApp['session']['idUsuario']];?>','Diagnosticar')" title="Llenar reporte">Reporte</div>-->
			<div class="opcionesEnsamble" onclick="clean2();muestraLista('<?=$_SESSION[$txtApp['session']['idProyectoSeleccionado']];?>','<?=$_SESSION[$txtApp['session']['idUsuario']];?>')" title="General">Inicio</div>
		</div>
			<div id="infoEnsamble3"> 
				<div id="listadoEmpaque2" style="border:1px solid #e1e1e1;background:#fff; height:99%;width:97%;font-size:12px;margin:3px;overflow: auto; display: none">
					<div id="selectListado" style="text-align: center;border:0px solid #e1e1e1; background: #fff; height: 3%; width:97%; font-size: 12px; margin:3px; overflow: :auto; display: none;">	
					</div>
					<div id="consultaListado" style="border:0px solid #e1e1e1; background: #fff; height: 95%; width:97%; font-size: 12px; margin:3px; overflow: :auto; display: none;">
					</div>	
				</div>
				<div id="listadoEmpaque" style="border:1px solid #e1e1e1;background:#fff; height:99%;width:97%;font-size:12px;margin:3px;overflow: auto;">
				</div>
			</div>
			<div id="detalleEmpaque" class="ventanaEnsambleContenido" style="font-size:13px; margin: 3px; overflow: auto;"></div>
			</div>
			<!--<div id="numReparacion" class="nuevaVentana" style="font-size: 20px; margin:3px; display:none;"></div>-->
			<div id="ventanaEnsambleContenido2" class="ventanaEnsambleContenido" style="display:none;"></div>
			<div style="clear:both;"></div>
	</div>
</div>
<div id="transparenciaGeneral1" class="transparenciaGeneral" style="display:none;">
	<div id="divMensajeCaptura" class="ventanaDialogo">
		<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Informaci&oacute;n<div id="btnCerrarVentanaDialogo"><a href="#" onclick="cerrarVentana('divMensajeCaptura')" title="Cerrar Ventana"><img src="../../img/close.gif" border="0" /></a></div></div>
		<div id="listadoEmpaqueValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:93%; overflow:auto;"></div>
	</div>
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

