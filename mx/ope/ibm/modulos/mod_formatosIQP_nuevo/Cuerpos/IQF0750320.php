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
$pag=11;//pag es el limite de registros
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
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and (status='Empaque' and id_irre_wk!='N/A' ) or status='SCRAP'";
	$exeCon=mysql_query($CON,conectarBd());
	$noReg=mysql_num_rows($exeCon);
	if($noReg>$pag){
		$paginasT=1+(intval($noReg/$pag));
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
		$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and (status='Empaque' and id_irre_wk!='N/A' ) or status='SCRAP' limit 0,11";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and (status='Empaque' and id_irre_wk!='N/A' ) or status='SCRAP' limit ".$intervalo.",11";
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

$i=($intervalo)+1;
?>
<div id="cont" style="margin-top: 10px;">
	<input type="hidden" id="limreg" name="limreg" value="<?=$pag;?>"/>
<?
	if($noReg==0){
		echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
	}else{
?>
		<div id="arriba" style="width:100%;float:left;height:15%;background:#FFF;clear:both;margin-left:30px;"> 
			<table class="taAr">
				<tr>
					<th colspan=2 style="border-top:1px solid #FFF; border-left:1px solid #FFF;border-right:8px solid #FFF;">IQ Electronics M&eacute;xico</th>
				</tr>
				<tr>
					<th >FECHA</th>
					<td ><?=date('Y-m-d');?></td>
				</tr>
				<tr>
					<th >EMITIO (EJECUTIVO CTA.HP PSG)</th>
					<td >ISRAEL AVALOS TAPIA</td>
				</tr>
				<tr>
					<th >FECHA DE ENVIO</th>
					<td ><?=$roL['fecha_tat'];?></td>
				</tr>
				<tr>
					<th >ENTREGADOS</th>
					<td ><?=date('Y-m-d');?></td>
				</tr>
			</table>
		</div>
		<div id="tablaIz" style="width:100%;float:left; height:80%;background:#fff;margin-top:15px;">
			<table class="tab">
				<tr class="gris">
					<th style="width:15px;">ITEM</th>
					<th style="width:80px;">TARIMA</th>
					<th style="width:140px;">MODELO</th>
					<th style="width:100px;">N&Uacute;MERO DE PARTE</th>
					<th style="width:100px;">N&Uacute;MERO DE SERIE</th>
					<th style="width:160px;">FECHA</th>
					<th style="width:160px;">OBSERVACIONES</th>
				</tr>
<?
					while($rowDe=mysql_fetch_array($exeCon)){
						$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
					    $exeSEN=mysql_query($Condes,conectarBd());
					    $rowSENC=mysql_fetch_array($exeSEN);
					    $conMod="SELECT * FROM CAT_modelo WHERE id_modelo='".$rowDe['id_modelo']."'";
					    $exeMod=mysql_query($conMod,conectarBd());
					    if(mysql_num_rows($exeMod)==0){
					    	$mode="NO TIENE MODELO";
					    }else{
					    	$rowM=mysql_fetch_array($exeMod);
					    	$mode=$rowM['modelo'];
					    }
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
				    	<td><?=$rowDe['id_item']?></td>
				    	<td>TARIMA</td>
				    	<td><?=$mode?></td>
				    	<td><?=$noParte?></td>
				    	<td><?=$rowDe['numSerie']?></td>
				    	<td><?=$roL["fecha_tat"]?></td>
				    	<td><?=$obs?></td></tr>
					</tr>
<?
					$i++;
				}
				if($noReg<$pag){
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
				}
?>
			</table>
		</div>
<?
	}
?>