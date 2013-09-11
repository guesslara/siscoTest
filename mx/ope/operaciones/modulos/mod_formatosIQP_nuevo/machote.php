<?
	include("../../includes/cabecera.php");

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
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-green.css"  title="win2k-cold-1" />
<link rel="stylesheet" type="text/css" media="all" href="css/hoja.css" />  
<script type="text/javascript" src="js/calendar.js"></script><!-- librería principal del calendario -->  
<script type="text/javascript" src="js/calendar-es.js"></script><!-- librería para cargar el lenguaje deseado -->   
<script type="text/javascript" src="js/calendar-setup.js"></script><!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript">
	function redimensionar(){
		var altoDiv=$("#pag").height();
		var anchoDiv=$("#pag").width();
		
		alert(anchoDiv);
				
		$("#detalleEmpaque").css("height",altoCuerpo+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#detalleEmpaque").css("width",(anchoDiv-400)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",altoCuerpo+"px");
	}	
	window.onresize=redimensionar;	
</script>
<?$div="listadoEmpaque";
include("../mod_esqueleto/nuevo.php");
$divNom=explode("_",$nombre);
if($divNom[3]=="|"){
	$w="21.5cm";
	$h="27.9cm";
	$hc=27.9-6;
}else if($divNom[3]=="-"){
	$w="27.9cm";
	$h="21.5cm";
	$hc=21.5-6;
}
?>
<div id="pag">
	<div id="paginador" style="height: 50px; width: 100%; background: #f0f0f0;"></div>
		<div id="hoja1" style="width:<?=$w;?>;height:<?=$h?>;">
			<div id="headerHoja1">

			</div>
			<div id="contenidoHoja1" style="height:<?=$hc;?>cm;" >
	
			</div>
			<div id="footHoja1">
				
			</div>
		</div>
</div>


<?
include ("../../includes/pie.php");
?>
