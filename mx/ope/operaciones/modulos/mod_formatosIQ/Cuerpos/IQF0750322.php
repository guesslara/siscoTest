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
?><input type="hidden" id="idLote" name="idLote" value="<?=$idL;?>"/><?
$paginasT=$_POST['totalpag'];
$intervalo=$_POST['intervalo'];
$pagAct=$_POST['pagAct'];
$pag=21;//pag es el limite de registros
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
	$CON="SELECT * FROM CAT_codigoReparacion";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	//echo"noreg=$noReg";
	if($noReg>$pag){
		$paginasT=($noReg/$pag)+1;
		if(is_int($paginasT)){}else{$paginasT=intval($paginasT+1);}
		//echo"$paginasT";
		?>
		<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
		<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
		<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
		<script>
			$("#paginador").show();
			$("#PAct").html("<?=$pagAct;?>");
			$("#TotPa").html("<?=$paginasT;?>")
		</script><?
		$CON="SELECT * FROM CAT_codigoReparacion limit 0,21";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	if($pagAct==$paginasT){
		?>
		<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
		<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
		<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
		<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
		<script>
			$("#PAct").html("<?=$pagAct;?>");
			muestraTiempo('<?=$noFormato;?>');
		</script><?
	}else{
	$CON="SELECT * FROM CAT_codigoReparacion limit ".$intervalo.",21";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	?>
	<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
	<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
	<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
	<script>
		//$("#paginador").show();
		$("#PAct").html("<?=$pagAct;?>");
		//$("#TotPa").html("<?=$paginasT;?>")
	</script><?
	}
}
$i=($intervalo)+1;
?>
<div id="cont" style="height:100%;width:100%">
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
		<div id="reparaciones" style="width:100%;height:auto;background:#fff; margin-top:15px;text-align:center;">
			<table class="rep" align="center">
				<tr class="encabRep">
					<th>C&Oacute;DIGO</th>
					<th>DESCRICI&Oacute;N</th>
				</tr>
<?
				while($rowRep=mysql_fetch_array($exeCon)){
?>
					<tr>
						<td><?=utf8_encode($rowRep['codigo_reparacion'])?></td>
						<td><?=utf8_encode($rowRep['descripcion'])?></td>
					</tr>
<?
				}
?>
			</table>
		</div>
<?
	}
?>
</div>