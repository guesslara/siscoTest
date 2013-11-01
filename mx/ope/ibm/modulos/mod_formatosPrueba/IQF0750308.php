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
	//$h="20cm";
}else if($divNom[3]=="-"){
	$orientacion="27.9cm";
	//$h="15cm";
}
//$hCo=$h-10;
?>

<!--<div id="contenedorEnsamble">
	<div id="contenedorEnsamble3">-->
		<div id="hoja" style="width:<?=$orientacion;?>">
			<div id="headerHoja">
				<table border=1 class="TabEN">
					<tr>
						<td rowspan=4><img width=80 src="../../img/iqe.jpeg"></td>
						<td>REVISIÓN: 01 FECHA:08/05/13</td>
						<td>CLAVE: <?=$noFormato?>
						<td rowspan=2 colspan=2>EMISIÓN: 23/10/09</td>
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
			<div id="contenidoHoja" >
				<?
							$CON="SELECT * FROM detalle_lotes WHERE id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%'";
							//print($CON);
							$exeCon=mysql_query($CON,conectarBd());
							$noReg=mysql_num_rows($exeCon);
							$conL="SELECT * FROM lote where id_lote='".$idLote."'";
							$exeL=mysql_query($conL,conectarBd());
							$roL=mysql_fetch_array($exeL);
							$cSEN="SELECT count( id_Senc ) AS sencs FROM detalle_lotes where id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%' ORDER BY (id_Senc)";
							$exeCS=mysql_query($cSEN,conectarBd());
							$rowCS=mysql_fetch_array($exeCS);
							$poPar="SELECT count(CAT_SENC.NoParte) as Total, CAT_SENC.NoParte FROM detalle_lotes INNER JOIN CAT_SENC ON CAT_SENC.id_SENC= detalle_lotes.id_Senc WHERE detalle_lotes.id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%' GROUP BY(NoParte)";
							$exePar=mysql_query($poPar,conectarBd());
							$comm="SELECT count( detalle_lotes.id_commodity ) AS qty, detalle_lotes.id_commodity, CAT_commodity.desc_esp FROM detalle_lotes INNER JOIN CAT_commodity ON detalle_lotes.id_commodity = CAT_commodity.id_commodity WHERE detalle_lotes.id_lote='".$idLote."' and (status='SCRAP' or (status='Empaque' and id_irre_wk!='N/A')) and TipoEntrada not like '%Garant%' GROUP BY (detalle_lotes.id_commodity)";
							//print($comm);
							$exeComm=mysql_query($comm,conectarBd());
							$i=1;
							$tQ=0;
							if($noReg==0){
								echo"<p style='text-align:center;text-width:bold;'>Actualmente no hay registros</p>";
							}else{
				?>
				<div id="tablaIz" style="width:60%;float:left; height:90%;background:#fff; border:0px solid #000;padding:0px;margin:5px;">

					<table class="tab">
							<tr id="encabezado">
								<th>No.</th><th>FlOWTAG</th><th>Descripción</th><th>Número de parte</th><th>Número de serie</th><th>Obs.</th>
							</tr>
							<?
							$i=1;
							while($rowDe=mysql_fetch_array($exeCon)){
    						$Condes="SELECT * from CAT_SENC where id_SENC='".$rowDe['id_Senc']."'";
						    $exeSEN=mysql_query($Condes,conectarBd());
						    $rowSENC=mysql_fetch_array($exeSEN);
						    $desc=utf8_encode($rowSENC['descripcion']);
						  //  print_r($desc);
						    $noParte=$rowSENC[2];
							if($rowDe['observaciones']==""){
							      $obs="--";
							}else{
							      $obs=$rowDe['observaciones'];
							}
						    ?>
						    <tr>
						    	<td><?=$i?></td><td><?=$rowDe['flowTag']?></td><td><?=$desc?></td><td><?=$noParte?></td><td><?=$rowDe['numSerie']?></td><td><?=$obs?></td></tr>
						    </tr>
						    <?$i++;
						    }?>
					</table>
				</div>
				<div id="tablaDe" style="width:20%;float:left; height:90%;background:#fff; border:0px solid #000;padding:5px;margin:5px;">
					<div id="1" style="width:90%; height:20%; border:0px solid #000;clear:both;margin:5px; padding:5px;">
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
					<div id="2" style="width:90%; height:20%; border:0px solid #000;clear:both;margin:5px;padding:5px;">
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
					<div id="3" style="width:90%; height:50%; border:0px solid #000;clear:both;margin:5px;padding:5px;">
						<table class="ta2">
						<tr class="uno">
							<th>Product</th><th>QTY</th>
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
					</table></div>

				</div>
				<?}?>
			</div>
			<div id="footHoja">
				<div id="firma1" style="with:160px;height:35px;margin: 5px 10px 5px 80px; float:left;border:0px solid #000;"><div id="linea" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;">_________________</div><div id="nombre" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;font-size:10px;"><n class="fo">ISRAEL AVALOS</n><BR>Nombre y Firma<br>IQE de México SA de CV</div></div>
				<div id="firma2" style="with:160px;height:35px;margin: 5px auto 5px 80px; float:left;border:0px solid #000;"><div id="linea" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;">_________________</div><div id="nombre" style="margin:2px auto 0 auto; clear:both:width:80%;text-align:center;font-size:10px;"><n class="fo">ATN:JAVIER RODRIGUEZ</n><BR>Nombre y Firma</div></div>
			</div>
		</div>
	<!--</div>
</div>-->


<?
include ("../../includes/pie.php");
?>
