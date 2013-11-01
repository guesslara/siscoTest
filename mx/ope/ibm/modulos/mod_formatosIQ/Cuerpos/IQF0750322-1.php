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
$idL=$_POST['idLote'];
include("../../mod_formatos/nuevo$idL.php");	
?><input type="hidden" id="idLote" name="idLote" value="<?=$idL;?>"/><?
$paginasT=$_POST['totalpag'];
$intervalo=$_POST['intervalo'];
$pagAct=$_POST['pagAct'];
/*print($pagAct);*/
$pag=21;//pag es el limite de registros
$lim=$intervalo;
$conTiempo="SELECT * FROM CAT_tiempoReparacion";
$exeTiempo=mysql_query($conTiempo,conectarBd());
?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css" />  
<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<div id="tiempos" style="width:100%;height:auto;background:#fff;margin-top:30px;">
	<script>
			$("#paginador").show();
			/*$("#PAct").html("<?=$pagAct+1;?>");*/
			$("#TotPa").html("<?=$paginasT;?>")
		</script>
	<table class="tiempo" align="center">
		<tr style="background: #F0F0F0;	height: 35px;text-align: center;">
			<th colspan=2>TIEMPO DE REPARAC&Oacute;N</th>
		</tr>
		<tr>
			<th >TIEMPO</th>
			<th >SIGNIFICADO</th>
		</tr>
<?
		while($rowTiempo=mysql_fetch_array($exeTiempo)){
?>
			<tr>
				<td><?=$rowTiempo['tiempo']?></td>
				<td><?=strtoupper($rowTiempo['significado'])?></td>
			</tr>
<?
		}
?>
	</table>
</div>