<?	/*
	 *modeloEnsamble:Clase del modulo mod_DYR que realiza las consultas e inserciones de los diagnosticos de
	  fallas y reparaciones de los items de cada uno de los técnicos, asi mismo mostrando los detalles necesarios para ambas funciones
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:
	*/
	session_start();
	include("../../clases/funcionesComunes.php");
	include("../../clases/cargaInicial.php");	
	date_default_timezone_set("America/Mexico_City");
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
		
		public function diagnostica($idProyecto,$idUser,$opt){
			if($opt=="Diagnosticar" || $opt=="Asignado"){
				$sel="SELECT * FROM detalle_lotes WHERE id_tecnico=$idUser and (status='Asignado' OR status='Diagnosticado_NT' OR status='Diagnosticado_Ao' OR status='Diagnosticado_Co'  OR status='Diagnosticado_Ir' OR status='Diagnosticado_Wk') AND (cantRechazos=vecesDiagnosticado)";
			}
			if($opt=="nada"){
			 	$sel="SELECT * FROM detalle_lotes WHERE id_tecnico=$idUser and (status='Asignado' OR status='Diagnosticado_Ao' OR status='Diagnosticado_Co' OR status='Diagnosticado_Nt' OR status='Diagnosticado_Ir' OR status='Diagnosticado_Wk')";
			}
			/*if($opt=="Asignado"){
				$sel="SELECT * FROM detalle_lotes WHERE id_tecnico=$idUser and (status='Asignado' OR status='Diagnosticado_NT' OR status='Diagnosticado_Ao' OR status='Diagnosticado_Co'  OR status='Diagnosticado_Ir' OR status='Diagnosticado_Wk') AND (cantRechazos=vecesDiagnosticado)";
			}*/
			if($opt=="x"){
				exit;
			}
			if($opt=="Diagnosticado"){
				$sel="SELECT * FROM detalle_lotes WHERE id_tecnico=$idUser and (status='Diagnosticado_Ao' OR status='Diagnosticado_Co' OR status='Diagnosticado_Nt' OR status='Diagnosticado_Ir' OR status='Diagnosticado_Wk') AND (cantRechazos<vecesDiagnosticado)";
			}

		
			$exeSel=mysql_query($sel,$this->conectarBd());
			$noCol=mysql_num_rows($exeSel);
			if($noCol==0){
				if($opt=="nada"||$opt=="Asignado"||$opt=="Diagnosticado"){
					?><script type="text/javascript">alert("POR EL MOMENTO NO TIENES ITEMS ASIGNADOS CON EL STATUS DE: <?=strtoupper($opt);?>");
					muestraSel('<?=$idProyecto;?>','<?=$idUser;?>');</script>
					<?
				}else{
				?><script type="text/javascript">alert("POR EL MOMENTO NINGUN ITEM TE HA SIDO ASIGNADO o SE ENCUENTRAN EN OTRO PROCESO");</script><?
				}
			}
			else{
				if($opt=="nada"||$opt=="Asignado"||$opt=="Diagnosticado"){
					if($opt=="nada"){
						?><div id="tituloDetalle" style="background: #DDD;width: 99%; height:20px; font-size: 12px;text-align: center;font-weight: bold;">MOSTRANDO TODOS LOS ITEM OBTENIDOS</div><?
					}
					else{
						?><div id="tituloDetalle" style="background: #DDD;width: 99%; height:20px; font-size: 12px;text-align: center;font-weight: bold;">MOSTRANDO LOS ITEMS <?=strtoupper($opt)."S";?></div><?
					}
				}
				else{
					?><div id="tituloDetalle" style="background: #DDD;width: 99%; height:20px; font-size: 12px;text-align: center;font-weight: bold;">MOSTRANDO LOS ITEMS HA DIAGNOSTICAR</div><?
				}
				
				$color="#EEEEEE";
				?><form name="recuperados" id="recuperados"><?
				if($opt=="Diagnosticado"){?>
					<div id="pushbutton" style="width: 100%; height: 30px;text-align: right; background: #F2F0F0"><input type="button" name="enviaCC" id="enviaCC" value="Enviar a CC" onclick="confirmar();recuperaCC();"/><input type="button" id="cancelar" name="cancelar" onclick="muestraSel('<?=$idProyecto;?>','<?=$idUser;?>');" value="Cancelar"/></div>
				<?}
				while($rowAsi=mysql_fetch_array($exeSel)){
					$name="check".$rowAsi['id_partes'];
					if($color=="#FFFFFF"){
						$color="#EEEEEE";
					}
					else{
						$color="#FFFFFF";
					}
					if($opt=="Diagnosticar"){
						$link="formDia('".$idProyecto."','".$idUser."','".$rowAsi['id_item']."','Nuevo');";
						$txt="Da clic para poder diagnosticar el item";
					}
					if($opt=="Diagnosticado"){
						$link="formDia('".$idProyecto."','".$idUser."','".$rowAsi['id_item']."','Consulta');";
						$txt="Da clic para mostrar el diagnostico que se realizo al item";
					}
					if($opt=="nada"||$opt=="Asignado"){
						if($rowAsi['status']=="Diagnosticado_Ao"||$rowAsi['status']=="Diagnosticado_Co"||$rowAsi['status']=="Diagnosticado_Nt"||$rowAsi['status']=="Diagnosticado_Ir"||$rowAsi['status']=="Diagnosticado_Wk"){
							$link="formDia('".$idProyecto."','".$idUser."','".$rowAsi['id_item']."','Consulta');";
							$txt="Da clic para mostrar el diagnostico que se realizo al item";
						}
						if($rowAsi['status']=="Asignado"){
						$link="formDia('".$idProyecto."','".$idUser."','".$rowAsi['id_item']."','Nuevo');";
						$txt="Da clic para poder diagnosticar el item";
						}
					}
?> 					<div id="showdetalleLote" style="background: <?=$color;?>;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<?
						if($rowAsi["cantRechazos"]<=$rowAsi["vecesDiagnosticado"] &&  $rowAsi["cantRechazos"]!=0 && $rowAsi["vecesDiagnosticado"]!=0 ){
							?><div style="float:right;width:40px; height:40px; background:#ff0000;color:#FFF; text-align:center;font-size:14px;margin:5px;padding-top:3px;"><?=$rowAsi["cantRechazos"];?></div><?
						}
						?>
						<table>
							<tr>
								<?if($opt=="Diagnosticado"){?>
									<td rowspan="4"><input type="checkbox" name="<?=$name;?>" id="<?=$name?>" value="<?=$rowAsi['id_item'];?>"/></td>
								<?}
								$idSenc=$rowAsi['id_Senc'];
								$findSenc="Select * from CAT_SENC where id_SENC=$idSenc";
								$exeFindSenc=mysql_query($findSenc,$this->conectarBd());
								$rowSENC=mysql_fetch_array($exeFindSenc);?>
								<th>No. Parte</th>
								<td><?=$rowSENC['NoParte'];?></td>
							</tr>
							<?$conPO="SELECT * FROM lote WHERE id_lote='".$rowAsi['id_lote']."'";
							$exeConPO=mysql_query($conPO,$this->conectarBd());
							$rowPO=mysql_fetch_array($exeConPO);?>
							<?if($idProyecto==1){?>
							<tr>
								<th>No. Pre-Alerta:</th>
								<td><?=$rowPO['num_po'];?></td>
							</tr>
							<?}else{?>
							<tr>
								<th>No. PO:</th>
								<td><?=$rowPO['num_po'];?></td>
							</tr>
							<?}?>
							<tr>
								<th>Fecha de Registro:</th>
								<td><?=$rowAsi['fecha_registro']?></td>
							</tr>
							<tr>
								<th>Status:</th>
								<? if($opt=="Diagnosticar"){
										if($rowAsi["cantRechazos"]==0){
											?><td>POR DIAGNOSTICAR</td><?
										}else{
											?><td>VOLVER A DIAGNOSTICAR</td><?
										}
								}
								if($opt=="nada"||$opt=="Asignado"||$opt=="Diagnosticado"){
									if($rowAsi['status']=="Diagnosticado_Ao"||$rowAsi['status']=="Diagnosticado_Co"||$rowAsi['status']=="Diagnosticado_Nt"||$rowAsi['status']=="Diagnosticado_Ir"||$rowAsi['status']=="Diagnosticado_Wk"){
										$st=str_replace($rowAsi['status'],"","Diagnosticado");
										if($rowAsi["cantRechazos"]==0){
											?><td><?=strtoupper($st);?></td><?
										}else{
											?><td>VOLVER A DIAGNOSTICAR</td><?
										}
										?>
										
										<!--<td></td>-->
									<?
									}else{
											?><!--<td><?=strtoupper($rowAsi["status"])?></td>-->
											<?
									}
								}
								?>
								
							</tr>
						</table>

					</div>
				<?}?>
						<input type="hidden" name="name12" id="name12" value="recuperados">
						<input type="hidden" name="opt12" id="opt12" value="<?=$opt;?>">
						<input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>">
						<input type="hidden" name="idProyecto12" id="idProyecto12" value="<?=$idProyecto?>">
				</form><?		
			}			
		}
		
		public function formDia($idProyecto,$idUser,$idItem,$decide){
			?>
			<br>
			<?				
				$conDeta="select * from detalle_lotes where id_item=$idItem";
				$exeConDe=mysql_query($conDeta,$this->conectarBd());
				$rowDeta=mysql_fetch_array($exeConDe);
				
			?>
			<fieldset style="border:6px groove #ccc; background:#EEE;">
					<legend style="font-weight:bold; color:#000;">DETALLES ITEM:</legend>
				<?if($idProyecto==1){
					$size="190px";
					$size2="180px";
					$size3="50px";
				}if($idProyecto12==2){
					$size="220px";
					$size2="215px";
					$size3="60px";
				}?>
				<div id="contienetablaSemaforo" style="width:100%; height:<?=$size;?>;overflow: hidden;">
				<div id="informacionItem" style="width: 60%; height:<?=$size2;?>; float: left;">
					<table border=0>
						<tr>
							<?
								$id_Senc=$rowDeta['id_Senc'];
								$findSenc="Select * from CAT_SENC where id_SENC=$id_Senc";
								$exeFindSenc=mysql_query($findSenc,$this->conectarBd());
								$rowSENC=mysql_fetch_array($exeFindSenc);?>
							<th align="left">Num. Parte:</th>
							<td><?=$rowSENC['NoParte'];?></td>
						</tr>
						<tr>
							<th align="left">Num. Serie:</th>
							<td><?=$rowDeta['numSerie'];?></td>
						</tr>
						<?
						$conPO="SELECT * FROM lote WHERE id_lote='".$rowDeta['id_lote']."'";
						$exeCon=mysql_query($conPO,$this->conectarBd());
						$rowC=mysql_fetch_array($exeCon);
						if($idProyecto==1){?>
						<tr>
							<th align="left">No.Pre-Alerta:</th>
							<td><?=$rowC['num_po'];?></td>
						</tr>
						<?}else{?>
						<tr>
							<th align="left">No. PO:</th>
							<td><?=$rowC['num_po'];?></td>
						</tr>
						<?}?>
						
						<tr>
							<th align="left">Modelo:</th>
							<?
							$idModelo=$rowDeta['id_modelo'];
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
						<?if($idProyecto==2){?>
							<tr>
								<th align="left">Code Type:</th>
								<td><?=$rowDeta['codeType'];?></td>
							</tr>
							<tr>
								<th align="left">Flow Tag</th>
								<td><?=$rowDeta['flowTag'];?></td>
							</tr>
						<?}
						else{}?>
						<th align="left">Observaciones:</th>
						<td colspan=3><textarea><?=$rowDeta['observaciones_asginacion'];?></textarea></td>
					</table>
				</div>
				<?
				$colorR="#FA0303";
				$colorV="#25D709";
				$colorA="#E2FA33";
				$color1="#f0fff";
				$color2="#f0fff";
				$color3="#f0fff";
				$fontColor="#000";
				$msj1="";
				$msj2="";
				$msj3="";
				$findLote="Select * from lote where id_lote='".$rowDeta['id_lote']."'";
				$exeFindLote=mysql_query($findLote,$this->conectarBd());
				$rowLote=mysql_fetch_array($exeFindLote);
				$fechaTAT=$rowLote['fecha_tat'];
				$fechaPO=$rowLote['fechaPO'];
				$fechaHoy=date('Y-m-d');
				$diasConvert=(strtotime($fechaPO)-strtotime($fechaTAT))/86400;
				$dias=abs($diasConvert);
				$dias1=round($dias);
				if($dias1==30){
					$inc=10;
					$inc2=20;
					$sumar='+'.$inc." day";
					$comparafecha = strtotime ( $sumar , strtotime ( $fechaPO ) ) ;
					$fecha_final = date ( 'Y-m-d' , $comparafecha );
					$sumar1='+'.$inc2." day";
					$comparafecha1 = strtotime ( $sumar1 , strtotime ( $fechaPO ) ) ;
					$fecha_final1 = date ( 'Y-m-d' , $comparafecha1 );
					if($fechaHoy<=$fecha_final && $fechaHoy>=$fechaPO){
						$fontColor="";
						$color="#FFF";
						$decoration="none";
						$muestra="block";
						$msj="";
						$color1=$colorV;
						$msj1="<br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fecha_final && $fechaHoy<=$fecha_final1){
						$color="#FFF";
						$fontColor="";
						$decoration="none";
						$muestra="block";
						$msj="";
						$color2=$colorA;
						$msj2="<br>Fecha TAT:<br>".$fechaTAT;
						
					}
					if($fechaHoy>$fecha_final1){
						$color="#FFF";
						$fontColor="";
						$decoration="blink";
						$muestra="block";
						$msj="";
						$color3=$colorR;
						$msj3="<br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fechaTAT){
						$color="url(../../img/Alert1.png)no-repeat";
						$decoration="blink";
						$muestra="none";
						$msj="<br><br><br>ya expiro el tat!!<br>".$fechaTAT;
					}
				}
				if($dias1==15){
					$inc=6;
					$inc2=9;
					$sumar='+'.$inc." day";
					$comparafecha = strtotime ( $sumar , strtotime ( $fechaPO ) ) ;
					$fecha_final = date ( 'Y-m-d' , $comparafecha );
					$sumar1='+'.$inc2." day";
					$comparafecha1 = strtotime ( $sumar1 , strtotime ( $fechaPO ) ) ;
					$fecha_final1 = date ( 'Y-m-d' , $comparafecha1 );
					if($fechaHoy<=$fecha_final && $fechaHoy>=$fechaPO){
						$color="#FFF";
						$fontColor="";
						$decoration="none";
						$muestra="block";
						$msj="";
						$color1=$colorV;
						$msj1="<br><br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fecha_final && $fechaHoy<=$fecha_final1){
						$color="#FFF";
						$fontColor="";
						$decoration="none";
						$muestra="block";
						$msj="";
						$color2=$colorA;
						$msj2="<br><br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fecha_final1){
						$color="#FFF";
						$fontColor="";
						$decoration="blink";
						$muestra="block";
						$msj="";
						$color3=$colorR;
						$msj3="<br><br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fechaTAT){
						$color="url(../../img/Alert1.png)no-repeat";
						$decoration="blink";
						$muestra="none";
						$msj="<br><br><br><br>ya expiro el tat!!<br>".$fechaTAT;
					}
				}
				if($dias1==7){
					$inc=3;
					$inc2=5;
					$sumar='+'.$inc." day";
					$comparafecha = strtotime ( $sumar , strtotime ( $fechaPO ) ) ;
					$fecha_final = date ( 'Y-m-d' , $comparafecha );
					$sumar1='+'.$inc2." day";
					$comparafecha1 = strtotime ( $sumar1 , strtotime ( $fechaPO ) ) ;
					$fecha_final1 = date ( 'Y-m-d' , $comparafecha1 );
					if($fechaHoy<=$fecha_final && $fechaHoy>=$fechaPO){
						$color="#FFF";
						$fontColor="#FFF";
						$decoration="none";
						$muestra="block";
						$msj="";
						$color1=$colorV;
						$msj1="<br><br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fecha_final && $fechaHoy<=$fecha_final1){
						$color="#FFF";
						$fontColor="#FFF";
						$decoration="none";
						$muestra="block";
						$msj="";
						$color2=$colorA;
						$msj2="<br><br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fecha_final1){
						$color="#FFF";
						$fontColor="#FFF";
						$decoration="blink";
						$muestra="block";
						$msj="";
						$color3=$colorR;
						$msj3="<br><br>Fecha TAT:<br>".$fechaTAT;
					}
					if($fechaHoy>$fechaTAT){
						$color="url(../../img/Alert1.png)no-repeat";
						$decoration="blink";
						$muestra="none";
						$msj="<br><br><br><br>ya expiro el tat!!<br>".$fechaTAT;
					}
				}?>
				<div id="semaforoTAT" style="height:<?=$size2;?>; width:39%; background-color: transparent; float: left; text-align: center; color:<?=$fontColor;?>; text-decoration: <?=$decoration;?>;">
					<div id="contSemaforo" style="height:100%;width: 100%;display:<?=$muestra;?>; background-color: transparent; float: left; text-align: center;">
						<div id="verde" style="width: <?=$size3;?>; height: <?=$size3;?>; clear: both; -moz-border-radius:90%; border: 1px; margin-left: 45%; margin-top: 5px; background: <?=$color1?>; display: block; font-size: 8px; text-align: center;border:inset; border-color: #000;color:<?=$fontColor;?>"><?=$msj1;?></div>
						<div id="amarillo" style="width: <?=$size3;?>; height: <?=$size3;?>; clear: both; -moz-border-radius:90%; border: 1px; margin-left: 45%; margin-top: 5px;background: <?=$color2?>; display: block;font-size: 8px;text-align: center;border:inset; border-color: #000;color:<?=$fontcolor;?>"><?=$msj2;?></div>
						<div id="rojo" style="width: <?=$size3;?>; height: <?=$size3;?>; clear: both; -moz-border-radius:90%; border: 1px; margin-left: 45%; margin-top: 5px;background: <?=$color3?>; display: block; font-size: 8px;text-align: center;text-decoration: <?=$decoration;?>;border:inset; border-color: #000;color:<?=$fontColor;?>"><?=$msj3;?></div>
					</div>
					<?=$msj;?>
				</div>
			</div>
			</fieldset>
			<?if($rowDeta["cantRechazos"]==$rowDeta["vecesDiagnosticado"] && $rowDeta["status"]!="Asignado"){?>
			<br>
			<fieldset style="border:6px groove #ccc; background:#FFF;">
					<legend style="font-weight:bold; color:#000;">ASEGURAMIENTO DE CALIDAD:</legend>
					<?
					$chkList="SELECT * FROM detalleCC WHERE id_item='".$idItem."' order by(id_revCC) DESC";
					$exeChk=mysql_query($chkList,$this->conectarBd());
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
					}
						?>
						</table>
			</fieldset>
			<?}?>
			<br>
			<fieldset style="border:6px groove #ccc; background:#FFF;">
					<legend style="font-weight:bold; color:#000;">DIAGNOSTICO Y REPARACIÓN ITEM:</legend>
				<?if($decide=="Nuevo"){?>
				<form name="diagnostico" id="diagnostico">
											<?
						$tipoVal="";
						$pruebaValida="DESCRIBE detalle_lotes";
						$exePruebaValida=mysql_query($pruebaValida,$this->conectarBd());
						while($arrayPruebaValida=mysql_fetch_array($exePruebaValida)){
								$tipoVal=$tipoVal.$arrayPruebaValida['Field']."=".$arrayPruebaValida['Type']."|";
						}
						$tipoVal1=substr($tipoVal,0,-1);
						?>
						<input type="hidden" name="TypeField" id="TypeField" value="<?=$tipoVal1?>"/>
				<table>
					<tr>
						<th align="left" style="width: 170px;">Fabricante:</th>
						<td>
							<select name="fabricante" id="fabricante">
								<option value="fabricante">Selecciona fabricante:</option>
								<?
								$conFab="select * from CAT_fabricante";
								$execonFab=mysql_query($conFab,$this->conectarBd());
								while($rowFab=mysql_fetch_array($execonFab)){
									?><option value="<?=$rowFab['id_fabricante'];?>"><?=$rowFab['nombre_fabricante'];?></option><?
								}
								?>
							</select>
						</td>
						<td>
							<div id="FabricanteError" style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;text-decoration:blink;'>Por favor Seleccione un Fabricante</div>
						</td>
					</tr>
					<tr>
						<th align="left" style="width: 170px;">Tipo de Entrada</th>
						<?
						$TiE="SELECT valor FROM configuracionglobal WHERE id='9'";
						$exeTiE=mysql_query($TiE,$this->conectarBd());
						$rowTiE=mysql_fetch_array($exeTiE);
						$ArrayTiE=explode("|", $rowTiE["valor"]);
						?>
						<td>
							<select id="tipoEnt" name="TipoEntError">
								<option value="x">Seleccione una entrada</option>
								<?for($ti=0;$ti<count($ArrayTiE);$ti++){
									?><option value="<?=utf8_encode($ArrayTiE[$ti]);?>"><?=utf8_encode($ArrayTiE[$ti]);?></option><?
								}?>
							</select>
						</td>
						<td>
							<div id="TipoEntError" style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;text-decoration:blink;'>Por favor Seleccione un tipo de Entrada</div>
						</td>
					</tr>
					<tr>
						<th align="left" style="width: 170px;">Status:</th>
						<td>
							<select name="status" id="status" onclick="compara('<?=$idItem?>','<?=$idProyecto?>');">
								<option value="0|0|0">selecciona un status</option>
								<?
									$constatusDia="SELECT * FROM CAT_tipoReparacion where id_proyecto=$idProyecto";
									$exestatusDia=mysql_query($constatusDia,$this->conectarBd());
									while($rowStatusDia=mysql_fetch_array($exestatusDia)){
?>
										<option value="<?=$rowStatusDia['tipo_reparacion'];?>|<?=$rowStatusDia['id_tipoReparacion'];?>|<?=$rowStatusDia['camposMuestra']?>"><?=$rowStatusDia['tipo_reparacion'];?></option>
<?
									}
?>
							</select>
						</td>
						<td>
							<div id="statusError" style='display:none;font-size: 10px;border:1px solid #50C9F9;text-align:justify;color:#3306FB;text-decoration:blink;'>Por favor Seleccione un Tipo de Reparación</div>
						</td>
						
					</tr>
				</table>
					<table>
						<div id="contenido">
						
						</div>
					</table>
				<table>
					<tr>
						<th align="left" style="width: 170px;">Observaciones:</th>
						<td colspan=3><textarea name="obsDia" id="obsDia" maxlength="200"></textarea></td>
					</tr>
				</table>
				<p style="margin-left: 400px"><input type="button" name="guarda" id="guarda" value="GUARDAR" onclick="guardarDiagnostico('<?=$idItem;?>','<?=$idProyecto;?>','<?=$idUser?>');" align="right"></p>
				</form>
				<?}if($decide=="Consulta"){
						$consCampos="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion='".$rowDeta['id_tipoReparacion']."'";
						$exeConsCampos=mysql_query($consCampos,$this->conectarBd());
						$ArrayExeCampos=mysql_fetch_array($exeConsCampos);
						$campos=$ArrayExeCampos['camposMuestra'];
						$arrayCampos=explode(",",$campos);
						$totalArrayCampos=count($arrayCampos);
						$contenedorArray=Array();
						?><table border=1>
							<tr align="left">
								<th>Fabricante:</th>
								<?
								$fab="SELECT * FROM CAT_fabricante WHERE id_fabricante='".$rowDeta['id_fabricante']."'";
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
								$valDatos=$rowDeta[$contenedorArray[$i]];
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
								<td><?=$rowDeta[$contenedorArray[$i]]?></td>
								<td><?=$unidad?></td>
							</tr>
							<?
							}
							
						}
						?></table><?
					}
				//}?>
			</fieldset>
