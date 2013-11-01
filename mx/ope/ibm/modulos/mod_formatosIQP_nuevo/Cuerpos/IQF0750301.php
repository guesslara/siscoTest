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
$pag=12;//pag es el limite de registros
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
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%'";
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
		
		$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' limit 0,12";
		$exeCon=mysql_query($CON,conectarBd());	
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' limit ".$intervalo.",12";
	$exeCon=mysql_query($CON,conectarBd()) or die ();
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
$cSEN="SELECT count( id_Senc ) AS sencs FROM detalle_lotes where id_lote='".$idLote."'
	and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' ORDER BY (id_Senc)";
$exeCS=mysql_query($cSEN,conectarBd());
$rowCS=mysql_fetch_array($exeCS);
/*$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_eng FROM detalle_lotes
	INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."'
	AND status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' GROUP BY (detalle_lotes.id_commodity)";
$exeComm=mysql_query($comm,conectarBd());
$nuComm=mysql_num_rows($exeComm);*/
$poPar="SELECT count(CAT_SENC.NoParte) as Total, CAT_SENC.NoParte FROM detalle_lotes
	INNER JOIN CAT_SENC ON CAT_SENC.id_SENC= detalle_lotes.id_Senc WHERE detalle_lotes.id_lote='".$idLote."'
	and status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' GROUP BY(NoParte)";
$exePar=mysql_query($poPar,conectarBd());
$i=($intervalo)+1;
$tQ=0;
$lisComm="SELECT * FROM CAT_commodity ";
$exeLis=mysql_query($lisComm,conectarBd());
$numLis=mysql_num_rows($exeLis);

?>
<link rel="stylesheet" type="text/css" href="../css/estilos.css" />  
<div id="cont" style="width:100%;height:100%;" >
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
		<div id="tablaIz" style="width:75%;float:left; height:90%;background:#fff; margin-top:15px;">
			<table class="tab">
				<tr id="encabezado">
					<th>No.</th>
					<th style="width:100px;">FLOWTAG</th>
					<th style="width:160px;">Descripci&oacute;n</th>
					<th style="width:80px;">N&uacute;mero de parte</th>
					<th style="width:80px;">N&uacute;mero de serie</th>
					<th style="width:80px;">Obs.</th>
				</tr>
<?
				while($rowDe=mysql_fetch_array($exeCon)){
   					$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
   					//print($Condes);
					$exeSEN=mysql_query($Condes,conectarBd());
					$rowSENC=mysql_fetch_array($exeSEN);
					$desc=utf8_encode($rowSENC['descripcion']);
					$noParte=$rowSENC[2];
					if($rowDe['observaciones']==""){
						$al="center";
						$obs="--";
					}else{
						$al="justify";
						$obs=$rowDe['observaciones'];
					}
?>
					<tr>
						<td class="otros"><?=$i?></td>
						<td class="otros"><?=$rowDe['flowTag']?></td>
						<td class="desc"><?=$desc?></td>
						<td class="otros"><?=$noParte?></td>
						<td class="otros"><?=$rowDe['numSerie']?></td>
						<td class="desc" style="text-align:<?=$al;?>"><?=$obs?></td>
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
		<div id="tablaDe" style="width:25%;float:left; height:auto;background:#fff;">
			<div id="1" style="width:90%; height:20%; float:right;clear:both;margin-top:5px;">
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
						<td>&nbsp;</td>
					</tr>
				</table>
			</div>
			<div id="2" style=" width:90%;height:20%; float:right;clear:both;margin-top:5px;">
				<table class="ta2">
					<tr class="uno">
						<th>N/P</th>
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
			<div id="3" style="width:90%; height:50%;clear:both;float:right;margin-top:5px;">
				<table class="ta2">
					<tr class="uno">
						<th>Product</th>
						<th>QTY</th>
					</tr>
<?
					while($rrow=mysql_fetch_array($exeLis)){
						?><tr>
							<td><?=$rrow["desc_eng"];?></td><?
						$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_eng FROM detalle_lotes
						INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."'
						AND status='Empaque' and id_irre_wk='N/A' and TipoEntrada not like '%Garant%' GROUP BY (detalle_lotes.id_commodity)";
						$exeComm=mysql_query($comm,conectarBd());
						$nuComm=mysql_num_rows($exeComm);
						while($rowComm=mysql_fetch_array($exeComm)){
							if($rrow['desc_eng']==$rowComm['desc_eng']){
								$valor=$rowComm['qty'];
								$tQ+=$valor;
								break;
							}else{
								$valor=0;
							}
						}
						echo"<td>$valor</td>";
						echo"</tr>";
						$valor=1;
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
