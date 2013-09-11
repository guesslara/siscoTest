<?	/*
	 *modeloEnsamble:Clase del modulo mod_cc que realiza las consultas e inserciones de los análisis de calidad en ellos son mostrados los detalles del diagnostico de cada item 
	 y el checkliste que se debe realizar al mismo dependiendo del comodity que sea
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:
	*/
	session_start();
	include("../../clases/funcionesComunes.php");
	include("../../clases/cargaInicial.php");
	class modeloEnsamble{

		private function conectarBd(){
			require("../../includes/config.inc.php");
			$link=mysql_connect($host,$usuario,$pass);
			if($link==false){
				echo "Error en la conexion a la base de datos";
			}else{
				mysql_select_db($db);
				return $link;
			}				
		}
		public function muestraListado($idProyecto,$idUserCC){
			//print_r($idProyecto); exit;
			$namePro="SELECT * FROM proyecto WHERE id_proyecto=$idProyecto";
			$exenamePro=mysql_query($namePro,$this->conectarBd());
			$rowName=mysql_fetch_array($exenamePro);
			$consultaCC="SELECT * FROM detalle_lotes WHERE status='CC'";
			$exeConsultaCC=mysql_query($consultaCC,$this->conectarBd());
			$numCol=mysql_num_rows($exeConsultaCC);
			$color="#F0F0F0";
			if($numCol==0){
				?><script type="text/javascript">alert("Por el momento ningun ITEM se encuentra en el proceso de calidad");</script><?
			}
			else{
				?>
				<div id="tituloListado" style="padding-top: 7px;background: #CCC;height: 30px; width:99%; text-align: center;font-weight: bold;clear: both; padding: 5px; margin: 5px; ">CONTROL DE CALIDAD <?=$rowName['nombre_proyecto'];?></div>
				<?while($rowListado=mysql_fetch_array($exeConsultaCC)){
					if($color=="#F0F0F0"){
						$color="#FFFFFF";
					}else{
						$color="#F0F0F0";
					}?>	
					<div id="showLote" style="background: <?=$color;?>;" onclick="muestraInfo('<?=$rowListado['id_item']?>','<?=$idProyecto;?>','<?=$idUserCC;?>');"title="Da clic para contestar check List">
						<?if($rowListado["cantRechazos"]<=$rowListado["vecesDiagnosticado"] &&  $rowListado["cantRechazos"]!=0 && $rowListado["vecesDiagnosticado"]!=0 ){
							?><div style="float:right;width:40px; height:40px; background:#ff0000;color:#FFF; text-align:center;font-size:14px;margin:5px;padding-top:3px;"><?=$rowListado["cantRechazos"];?></div><?
						}?>
						<table>
							<tr>
								<th>Número de Parte:</th>
								<?
								$id_Senc=$rowListado['id_Senc'];
								$consNumPart="SELECT * FROM CAT_SENC where id_SENC=$id_Senc";
								$conseje=mysql_query($consNumPart,$this->conectarBd());
								$filPart=mysql_fetch_array($conseje);
								?>
								<td><?=$filPart['NoParte'];?></td>
							</tr>
							<tr>
								<th>No. Lote:</th>
								<td><?=$rowListado['id_lote'];?></td>
							</tr>
							<tr>
								<th>Modelo:</th>
								<td><?=$rowListado['modelo'];?></td>
							</tr>
							<tr>
								<th>Numero de Serie:</th>
								<td><?=$rowListado['numSerie'];?></td>
							</tr>
							<?if($idProyecto==2){?>
							<tr>
								<th>Code type:</th>
								<td><?=$rowListado['codeType'];?></td>
							</tr>
							<tr>
								<th>FlowTag:</th>
								<td><?=$rowListado['flowTag']?></td>
							</tr>
							<?}?>
							<tr>
								<th>Técnico que reparo:</th>
								<?
									$TEC=$rowListado['id_tecnico'];
									$conTEC="SELECT * FROM userdbcontroloperaciones where ID=$TEC";
									$exeConTEC=mysql_query($conTEC,$this->conectarBd());
									$rowTEC=mysql_fetch_array($exeConTEC);
								?>
								<td><?=$rowTEC['nombre']." ".$rowTEC['apaterno'];?></td>
							</tr>
							<tr>
								<th>Tipo de Reparacion:</th>
								<?
									$TR=$rowListado['id_tipoReparacion'];
									$conTR="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion=$TR";
									$exeConTR=mysql_query($conTR,$this->conectarBd());
									$rowTR=mysql_fetch_array($exeConTR);
								?>
								<td><?=$rowTR['tipo_reparacion'];?></td>
							</tr>
						</table>
					</div>	
				<?
			
				}
			}
		}
		public function muestraInfo($idItem,$idProyecto,$idUserCC){
		?><div style="background:#fff; border:0px solid #000; padding:5px;margin:5px;font-family:Verdana, Geneva, sans-serif;text-align:justify;font-size:10px;"><?
		
			$found="SELECT detalle_lotes . * , detalleDYR . *
			FROM detalle_lotes INNER JOIN detalleDYR ON detalle_lotes.id_item = $idItem AND detalleDYR.id_item= $idItem";
			$exeFound=mysql_query($found,$this->conectarBd());
				if(!$exeFound){
					echo "<br>No se encuentra el detalle de esta orden intentelo de nuevo";
				}
				else{
					$rowFound=mysql_fetch_array($exeFound);
					$consCampos="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion='".$rowFound['id_tipoReparacion']."'";
					$exeConsCampos=mysql_query($consCampos,$this->conectarBd());
					$ArrayExeCampos=mysql_fetch_array($exeConsCampos);
					$campos=$ArrayExeCampos['camposMuestra'];
					$arrayCampos=explode(",",$campos);
					$totalArrayCampos=count($arrayCampos);
					$contenedorArray=Array();
					?><fieldset>
					<legend style="font-size:12px;font-weight:bold;">DIAGNOSTICO Y REPARACIÓN ITEM:</legend><table>
						<tr align="left">
							<th>Fabricante:</th>
							<?
							$idFab=$rowFound['id_fabricante'];
							$fab="SELECT * FROM CAT_fabricante WHERE id_fabricante=$idFab";
							$exeFab=mysql_query($fab,$this->conectarBd());
							$rowfoundFab=mysql_fetch_array($exeFab);
							?>
							<td><?=$rowfoundFab['nombre_fabricante'];?></td>
							<td>&nbsp;</td>
						</tr>
						<tr align="left">
							<th>tipo de Reparacion:</th>
							<td><?=$ArrayExeCampos['tipo_reparacion']?></td>
							<td>(<?=$ArrayExeCampos['descripcion']?>)</td>
						</tr><?
						for($i=0;$i<$totalArrayCampos;$i++){
							$divideCampo=explode("-",$arrayCampos[$i]);
							if($divideCampo[1]==1){
								$contenedorArray[$i]="id_".$divideCampo[0];
								$valDatos=$rowFound[$contenedorArray[$i]];
								$usar=$divideCampo[0];
								$usArr=str_split($usar);
								$nomCompleto=array();
								array_push($nomCompleto, strtoupper($usArr[0]));
								for($re=1;$re<count($usArr);$re++){
									$cha=$usArr[$re];
									if(ord($cha)>=65 && ord($cha)<=95){
										array_push($nomCompleto," ");
										array_push($nomCompleto,strtoupper($usArr[$re]));
									}else{
										array_push($nomCompleto,$usArr[$re]);
									}

								}
								$cadNomCom=implode("", $nomCompleto);
								$CatName="CAT_".$usar;
								$muCon="SELECT * FROM $CatName where $contenedorArray[$i] IN ($valDatos) ";
								$exemuCon=mysql_query($muCon,$this->conectarBd());
								$CuentaCampo=mysql_num_rows($exemuCon);
								?>
									<tr align="left">
										<th rowspan="<?=$CuentaCampo?>"><?=$cadNomCom?></th>
										<?
										$j=0;
										while($rowExeMuCon=mysql_fetch_array($exemuCon)){
											if($j>0){
												?><tr><?
											}
											?>
											<td><?=strtoupper(utf8_encode($rowExeMuCon[1]))?></td>
											<?if($CatName=="CAT_refacciones"){?>
												<td>(<?=strtoupper(utf8_encode($rowExeMuCon[4]))?>)</td>
											<?}else{
												?><td>(<?=strtoupper(utf8_encode($rowExeMuCon[2]))?>)</td><?
											}
											if($j>0){
												?></tr><?
											}
											$j++;
										}
										?>
									</tr>
								<?
							}else{
								$contenedorArray[$i]=$divideCampo[0];
								if($contenedorArray[$i]!="FabRev"){
									$usArr=str_split($contenedorArray[$i]);
									$nomCompleto=array();
									array_push($nomCompleto, strtoupper($usArr[0]));
									for($re=1;$re<count($usArr);$re++){
										$cha=$usArr[$re];
										if(ord($cha)>=65 && ord($cha)<=95){
											array_push($nomCompleto," ");
											array_push($nomCompleto,strtoupper($usArr[$re]));
										}else{
											array_push($nomCompleto,$usArr[$re]);
										}

									}
									$cadNomCom=implode("", $nomCompleto);
								}else{
									$cadNomCom=$contenedorArray[$i];
								}
								?>
							<tr align="left">
								<th><?=$cadNomCom?></th>
								<?
								if($contenedorArray[$i]=='FabRev'){
									$unidad="Versión";
								}else{
									if(strripos($contenedorArray[$i],'Tiempo')===false){
										if(strripos($contenedorArray[$i],'Cantidad')===false){
											$unidad="";
										}else{
											$unidad="Piezas";
										}
										
									}
									else{
										$unidad="Horas";
									}
								}
								?>
								<td><?=$rowFound[$contenedorArray[$i]]?></td>
								<td><?=$unidad?></td>
							</tr>
							<?
							}
							
						}
						$idcommo=$rowFound['id_commodity'];
						
						
						?></table><?
					}
			?></fieldset>
		</div>
				<div id="muestraCHK" style="width: 98%; height:70%; padding: 5px; display;block; background: #FFFFFF; border: 0px solid #ff0000; border-color: #000;float:left;padding-left: 5px;text-align: justify;">
					<?$this->prueba1($idItem,$idProyecto,$idUserCC,$idcommo);?>
				</div>
			</div>
		<?
		}
		
		public function prueba1($idItem,$idProyecto,$idUserCC,$idcommo){
			
			$consCommodity="select * from CAT_commodity where id_commodity=$idcommo";
			$execonsCommodity=mysql_query($consCommodity,$this->conectarBd());
			$nomFilas=mysql_fetch_array($execonsCommodity);
			?>
			
			
			<form name="checklist">
			<div id="tituloCHK" style="height:20px; width: 98%; clear: both; text-align: center; font-size: 12px; background: #CECECE;font-weight: bold;padding:5px;margin:5px;">CHECK LIST <?=strtoupper($nomFilas["desc_esp"]);?></div></td></tr>
			<div id="muestraCHK" style="height: auto; width: 98%; text-align: justify; font-size: 12px;background: #FFF;font-weight: bold;padding:5px;">
				<div id="Encabezado" style="display:block; width:100%; height:40px;text-align: center;font-size: 12px;" >
					<div id="pregunta" style="width: 51.2%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;"> PRUEBA A VALIDAR</div>
					<div id="RSi" style="width: 24%;height: 30px;  padding-top: 8px; float:left;border: 1px solid #000;">SI</div>
					<div id="RNo" style="width: 24%;height: 30px;  padding-top: 8px; float:left;border: 1px solid #000;">NO</div>
				</div>
			
			
			
			<?
			$cu=1;
			$consPruebaCommo="SELECT * FROM detalle_prueba_commodity where id_commodity=$idcommo";
			$execonsPruebaCommo=mysql_query($consPruebaCommo,$this->conectarBd());
			$numFil=mysql_num_rows($execonsPruebaCommo);
			if($numFil==0){
				echo "No hay ningun registro....";
				
			}else{
			while($numRegis=mysql_fetch_array($execonsPruebaCommo)){
								
			$consPruebas="Select *from CAT_pruebas where id_prueba='".$numRegis["id_prueba"]."'";
			$execonsPruebas=mysql_query($consPruebas,$this->conectarBd());
			if(!$execonsPruebas){
				echo "No hay pruebas asociadas a este comodity";
				
			}else{
			?><!--<div id="contenedor" style="width:99%;height:99%;background:#fff;border:1px solid #ffffff;" onmouseover="cambiaColor(this);"  onmouseout="quitaColor(this);">--><?	
			while($numPruebas=mysql_fetch_array($execonsPruebas)){
			?>
			
			<div id="pruebas" style="width:100%; height:40px; text-align: justify;font-size: 10px;"  onmouseover="cambiaColor(this);" onmouseout="quitaColor(this);" > 
				
				<div id="preguntaPrueba" style=" display: block; width: 51.2%;;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;" >
					<label><?=$cu;?>.-</label>  <?=utf8_encode($numPruebas["nombre"]);?>
				</div>
				<div id="Si" style="width: 24%;height: 30px; padding-top: 8px;float:left; text-align: center;border: 1px solid #000;" >
						<input type="radio" name="prueba <?=$cu;?>" id="prueba <?=$cu;?>" value="Si"/>
						<input type="hidden" name="num_prueba" id="num_prueba" value="<?=$numPruebas["id_prueba"];?>" />
						<label></label>
				</div>
				<div id="No" style="width: 24%;height: 30px; padding-top: 8px;  float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="prueba <?=$cu;?>" id="prueba <?=$cu;?>" value="No"/>
						<input type="hidden" name="num_prueba" id="num_prueba" value="<?=$numPruebas["id_prueba"];?>" />
						<label></label>	
				</div>
				
			</div>
			
			<?
			$cu++;
			}
			
			}
			}
			}
			$statusPass='PASS';
			$statusNoPass='NO PASS';
			?>	
				<div id="otras2" style="clear: both;display:block; width:99.8%; height:50px;text-align: justify;font-size: 10px;">
					
					<div id="select" style="width: 100%;height: 50px; padding-top: 1px; float:left;border: 1px solid #000;text-align: justify;">
						<div id="title1" style="width: 98%;height: 10px;float:left;border: 1px solid #FFF;text-align: center;clear: both;">
							Aseguramiento de la calidad:
						</div>
						<div id="txtarea" style="width: 98%;height: 30px;float:left;border: 1px solid #FFF;text-align: center;clear: both;overflow: auto">
							<textarea id="aseguramientoCalidad" name="aseguramientoCalidad" style="width: 90%;height: 20px;" ></textarea>
						</div>
					</div>
				</div>
				<div id="observaciones" style="clear: both;display:block; width:99.8%; height:70px;text-align: justify;font-size: 10px;"> 
					<div id="texto" style="width: 100%;height: 50px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						<div id="title2" style="width: 98%;height: 10px;float:left;border: 1px solid #FFF;text-align: center;clear: both;">
							Observaciones:
						</div>
						<div id="txtarea" style="width: 98%;height: 30px;float:left;border: 1px solid #FFF;text-align: center;clear: both;overflow: auto">
							<textarea id="observacionesCC" name="observacionesCC" style="width: 90%;height: 20px;" ></textarea>
						</div>
					</div>
				</div>
				<div id="BotonesDIV" style="display:block; width:100%; height:auto;text-align: center;font-size: 10px;">
					<input type="button" name="pass" id="pass" value="PASS" style="font-size: 14px; width: 120px; height: 60px; padding: 10px; color: white; background:green; border: 1px solid green;" onclick="guardaDatos('<?=$idItem?>','<?=$idUserCC?>','<?=$statusPass?>','<?=$idProyecto?>');"/>
					<input type="button" name="no pass" id="cancelar" value="NO PASS"  style="font-size: 14px; width: 120px; height: 60px; padding: 10px; color: white; background: #ff0000; border:1px solid #ff0000;" onclick="guardaDatos('<?=$idItem?>','<?=$idUserCC?>','<?=$statusNoPass?>','<?=$idProyecto?>');" />
				</div>
			
				</form>
			
		<?
		}
		public function guardarDatos($idUserCC,$idItem,$statusCC,$obserCC,$asegcalidad,$idsprubsi,$idsprubno,$idProyecto){
			date_default_timezone_set("America/Mexico_City");
			$fechaCC=date('Y-m-d');
			$horaCC=date('G:i:s');
			$conRechaz="SELECT * FROM detalle_lotes WHERE id_item='".$idItem."'";
			$exeRechazos=mysql_query($conRechaz,$this->conectarBd());
			$rowRecha=mysql_fetch_array($exeRechazos);
			$noRechazo=$rowRecha["cantRechazos"];
					
			
			$insertaDaCC="INSERT INTO detalleCC (id_item,id_inspector,fechaRevCC,horaRevCC,observacionesCC,pruebas_aceptadas,pruebas_rechazadas,status_cc,aseguramiento_cc) VALUES
			('".$idItem."','".$idUserCC."','".$fechaCC."','".$horaCC."','".$obserCC."','".$idsprubsi."','".$idsprubno."','".$statusCC."','".$asegcalidad."')";
			$exeInsertDaCC=mysql_query($insertaDaCC,$this->conectarBd());
			if(!$exeInsertDaCC){
				?><script type="text/javascript">alert("Su registro no se puedo guardar intente de nuevo");</script><?
				//exit;
			}
			else{
				if($statusCC=="PASS"){
					$otrostatus="Empaque";
					$cantRechazo=$noRechazo;
					//print_r($statusCC); exit;
				}else{
					$cantRechazo=$noRechazo+1;
					if($cantRechazo>=3){
						$otrostatus="SCRAP";
					}else{
						$peqCons="Select * from detalle_lotes where id_item=$idItem";
						$exepeqCons=mysql_query($peqCons,$this->conectarBd());
						$listadox=mysql_fetch_array($exepeqCons);
						$tipore=$listadox['id_tipoReparacion'];
										$conTR="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion=$tipore";
										$exeConTR=mysql_query($conTR,$this->conectarBd());
										$filatr=mysql_fetch_array($exeConTR);
										//$Status = ucwords(strtolower($status));
						$otrostatus="Diagnosticado_".ucwords(strtolower($filatr["tipo_reparacion"]));
					}
				}
				 $modStatus="UPDATE detalle_lotes SET status='".$otrostatus."', cantRechazos='".$cantRechazo."' WHERE id_item=$idItem";		
				$exeModStatus=mysql_query($modStatus,$this->conectarBd());
				?><script type="text/javascript">alert("Su registro fue guardado correctamente"); clean2("detalleEmpaque"); muestraLista('<?=$idProyecto?>','<?=$idUserCC?>')</script><?
			}
		}
		
		public function consultaXParametro($paraBusqueda,$valor){
			//echo $valor; exit;
			if($paraBusqueda=="numSerie"){
				$cons1="select*from detalle_lotes where numSerie='".$valor."' and status='CC'";
				$execons1=mysql_query($cons1,$this->conectarBd());
				$numBus=mysql_num_rows($execons1);
			$color="#F0F0F0";
			if($numBus==0){
				?><script type="text/javascript">alert("Por el momento no hay ningun ITEM con su parametro de busqueda ");
				$("#detalleEmpaque").html("");
				</script>
				<?
			}
			else{
				?>
				<div id="listadoItem" style="padding-top: 7px;background: #CCC;height: 30px; width:99%; text-align: center;font-weight: bold;clear: both; padding: 5px; margin: 5px; ">CONTROL DE CALIDAD <?=$rowName['nombre_proyecto'];?></div>
				<?while($busListado=mysql_fetch_array($execons1)){
				if($color=="#F0F0F0"){
						$color="#FFFFFF";
					}else{
						$color="#F0F0F0";
					}?>	
					<div id="showLote" style="background: <?=$color;?>;" onclick="muestraInfo('<?=$busListado['id_item']?>','<?=$idProyecto;?>','<?=$idUserCC;?>');"title="Da clic para contestar check List">
						<table>
							<tr>
								<th>Número de Parte:</th>
								<?
								$id_senc=$busListado['id_Senc'];
								$NumParte="SELECT * FROM CAT_SENC where id_SENC=$id_senc";
								$ejeNumParte=mysql_query($NumParte,$this->conectarBd());
								$numregis=mysql_fetch_array($ejeNumParte);
								?>
								<td><?=$numregis['NoParte'];?></td>
							</tr>
							<tr>
								<th>No. Lote:</th>
								<td><?=$busListado['id_lote'];?></td>
							</tr>
							<tr>
								<th>Modelo:</th>
								<td><?=$busListado['modelo'];?></td>
							</tr>
							<tr>
								<th>Numero de Serie:</th>
								<td><?=$busListado['numSerie'];?></td>
							</tr>
							<?if($idProyecto==2){?>
							<tr>
								<th>Code type:</th>
								<td><?=$busListado['codeType'];?></td>
							</tr>
							<tr>
								<th>FlowTag:</th>
								<td><?=$busListado['flowTag']?></td>
							</tr>
							<?}?>
							<tr>
								<th>Técnico que reparo:</th>
								<?
									$tec=$busListado['id_tecnico'];
									//echo $tec;
									$contec="SELECT * FROM userdbcontroloperaciones where ID=$tec";
									$execonte=mysql_query($contec,$this->conectarBd());
									$registe=mysql_fetch_array($execonte);
								?>
								<td><?=$registe['nombre']." ".$registe['apaterno'];?></td>
							</tr>
							<tr>
								<th>Tipo de Reparacion:</th>
								<?
									$w=$busListado['id_tipoReparacion'];
									$contr="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion=$w";
									$execontr=mysql_query($contr,$this->conectarBd());
									$regiTR=mysql_fetch_array($execontr);
								?>
								<td><?=$regiTR['tipo_reparacion'];?></td>
							</tr>
						</table>
					</div>	
				<?
			
				}
				
			}
			}
			if($paraBusqueda=="NoParte"){
				
				$cons2="select *from CAT_SENC, detalle_lotes where NoParte='".$valor."' and detalle_lotes.id_SENC=CAT_SENC.id_SENC and status='CC'"; 
				$execons2=mysql_query($cons2,$this->conectarBd());
				$numfilas=mysql_num_rows($execons2);
			$color="#F0F0F0";
			if($numfilas==0){
				?><script type="text/javascript">alert("Por el momento no hay ningun ITEM con su parametro de busqueda ");</script><?
			}
			else{
				?>
				<div id="listadoItem" style="padding-top: 7px;background: #CCC;height: 30px; width:99%; text-align: center;font-weight: bold;clear: both; padding: 5px; margin: 5px; ">CONTROL DE CALIDAD <?=$rowName['nombre_proyecto'];?></div>
				<?while($busqParte=mysql_fetch_array($execons2)){
				if($color=="#F0F0F0"){
						$color="#FFFFFF";
					}else{
						$color="#F0F0F0";
					}?>	
					<div id="showLote" style="background: <?=$color;?>;" onclick="muestraInfo('<?=$busqParte['id_item']?>','<?=$idProyecto;?>','<?=$idUserCC;?>');"title="Da clic para contestar check List">
						<table>
							<tr>
								<th>Número de Parte:</th>
								
								<td><?=$busqParte['NoParte'];?></td>
							</tr>
							<tr>
								<th>No. Lote:</th>
								<td><?=$busqParte['id_lote'];?></td>
							</tr>
							<tr>
								<th>Modelo:</th>
								<td><?=$busqParte['id_modelo'];?></td>
							</tr>
							<tr>
								<th>Numero de Serie:</th>
								<td><?=$busqParte['numSerie'];?></td>
							</tr>
							<?if($idProyecto==2){?>
							<tr>
								<th>Code type:</th>
								<td><?=$busqParte['codeType'];?></td>
							</tr>
							<tr>
								<th>FlowTag:</th>
								<td><?=$busqParte['flowTag']?></td>
							</tr>
							<?}?>
							<tr>
								<th>Técnico que reparo:</th>
								<?
									$T=$busqParte['id_tecnico'];
									//echo $tec;
									$C="SELECT * FROM userdbcontroloperaciones where ID=$T";
									$exeC=mysql_query($C,$this->conectarBd());
									$regisC=mysql_fetch_array($exeC);
								?>
								<td><?=$regisC['nombre']." ".$regisC['apaterno'];?></td>
							</tr>
							<tr>
								<th>Tipo de Reparacion:</th>
								<?
									$p=$busqParte['id_tipoReparacion'];
									$consX="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion=$p";
									$exeX=mysql_query($consX,$this->conectarBd());
									$regisX=mysql_fetch_array($exeX);
								?>
								<td><?=$regisX['tipo_reparacion'];?></td>
							</tr>
						</table>
					</div>	
				<?
				}
			
			}
			
				
			}
		}

	}//fin de la clase
	
