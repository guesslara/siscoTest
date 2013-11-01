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
//print_r($_POST);
$idL=$_POST['idLote'];
include("../../mod_formatos/nuevo$idL.php");	
$conT="SELECT * FROM CAT_tipoReparacion";
$exeConT=mysql_query($conT,conectarBd());
?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css">
<div id="cont" style="height:100%;width:100%">
	<div id="arriba" style="width:100%; margin-top:10px; height:200px;">
		<table class="cf1">
			<tr class="tituloCF1">
				<th style="width:40px;">A</th>
				<th style="width:40px;">&nbsp;&nbsp;</th>
				<th class="med">B</th>	
				<th class="med">C</th>
				<th class="med">D</th>
				<th class="med">E</th>	
				<th class="med">F</th>
				<th class="med">G</th>
				<th class="anc" rowspan=2>OBSERVACIONES</th>	
			</tr>
			<tr class="tituloCF1">
				<th>REPARACION</th>
				<th>FALLA REPORT</th>
				<th>FALLA ENCONTRADA</th>	
				<th>ROOT CAUSE</th>
				<th>CODIGO REPARACION</th>
				<th>CODIGO IRR/WK</th>	
				<th>TIEMPO REPARACION</th>
				<th>PARTES CAMBIADAS</th>
			</tr>
			<tr>
				<td>AO </td>
				<td>&nbsp;</td>
				<td>202</td>
				<td>BDCOAT</td>
				<td>SOLDER</td>
				<td>--</td>
				<td>2H</td>
				<td>--</td>
				<td>--</td>
			</tr>   
			<tr>
				<td>CO</td>
				<td>&nbsp;</td>
				<td>201</td>
				<td>CPF</td>
				<td>RPLNEW</td>
				<td>--</td>
				<td>2H</td>
				<td>IQMTMR****</td>
				<td>--</td>
			</tr> 
			<tr>
				<td>NT</td>
				<td>&nbsp;</td>
				<td>101</td>
				<td>NFF</td>
				<td>NOAC</td>
				<td>--</td>
				<td>72H</td>
				<td>--</td>
				<td>S/FALLA</td>
			</tr>   
			<tr>
				<td>WK</td>
				<td>&nbsp;</td>
				<td>208</td>
				<td>VERLIN</td>
				<td>NOAC</td>
				<td>0032</td>
				<td>.2</td>
				<td>--</td>
				<td>LINEA/PIXEL/CORTO/MANCHA</td>
			</tr>  
			<tr>
				<td>WK</td>
				<td>&nbsp;</td>
				<td>106</td>
				<td>DAMAGO</td>
				<td>NOAC</td>
				<td>0006</td>
				<td>.2</td>
				<td>--</td>
				<td>ROTO/RAYADO</td>
			</tr> 
		</table>

	</div>	
	<div>
		
	</div>

</div>