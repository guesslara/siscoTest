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
$pag=10;//pag es el limite de registros
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
	$COEm="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%'";
	$exeCOEm=mysql_query($COEm,conectarBd());
	$noRegCOEm=mysql_num_rows($exeCOEm);
	if($noRegCOEm>$pag){
		$paginasT=$noRegCOEm/$pag;
		if(is_int($paginasT)){}else{
			$paginasT=intval($paginasT+1);
		}
		?>
		<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
		<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
		<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
		<script>
			$("#paginador").show();
			$("#PAct").html("<?=$pagAct;?>");
			$("#TotPa").html("<?=$paginasT;?>")
		</script><?
		
		$COEm="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' limit 0,10";
		$exeCOEm=mysql_query($COEm,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$COEm="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' limit ".$intervalo.",10";
	$exeCOEm=mysql_query($COEm,conectarBd());
	$noRegCOEm=mysql_num_rows($exeCOEm);
	?>
	<input type="hidden" id="pagAct" name="pagAct" value="<?=$pagAct;?>"/>
	<input type="hidden" id="limite" name="limite" value="<?=$lim;?>"/>
	<input type="hidden" id="tp" name="tp" value="<?=$paginasT;?>"/>
	<script>
		$("#PAct").html("<?=$pagAct;?>");
	</script><?
}
$conL="SELECT * FROM lote where id_lote='".$idLote."'";
$exeL=mysql_query($conL,conectarBd());
$roL=mysql_fetch_array($exeL);
$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."'";
$exeCon=mysql_query($CON,conectarBd());
$noReg=mysql_num_rows($exeCon);
$rep="SELECT COUNT(id_item) as itemRep FROM detalle_lotes where id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%'";
$exeRe=mysql_query($rep,conectarBd());
$roRep=mysql_fetch_array($exeRe);
$cSEN="SELECT count( id_Senc ) AS sencs FROM detalle_lotes where id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' ORDER BY (id_Senc)";
$exeCS=mysql_query($cSEN,conectarBd());
$rowCS=mysql_fetch_array($exeCS);
$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_esp FROM detalle_lotes INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."' AND status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' GROUP BY (detalle_lotes.id_commodity)";
$exeComm=mysql_query($comm,conectarBd());
$poPar="SELECT count(CAT_SENC.NoParte) as Total, CAT_SENC.NoParte FROM detalle_lotes INNER JOIN CAT_SENC ON CAT_SENC.id_SENC= detalle_lotes.id_Senc WHERE detalle_lotes.id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' GROUP BY(NoParte)";
$exePar=mysql_query($poPar,conectarBd());
$i=($intervalo)+1;
$tQ=0;
?>
<div id="contenidoHoja" style="width:100%;height:100%;">
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{	
?>
		<div id="tablaAri" style="width:100%;float:left; height:90px;background:#fff; margin-top:5px;">
			<div id="izD" style="width:40%; float:left; height:100%;">
				<table class="iz">
					<tr>
						<th>IQ Electronics México</th>
						<td style="border-top-color: #fff; border-right-color: #fff;"></td>
					</tr>
					<tr>
						<th >PO</th>
						<td ><?=$roL['num_po']?></td>
					</tr>
					<tr>
						<th >No.De Sello</th>
						<td >N/A</td>
					</tr>
					<tr>
						<th class="pe">Recibidos</th>
						<td><?=$roL['numero_items']?></td>
					</tr>
					<tr>
						<th class="pe">Reparados</th>
						<td ><?=$roRep['itemRep']?></td>
					</tr>
					<tr>
						<th class="pe">% Recuperacion</th>
						<td ><?=($roRep['itemRep']*100)/$roL['numero_items'];?> %</td>
					</tr>
				</table>
			</div>
			<div id="der" style="width:35%; float:left; height:100%;margin-top:15px;">
				<table class="tabDe" align="center">
					<tr>
						<th style="width:100px;">Descripcion</th>
						<th style="width:60px;">QTY</th>
					</tr>
					<tr>
						<th>Recuperable</th>
						<td><?=$roRep['itemRep']?></td>
					</tr>
					<tr>
						<th>Total</th>
						<td><?=$roRep['itemRep']?></td>
					</tr>
					<tr>
						<th>FACTURA NO.</th>
						<td>***</td>
					</tr>
				</table>
			</div>
		</div>
		<div style="clear:both;"></div>
		<div id="medio" style="width:100% heigth:50px;background:#fff; border:0px solid #000;margin-top:10px;margin-left: 5px; margin-button:10px;">
			<table class="tabMedio">
				<tr>
					<th>FECHA</th>
					<td><?=date("o-m-d")?></td>
				</tr>
				<tr>
					<th>EMITIO (EJECUTIVO CTA.HP PSG)</th>
					<td>Israel Avalos</td>
				</tr>
				<tr>
					<th>FECHA DE ENVIO</th>
					<td><?=$roL["fecha_tat"]?></td>
				</tr>
			</table>
		</div>
<?
		if($noRegCOEm!=0){
?>
			<div id="abajo" style="width:100%;height: auto;background:#fff; border:0px solid #000;padding:10x;margin:10px 0px 0px 0px;clear:both;">
				<div id="izqt" style="width:75%;height:90%; float:left; margin-left:5px;">
					<table class="tab">
						<tr class="encabezado2">
							<th>QTY</th>
							<th>Spare</th>
							<th>Descripción</th>
							<th>Número de serie</th>
							<th>Clase</th><th>Tarima</th>
							<th>Observaciones</th>
						</tr>
<?
						while($rowEm=mysql_fetch_array($exeCOEm)){
							$Condes="SELECT * from CAT_SENC where id_SENC='".$rowEm['id_Senc']."'";
							$exeSEN=mysql_query($Condes,conectarBd());
							$rowSENC=mysql_fetch_array($exeSEN);
							$desc=$rowSENC;
							$noParte=$rowSENC[2];
							if($rowEm['observaciones']==""){
								$obs="--";
							}else{
								$obs=$rowEm['observaciones'];
							}
?>
							<tr>
								<td><?=$i?></td>
								<td><?=$noParte?></td>
								<td></td>
								<td><?=$rowEm['numSerie']?></td>
								<td>Q clase</td>
								<td>tarima</td>
								<td><?=$obs?></td>
							</tr>
<?
							$i++;
						}
						for($v=$i;$v<=$lim;$v++){
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
				<div id="der" style="width:20%;height:90%; float:right;margin-right:5px;">
					<table class="tab">
						<tr class="encabezado2">
							<th>Por spare</th>
							<th>QTY</th>
						</tr>
<?
						$sm=0;
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
			</div>
<?
		}
	}