<?		}
		public function guarDia($idItem,$idProyecto,$idUser,$idFabricante,$observacionesDia,$status,$idLote,$idTipoRep,$cadena,$tipoEnt){
			$queryAumDia="SELECT vecesDiagnosticado FROM detalle_lotes where id_item='".$idItem."'";
			$exeQueryAum=mysql_query($queryAumDia,$this->conectarBd());
			$rowVecesDia=mysql_fetch_array($exeQueryAum);
			$vecesDiaReal=$rowVecesDia["vecesDiagnosticado"]+1;
			$fechaDYR=date('Y-m-d');
			$horaDYR=date('G:i:s');
			$cad1Arr=explode("-",$cadena);
			$CCad1=count($cad1Arr);
			$nuevoVal=Array();
			for($m=0;$m<$CCad1;$m++){
				$valCad1=$cad1Arr[$m];
				$otCad=explode("=",$valCad1);
				$nuevoVal[$m]=$otCad[0]."='".$otCad[1]."'";
			}
			$camposUpdate=implode(",",$nuevoVal);
			$Status = ucwords(strtolower($status));
			$Status="Diagnosticado_".$Status;
			$insDia="UPDATE detalle_lotes SET status='".$Status."',id_tipoReparacion='".$idTipoRep."',id_fabricante='".$idFabricante."',$camposUpdate, vecesDiagnosticado='".$vecesDiaReal."', TipoEntrada='".$tipoEnt."' where id_item=$idItem";			
			$exeInsDia=mysql_query($insDia,$this->conectarBd());
			$opt="Diagnosticar";
				if(!$exeInsDia){
					echo "<br>No se pudo registrar su diagnostico intentelo de nuevo";
				}
				else{
?>					<script type="text/javascript">clean2();</script><?
					$cambiaStatus="INSERT INTO detalleDYR (id_item,fechaDYR, horaDYR,status,observaciones) values ('".$idItem."','".$fechaDYR."','".$horaDYR."','".$status."','".$observacionesDia."')";
					$exeCambiaStatus=mysql_query($cambiaStatus,$this->conectarBd());
					include("../../clases/claseDetalle.php");
					$objClase=new claseDetalle();
					$objClase->consulta($idItem,$idUser,"Diagnostico Item");
					?><script type="text/javascript">clean2("listadoEmpaque");diagnostica('<?=$idProyecto?>','<?=$idUser?>','<?=$opt?>');</script><?
				}
		}
		
		public function muestraSel($idProyecto,$idUser){
			?>
			<input type="hidden" name="idProyecto" id="idProyecto" value="<?=$idProyecto?>">
			<input type="hidden" name="idUser" id="idUser" value="<?=$idUser?>">				
			<select name="optSel" id="optSel" onchange="Seleccionado(this);">
				<option value="x">Selecciona</option>
				<option value="nada">TODOS</option>
				<option value="Diagnosticado">DIAGNOSTICADOS</option>
				<option value="Asignado">POR DIAGNOSTICAR</option>
			</select>
<?
		}
		public function sendCC($idProyecto,$idUser,$idItem){
			$queryAumCC="SELECT enviados_calidad FROM detalle_lotes where id_item='".$idItem."'";
			$exeQueryAum=mysql_query($queryAumCC,$this->conectarBd());
			$rowVecesCC=mysql_fetch_array($exeQueryAum);
			$vecesCCReal=$rowVecesCC["enviados_calidad"]+1;
				$actualizaStaCC="UPDATE detalle_lotes SET status='CC', enviados_calidad='".$vecesCCReal."' WHERE id_item IN ($idItem)";
				$exeActualizaCC=mysql_query($actualizaStaCC,$this->conectarBd());
				if(!$exeActualizaCC){
					echo "<br>No se pudo enviar a CC intentelo de nuevo";
				}
				else{
					echo "Su Envio fue exitoso";
					include("../../clases/claseDetalle.php");
					$objClase=new claseDetalle();
					$objClase->consulta($idItem,$idUser,"Diagnostico Item");
					?><script type="text/javascript">clean2(); muestraSel('<?=$idProyecto?>','<?=$idUser?>')</script><?
				}
		}
		public function muestraConsultasChk($idItem,$idProyecto,$tbl){
			$nomTBL="CAT_".$tbl;
			$conDes="DESCRIBE ".$nomTBL;
			$exeConDes=mysql_query($conDes,$this->conectarBd());
			$conTBL="SELECT * FROM $nomTBL WHERE id_proyecto=$idProyecto";
			$exeConTBL=mysql_query($conTBL,$this->conectarBd());
			$noDatos=mysql_num_rows($exeConTBL);
			$idCAT="id_".$tbl;
			$nomForm="Selection".$tbl;
			if($noDatos==0){
				echo "El catalogo de". $tbl ."se encuentra vacio ";
			}
			else{
				?>
				<h3 align="center">CATALOGO DE <?=strtoupper($tbl);?></h3>
				<hr align="center" color="silver" width="500px">
				<form name="<?=$nomForm?>" id="<?=$nomForm?>" method="post">
				<input type="hidden" name="name" id="name" value="<?=$nomForm?>" >
				<input type="hidden" name="idItem" id="idItem" value="<?=$idItem?>">
				<input type="hidden" name="idProyecto" id="idProyecto" value="<?=$idProyecto?>">
				<input type="hidden" name="opt1" id="opt1" value="<?=$tbl;?>">
				<table border=1 align="center" style="font-size: 11px;">
					<tr>
						<th align="center">#</th>
						<?
						while($rowConDes=mysql_fetch_array($exeConDes)) {
							if($rowConDes["Field"]=="id_proyecto"||$rowConDes["Field"]==$idCAT){}else{
								?>
								<th align="center"><?=$rowConDes["Field"];?>
								<?
								if ($rowConDes['Key']=='PRI'){ $sql_orden=" ORDER BY ".$Rs2['Field']; }
								?></th><?
							}
						}?>
					</tr><?
				 $colorT="#FFF";
				 while($rowConTBL=mysql_fetch_array($exeConTBL)){
					$ndc_respuesta=(count($rowConTBL)/2)-1;
					
					if ($ndc_respuesta>0){
						?>
						<tr style="background: <?=$colorT;?>">
						<?$nameCHK="chk".$rowConTBL[0];?>
							<td align="center"><input type="checkbox" name="<?=$rowConTBL[1];?>" id="<?=$nameCHK;?>" value="<?=$rowConTBL[0];?>"></td><?
							for ($i=1;$i<$ndc_respuesta;$i++){
									echo "<td>".utf8_encode($rowConTBL[$i])."</td>";
							}
						?></tr><?
						($colorT=="#FFF")? $colorT="#F0F0F0" : $colorT="#FFF";	 
					}
				}
				 ?></table></form><?
			}
		}
	}//fin de la clase
?>