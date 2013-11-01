<?
function conectarBd(){
	require("../../../includes/config.inc.php");
	$link=mysql_connect($host,$usuario,$pass);
	if($link==false){
		echo "Error en la conexion a la base de datos";
	}else{
		mysql_select_db($db);
		return $link;
	}				
}
/*print_r($_POST);*/
$idL=$_POST['idLote'];
include("../../mod_formatos/nuevo$idL.php");
?>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
	<link rel="stylesheet" type="text/css" media="all" href="../js/calendar-green.css"  title="win2k-cold-1" />
        <script type="text/javascript" src="../js/calendar.js"></script><!-- librería principal del calendario -->  
        <script type="text/javascript" src="../js/calendar-es.js"></script><!-- librería para cargar el lenguaje deseado -->   
        <script type="text/javascript" src="../js/calendar-setup.js"></script><!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
	<script type="text/javascript" src="../js/funcionesEnsamble.js" ></script>
	<script type="text/javascript" src="../../../clases/jquery-1.3.2.min.js"></script>
      	</script>	
		<form id="formdaños" enctype="multipart/form-data">
	<div id="uno" style="width:100%; height:100%">

		<table border = "" cellpading "0" cellspacing = "0" style=" margin: 8px 50px 10px 30px;">
			
		<tr>		
		   <td style="font-size: 9pt;"><b>FECHA:</b></td>
		   <td><input type ="text" name = "fecha" id = "fecha" size="50" style="width:200px;height:25px;"/>
		   <input type="button" id="date"  value="..." />
		<!-- script que define y configura el calendario-->
		<script type="text/javascript">
		    Calendar.setup({
		    inputField     :    "fecha",      // id del campo de texto
		    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
		    button         :    "date"   // el id del botón que lanzará el calendario
		    });
		</script>
		  </td>
		 </tr>
		</table>
		
	        <table border = "" cellpading "0" cellspacing = "0" style=" margin: 5px 50px 10px 30px;">
		<tr>
		   <td style="font-size: 8pt;"><b>DIRIGIDO A:</b> </td>
		   <td><input type ="text" name = "nombre" id = "nombre" size="50" maxlenght="50" style="width:382px;height:25px;"/></td>
		 </tr>
		</table>
		<table border = "" cellpading "0" cellspacing = "0"  style=" margin: 5px 50px 10px 30px;">
		<tr>
		   <td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>INTRODUCCI&Oacute;N:</b></td>
		</tr>
		<tr>
		   <td><input type ="text" name = "intro" id = "intro" size="80" style="width:630px;height:70px;"/></td>
		 </tr>
		</table>
		 <table border = "" cellpading "0" cellspacing = "0" style=" margin: 5px 50px 10px 30px;">
		 <tr>
		   <td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>CONTENIDO/PRODUCTOS Y/O N&Uacute;MEROS DE PARTE OBJETO DEL INFORME</b></td>
		</tr>
		 <tr>
		   <td><input type ="text" name = "numpart" id = "numpart" size="80" style="width:630px;height:70px;"/></td>
		 </tr>
                </table>
		<table border = "" cellpading = "0" cellspacing = "0" style=" margin: 5px 50px 10px 30px; width:639px;">
		 <tr>
		<td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>FOTOGRAF&Iacute;AS O GR&Aacute;FICOS</b> (SI APLICA)<br>
		   <input type ="file"  multiple="multiple" name = "uploadedfile" id = "uploadedfile" title="Elige un archivo para subir."/></td>                   
		</tr>
		</table>
		<table border = "" cellpading ="0" cellspacing = "0" style=" margin: 5px 50px 10px 30px;"><br><br><br><br><br><br>
		<!--<div id="foto_b_1" style="background-color:#EFFBFB; width:386px;height:170px;"></div>-->
		<tr>
		   <td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>COMENTARIOS:</b></td><br>
		</tr>
		<tr>
		   <td><input type ="text" name = "coment" id = "coment" size="80" style="width:630px;height:70px;"/></td>
		 </tr>
		<table border = "" cellpading "0" cellspacing = "0" style="margin: 5px 5px 5px 300px;">
		<tr>
		   <td colspan="2" align="center" style="background-color:#F3F781; font-size: 8pt; margin: 8px 50px 10px 0px;"><b>ELABOR&Oacute;:</b>
		   <input type="button" value="GUARDAR"  onclick="valida()" on style="font-size: 7pt;"/></td>
		</tr>
		<tr>
		<td><input type ="text" name = "firma" id = "firma" align="center" size="20"  style="width:150px;height:50px;"/></td>
		</tr>
		</table
<?
                $nombre=$nomFormato."-1";
?>
		<input  type="button" name="" id="" onclick="formatoPDF('<?=$nombre?>')"/>
	</div>
		</form>
		
		

