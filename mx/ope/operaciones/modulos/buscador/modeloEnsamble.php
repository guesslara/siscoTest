<?

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



                public function consultaXParametro($seleccion,$serieOParte){
			//echo $valor; exit;
			if($seleccion=="numSerie"){
				$cons1="select*from detalle_lotes where numSerie='".$serieOParte."'";
				
                        }
                        
                        if($seleccion=="NoParte"){
				
				$cons1="select *from CAT_SENC, detalle_lotes where NoParte='".$serieOParte."' and detalle_lotes.id_SENC=CAT_SENC.id_SENC"; 
				
                        }
                        
                        $execons1=mysql_query($cons1,$this->conectarBd());
			    $numfilas=mysql_num_rows($execons1);
			
                        $color="#F0F0F0";
			if($numfilas==0){
				?><script type="text/javascript">alert("Por el momento no hay ningun ITEM con su parametro de busqueda ");</script><?
			}
			else{
				?>
				<div id="listadoItem" style="padding-top: 3px;background: #848484;height: 20px; width:98%; text-align: center;font-weight: bold;clear: both; padding: 5px;">RESULTADOS OBTENIDOS....</div>
				<? 
				while($busqParte=mysql_fetch_array($execons1)){
					$nomDiv="muestraMas".$busqParte["id_item"];
					$nomcont="contDYR".$busqParte["id_item"];
					$divCC="muestraOtro".$busqParte["id_item"];
					$conCC="contCC".$busqParte["id_item"];
					
				if($color=="#F0F0F0"){
						$color="#FFFFFF";
					}else{
						$color="#F0F0F0";
					}?>
                                        <div id="detallesItem" style="background: #BDBDBD; height: 20px; width:98%; text-align: center;font-weight: bold;clear: both; padding: 5px;">DETALLES DEL ITEM </div>
					<div id="showLote" style="background: <?=$color;?>; width: 98%;" >
						<table>
							<?
							if($seleccion=="numSerie"){
							$nPart="select * from CAT_SENC where id_SENC='".$busqParte['id_Senc']."'";
							$exenPart=mysql_query($nPart,$this->conectarBd());
							$Parteregis=mysql_fetch_array($exenPart);
							?><tr>
								<th>Número de Parte:</th>
								
								<td><?=$Parteregis['NoParte'];?></td>
							</tr>
							<?
							}else{
							?><tr>
								<th>Número de Parte:</th>
								
								<td><?=$busqParte['NoParte'];?></td>
							</tr>
							<?
							}
							?>
							
							<tr>
								<th>No. Lote:</th>
								<td><?=$busqParte['id_lote'];?></td>
							</tr>
							<tr>
								<th>Modelo:</th>
							<?
							$idModelo=$busqParte['id_modelo'];
							$conMod="SELECT * FROM CAT_modelo WHERE id_modelo=$idModelo";
							$exeMod=mysql_query($conMod,$this->conectarBd());
							$con=mysql_num_rows($exeMod);
							if($con==0){
								$msjM="No tiene asignado un modelo";
							}else{
								$AMo=mysql_fetch_array($exeMod);
								$msjM=$AMo['modelo'];
							}
							?>
								<td><?=$msjM;?></td>
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
                                                                        if($T==0){?>
                                                                           <td><?echo "N/A";?></td>
                                                                        <?}else{
									//echo $tec;
									$C="SELECT * FROM userdbcontroloperaciones where ID=$T";
									$exeC=mysql_query($C,$this->conectarBd());
									$regisC=mysql_fetch_array($exeC);
								?>
								<td><?=$regisC['nombre']." ".$regisC['apaterno']; }?></td>
							</tr>
							<tr>
								<th>Tipo de Reparacion:</th>
								<?
									$p=$busqParte['id_tipoReparacion'];
                                                                         if($p ==""){?>
                                                                           <td><?echo "N/A";?></td>
                                                                        <?}else{
									$consX="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion=$p";
									$exeX=mysql_query($consX,$this->conectarBd());
									$regisX=mysql_fetch_array($exeX);
								?>
								<td><?=$regisX['tipo_reparacion']; }?></td>
							</tr>
                                                        <tr>
                                                                <th>Status ITEM:</th>
                                                                <td><?=$busqParte['status']?></td>
                                                        </tr>
                                                        <tr>
                                                                <th>Fecha registro ITEM:</th>
                                                                <td><?=$busqParte['fecha_registro']?></td>
                                                        </tr>
                                                                <?
                                                                    $lote=$busqParte['id_lote'];
                                                                    $conslote="select num_po from lote where id_lote=$lote";
                                                                    $execonslote=mysql_query($conslote,$this->conectarBd());
                                                                    $registro=mysql_fetch_array($execonslote);
                                                                    if($idProyecto==1){?>
                                                        <tr>
                                                                <th align="left">No.Pre-Alerta:</th>
                                                                <td><?=$registro['num_po'];?></td>
                                                        </tr>
                                                                    <?}else{?>
                                                        <tr>
                                                                <th align="left">No. PO:</th>
                                                                <td><?=$registro['num_po']; }?></td>
                                                        </tr>
                                                    
                                                                
                                                </table>
                                                
                                        </div>
                                <div id="diagnostico" style=" padding-top: 4px; width: 98%; height: 15px; background: #CCC; margin-right:5px;margin-left: 5px; font-size:8px; font-weight: bold; padding-left: 1.5px; border: 1px solid gray; margin-bottom: 5px;">DIAGNOSTICO Y REPARACION<a href="#" onclick="detalles_dyr('<?=$busqParte['id_item']?>');" style="margin-left: 670px; font-size: 7px;">Ver Más</a></div>
				
				<div id="<?=$nomDiv?>" style="width:98% height:auto; display: none;clear: both;">
					<div id="barraDYR" style=" margin-left: 5px; width: 98%; height: 15px;background: #000;text-align: right;"><a href="#" onclick="cerrar('<?=$nomDiv?>');"><img src="../../img/close2.gif"></a></div>
					<div id="<?=$nomcont?>"> </div>
				</div>
				
				<div id="CC" style="  padding-top: 4px; width: 98%;  height: 10px;  height: 15px; background: #ccc; margin-right: 5px; margin-left: 5px; font-size: 8px; font-weight: bold; padding-left: 1.5px; border: 1px solid gray; "> CONTROL DE CALIDAD <a href="#" onclick="detalles_cc('<?=$busqParte['id_item']?>');" style="margin-left: 700px; font-size: 7px;">Ver Más</a></div>
				<div id="<?=$divCC?>" style="width:98% height:auto; display: none;clear: both;">
					<div id="barraCC" style="  margin-left: 5px; width: 98%; height: 15px;background: #000;text-align: right;"><a href="#" onclick="cerrar('<?=$divCC?>');"><img src="../../img/close2.gif"></a></div>
					<div id="<?=$conCC?>" style="margin-left: 5px;"></div>
				
				</div>
				<div id="separador" style="width: 98%  height: 20px; background: #fff; margin-bottom: 20px; display: block; clear: both;"></div>
				<?
				
				}
				
				
				
			
			}
			
				
			
		}
		public function busdetallesdyr($idItem){
			
			$consDR="SELECT detalle_lotes . * , detalleDYR . *
			FROM detalle_lotes INNER JOIN detalleDYR ON detalle_lotes.id_item = $idItem AND detalleDYR.id_item= $idItem";
			$execonsDR=mysql_query($consDR,$this->conectarBd());
			
			if(!$execonsDR){
				?><script type="text/javascript">alert("El item aún no  se encuentra en diagnostico");</script><?

			}else{
				$rowDiagnostico=mysql_fetch_array($execonsDR);
				$consCampos="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion='".$rowDiagnostico['id_tipoReparacion']."'";
				$exeConsCampos=mysql_query($consCampos,$this->conectarBd());
				$ArrayExeCampos=mysql_fetch_array($exeConsCampos);
				$campos=$ArrayExeCampos['camposMuestra'];
				$arrayCampos=explode(",",$campos);
				$totalArrayCampos=count($arrayCampos);
				$contenedorArray=Array();
				
				?>
				
				
				<div id="showDYR" style="background:#FFF; width: 98%; margin-left: 5px; padding-top: 7px;" >
					<table>
						<tr align="left">
							<th>Fabricante:</th>
							<?
							$idFab=$rowDiagnostico['id_fabricante'];
							if($idFab==""){
								?>
								<td>S/N</td>
								<?
							}
							else{
							$fab="SELECT * FROM CAT_fabricante WHERE id_fabricante=$idFab";
							$exeFab=mysql_query($fab,$this->conectarBd());
							$rowfoundFab=mysql_fetch_array($exeFab);
							?>
							<td><?=$rowfoundFab['nombre_fabricante']; }?></td>
							<td>&nbsp;</td>
						</tr>
						<tr align="left">
							<th>tipo de Reparacion:</th>
							<?
							if($rowDiagnostico['id_tipoReparacion']==""){?>
								<td>No hay tipo de reparación</td>
								<td>(Ninguna descripción)</td>
								
							<?}else{?>
							<td><?=$ArrayExeCampos['tipo_reparacion']?></td>
							<td>(<?=$ArrayExeCampos['descripcion']?>)</td>
							<?}
							?>	
						</tr><?
						for($i=0;$i<$totalArrayCampos;$i++){
							$divideCampo=explode("-",$arrayCampos[$i]);
							if($divideCampo[1]==1){
								$contenedorArray[$i]="id_".$divideCampo[0];
								$valDatos=$rowDiagnostico[$contenedorArray[$i]];
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
								<td><?=$rowDiagnostico[$contenedorArray[$i]]?></td>
								<td><?=$unidad?></td>
							</tr>
							<?
							}
							
						}
						
						?></table>
						</div><?
				
				}
						
				
			
				
			}
			
		public function busCC($idItem){
			
			
					
			$chkList="SELECT detalle_lotes . * , detalleCC . *
			FROM detalle_lotes INNER JOIN detalleCC ON detalle_lotes.id_item =$idItem AND detalleCC.id_item=$idItem";
			$exeChk=mysql_query($chkList,$this->conectarBd());
			if(mysql_num_rows($exeChk)==0){?>
				<p align="center" style="font-size: 10px; font-weight: bold;">"EL ITEM AÚN NO SE ENCUENTRA EN PROCESO DE CALIDAD"</p>
			<?}else{
			$rowChk=mysql_fetch_array($exeChk);
			$acep=$rowChk["pruebas_aceptadas"];
			$arrayAcep=explode(",",$acep);
			$imConsultaAce=implode("','",$arrayAcep);
					$rech=$rowChk["pruebas_rechazadas"];
					$arrayRech=explode(",",$rech);
					$imConsultaRech=implode("','",$arrayRech);
					$muestraPruebas="SELECT * FROM CAT_pruebas WHERE id_prueba IN ('".$imConsultaAce."','".$imConsultaRech."')";
					$exeMuestraP=mysql_query($muestraPruebas,$this->conectarBd());
					if(mysql_num_rows($exeMuestraP)==0){
						print("NO SE PUEDEN MOSTRAR LAS PRUEBAS DE ESTE ITEM");
					}else{
						?>
					<legend style="font-weight:bold; color:#000; text-align: center; margin-bottom: 15px; margin-top: 8px;">ASEGURAMIENTO DE CALIDAD:</legend>
						<table class="styleTa">
							<tr style="background:#e1e1e1;">
								<th style="width:46%;">Prueba</th>
								<th style="width:21%;">Si</th>
								<th style="width:21%;">No</th>
							</tr>
						<?
						$colorTR="#FFF";
						while($rowPru=mysql_fetch_array($exeMuestraP)){
							if(array_search($rowPru["id_prueba"], $arrayAcep)===false){
								?>
								<tr style="border:1px solid #000;">
									<td><?=utf8_encode($rowPru["nombre"])?></td>
									<td></td>
									<th>X</th>
								</tr>
								<?
							}else{
								?>
								<tr style="border:1px solid #000;">
									<td><?=utf8_encode($rowPru["nombre"])?></td>
									<th>X</th>
									<td></td>
								</tr>
								<?
							}
						}
						?>
						</table>
						
				
				<?
					}
			
				
			}
			}
			
			
			
		

	}




?>