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
<input type="hidden" id="idLote" name="idLote" value="<?=$idL;?>"/><?
$paginasT=$_POST['totalpag'];
$intervalo=$_POST['intervalo'];
$pagAct=$_POST['pagAct'];
$pag=6;//pag es el limite de registros
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
	$CON="SELECT detalle_lotes.*, detalleDYR.idDetalleDYR, detalleDYR.id_item, detalleDYR.status AS statusDYR, detalleDYR.observaciones AS detalleDYR	FROM detalle_lotes INNER JOIN detalleDYR ON detalleDYR.id_item= detalle_lotes.id_item
		  WHERE detalle_lotes.id_tecnico='".$datoE."' and (detalle_lotes.status='Empaque' or detalle_lotes.status='SCRAP') ORDER BY (detalleDYR.idDetalleDYR)";
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
		$CON="SELECT detalle_lotes.*, detalleDYR.idDetalleDYR, detalleDYR.id_item, detalleDYR.status AS statusDYR, detalleDYR.observaciones AS detalleDYR	FROM detalle_lotes INNER JOIN detalleDYR ON detalleDYR.id_item= detalle_lotes.id_item
		  WHERE detalle_lotes.id_tecnico='".$datoE."' and (detalle_lotes.status='Empaque' or detalle_lotes.status='SCRAP') ORDER BY (detalleDYR.idDetalleDYR) limit 0,6";
		$exeCon=mysql_query($CON,conectarBd());
	}else{
		?><script>
			$("#PAct").html("1");
			$("#TotPa").html("1")
		</script><?
	}
}else{
	$CON="SELECT detalle_lotes.*, detalleDYR.idDetalleDYR, detalleDYR.id_item, detalleDYR.status AS statusDYR, detalleDYR.observaciones AS detalleDYR	FROM detalle_lotes INNER JOIN detalleDYR ON detalleDYR.id_item= detalle_lotes.id_item
		  WHERE detalle_lotes.id_tecnico='".$datoE."' and (detalle_lotes.status='Empaque' or detalle_lotes.status='SCRAP') ORDER BY (detalleDYR.idDetalleDYR) limit ".$intervalo.",6";
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
$conTec="SELECT * FROM userdbcontroloperaciones WHERE ID=$datoE";
$exeTec=mysql_query($conTec,conectarBd());
$rowTec=mysql_fetch_array($exeTec);
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
	<div style="background:#AFACAC;height:10px;width:100%;border:1px solid #000;"></div>
		<div id="arriba" style="width:100%;height:40px;background:#FFF;clear:both;margin-left:0px;border:1px solid #000;"> 
			<table class="tecTab">
				<tr>
					<th rowspan=6 style="width:15%;">NOMBRE DEL T&Eacute;CNICO:</th>
					<td rowspan=6 style="width:15%;"><div style="border:1px solid #000;width:180px;font-weight:bold;font-size:9px;"><?=$rowTec['nombre']." ".$rowTec['apaterno'];?></div></td>
					<th style="width:13%;">FECHA INGRESO:</th>
					<td style="width:15%;border-bottom:1px solid #000; text-align:center;"><?=$roL['fecha_reg']?></td>
					<th style="width:10%;">FECHA SALIDA:</th>
					<td style="width:60%;border-bottom:1px solid #000; text-align:center;"><pre style="display:inline">&#09;</pre><?=$roL['fecha_tat']?><pre style="display:inline">&#09;</pre></td>
				</tr>
				<tr>
					<th style="width:13%;">FOLIO:</th>
					<td style="width:15%;border-bottom:1px solid #000; text-align:center;">00000</td>
					<th style="width:10%;">LOTE  IQE:</th>
					<td style="width:60%;border-bottom:1px solid #000; text-align:center;"><pre style="display:inline">&#09;</pre><?=$roL['id_lote']?> (<?=$roL['num_po']?>)<pre style="display:inline">&#09;</pre></td>
				</tr>
			</table>
		</div>
		<div id="tablaIz" style="width:100%;float:left; height:80%;background:#fff;margin-top:0px;">
			<table class="capTab">
				<tr class="enctabCap">
					<th style="width:auto;">No.</th>
					<th style="width:auto;">DESCRIPCI&Oacute;N</th>
					<th style="width:auto;">FLOWTAG</th>
					<th style="width:auto;">No.PARTE</th>
					<th style="width:auto;">NO.SERIE</th>
					<th style="width:auto;">CT</th>
					<th style="width:auto;">FABRICANTE</th>
					<th style="width:auto;">PAIS DE MANUFACTURA</th>
					<th style="width:auto;">REPARACI&Oacute;N</th>
					<th style="width:auto;">FALLA ENCONTRADA</th>
					<th style="width:auto;">ROOT CAUSE</th>
					<th style="width:auto;">C&Oacute;DIGO REPARACI&Oacute;N</th>
					<th style="width:auto;">C&Oacute;DIGO IRR/WK</th>
					<th style="width:auto;">Rev. IN</th>
					<th style="width:auto;">Rev. Out</th>
					<th style="width:auto;">TIEMPO REPARACI&Oacute;N</th>
					<th style="width:auto;">fabRev</th>
					<th style="width:auto;">TIEMPO DE FUNCIONAMIENTO</th>
					<th style="width:auto;">PARTES CAMBIADAS</th>
					<th style="width:auto;">FABRICANTE DE COMPONENTES</th>
					<th style="width:auto;">OBSERVACIONES</th>
				</tr>
<?
					while($rowDe=mysql_fetch_array($exeCon)){
						//print_r($rowDe);
						//exit;
						$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
					    $exeSEN=mysql_query($Condes,conectarBd());
					    $rowSENC=mysql_fetch_array($exeSEN);
					    $noParte=$rowSENC[2];
					    $descripcion=$rowSENC[4];
					    if($rowDe['detalleDYR']==""){
					    	$obs="--";
					    }else{
					    	$obs=$rowDe['detalleDYR'];
					    }if($rowDe['fabRev']==""){
					    	$fab="N/A";
					    }else{
					    	$fab=$rowDe['fabRev'];
					    }
					    if($rowDe['TiempoReparacion']==""){
					    	$tiempoFun="--";
					    }else{
					    	$tiempoFun=$rowDe['TiempoFuncionamiento'];
					    }
					    if($rowDe['TiempoFuncionamiento']==""){
					    	$tiempoRep="--";
					    }else{
					    	$tiempoRep=$rowDe['TiempoReparacion'];
					    }
					    $conFab="SELECT * FROM CAT_fabricante WHERE id_fabricante='".$rowDe['id_fabricante']."'";
					    $exeFab=mysql_query($conFab,conectarBd());
					    $noFab=mysql_num_rows($exeFab);
					    if($noFab==0){
					    	$fabri="--";
					    }else{
					    	$rowFab=mysql_fetch_array($exeFab);
					    	$fabri=$rowFab['nombre_fabricante'];
					    }
					    if($rowDe['id_fallas']=='N/A'){
					    	$fallas="N/A";
					    }else{
						    $explodeFallas=explode(",", $rowDe['id_fallas']);
						    $implodeFallas=implode("','", $explodeFallas);
						    $conFallas="SELECT * FROM CAT_fallas WHERE id_fallas IN ('".$implodeFallas."')";
						    $exeFallas=mysql_query($conFallas,conectarBd());
						    $noFallas=mysql_num_rows($exeFallas);
						    if($noFallas==0){
						    	$fallas="N/A";
						    }else{
						    	$arrayFallas=array();
						    	while($rowFallas=mysql_fetch_array($exeFallas)){
						    		array_push($arrayFallas, $rowFallas['tipo_falla']);
						    	}
						    	$fallas=implode(",", $arrayFallas);
						    }
					    }
					    if($rowDe['id_rootCause']=='N/A'){
					    	$rootCause="N/A";
					    }else{
						    $explodeRoot=explode(",", $rowDe['id_rootCause']);
						    $implodeRoot=implode("','", $explodeRoot);
						    $conRoot="SELECT * FROM CAT_rootCause WHERE id_rootCause IN ('".$implodeRoot."')";
						    $exeRoot=mysql_query($conRoot,conectarBd());
						    $noRoot=mysql_num_rows($exeRoot);
						    if($noRoot==0){
						    	$rootCause="N/A";
						    }else{
						    	$arrayRoot=array();
						    	while($rowRoot=mysql_fetch_array($exeRoot)){
						    		array_push($arrayRoot, $rowRoot['codigoRoot']);
						    	}
						    	$rootCause=implode(",", $arrayRoot);
						    }
					    }
					    if($rowDe['id_irre_wk']=='N/A'){
					    	$irre_wk="N/A";
					    }else{
						    $explodeIrrWk=explode(",", $rowDe['id_irre_wk']);
						    $implodeIrrWk=implode("','", $explodeIrrWk);
						    $conIrrWk="SELECT * FROM CAT_irre_wk WHERE id_irre_wk IN ('".$implodeIrrWk."')";
						    $exeIrWk=mysql_query($conIrrWk,conectarBd());
						    $noIrrWk=mysql_num_rows($exeIrWk);
						    if($noIrrWk==0){
						    	$irre_wk="N/A";
						    }else{
						    	$arrayIrWk=array();
						    	while($rowIrrWk=mysql_fetch_array($exeIrWk)){
						    		array_push($arrayIrWk, $rowIrrWk['codigo']);
						    	}
						    	$irre_wk=implode(",", $arrayIrWk);
						    }
					    }
					    if($rowDe['id_codigoReparacion']=='N/A'){
					    	$codRep="N/A";
					    }else{
						    $explodeCodRep=explode(",", $rowDe['id_codigoReparacion']);
						    $implodeCodRep=implode("','", $explodeCodRep);
						    $conCodRep="SELECT * FROM CAT_codigoReparacion WHERE id_codigoReparacion IN ('".$implodeCodRep."')";
						    $exeCodRep=mysql_query($conCodRep,conectarBd());
						    $noCodRep=mysql_num_rows($exeCodRep);
						    if($noCodRep==0){
						    	$codRep="N/A";
						    }else{
						    	$arrayCodRep=array();
						    	while($rowCodRep=mysql_fetch_array($exeCodRep)){
						    		array_push($arrayCodRep, $rowCodRep['codigo_reparacion']);
						    	}
						    	$codRep=implode(",", $arrayCodRep);
						    }
					    }
					    if($rowDe['id_refacciones']=='N/A'){
					    	$ref="N/A";
					    	$fabRef="N/A";
					    }else{
						    $explodeRef=explode(",", $rowDe['id_codigoReparacion']);
						    $implodeRef=implode("','", $explodeRef);
						    $conRef="SELECT * FROM CAT_codigoReparacion WHERE id_codigoReparacion IN ('".$implodeRef."')";
						    $exeRef=mysql_query($conCodRep,conectarBd());
						    $noRef=mysql_num_rows($conRef);
						    if($noRef==0){
						    	$ref="N/A";
						    	$fabRef="N/A";
						    }else{
						    	$arrayRef=array();
						    	$arrFabRef=array();
						    	while($rowRef=mysql_fetch_array($exeRef)){
						    		array_push($arrayRef, $rowRef['id_en_almacen']);
						    		if($rowRef['fabricante']==""||$rowRef['fabricante']==NULL){
						    			array_push($arrFabRef, "--");
						    		}else{
						    			array_push($arrFabRef, $rowRef['fabricante']);
						    		}
						    	}
						    	$ref=implode(",", $arrayRef);
						    	$fabRef=implode(",", $arrFabRef);
						    }
					    }
					    
?>
						<tr>
							<th style="width:auto;"><?=$capC;?></th>
							<th style="width:auto;"><?=utf8_encode($descripcion);?></th>
							<th style="width:auto;"><?=$rowDe['flowTag']?></th>
							<th style="width:auto;"><?=$noParte?></th>
							<th style="width:auto;"><?=$rowDe['numSerie']?></th>
							<th style="width:auto;"><?=$rowDe['codeType']?></th>
							<th style="width:auto;"><?=$fabri;?></th>
							<th style="width:auto;"><?=$rowDe['paisManufactura']?></th>
							<th style="width:auto;"><?=$rowDe['statusDYR']?></th>
							<th style="width:auto;"><?=$fallas?></th>
							<th style="width:auto;"><?=$rootCause?></th>
							<th style="width:auto;"><?=$codRep?></th>
							<th style="width:auto;"><?=$irre_wk?></th>
							<th style="width:auto;">--</th>
							<th style="width:auto;">--</th>
							<th style="width:auto;"><?=$tiempoRep?></th>
							<th style="width:auto;"><?=$fab?></th>
							<th style="width:auto;"><?=$tiempoFun?></th>
							<th style="width:auto;"><?=$ref;?></th>
							<th style="width:auto;"><?=$fabRef;?></th>
							<th style="width:auto;"><?=$obs?></th>
						</tr>
<?
						$i++;
						$capC++;
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
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
					    	<td>&nbsp;</td>
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