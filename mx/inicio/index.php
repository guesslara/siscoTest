<?
	session_start();
	//print_r($_SESSION);
	include("../../includes/txtApp.php");
	/*if($_SERVER['HTTP_REFERER']==""){
		header("Location: mod_login/index.php");
		exit;
	}*/
	/*if(!isset($_SESSION[$txtApp['session']['idUsuario']])){
		echo "<script type='text/javascript'> alert('Su sesion ha terminado por inactividad'); window.location.href='../mod_login/index.php'; </script>";
		exit;
	}*/
	
	$proceso="";	
	
	/* Realizamos la consulta SQL */
	$sql="select * from cat_clientes order by id_cliente";
	$result=mysql_query($sql,conectarBd());
	$nuevo=mysql_num_rows($result);	
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
<script type="text/javascript" src="../../../clases/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  

<script type="text/javascript">
	$(document).ready(function(){
		redimensionar();		
	});	
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;
		$("#detalleEmpaque").css("height",altoCuerpo+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#detalleEmpaque").css("width",(anchoDiv-280)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",altoCuerpo+"px");
	}	
	window.onresize=redimensionar;	
</script>
<!--<div id="cargadorEmpaque" class="cargadorEmpaque">Cargando...</div>-->
<input type="hidden" name="txtProcesoEmpaque" id="txtProcesoEmpaque" value="<?=$proceso;?>" />
<input type="hidden" name="txtIdUsuarioEmpaque" id="txtIdUsuarioEmpaque" value="<?=$_SESSION['id_usuario_nx'];?>" />
<div style="position: absolute;z-index: 99999;height: 25px;padding: 15px;background: #000;color: #fff;width: 100%;">
	<div style="float: left;margin-right: 25px;color: #FFF;font-size: 12px;font-weight: bold;">Bienvenid@, seleccione el modulo al cual desea entrar:</div>
</div>
<div style="position: absolute;z-index: 99999;bottom: 0;height: 25px;padding: 15px;background: #000;color: #fff;width: 100%;">
	<div style="float: right;margin-right: 25px;margin-top: -10px;color: #FFF;font-size: 12px;font-weight: bold;border: 0px solid #ff0000;width: 77px;"><div style="float: left;margin-top: 10px;">Salir: </div><div><a href="../cerrar_sesion.php?<?=$SID;?>" title="Cerrar App"><img src="../../img/shutdown1.png" width="40" height="40" border="0"></a></div></div>
</div>
<div id="transparenciaGeneral1" class="transparenciaGeneral" style="display:block;">
	<div id="divMensajeCaptura" class="ventanaDialogo">
		<div id="barraTitulo1VentanaDialogoValidacion" class="barraTitulo1VentanaDialogoValidacion">Seleccionar Modulo...</div>
		<form name="proyecto" id="proyecto" action="procesarPeticion.php" method="post">
		<div id="listadoEmpaqueValidacion" style="border:1px solid #CCC; margin:4px; font-size:10px;height:87%; overflow:auto;">			
			<div style="border: 1px solid #e1e1e1;height: 97%;width: 462px;float: left;position: relative;margin: 3px;overflow: auto;">
<?
			if(mysql_num_rows($result)==0){
				die("No hay registros para mostrar");
			}else{
?>
				
				<table width="96%" border="0" cellpadding="0" cellspacing="1" style="margin: 5px;background: #FFF;border: 1px solid #666;font-size: 12px;">										
					<tr>
						<th width="15%" style="border: 1px solid #666;background: #e1e1e1;height: 20px;padding: 3px;text-align: center;"> # </th>
						<th width="81%" style="border: 1px solid #666;background: #e1e1e1;height: 20px;padding: 3px;text-align: left;"> Nombre del proyecto </th>			     						
					</tr>
					<tr>
						<td align="center" style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;"><input type="radio" name="radio" id="radio" value="Almacen"></td>
						<td align="center" style="text-align: left;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;">&nbsp;Almacen</td>
					</tr>
<?
				while($row=mysql_fetch_array($result)){					
?>
					<tr>
						<td align="center" style="height: 15px;padding: 5px;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;"><input type="radio" name="radio" id="radio" value="<?=$row['id_cliente'];?>"></td>
						<td align="center" style="text-align: left;height: 15px;padding: 5px;border-bottom: 1px solid #CCC;">&nbsp;<?=$row['r_social']?></td>
					</tr>
<?
				}
?>
				</table>
<?
			}
?>				
			</div>
			<div style="border: 1px solid #e1e1e1;height: 97%;width: 210px;float: left;position: relative;margin: 3px;">
				<table border=0 align="center" style="margin-top: 10px;">
					<tr>
						<th><input type="submit" name="entra" id="entra" style="height: 50px;width: 120px;" value="Entrar"></th>
					</tr>					
				</table>
			</div>
		</div>
		</form>
	</div>
</div>	