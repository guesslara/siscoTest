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
$pag=14;//pag es el limite de registros
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
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	//echo"noreg=$noReg";
	if($noReg>$pag){
		$paginasT=$noReg/$pag;
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
		$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A') limit 0,14";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A') limit ".$intervalo.",14";
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

	$conL="SELECT * FROM lote where id_lote='".$idLote."'";
	$exeL=mysql_query($conL,conectarBd());
	$roL=mysql_fetch_array($exeL);
	$cSEN="SELECT count( id_Senc ) AS sencs FROM detalle_lotes where id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%' ORDER BY (id_Senc)";
	$exeCS=mysql_query($cSEN,conectarBd());
	$rowCS=mysql_fetch_array($exeCS);
	$poPar="SELECT count(CAT_SENC.NoParte) as Total, CAT_SENC.NoParte FROM detalle_lotes INNER JOIN CAT_SENC ON CAT_SENC.id_SENC= detalle_lotes.id_Senc WHERE detalle_lotes.id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%' GROUP BY(NoParte)";
	$exePar=mysql_query($poPar,conectarBd());
	$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_esp FROM detalle_lotes INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%' GROUP BY (detalle_lotes.id_commodity)";
	$exeComm=mysql_query($comm,conectarBd());
	$lisComm="SELECT * FROM CAT_commodity ";
	$exeLis=mysql_query($lisComm,conectarBd());
	$numLis=mysql_num_rows($exeLis);
	$i=($intervalo)+1;
	$tQ=0;
	$sm=0;

?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css">
<div id="cont" style="width:100%;height:100%;margin-top:10px;" >
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
		<div id="tablaIz" style="width:75%;float:left; height:100%;background:#fff; margin-top:15px;">
			<table class="tab">
				<tr id="encabezado">
					<th>No.</th>
					<th>FLOWTAG</th>
					<th>Descripci&oacute;n</th>
					<th>N&uacute;mero de parte</th>
					<th>N&uacute;mero de serie</th>
					<th>Obs.</th>
				</tr>
<?
				while($rowDe=mysql_fetch_array($exeCon)){
					$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
				    $exeSEN=mysql_query($Condes,conectarBd());
				    $rowSENC=mysql_fetch_array($exeSEN);
				    $desc=utf8_encode($rowSENC['descripcion']);
				    $noParte=$rowSENC[2];
					if($rowDe['observaciones']==""){
				      	$obs="--";
					}else{
					    $obs=$rowDe['observaciones'];
					}
?>
					<tr>
					   	<td><?=$i?></td>
					   	<td><?=$rowDe['flowTag']?></td>
					   	<td><?=$desc?></td>
					   	<td><?=$noParte?></td>
					   	<td><?=$rowDe['numSerie']?></td>
					   	<td><?=$obs?></td>
					</tr>
<?
					$i++;
			}
			for($xt=$i;$xt<=$lim;$xt++){
				?>
				<tr>
				   	<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<?
			}
	
?>
			</table>
		</div>
		<div id="tablaDe" style="width:25%;float:left; height:100%;background:#fff; margin-top:5px;">
			<div id="1" style="width:90%; height:auto; float:right;clear:both;margin-top:5px;">
				<table class="ta1">
					<tr>
						<th>Fecha Entrega</th>
						<td><?=$roL["fecha_tat"]?></td>
					</tr>
					<tr>
						<th >PO</th>
						<td><?=$roL["num_po"]?></td>
					</tr>
					<tr>
						<th >Factura No.</th>
						<td>de donde?</td>
					</tr>
				</table>

			</div>
			<div id="2" style=" width:90%;height:auto; float:right;clear:both;margin-top:5px;">
				<table class="ta2">
					<tr class="uno">
						<th>N/P</th>
						<th>QTY</th>
					</tr>
<?
					while($rowPart=mysql_fetch_array($exePar)){
?>
						<tr>
							<td><?=$rowPart['NoParte']?></td>
							<td><?=$rowPart['Total']?></td>
						</tr>
<?
						$sm+=$rowPart['Total'];
					}
?>
					<tr class="encabezado2">
						<th>Total</th>
						<th><?=$sm;?></th>
					</tr>
				</table>
			</div>
			<div id="3" style="width:90%; height:auto;clear:both;float:right;margin-top:5px;">
				<table class="ta2">
					<tr class="uno">
						<th>Product</th><th>QTY</th>
					</tr>
<?
					while($rowComm=mysql_fetch_array($exeComm)){
						while($rrow=mysql_fetch_array($exeLis)){
?>
							<tr>
								<td><?=strtoupper($rrow['desc_eng'])?></td>
<?
								if($rowComm['desc_eng']==$rrow['desc_eng']){
									?><td><?=$rowComm['qty']?></td><?
								}else{
									?><td>0</td><?
								}
?>
							</tr>
<?
						}
						$tQ+=$rowComm['qty'];
					}
?>
					<tr class="uno">
						<th>Total</th>
						<th><?=$tQ;?></th>
					</tr>
					</table>
			</div>
		</div>
<?
	}
?>
</div>
