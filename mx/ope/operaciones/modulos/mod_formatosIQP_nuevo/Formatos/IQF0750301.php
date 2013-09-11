<?
include("../mod_formatos/nuevo.php");
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
$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque'";
$exeCon=mysql_query($CON,conectarBd());
$noReg=mysql_num_rows($exeCon);
$conL="SELECT * FROM lote where id_lote='".$idLote."'";
$exeL=mysql_query($conL,conectarBd());
$roL=mysql_fetch_array($exeL);
$cSEN="SELECT count( id_Senc ) AS sencs FROM detalle_lotes where id_lote='".$idLote."' and status='Empaque' ORDER BY (id_Senc)";
$exeCS=mysql_query($cSEN,conectarBd());
$rowCS=mysql_fetch_array($exeCS);
$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_esp FROM detalle_lotes INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."' AND status='Empaque' GROUP BY (detalle_lotes.id_commodity)";
$exeComm=mysql_query($comm,conectarBd());
$i=1;
$tQ=0;
?>
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  
<div style="width:100%;height:100%;border:1px solid #000;"id="con">
	<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
	?>
		<div id="tablaIz" style="width:75%;float:left; height:100%;background:#fff; border:0px solid #000;margin-top:0px;">
			<table class="tab">
				<tr id="encabezado">
					<th>No00.</th>
					<th>FlOWTAG</th>
					<th>Descripción</th>
					<th>Número de parte</th>
					<th>Número de serie</th>
					<th>Obs.</th>
				</tr>
				<?
				$i=1;
				while($rowDe=mysql_fetch_array($exeCon)){
					$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
					$exeSEN=mysql_query($Condes,conectarBd());
					$rowSENC=mysql_fetch_array($exeSEN);
					$desc=$rowSENC;
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
				?>
			</table>
		</div>
		<div id="tablaDe" style="width:25%;float:left; height:100%;background:#fff; border:0px solid #000;">
			<div id="1" style="width:100%; height:20%; border:0px solid #000;clear:both;margin-top:5px;float:left;">
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
			<div id="2" style="width:100%; height:20%; border:0px solid #000;clear:both;margin-top:5px;float:left;">
				<table class="ta2">
					<tr class="uno">
						<th>N/P</th>
						<th>QTY</th>
					</tr>
					<tr>
						<td><?=$rowCS['sencs']?></td>
						<td><?=$rowCS['sencs']?></td>
					</tr>
					<tr class="uno">
						<th>Total</th>
						<td><?=$rowCS['sencs']?></td>
					</tr>
				</table>
			</div>
			<div id="3" style="width:100%; height:50%; border:0px solid #000;clear:both;margin-top:5px;float:left;">
				<table class="ta2">
					<tr class="uno">
						<th>Product</th>
						<th>QTY</th>
					</tr>
					<?
					while($rowComm=mysql_fetch_array($exeComm)){
					?>
						<tr>
							<td><?=$rowComm['desc_esp']?></td>
							<td><?=$rowComm['qty']?></td>
						</tr>
					<?
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
