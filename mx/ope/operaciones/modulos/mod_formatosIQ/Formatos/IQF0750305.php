<?
	include("../../includes/cabecera.php");

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
?>
<script type="text/javascript" src="js/funcionesEnsamble.js"></script>
<script type="text/javascript" src="../../clases/jquery-1.3.2.min.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="js/calendar-green.css"  title="win2k-cold-1" />
<link rel="stylesheet" type="text/css" media="all" href="css/estilos.css" />  
<script type="text/javascript" src="js/calendar.js"></script><!-- librería principal del calendario -->  
<script type="text/javascript" src="js/calendar-es.js"></script><!-- librería para cargar el lenguaje deseado -->   
<script type="text/javascript" src="js/calendar-setup.js"></script><!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
<script type="text/javascript">
	function redimensionar(){
		var altoDiv=$("#contenedorEnsamble3").height();
		var anchoDiv=$("#contenedorEnsamble3").width();
		var altoCuerpo=altoDiv-52;		
		$("#detalleEmpaque").css("height",altoCuerpo+"px");
		$("#ventanaEnsambleContenido2").css("height",altoCuerpo+"px");
		$("#detalleEmpaque").css("width",(anchoDiv-400)+"px");
		$("#ventanaEnsambleContenido2").css("width",(anchoDiv-200)+"px");
		$("#infoEnsamble3").css("height",altoCuerpo+"px");
	}	
	window.onresize=redimensionar;	
</script>
<?$div="listadoEmpaque";
include("../mod_formatos/nuevo.php");
$divNom=explode("_",$nombre);
if($divNom[3]=="|"){
	$orientacion="21.5cm";
	/*$h="20cm";*/
}else if($divNom[3]=="-"){
	$orientacion="27.9cm";
	//$h="15cm";
}
//$hCo=$h-10;
?>

<!--<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">-->
		<div id="hoja" style="width:<?=$orientacion;?>">
			<div id="headerHoja" style="width:<?=$orientacion;?>">
				<table border=1 class="TabEN">
					<tr>
						<td rowspan=4><img width=80 src="../../img/iqe.jpeg"></td>
						<td>REVISIÓN: 01 FECHA:08/05/13</td>
						<td>CLAVE: <?=$noFormato?>
						<td rowspan=2 colspan=2>EMISIÓN: 11/09/08</td>
					</tr>
					<tr>
						<th rowspan=3 colspan=2><?=$divNom[1];?></th>
					</tr>
					<tr>
						<td rowspan=2 colspan=2>pagina _/_</td>
					</tr>
					<tr></tr>
				</table>
			</div>
			<div style="<?=$h?>"id="contenidoHoja" style="width:<?=$orientacion;?>">
				<?
							$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."'";
							$exeCon=mysql_query($CON,conectarBd());
							$noReg=mysql_num_rows($exeCon);
							$COEm="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and status='Empaque'";
							$exeCOEm=mysql_query($COEm,conectarBd());
							$noRegCOEm=mysql_num_rows($exeCOEm);
							$conL="SELECT * FROM lote where id_lote='".$idLote."'";
							$exeL=mysql_query($conL,conectarBd());
							$roL=mysql_fetch_array($exeL);
							$rep="SELECT COUNT(id_item) as itemRep FROM detalle_lotes where id_lote='".$idLote."' and status='Empaque'";
							//print($rep);
							$exeRe=mysql_query($rep,conectarBd());
							$roRep=mysql_fetch_array($exeRe);
							$cSEN="SELECT count( id_Senc ) AS sencs FROM detalle_lotes where id_lote='".$idLote."' and status='Empaque' ORDER BY (id_Senc)";
							$exeCS=mysql_query($cSEN,conectarBd());
							$rowCS=mysql_fetch_array($exeCS);
							$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_esp FROM detalle_lotes INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."' AND status='Empaque' GROUP BY (detalle_lotes.id_commodity)";
							$exeComm=mysql_query($comm,conectarBd());
							$poPar="SELECT count(CAT_SENC.NoParte) as Total, CAT_SENC.NoParte FROM detalle_lotes INNER JOIN CAT_SENC ON CAT_SENC.id_SENC= detalle_lotes.id_Senc WHERE detalle_lotes.id_lote='".$idLote."' and status='Empaque' GROUP BY(NoParte)";
							$exePar=mysql_query($poPar,conectarBd());
							$i=1;
							$tQ=0;
							if($noReg==0){
								echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
							}else{
				?>
				<div id="tablaAri" style="width:90%;float:left; height:90px;background:#fff; border:0px solid #000;padding:5px;margin:0px;clear:both">
					<div id="iz" style="width:40%; float:left; height:89%; border:0px solid #000;padding:5px; margin:5px 10px 0px auto;">
							<table class="iz">
								<tr class="titulo">
									<th >IQ Electronics México</th>
								</tr>
								<tr>
									<th>PO</th>
									<td ><?=$roL['num_po']?></td>
								</tr>
								<tr>
									<th>No.De Sello</th>
									<td></td>
								</tr>
								<tr>
									<th class="pe">Recibidos</th>
									<td><?=$roL['numero_items']?></td>
								</tr>
								<tr>
									<th class="pe">Reparados</th>
									<td><?=$roRep['itemRep']?></td>
								</tr>
								<tr>
									<th class="pe">% Recuperacion</th>
									<td><?=($roRep['itemRep']*100)/$roL['numero_items'];?> %</td>
								</tr>
							</table>

					</div>
					<div id="der" style="width:40%; float:left; height:89%; border:0px solid #000;padding:5px; margin: 5px auto 0px 10px;">
						<table class="tabDe">
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
				<div id="medio" style="width:90% heigth:40px;background:#fff; border:0px solid #000;padding:10px;margin:5px 0px 0px 0px;clear:both">
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
				<?if($noRegCOEm!=0){
				?>
				<div id="abajo" style="width:90%;height:40%;background:#fff; border:0px solid #000;padding:10x;margin:0px 0px 20px 5px;clear:both;overflow:auto">
					<div id="izqt" style="width:70%;height:90%; float:left; margin: 0px 10px 0px auto; padding">
						<table class="tab">
							<tr class="encabezado2">
								<th>QTY</th><th>Spare</th><th>Descripción</th><th>Número de serie</th><th>Clase</th><th>Tarima</th><th>Observaciones</th>
							</tr>
							<?
							$i=1;
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
						    	<td><?=$i?></td><td><?=$noParte?></td><td></td><td><?=$rowEm['numSerie']?></td><td>Q clase</td><td>tarima</td><td><?=$obs?></td></tr>
						    </tr>
						    <?$i++;
						    }?>
					</table>
					</div>
					<div id="der" style="width:20%;height:90%; float:left; margin: 0px 10px 5px auto;">
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
			<?}
		}
		?>
			<div id="footHoja">
				<div id="firma1" style="with:160px;height:35px;margin: 5px 10px 5px 80px; float:left;border:0px solid #000;"><div id="linea" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;">_________________</div><div id="nombre" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;font-size:10px;"><n class="fo">ISRAEL AVALOS</n><BR>Nombre y Firma<br>IQE de México SA de CV</div></div>
				<div id="firma2" style="with:160px;height:35px;margin: 5px auto 5px 80px; float:left;border:0px solid #000;"><div id="linea" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;">_________________</div><div id="nombre" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;font-size:10px;"><n class="fo">RECIBE</n><BR>Nombre y Firma</div></div>
			</div>
		</div>
	<!--</div>
</div>-->
<?
include ("../../includes/pie.php");
?>
