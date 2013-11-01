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
?>
<input type="hidden" id="idLote" name="idLote" value="<?=$idL;?>"/>
<link rel="stylesheet" type="text/css" href="../css/estilos.css">
<?
$paginasT=$_POST['totalpag'];
$intervalo=$_POST['intervalo'];
$pagAct=$_POST['pagAct'];
$pag=16;//pag es el limite de registros
$lim=$pag+$intervalo;
if($intervalo==0){
	?><script>
		$("#ant").hide();
	</script><?
}
if($paginasT==$pagAct){
	?><script>
		$("#sig").hide();
	</script><?
}
if($paginasT==0 && $intervalo==0){
	$CON="SELECT * FROM CAT_refacciones";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	if($noReg>$pag){
		$paginasT=(intval($noReg/$pag));
		//echo"pag= $paginasT";
		?>
		<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
		<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
		<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
		<script>
			$("#paginador").show();
			$("#PAct").html("<?=$pagAct;?>");
			$("#TotPa").html("<?=$paginasT;?>")
		</script><?
		$CON="SELECT * FROM CAT_refacciones limit 0,16";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT * FROM CAT_refacciones limit ".$intervalo.",16";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	?>
	<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
	<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
	<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
	<script>
		//$("#paginador").show();
		$("#PAct").html("<?=$pagAct;?>");
		//$("#TotPa").html("<?=$paginasT;?>")
	</script><?
}	
$conTiempo="SELECT * FROM CAT_tiempoReparacion";
$exeTiempo=mysql_query($conTiempo,conectarBd());
$i=($intervalo)+1;
$capC=1;
//print($noReg);
?>
<div id="cont" style="margin-top: 10px;">
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
	<div id="izq" style="width:30%;height:100%;background:#FFF;clear:both;margin-left:0px;border:1px solid #000;float:left;"> 
		<table class="tabTiempo" align="center">
			<tr>
				<th colspan=2>F</th>
			</tr>
			<tr>
				<th colspan=2>TIEMPO DE REPARACI&Oacute;N</th>
			</tr>
<?
		while($rowT=mysql_fetch_array($exeTiempo)){
			?>
				<tr>
					<td style="width:30px;"><?=$rowT['tiempo']?></td>
					<td style="width:170px;"><?=$rowT['significado']?></td>
				</tr>
				<?
			}
			?>
		</table>
	</div>
	<div id="der" style="width:60%;float:left; height:100%;background:#FFF;margin-top:0px;border:1px solid #000;">
		<table class="tabDer19" align="center">
			<tr>
				<th colspan="2">G</th> 
			</tr>
			<tr>
				<th colspan="2">PARTES CAMBIADAS</th>
			</tr>
<?	
				while($rowRef=mysql_fetch_array($exeCon)){
?>		
					<tr>
						<td style="width:40px;"><?=$rowRef['id_en_almacen']?></td>
						<td style="width:230px;"><?=$rowRef['nombre_generico']?></td>
					</tr>
<?
				}
				if($noReg<$pag){
			    	for($v=$i;$v<=$lim;$v++){
?>
					    <tr>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    </tr>
<?
					}
				}
?>
		</table>
	</div>
?
	}
?>
</div>