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
			//print_r($idUserCC); exit;
			$namePro="SELECT * FROM proyecto WHERE id_proyecto=$idProyecto";
			$exenamePro=mysql_query($namePro,$this->conectarBd());
			$rowName=mysql_fetch_array($exenamePro);
			$consultaCC="SELECT * FROM detalle_lote2 WHERE status='CC'";
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
					<div id="showDE" style="background: <?=$color;?>;" onclick="muestraInfo('<?=$rowListado['id_partes']?>','<?=$idProyecto;?>','<?=$idUserCC;?>');"title="Da clic para contestar check List">
						<table>
							<tr>
								<th>Número de Parte:</th>
								<td><?=$rowListado['Numparte'];?></td>
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
							<?/*if($roidPartewTR['tipo_reparacion']=='CO'||$rowTR=='AO'||$rowTR=='IR'||$rowTR=='WK'){?>
							<!--<tr>
								<th>Tipo de Fallas:</th>
								<td><?=$rowC['id_fallas'];?></td>
							</tr>
							<tr>
								<th>Descripción de Fallas</th>
								<?
								$TP=$rowListado['id_fallas'];
								print($TP);
								$TDF=Array();
								$conDF="SELECT * FROM CAT_fallas WHERE id_fallas IN ($TP)";
								$exeConDf=mysql_query($conDF,$this->conectarBd());
								$i=0;
								while($rowDF=mysql_fetch_array($exeConDF)){
									$TDF[$i]=$rowDF['descEspa'];
								}
								$TDFCOMAS=implode(",",$TDF);
								?>
								<td><?=$TDFCOMAS;?></td>
							</tr>
							<?//}*/?>
						</table>
					</div>	
				<?
			
				}
			}
		}
		public function muestraInfo($idParte,$idProyecto,$idUserCC){
		?><div><?
		
			$found="SELECT detalle_lote2 . * , detalleDYR . *
			FROM detalle_lote2 INNER JOIN detalleDYR ON (detalle_lote2.id_partes = $idParte AND detalleDYR.idParte= $idParte
			AND detalle_lote2.id_proyecto= $idProyecto AND detalleDYR.id_proyecto=$idProyecto)";
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
					//print_r($campos); exit;
					$arrayCampos=explode(",",$campos);
					$totalArrayCampos=count($arrayCampos);
					$contenedorArray=Array();
					?><fieldset>
					<legend>DIAGNOSTICO Y REPARACIÓN ITEM:</legend><table>
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
								$CatName="CAT_".$usar;
								$muCon="SELECT * FROM $CatName where $contenedorArray[$i] IN ($valDatos) ";
								$exemuCon=mysql_query($muCon,$this->conectarBd());
								$CuentaCampo=mysql_num_rows($exemuCon);
								?>
									<tr align="left">
										<th rowspan="<?=$CuentaCampo?>"><?=$usar?></th>
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
								?>
							<tr align="left">
								<th><?=$contenedorArray[$i]?></th>
								<?
								if($contenedorArray[$i]=='FabRev'){
									$unidad="Versión";
								}else{
									if(strpbrk($contenedorArray[$i],'Time')>=0){
										$unidad="Horas";
									}
									if(strpbrk($contenedorArray[$i],'Cantidad')>=0){
										$unidad="Piezas";
									}
								}
								?>
								<td><?=$rowFound[$contenedorArray[$i]]?></td>
								<td><?=$unidad?></td>
							</tr>
							<?
							}
							
						}
						?></table><?
					}
			?></fieldset>
		</div>
				<div id="muestraCHK" style="width: 97%; height:70%; padding: 5px; display;block; background: #FFFFFF; border: 0px; border-color: #000;float:left;padding-left: 5px;text-align: justify;">
					<?$this->prueba1($idParte,$idProyecto,$idUserCC,$idGrupo);?>
				</div>
			</div>
		<?
		}
		
		public function prueba1($idParte,$idProyecto,$idUserCC,$idGrupo){
			$idGrupo=2;
			?>
			<script type="text/javascript">
				var arrayLCD=['pinturaOriginal','texturaUniforme','serigrafia','rayones','partesRotas','rayadoMarcado','faltanPiezas','limpio','botonesBuenEstado','enciende','datosEtiqueta','pruebasFuncionales','empaque','datosEquipo'];
				var arrayHD=['bolsaConductiva','faltanPiezas','limpio','datosEtiqueta','pruebasFuncionales','empaque','formateado'];
				var arrayMB=['bolsaConductiva','faltanPiezas','limpio','componentesDañados','partesDesoldadas','soldaduras','holograma','scanearEtiqueta','realizarPruebas','pruebasFuncionales','empaque','datosEquipo'];
				var aux=arrayLCD.concat(arrayHD,arrayMB);
				for(var p=0;p<aux.length;p++){
					$("#"+aux[p]).hide();
				}
			</script>
			<form name="checklist">
			<?
			if($idGrupo==1){
				?>
				<script type="text/javascript">
					alert("Este es un LCD");
				for(var j=0;j<arrayHD.length;j++){
					$("#"+arrayHD[j]).hide();
				}
				for(var k=0;k<arrayMB.length;k++){
					$("#"+arrayMB[k]).hide();
				}
				for(var i=0;i<arrayLCD.length;i++){
					$("#"+arrayLCD[i]).show();
				}
				</script>
			<?}
			if($idGrupo==3){
				?>
				<script type="text/javascript">
					alert("Este es un HD");
				for(var i=0;i<arrayLCD.length;i++){
					$("#"+arrayLCD[i]).hide();
				}
				for(var k=0;k<arrayMB.length;k++){
					$("#"+arrayMB[k]).hide();
				}
				for(var j=0;j<arrayHD.length;j++){
					$("#"+arrayHD[j]).show();
				}
				</script>
				<?
			}
			if($idGrupo==2){
				?>
				<script type="text/javascript">
					alert("este es un MB");
				for(var i=0;i<arrayLCD.length;i++){
					$("#"+arrayLCD[i]).hide();
				}
				for(var j=0;j<arrayHD.length;j++){
					$("#"+arrayHD[j]).hide();
				}
				for(var k=0;k<arrayMB.length;k++){
					if(<?=$idProyecto;?>!='2' && arrayMB[k]=='holograma'){
						$("#"+arrayMB[k]).hide()
					}
					else{
					$("#"+arrayMB[k]).show();
					}
				}
				</script>
				<?
			}
			?>
			
			<div id="tituloCHK" style="height:20px; width: 98%; clear: both; text-align: center; font-size: 12px; background: #CECECE;font-weight: bold;padding-top: 5px;">CHECK LIST LCD</div>
			<div id="muestraCHK" style="height: auto; width: 100%; text-align: justify; font-size: 12px;background: #FFF;font-weight: bold;">
				<div id="Encabezado" style="display:block; width:100%; height:auto;text-align: center;font-size: 12px;">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;"> Elemento a Verificar</div>
					<div id="RSi" style="width: 24%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;">SI</div>
					<div id="RNo" style="width: 24%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;">NO</div>
				</div>
				<div id="pinturaOriginal" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntapinturaOriginal" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿El tono de la pintura coincide con la original?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="pinturaOriginalRd" id="pinturaOriginalRd" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="pinturaOriginalRd" id="pinturaOriginalRd" value="No"/>
					</div>
				</div>
				<div id="texturaUniforme" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntatexturaUniforme" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Textura Uniforme y se apega a la textura original?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="texturaOriginal" id="texturaOriginal" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="texturaOriginal" id="texturaOriginal" value="No"/>
					</div>
				</div>
				<div id="serigrafia" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntaserigrafia" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿La serigrafía esta Dañada?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="serigrafia" id="serigrafia" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="serigrafia" id="serigrafia" value="No"/>
					</div>
				</div>
				<div id="rayones" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntarayones" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Trae rayones, tallones, decoraciones, o manchas en partes pintadas?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="rayones" id="rayones" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="rayones" id="rayones" value="No"/>
					</div>
				</div>
				<div id="partesRotas" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntapartesRotas" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Trae partes rotas?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="partesRotas" id="partesRotas" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="partesRotas" id="partesRotas" value="No"/>
					</div>
				</div>
				<div id="rayadoMarcado" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntarayadoMarcado" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Se encuentra rayada o marcada la pantalla?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="rayadoMarcado" id="rayadoMarcado" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="rayadoMarcado" id="rayadoMarcado" value="No"/>
					</div>
				</div>
				<div id="faltanPiezas" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntafaltanPiezas" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Le faltan piezas?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="faltanPiezas" id="faltanPiezas" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="faltanPiezas" id="faltanPiezas" value="No"/>
					</div>
				</div>
				<div id="limpio" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntalimpio" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Se encuentra limpio?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="limpio" id="limpio" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="limpio" id="limpio" value="No"/>
					</div>
				</div>
				<div id="botonesBuenEstado" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntabotonesBuenEstado" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Los botones se encuentran en buen estado cosmetico y funcional?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="botonesBuenEstado" id="botonesBuenEstado" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="botonesBuenEstado" id="botonesBuenEstado" value="No"/>
					</div>
				</div>
				<div id="enciende" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="preguntaenciende" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿El ITEM enciende?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="enciende" id="enciende" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="enciende" id="enciende" value="No"/>
					</div>
				</div>
				<div id="datosEtiqueta" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Los datos de la etiqueta coinciden con los del equipo?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="datosEtiqueta" id="datosEtiqueta" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="datosEtiqueta" id="datosEtiqueta" value="No"/>
					</div>
				</div>
				<div id="pruebasFuncionales" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Paso las pruebas funcionales(sensibilidad y usuario)?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="pruebasFuncionales" id="pruebasFuncionales" value="Si">
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="pruebasFuncionales" id="pruebasFuncionales" value="No"/>
					</div>
				</div>
				<div id="empaque" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿La parte se encuentra correctamente empacada?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="empaque" id="empaque" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="empaque" id="empaque" value="No"/>
					</div>
				</div>
				<div id="datosEquipo" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Coinciden los datos de la etiqueta con los impresos en la etiqueta del equipo?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="datosEquipo" id="datosEquipo" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="datosEquipo" id="datosEquipo" value="No"/>
					</div>
				</div>
				<div id="bolsaConductiva" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿La parte se encuentra dentro de su bolsa coductiva sin generadores de estatica dentro?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="bolsaConductiva" id="bolsaConductiva" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="bolsaConductiva" id="bolsaConductiva" value="No"/>
					</div>
				</div>
				<div id="formateado" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Dispositivo Formateado (A peticion del cliente)?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="formateado" id="formateado" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="formateado" id="formateado" value="No"/>
					</div>
				</div>
				<div id="componentesDañados" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Contiene componentes dañados?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="componentesDañados" id="componentesDañados" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="componentesDañados" id="componentesDañados" value="No"/>
					</div>
				</div>
				<div id="partesDesoldadas" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Tiene partes desoldadas?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="partesDesoldadas" id="partesDesoldadas" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="partesDesoldadas" id="partesDesoldadas" value="No"/>
					</div>
				</div>				
				<div id="soldaduras" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Trae soldaduras frías o excesos de soldaduras?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="soldaduras" id="soldaduras" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="soldaduras" id="soldaduras" value="No"/>
					</div>
				</div>
				<!--******Solo para R&B(START)******-->
				<div id="holograma" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Trae holograma y etiqueta?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="holograma" id="holograma" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="holograma" id="holograma" value="No"/>
					</div>
				</div>
				<!--******Solo para R&B(END)******-->
				<div id="scanearEtiqueta" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Se puede escanear la etiqueta?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="scanearEtiqueta" id="scanearEtiqueta" value="Si"/>
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="scanearEtiqueta" id="scanearEtiqueta" value="No"/>
					</div>
				</div>				
				<div id="realizarPruebas" style="display:none; width:100%; height:auto;text-align: justify;font-size: 10px; ">
					<div id="pregunta" style="width: 49%;height: 30px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						¿Se realizaron pruebas funcionales?
					</div>
					<div id="Si" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="realizarPruebas" id="realizarPruebas" value="Si">
					</div>
					<div id="No" style="width: 24%;height: 30px; padding-top: 8px; float:left; text-align: center;border: 1px solid #000;">
						<input type="radio" name="realizarPruebas" id="realizarPruebas" value="No"/>
					</div>
				</div>
				<div id="otras2" style="clear: both;display:block; width:100%; height:50px;text-align: justify;font-size: 10px;">
					<div id="select" style="width: 49%;height: 50px; padding-top: 0px; float:left;border: 1px solid #000;text-align: justify;">
						<div id="pregunta" style="width: 98%;height: 10px;float:left;border: 1px solid #FFF;text-align: center;clear: both;">
							Status del ITEM:
						</div>
						<div id="pregunta" style="width: 98%;height: 10px;float:left;border: 1px solid #FFF;text-align: center;">
							<select name="statusCC" id="statusCC">
								<option value="x">Seleccione Status</option>
								<?
								$conSt="SELECT * FROM configuracionglobal WHERE nombreConf='statusCC'";
								$exConST=mysql_query($conSt,$this->conectarBd());
								$rowST=mysql_fetch_array($exConST);
								$valor=$rowST['valor'];
								$valor1=explode("|",$valor);
								$total=count($valor1);
								for($i=0;$i<$total;$i++){
								?>
									<option value="<?=$valor1[$i];?>"><?=$valor1[$i];?></option>
								<?
								}
								?>
							</select>
						</div>
					</div>
					<div id="select" style="width: 48%;height: 50px; padding-top: 0px; float:left;border: 1px solid #000;text-align: justify;">
						<div id="pregunta" style="width: 98%;height: 10px;float:left;border: 1px solid #FFF;text-align: center;clear: both;">
							Aseguramiento de la calidad:
						</div>
						<div id="txtarea" style="width: 98%;height: 30px;float:left;border: 1px solid #FFF;text-align: center;clear: both;overflow: auto">
							<textarea id="aseguramientoCalidad" name="aseguramientoCalidad" style="width: 90%;height: 20px;" ></textarea>
						</div>
					</div>
				</div>
				<div id="observaciones" style="clear: both;display:block; width:100%; height:70px;text-align: justify;font-size: 10px;">
					<div id="pregunta" style="width: 98%;height: 50px; padding-top: 8px; float:left;border: 1px solid #000;text-align: justify;">
						<div id="pregunta" style="width: 98%;height: 10px;float:left;border: 1px solid #FFF;text-align: center;clear: both;">
							Observaciones:
						</div>
						<div id="txtarea" style="width: 98%;height: 40px;float:left;border: 1px solid #FFF;text-align: center;clear: both;overflow: auto">
							<textarea id="observacionesCC" name="observacionesCC" style="width: 90%;height: 20px;" ></textarea>
						</div>
					</div>
				</div>
				<div id="BotonesDIV" style="display:block; width:100%; height:auto;text-align: center;font-size: 10px; ">
					<input type="button" name="aceptar" id="aceptar" value="Guardar" onclick="confirmar();guardaDatosPrueba1('<?=$idParte?>','<?=$idProyecto?>','<?=$idUserCC?>','<?=$idGrupo?>');"/>
					<input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="confirmarSalir();muestraLista('<?=$idProyecto?>','<?=$idUserCC?>');"/>
				</div>
				</form>
					<?
		}
		public function guardarDatos($idProyecto,$idUserCC,$idParte,$idLote,$cosmetica,$limpieza,$piezasFaltantes,$partesSueltas,$pantallaFisica,$enciende,$serial,$saHDMI,$saDVI,$bocinas,$pruebaFunc,$inspID,$statusCC,$date,$hr,$min,$obserCC){
			date_default_timezone_set("America/Mexico_City");
			$fechaCC=date('Y-m-d');
			$horaCC=date('G:i:s');
			$hrEmpaque=$hr.":".$min;
			$insertaDaCC="INSERT INTO detalleRevCC (idParte,idProyecto,idLote,idUserCapturo,idInspector,status,fechaCC,horaCC,observacionesCC,cosmetica,limpieza,piezasFaltantes,partesSueltas,pantallaFisica,enciende,serial,salidaHDMI,salidaDVI,bocinas,pruebaFuncional,fechaEmpaque,horaEmpaque) VALUES
			('".$idParte."','".$idProyecto."','".$idLote."','".$idUserCC."','".$inspID."','".$statusCC."','".$fechaCC."','".$horaCC."','".$obserCC."','".$cosmetica."','".$limpieza."','".$piezasFaltantes."','".$partesSueltas."','".$pantallaFisica."','".$enciende."','".$serial."','".$saHDMI."','".$saDVI."','".$bocinas."','".$pruebaFunc."','".$date."','".$hrEmpaque."')";
			$exeInsertDaCC=mysql_query($insertaDaCC,$this->conectarBd());
			if(!$exeInsertDaCC){
				?><script type="text/javascript">alert("Su registro no se puedo guardar intente de nuevo");</script><?
				exit;
			}
			else{
				if($statusCC=="No Ok"){
					$statusCC=str_replace(" ","_",$statusCC);
				}else{}
				$cd="Empaque_".$statusCC;
				$modStatus="UPDATE detalle_lote2 SET status=$cd WHERE id_partes=$idParte AND status='CC'";
				$exeModStatus=mysql_query($modStatus,$this->conectarBd());
				?><script type="text/javascript">alert("Su registro fue guardado correctamente");
				clean2("detalleEmpaque"); muestraLista('<?=$idProyecto?>','<?=$idUserCC?>')</script><?
			}
		}
				
			/*public function muestraReporte($idParte,$idProyecto,$idUserCC){
			$consultaDatos="SELECT * FROM detalle_lote WHERE id_partes=$idParte AND id_proyecto=$idProyecto";
			$exeConsultaDatos=mysql_query($consultaDatos,$this->conectarBd());
			$rowC=mysql_fetch_array($exeConsultaDatos);
			$idLote=$rowC['id_lote'];
			?>
				<!--<div id="contenedorCKL" style="width: 98%; height: 100%; overflow: auto; border:1px; background: #fff;">
					<div id="infoITEM" style="width:100%; height: 40px;background: #DDD; text-align: right;font-size: 12px;">
					</div>
				</div>-->
				<fieldset>
					<legend>CHECK LIST</legend>
					<form name="checkList" id="checkList">
					<table align="left">
						<tr align="center">
							<th>#</th>
							<th>Sí</th>
							<th>No</th>
							<th>N/A</th>
							<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
							<th>#</th>
							<th>Sí</th>
							<th>No</th>
							<th>N/A</th>
							
						</tr>
						<tr>
							<th align="left">Cosmética:</th>
							<td><input type="radio" name="cosmetica" id="cosmetica" value="Si"/></td>
							<td><input type="radio" name="cosmetica" id="cosmetica" value="No"/></td>
							<td><input type="radio" name="cosmetica" id="cosmetica" value="N/A"/></td>
							<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
							<th align="left">Limpieza:</th>
							<td><input type="radio" name="limpieza" id="limpieza" value="Si"/></td>
							<td><input type="radio" name="limpieza" id="limpieza" value="No"/></td>
							<td><input type="radio" name="limpieza" id="limpieza" value="N/A"/></td>
						</tr>
						<tr>
							
							<th align="left">Piezas Faltantes:</th>
							<td><input type="radio" name="piezasFaltantes" id="piezasFaltantes" value="Si"/></td>
							<td><input type="radio" name="piezasFaltantes" id="piezasFaltantes" value="No"/></td>
							<td><input type="radio" name="piezasFaltantes" id="piezasFaltantes" value="N/A"/></td>
							<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
							<th align="left">Partes Sueltas:</th>
							<td><input type="radio" name="partesSueltas" id="partesSueltas" value="Si"/></td>
							<td><input type="radio" name="partesSueltas" id="partesSueltas" value="No"/></td>
							<td><input type="radio" name="partesSueltas" id="partesSueltas" value="N/A"/></td>
						</tr>
						<tr>
							<th align="left">Pantalla Física:</th>
							<td><input type="radio" name="pantallaFisica" id="pantallaFisica" value="Si"/></td>
							<td><input type="radio" name="pantallaFisica" id="pantallaFisica" value="No"/></td>
							<td><input type="radio" name="pantallaFisica" id="pantallaFisica" value="N/A"/></td>
							<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
							<th align="left">Enciende:</th>
							<td><input type="radio" name="enciende" id="enciende" value="Si"/></td>
							<td><input type="radio" name="enciende" id="enciende" value="No"/></td>
							<td><input type="radio" name="enciende" id="enciende" value="N/A"/></td>
						</tr>
						<tr>
							<th align="left">Serial:</th>
							<td><input type="radio" name="serial" id="serial" value="Si"/></td>
							<td><input type="radio" name="serial" id="serial" value="No"/></td>
							<td><input type="radio" name="serial" id="serial" value="N/A"/></td>
							<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
							<th align="left">Salida HDMI:</th>
							<td><input type="radio" name="saHDMI" id="saHDMI" value="Si"/></td>
							<td><input type="radio" name="saHDMI" id="saHDMI" value="No"/></td>
							<td><input type="radio" name="saHDMI" id="saHDMI" value="N/A"/></td>
						</tr>
						<tr>
							<th align="left">Salida DVI:</th>
							<td><input type="radio" name="saDVI" id="saDVI" value="Si"/></td>
							<td><input type="radio" name="saDVI" id="saDVI" value="No"/></td>
							<td><input type="radio" name="saDVI" id="saDVI" value="N/A"/></td>
							<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
							<th align="left">Bocinas:</th>
							<td><input type="radio" name="bocinas" id="bocinas" value="Si"/></td>
							<td><input type="radio" name="bocinas" id="bocinas" value="No"/></td>
							<td><input type="radio" name="bocinas" id="bocinas" value="N/A"/></td>
						</tr>
						<tr>
							<th align="left">Prueba Funcional:</th>
							<td><input type="radio" name="pruebaFunc" id="pruebaFunc" value="Si"/></td>
							<td><input type="radio" name="pruebaFunc" id="pruebaFunc" value="No"/></td>
							<td><input type="radio" name="pruebaFunc" id="pruebaFunc" value="N/A"/></td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend>Group</legend>
						<table>
							<tr align="left">
								<th>Inspector:</th>
								<td>
									<select name="inspID" id="inspID">
										<option value="0">Selecciona Inspector</option>
										<?
										$conIns="SELECT * FROM userdbcontroloperaciones WHERE nivel_acceso=4";
										$exConIns=mysql_query($conIns,$this->conectarBd());
										 while($rowIns=mysql_fetch_array($exConIns)){
											?>
											<option value="<?=$rowIns['ID'];?>"><?=$rowIns['nombre']." ".$rowIns['apaterno']?></option>
											<?
										 }
										?>
										
									</select>
							</tr>
							<tr align="left">
								<th>Status</th>
								<td>
									<select name="statusCC" id="statusCC">
										<option value="0">Selecciona Status</option>
										<?
										$conSt="SELECT * FROM configuracionglobal WHERE nombreConf='statusCC'";
										$exConST=mysql_query($conSt,$this->conectarBd());
										$rowST=mysql_fetch_array($exConST);
										$valor=$rowST['valor'];
										$valor1=explode("|",$valor);
										$total=count($valor1);
										for($i=0;$i<$total;$i++){
											?>
											<option value="<?=$valor1[$i];?>"><?=$valor1[$i];?></option>
											<?
										}
										?>
									</select>
									
								</td>
							</tr>
							<?
							date_default_timezone_set("America/Mexico_City");
							$DATE=date('Y-m-d');
							$HOUR=date('G:i:s');
							?>
							<tr align="left">
								<th>Fecha de Empaque:</th>
								<td><input type="text" name="date" id="date" value="<?=$DATE;?>"><input type="button" id="lanzador1" value="..." />
									<!-- script que define y configura el calendario-->
									<script type="text/javascript">
											Calendar.setup({
											inputField     :    "date",      // id del campo de texto
											ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
											button         :    "lanzador1"   // el id del botón que lanzará el calendario
											});
									</script></td>  
							</tr>
							<tr aling="text">
								<?
								$hr=date('G');
								$min=date('i');
								?>
								<th>Hora de Empaque:</th>
								<td>
									<select name="href" id="hr">
										<option value="<?=$hr;?>"><?=$hr;?></option>
										<?
										for($i=0;$i<=24;$i++){
											if($i<10){
												$i1='0'.$i;
												?>
												<option value="<?=$i1;?>"><?=$i1;?></option>
												<?
											}
											else{
												?>
												<option value="<?=$i;?>"><?=$i;?></option>
												<?
											}
										}
										?>
									</select>
									:
									<select name="min" id="min">
										<option value="<?=$min?>"><?=$min;?></option>
										<?
										for($j=0;$j<=60;$j++){
											if($j<10){
												$j1='0'.$j;
												?>
												<option value="<?=$j1;?>"><?=$j1;?></option>
												<?
											}
											else{
												?>
												<option value="<?=$j;?>"><?=$j;?></option>
												<?
											}
										}
										?>
									</select>

								</td>
							</tr>
							<tr>
								<th>Observaciones</th>
								<td><textarea name="obserCC" id="obserCC" maxlength="200"></textarea></td>
							</tr>
							
						</table>
						<p align="right"><th colspan="2"><input type="button" name="guarda" id="guarda" value="Guardar" onclick="confirmar();guardaDatos('<?=$idParte?>','<?=$idProyecto?>','<?=$idUserCC?>','<?=$idLote?>');"><input type="reset" name="borrar" id="borrar" value="Borrar"></th></p>
					</form>
				</fieldset>
		<?
		}*/
	}//fin de la clase
