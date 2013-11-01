<?
	/*
	 *modeloEnsamble:clase que realiza la inserción, modificación y consulta tanto de lotes como del detalle de los Items ingresados en cada uno de los lotes
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
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
		private function conecta2(){
			require("../../includes/config.inc.php");
			$link2=mysql_connect($host,$usuario,$pass);
			if($link2==false){
				echo "Error en la conexion a la base de datos";
			}else{
				mysql_select_db($db2);
				return $link2;
			}	
		}
		/**********************************LOTES***********************************/
		public function mostrarLotesProyecto($opt,$id_usuario,$idProyecto){/*Funcion que muestra los lotes que hay en el sistema*/
			$objCargaInicial=new verificaCargaInicial();
			$con="SELECT * FROM lote WHERE id_proyecto='".$idProyecto."' AND status='Recibido' ORDER BY fecha_reg DESC";
			$cons=mysql_query($con,$this->conectarBd());
			$name_pro=$objCargaInicial->dameNombreProyecto($idProyecto);
			if(mysql_num_rows($cons)==0){
				echo"No hay registros que mostrar";
			}else{
?>
				<h3 align="center">Linea <?=$name_pro;?></h3>
				<div id="titulo" style="background: #CCC; width: 95%; height:20px; font-size: 12px;text-align: center;font-weight: bold;"><?=strtoupper($opt);?> LOTES</div>
				
<?
				$color="#FFFFFF";
				while($row=mysql_fetch_array($cons)){
					$fechaB=explode("-",$row['fecha_tat']);						
					$diaSeg=date("w",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
					$mesSeg=date("n",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
					$dias= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
					$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
					if($color=="#FFFFFF"){
						$color="#EEE";
					}else{
						$color="#FFFFFF";
					}
					if($opt=="Consulta"){
						$link="consultaDetalleLote('".$row['id_lote']."','".$idProyecto."','".$row['numero_items']."','Consulta','".$id_usuario."');";
						$txt="De click para consultar el detalle del lote";
					}
					if($opt=="Modifica"){
						$link="formModificaLote('".$row['id_lote']."','".$idProyecto."','".$id_usuario."');";
						$txt="De click para modificar el lote";
					}
					if($opt=="Elimina"){
						$link="continuar();eliminaLote('".$row['id_lote']."','".$idProyecto."','".$id_usuario."');";
						$txt="De click para eliminar el lote";
					}
?>
					<div id="showLote" style="background: <?=$color;?>;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<table border=0>
							<tr>
								<th>No.Lote:</th>
								<td><?=$row["id_lote"]?></td>
							</tr>
						<?if($idProyecto==1){?>
							<tr>
								<th>Pre-Alerta:</th>
								<td><?=strtoupper($row['num_po']);?></td>
							</tr>
							<tr>
								<th>Fecha Pre-Alerta:</th>
								<td><?=$row['fechaPO']?></td>
							</tr>
						<?}else{?>
							<tr>
								<th>Num PO:</th>
								<td><?=$row['num_po'];?></td>
							</tr>
							<tr>
								<th>Fecha PO:</th>
								<td><?=$row['fechaPO']?></td>
							</tr>
						
						<?}?>
							<tr>
								<th>No. ITEM:</th>
								<td><?=$row['numero_items'];?></td>
							</tr>
							<tr>
								<th>Fecha Registro:</th>
								<td><?=$row['fecha_reg'];?></td>
							</tr>
							<tr>
								<th>Status:</th>
								<td><?=$row['status'];?></td>
							</tr>
							<tr>
								<th>TAT:</th>
								<td>El <?=$dias[$diaSeg]." ".$fechaB[2]." de ".$meses[$mesSeg-1]." de ".$fechaB[0]." a las ".$row['hora_reg']. " se liberar&aacute";?></td>
							</tr>
						
						</table>
					</div>
<?			
				}
			}
		}//fin function mostrarLotesProyecto
		public function formLotes($id_proyecto,$idUsuario,$idMov){ /*Funcion para agregar nuevo lote*/
			$pru="select nombre_proyecto from proyecto where id_proyecto='".$id_proyecto."'";
			$pru2=mysql_query($pru,$this->conectarBd());
			$rowPro=mysql_fetch_array($pru2);
			$proj=$rowPro['nombre_proyecto'];
			$tatPro="tat".$proj;
			$con1="select valor from configuracionglobal where nombreConf='$tatPro'";
			$ejecon1=mysql_query($con1,$this->conectarBd());
			$row=mysql_fetch_array($ejecon1);
			$valor=$row['valor'];
			$no_day=explode("|",$valor);
			$total=count($no_day);
			$cDeMov="SELECT * FROM mov_almacen where id_mov='".$idMov."'";
			$exCDeM=mysql_query($cDeMov,$this->conecta2());
			$rowMov=mysql_fetch_array($exCDeM);
			$toCa="SELECT SUM(cantidad) AS totalPro FROM prodxmov WHERE nummov='".$idMov."'";
			$exeToCa=mysql_query($toCa,$this->conecta2());
			$rowCan=mysql_fetch_array($exeToCa);
			/*realizar suma*/

?>
			<form name="lote" id="lote" method="POST">
			<table align="center">
				<input type="hidden" name="idUsuario" id="idUsuario" value="<?=$idUsuario;?>"/>
				<input type="hidden" name="id_proyecto" id="id_proyecto" value="<?=$id_proyecto;?>"/>
				<input type="hidden" name="idMov" id="idMov" value="<?=$idMov?>"/>
				<tr align="center">
					<th colspan="2" style="size: 30px;  ">Movimiento <?=$idMov;?></th>
				</tr>
				<?if($id_proyecto==1){
				?><tr>
					<th align="left"># Pre-Alerta</th>
					<td><input type="text" name="noPO" id="noPO" value="<?=$rowMov['referencia']?>" readonly/></td>
				</tr>
<?
				}?>
				<?if($id_proyecto==2){
?>				<tr>
					<th align="left"># PO</th>
					<td><input type="text" name="noPO" id="noPO" onkeyup="this.value = this.value.replace (/[^0-9]/, ''); "value="<?=$rowMov['referencia']?>" readonly/></td>
				</tr>
<?
				}?>
				<tr>
					<th align="left">Numero de ITEMS</th>
					<td><input type="text" name="noItem" id="noItem" onkeyup="this.value = this.value.replace (/[^0-9]/, ''); "style="width: 80px;" value="<?=$rowCan['totalPro']?>" readonly/></td>
				</tr>
				<?if($id_proyecto==1){
				?>
				<tr>
					<th align="left">Fecha de Pre-alerta</th>
					<td><input type="text" name="fechaPO" id="fechaPO" style="width: 80px;"><input type="button" id="lanzador1" value="..." />
					        <!-- script que define y configura el calendario-->
					        <script type="text/javascript">
						Calendar.setup({
						        inputField     :    "fechaPO",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzador1"   // el id del botón que lanzará el calendario
						});
									    </script>
					</td>
				</tr>
<?
				}?>
				<?if($id_proyecto==2){
?>			
				<tr>
					<th align="left">Fecha de PO</th>
					<td><input type="text" name="fechaPO" id="fechaPO" style="width: 80px;"><input type="button" id="lanzador1" value="..." />
					        <!-- script que define y configura el calendario-->
					        <script type="text/javascript">
						Calendar.setup({
						        inputField     :    "fechaPO",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzador1"   // el id del botón que lanzará el calendario
						});
									    </script>
					</td>
				</tr>
<?
				}?>
            			<tr>
					<th align="left">TAT</th>
					<td><select name="diasTAT" id="diasTAT">
<?
						for($i=0;$i<$total;$i++){
						    ?><option value="<?=$no_day["$i"];?>"><?=$no_day["$i"];?></option> 
						    <?
						}
?>
					</select></td>
				</tr>
				<tr>
					<th align="left">Observaciones</th>
					<td><textarea row="5" cols="20" maxlength="200" name="observaciones" id="observaciones"></textarea></td>
				</tr>
				<tr>
					<th rowspan="2" colspan="2">
						<input type="button" name="addLote" id="addLote" value="Agregar" onclick="confirmar();agregarLotes('document.getElementsBy(hidden)')">
						<input type="button" name="cancela" id="cancela" value="Cancelar" onclick="cerrarVentana('divMensajeCaptura','transparenciaGeneral1'	)">
					</th>
				</tr>
			</table></form><?
		}// fin funcion formLote
		public function agregarLote($noPO,$fechaPO,$noItem,$diasTAT,$observaciones,$idUsuario,$id_proyecto,$idMov){/*Funcion que guarda los datos del nuevo lote*/
			$fechaReg=date('Y-m-d');
			$horaReg=date('G:i:s');
			$noPO = strtoupper($noPO);
			$Noday=$diasTAT;
			$suma="+".$Noday." day";
			$nuevafecha = strtotime ( $suma , strtotime ( $fechaPO ) ) ;
			$fecha_final = date ( 'Y-m-j' , $nuevafecha );
			//print("Suma=".$suma."fechaReg=".$fechaReg." NuevaFecha=".$nuevafecha."fechaFinal=".$fecha_final);
			//exit;
			$add="INSERT INTO lote (numero_items,fecha_reg,hora_reg,id_usuario,fecha_tat,num_po,fechaPO,observaciones,id_proyecto,id_mov) VALUES ('".$noItem."','".$fechaReg."','".$horaReg."','".$idUsuario."','".$fecha_final."','".$noPO."','".$fechaPO."','".$observaciones."','".$id_proyecto."','".$idMov."')";
			$una=mysql_query($add,$this->conectarBd());
				if(!$una){
					
				    echo "<br>El Lote no ha sido agregado";
				}
				else{
					include("../../clases/claseDetalle.php");
					$objClase=new claseDetalle();
					$idUltimoL=mysql_insert_id($this->conectarBd());
					$proc="Agrega Lote ".$idUltimoL;
					$objClase->consulta(0,$idUsuario,$proc);
				    ?><script type="text/javascript">alert("El lote ha sido agregado satisfactoriamente");clean2(); mostrarLotes('<?=$idUsuario?>','<?=$id_proyecto;?>','Consulta');</script><?
	    			}
		}// fin funcion agregarLote
		public function formModificaLote($idLote,$id_proyecto,$id_usuario){/*Funcion que muestra el formulario para modificar el lote*/
			$pru="select nombre_proyecto from proyecto where id_proyecto='".$id_proyecto."'";
			$pru2=mysql_query($pru,$this->conectarBd());
			$rowPro=mysql_fetch_array($pru2);
			$proj=$rowPro['nombre_proyecto'];
			$tatPro="tat".$proj;
			$con1="select valor from configuracionglobal where nombreConf='$tatPro'";
			$ejecon1=mysql_query($con1,$this->conectarBd());
			$row=mysql_fetch_array($ejecon1);
			$valor=$row['valor'];
			$no_day=explode("|",$valor);
			$total=count($no_day);
			$cons="Select * from lote where id_lote=$idLote";
			$cons1=mysql_query($cons,$this->conectarBd());
		
?>
			<form name="Modlote" id="Modlote" method="POST">
			<table align="center">
<?
				while($row=mysql_fetch_array($cons1)){
					$fechatat=$row['fecha_tat'];
					$fechapo=$row['fechaPO'];
					$diasConvert= (strtotime($fechapo)-strtotime($fechatat))/86400;
					$dias=abs($diasConvert);
					$dias1=round($dias);	
?>
						<tr align="center">
							<th colspan="2" style="size: 30px;  ">Editando referencia <?=$row['num_po']?> </th>
						</tr>
						<?if ($id_proyecto==1){?>
						<tr>
							<th align="left">Pre-alerta</th>
							<td><input type="text" name="nuPo" id="nuPo" value="<?=$row['num_po']?>" style="width: 150px;" readonly/></td>
							<th><a href="#" onclick="listaMov();"><img src="../../"></a></th>
						</tr>
						<?}
						if($id_proyecto==2){?>
						<tr>
							<th align="left">No. PO</th>
							<td><input type="text" name="nuPo" id="nuPo" value="<?=$row['num_po']?>" onkeyup="this.value = this.value.replace (/[^0-9 ]/, ''); " style="width: 150px;"readonly/></td>
							<th></th>
						</tr>
<?						}?>	
					<tr>
						<th align="left">Numero de ITEMS</th>
						<td colspan=2><input type="text" name="noItem" id="noItem" value="<?=$row['numero_items']?>"onkeyup="this.value = this.value.replace (/[^0-9 ]/, ''); " style="width: 150px;"	readonly/></td>
					</tr>
					<?if ($id_proyecto==1){?>
						<tr>
							<th align="left">Fecha de PO</th>
							<td colspan=2><input type="text" name="fechaPo" id="fechaPo" style="width: 120px;"value="<?=$row['fechaPO']?>"><input type="button" id="lanzador1" value="..." />
								<!-- script que define y configura el calendario-->
								<script type="text/javascript">
								Calendar.setup({
									inputField     :    "fechaPo",      // id del campo de texto
									ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
									button         :    "lanzador1"   // el id del botón que lanzará el calendario
								});
											    </script>
							</td>
						</tr>
						<?}
						if($id_proyecto==2){?>
						<tr>
							<th align="left">Fecha de PO</th>
							<td colspan=2><input type="text" name="fechaPo" id="fechaPo" style="width: 120px;" value="<?=$row['fechaPO']?>"><input type="button" id="lanzador1" value="..." />
								<!-- script que define y configura el calendario-->
								<script type="text/javascript">
								Calendar.setup({
									inputField     :    "fechaPo",      // id del campo de texto
									ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
									button         :    "lanzador1"   // el id del botón que lanzará el calendario
								});
											    </script>
							</td>
						</tr>
<?						}?>	
					<tr>
						<th align="left">Fecha de registro</th>
						<td colspan=2><input type="text" name="fechaReg" id="fechaReg" value="<?=$row['fecha_reg']?>" style="width: 120px;"/><input type="button" id="lanzador1" value="..." />
									    <!-- script que define y configura el calendario-->
									    <script type="text/javascript">
										    Calendar.setup({
											    inputField     :    "fechaReg",      // id del campo de texto
											    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
											    button         :    "lanzador1"   // el id del botón que lanzará el calendario
										    });
									    </script>
						</td>
					</tr>
					<tr>
						<th align="left">Hora de registro</th>
						<td colspan=2><input type="text" name="horaReg" id="horaReg" value="<?=$row['hora_reg']?>" style="width: 140px;" readonly/></td>
					</tr>
            				<tr>
						<th align="left">TAT</th>
						<td colspan=2><select name="diasTAT" id="diasTAT" style="width: 140px;text-align:center;">
						    <option value="<?=$dias1;?>"><?=$dias1;?></option>
<?
							for($i=0;$i<$total;$i++){
							    ?><option value="<?=$no_day["$i"];?>"><?=$no_day["$i"];?></option> 
							    <?
							}
?>	
						</select></td>
					</tr>
					<tr>
						<th align="left">Observaciones</th>
						<td><textarea row="5" cols="20" maxlength="200" name="observaciones" id="observaciones" value="<?=$row['observaciones']?>"></textarea></td>
					</tr>
					<tr>
<?	
				}
?>
						<th rowspan="2" colspan="2">
						<input type="button" name="addLote" id="addLote" value="Modifica" onclick="confirmar();modificaLote('<?=$idLote?>','<?=$id_proyecto?>','<?=$id_usuario?>')"/>
						<input type="button" name="cancela" id="cancela" value="Cancelar" onclick="cerrarVentana('divMensajeCaptura')"/>
					</th>
					</tr>
        
			</table> </form><?
   
	    	}//fin funcion formModificaLote
		public function modificaLote($noPO,$fechaPo,$noItem,$fechaReg,$horaReg,$diasTAT,$observaciones,$idLote,$id_proyecto,$id_usuario){/*Funcion que gurada las modificacion que se le hicieron alos lotes*/
			$noPO = strtoupper($noPO);
			$Noday=$diasTAT;
			$suma="+".$Noday." day";
			$nuevafecha = strtotime ( $suma , strtotime ( $fechaPo ) ) ;
			$fecha_final = date ( 'Y-m-j' , $nuevafecha );
			//gUARDAR ORIGINAL EN LOTE_CAMBIOS
			$consultaLActual="SELECT * from lote WHERE id_lote=$idLote";
			$DATE=date('Y-m-d');
			$HOUR=date('G:i:s');
			$ejecutaConsultaActual=mysql_query($consultaLActual,$this->conectarBd());
			$rowActual=mysql_fetch_array($ejecutaConsultaActual);
			$PREchange= "INSERT INTO lote_cambios(id_lote,numero_items,fecha_reg,hora_reg,id_usuario,status,fecha_tat,num_po,fechaPO,observaciones,id_pro,fecha_cambio,hora_cambio,usuario_cambio) VALUES ('".$rowActual['id_lote']."','".$rowActual['numero_items']."','".$rowActual['fecha_reg']."','".$rowActual['hora_reg']."','".$rowActual['id_usuario']."','".$row['status']."','".$rowActual['fecha_tat']."','".$rowActual['num_po']."','".$rowActual['fechaPO']."','".$rowActual['observaciones']."','".$rowActual['id_proyecto']."','".$DATE."','".$HOUR."','".$id_usuario."')";
			//FIN DEL GUARDADO ORIGINAL
			$mod="UPDATE lote SET num_po='".$noPO."',fechaPO='".$fechaPo."', numero_items='".$noItem."', fecha_reg='".$fechaReg."',hora_reg='".$horaReg."', fecha_tat='".$fecha_final."',observaciones='".$observaciones."' WHERE id_lote='".$idLote."'";
			$una=mysql_query($mod,$this->conectarBD());
				if(!$una){
				    echo "<br>El Lote no ha sido modificado";
				}
				else{
					include("../../clases/claseDetalle.php");
					$objClase=new claseDetalle();
					$procM="Modifica Lote ".$idLote;
					$objClase->consulta(0,$id_usuario,$procM);
					$ejecutaPREchange=mysql_query($PREchange,$this->conectarBd());
				?><script type="text/javascript">alert("El lote ha sido modificado satisfactoriamente");clean2(); mostrarLotes('<?=$idUsuario?>','<?=$id_proyecto;?>','Consulta');</script><?
	    			}
		}//fin de la funcion modificaLote
		public function eliminaLote($idLote,$id_proyecto,$id_usuario){
			$del="UPDATE lote set status='Eliminado' where id_lote=$idLote";
			$exeDel=mysql_query($del,$this->conectarBd());
			if($exeDel==true){
				?><script type="text/javascript">alert("El lote ha sido eliminado");clean2(); mostrarLotes('<?=$id_usuario?>','<?=$id_proyecto;?>','Consulta');</script><?
			}else{
				?><script type="text/javascript">alert("El lote NO ha sido eliminado");clean2(); mostrarLotes('<?=$id_usuario?>','<?=$id_proyecto;?>','Consulta');</script><?
			}
		}
		/***************************Detalle Lote************************************/
		public function FindSEC($likeNoParte,$enter){
			$sqlBuskFac="SELECT id_SENC, SECN, NoParte,descripcion FROM CAT_SENC WHERE NoParte LIKE '".$likeNoParte."%' LIMIT 0,15";
			$rResp=mysql_query($sqlBuskFac,$this->conectarBd());
			$paraIf=mysql_num_rows($rResp);$color="#FFF";
			if($paraIf=="0"){
				?><script type="text/javascript">quita();</script><?
				if($enter=="si"){
					?><script type="text/javascript">
						var entrar = confirm("¿Este numero de parte no tiene un SECN Deseas continuar?"); 
						if ( !entrar ){cerrarVentana("ventanaDialogo1");}
						else{
							$("#transparenciaOp").show();
							$("#divAgrega").show();
							formSENC(<?=$likeNoParte;?>);
							//$("SENC").focus();
						//$("#modelo").focus();
					}</script><?
				}
				echo"No Hay Registros";
			}
			else{
				if($paraIf==1 && $enter=="si"){
					$rowBuskFac=mysql_fetch_array($rResp);
					?><script type="text/javascript">cerrarVentana('resultados');inserta('<?=$rowBuskFac['id_SENC']?>','<?=$rowBuskFac['SECN']?>','<?=$rowBuskFac['NoParte']?>');</script><?
				}else{
					
				
?>				<script type="text/javascript">coloca();</script><table style="font-family: sans-serif; font-size: 9px;">
					<tr style="background: #EEE; text-align: center; font-weight: bold;">
						<th>No. Parte</th>
						<th>SENC</th>
						<th>Descripcion</th>
					</tr>
				<?while($rowBuskFac=mysql_fetch_array($rResp)){?>
					<tr style="background:<?=$color?>;">
						<td onclick="cerrarVentana('resultados');inserta('<?=$rowBuskFac['id_SENC']?>','<?=$rowBuskFac['SECN']?>','<?=$rowBuskFac['NoParte']?>');" title="De click en el No de Parte"><?=utf8_encode($rowBuskFac["NoParte"]);?></td>
						<td onclick="cerrarVentana('resultados');inserta('<?=$rowBuskFac['id_SENC']?>','<?=$rowBuskFac['SECN']?>','<?=$rowBuskFac['NoParte']?>');" title="De click en el No de Parte"><?=utf8_encode($rowBuskFac["SECN"]);?></td>
						<td onclick="cerrarVentana('resultados');inserta('<?=$rowBuskFac['id_SENC']?>','<?=$rowBuskFac['SECN']?>','<?=$rowBuskFac['NoParte']?>');" title="De click en el No de Parte"><?=utf8_encode($rowBuskFac["descripcion"]);?></td>
					
					</tr>
				<?($color=="#FFF") ? $color="#EEEEEE" : $color="#FFF";}?>
				</table>
<?
				}
			}
		}
		/****************************************DEtalle lote************************************************/
		public function consultaDetalleLote($id_lote,$id_proyecto,$noItem,$opt,$idUsuario){
			$conMov="SELECT * FROM lote where id_lote='".$id_lote."'";
			$exeCon=mysql_query($conMov,$this->conectarBd());
			$rowMovC=mysql_fetch_array($exeCon);
			$fechaB=explode("-",$rowMovC['fecha_tat']);						
			$diaSeg=date("w",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
			$mesSeg=date("n",mktime(0,0,0,$fechaB[1],$fechaB[2],$fechaB[0]));
			$dias= array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","S&aacute;bado");
			$meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
			?>
			<div id="barraOpcionesEnsambleIZQ">
				<div class="opcionesEnsamble" onclick="consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Consulta','<?=$idUsuario?>')" title="Inicio">Consulta ITEMS</div>
				<div class="opcionesEnsamble" onclick="formAgrega('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','<?=$idUsuario;?>')" title="Agregar ITEMS">Agregar ITEMS</div>
				<div class="opcionesEnsamble" onclick="consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Modifica','<?=$idUsuario?>')" title="Modificar">Modificar</div>
				<div class="opcionesEnsamble" onclick="Exportar('<?=$id_lote;?>','<?=$id_proyecto;?>','<?=$noItem?>','<?=$idUsuario;?>','<?=$rowMovC['id_mov']?>')" title="Exportar detalle Lote a Excel">Exportar</div>
			</div>
			<div id="contenedorDetalleLote" style="background: #FFF;height: 80%;">
				<?
				$Reg_lote="SELECT * from detalle_lotes where id_lote=$id_lote";
				$reg_loteCon=mysql_query($Reg_lote,$this->conectarBd());
				if(mysql_num_rows($reg_loteCon)==0){
				    echo "<br><br>Este lote se encuentra vacio";
				}
				else{
	?>
					<div id="tituloDetalle"><?=strtoupper($opt);?> DETALLE DE LA REFERENCIA: <?=$rowMovC['num_po'];?></div>
					<div id="DatosLotes" style="clear:both;height:180px;width:98%; text-align:justify;font-size:10px;background:#fff;padding:5px;margin:5px;">
					<br>
					<fieldset style="border:6px groove #ccc; background:#E1E0E0;">
					<legend style="font-weight:bold; color:#000;">Informaci&oacute;n Lote</legend>
					<table border=0  >
							<tr>
								<th>No.Lote:</th>
								<td><?=$rowMovC["id_lote"]?></td>
							</tr>
						<?if($idProyecto==1){?>
							<tr>
								<th>Pre-Alerta:</th>
								<td><?=strtoupper($rowMovC['num_po']);?></td>
							</tr>
							<tr>
								<th>Fecha Pre-Alerta:</th>
								<td><?=$rowMovC['fechaPO']?></td>
							</tr>
						<?}else{?>
							<tr>
								<th>Num PO:</th>
								<td><?=$rowMovC['num_po'];?></td>
							</tr>
							<tr>
								<th>Fecha PO:</th>
								<td><?=$rowMovC['fechaPO']?></td>
							</tr>
						
						<?}?>
							<tr>
								<th>No. ITEM:</th>
								<td><?=$rowMovC['numero_items'];?></td>
							</tr>
							<tr>
								<th>Fecha Registro:</th>
								<td><?=$rowMovC['fecha_reg'];?></td>
							</tr>
							<tr>
								<th>Status:</th>
								<td><?=$rowMovC['status'];?></td>
							</tr>
							<tr>
								<th>TAT:</th>
								<td>El <?=$dias[$diaSeg]." ".$fechaB[2]." de ".$meses[$mesSeg-1]." de ".$fechaB[0]." a las ".$rowMovC['hora_reg']. " se liberar&aacute";?></td>
							</tr>
						
						</table>
						</fieldset>
					</div>
				   <?
					while ($row=mysql_fetch_array($reg_loteCon)){
						if($color=="#FFFFFF"){
							$color="#EEE";
						}else{
							$color="#FFFFFF";
						}
						if($opt=="Consulta"){
							$link="";
							$txt="";
						}
						if($opt=="Modifica"){
							$link="formModifica('".$row['id_lote']."','".$id_proyecto."','".$row['id_item']."','".$idUsuario."');";
							$txt="De click para modificar el detalle del ITEM";
						}
	?>
					<div id="showdetalleLote" style="background: <?=$color;?>;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<table>
							<tr>
								<th>Numero de Parte:</th>
								<?
								$idSenc=$row['id_Senc'];
								$findSenc="Select * from CAT_SENC where id_SENC=$idSenc";
								$exeFindSenc=mysql_query($findSenc,$this->conectarBd());
								$rowSENC=mysql_fetch_array($exeFindSenc);?>

								<td><?=$rowSENC['NoParte'];?></td>
							</tr>
							<tr>
								<th>SENC:</th>
								<td><?=$rowSENC['SECN'];?></td>
							</tr>
							<tr>
								<th>Modelo:</th>
								<?
								$queMod="SELECT * FROM CAT_modelo where id_modelo='".$row['id_modelo']."'";
								$exequeMod=mysql_query($queMod,$this->conectarBd());
								$fetchMod=mysql_fetch_array($exequeMod);
								?>
								<td><?=$fetchMod['modelo'];?></td>
							</tr>
							<?if($id_proyecto==2){?>
							<tr>
								<th>Code Type</th>
								<td><?=$row['codeType'];?></td>
							</tr>
							<tr>
								<th>Flow Tag</th>
								<td><?=$row['flowTag'];?></td>
							</tr>
							<?}else{}?>
							<tr>
								<th>Numero de Serie:</th>
								<td><?=$row['numSerie'];?></td>
							</tr>
							<tr>
								<th>Fecha y Hora de Registro</th>
								<td><?=$row['fecha_registro']?> <?=$row['hora_registro']?></td>
							</tr>
							<tr>
								<th>Descripción:</th>
								<td><?=$row['observaciones']?></td>
							</tr>
						</table>
					</div>
<?
					}
					?>
			</div><?
			}
		}//fin de consulta
		
		public function formAgrega($id_lote,$id_proyecto,$noItem,$idUsuario){
			$conMov="SELECT * FROM lote where id_lote='".$id_lote."'";
			$exeCon=mysql_query($conMov,$this->conectarBd());
			$rowMovC=mysql_fetch_array($exeCon);
			?>
				<table align="center"><form name="agrega" id="agrega">
				<input type="hidden" name="id_SEC" id="id_SEC">
					<tr>
						<th colspan=2  align="center">Detalle de la referencia: <?=$rowMovC['num_po']?></th>
					</tr>
					<tr>	
						<th  align="left">Num parte</th>
						<td><input type="text"name="noParte" id="noParte" onkeyup="buskSEC(event);" /></td>
					</tr>
					<tr>	
						<th  align="left">Num SECN</th>
						<td><input type="text" name="noSEC" id="noSEC" readonly=""/></td>
					</tr>
					<tr>
						<th  align="left">Modelo</th>
						<?
						$Mod="SELECT * FROM CAT_modelo";
						$sqlMod=mysql_query($Mod,$this->conectarBd());
						?>
						<td>
							<select id="modelo" style="width:235px;">
								<option value="0">Seleccione un Modelo</option>
								<?
								while($rowMod=mysql_fetch_array($sqlMod)){
									?>
									<option value="<?=$rowMod['id_modelo'];?>"><?=$rowMod['modelo'];?></option>
									<?
								}
								?>
							</select>
						</td>
						<!--<td><input type="text" name="modelo" id="modelo" onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); " /></td>-->
					</tr>
					<?if($id_proyecto==2){?>
					<tr>
						<th  align="left">Code Type</th>
						<td><input type="text" name="codeType" id="codeType" onkeyup="this.value = this.value.replace (/[]/, '');" value=""/></td>		    
					</tr>
					<tr>
						<th  align="left">Flow Tag</th>
						<td><input type="text" name="flowTag" id="flowTag" value=""/></td>
					</tr>
					<?}
					else {}?>
					<tr>
						<th  align="left">Num Serie</th>
						<td><input type="text" name="numSerie" id="numSerie" onkeyup="this.value = this.value.replace (/[]/, ''); "/></td>	    
					</tr>
					<tr>
						<th align="left">Tipo de Comodity</th>
						<td>
							<select name="tipoComodity" id="tipoComodity" style="width:235px;">
								<option value="">Selecciona tipo de comodity:</option>
								<?
								$com="Select * from CAT_commodity";
								$comExe=mysql_query($com,$this->conectarBd());
								while($fetchCom=mysql_fetch_array($comExe)){
									?>
									<option value="<?=$fetchCom['id_commodity']?>"><?=$fetchCom['desc_esp'];?></option>
									<?
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th align="left">Observaciones</th>
						<td><textarea name="obs" id="obs" maxlength="100"style="width: 230px;" ></textarea></td>
					</tr>
					<tr>
						<td colspan=2 align="right"><input type="button" name="envia" id="envia" value="Guardar" onclick="confirmar();agregar('<?=$id_lote?>','<?=$id_proyecto?>','<?=$noItem?>','<?=$idUsuario?>')"/><input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cerrarVentana('divMensajeCaptura','transparenciaGeneral1');consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Consulta','<?=$idUsuario?>')"/></td>
					</tr>
				</table></form><?
		}
		public function agregar($id_modelo,$codeType,$flowTag,$numSerie,$desc,$id_lote,$id_proyecto,$noItem,$idSENC,$idTipoComodity,$idUsuario){
			$conPrueba="SELECT * from detalle_lotes where id_lote=$id_lote";
			$conPrueba2=mysql_query($conPrueba,$this->conectarBd());
			$a=mysql_num_rows($conPrueba2);
			/*BUSCA LA SERIE PARA QUE NO SE REPITA*/
			$conPruebaN="SELECT * FROM detalle_lotes WHERE numSerie='".$numSerie."' order by (id_item) desc";
			$exeConPruebaN=mysql_query($conPruebaN,$this->conectarBd());
			$noAparece=mysql_num_rows($exeConPruebaN);
			if($noAparece==0){
				$comeBackReal=1;
			}else{
				$conPruebaNT="SELECT * FROM detalle_lotes WHERE numSerie='".$numSerie."' order by (id_item) desc";
				$exeConPruebaNT=mysql_query($conPruebaNT,$this->conectarBd());
				$rowSum=mysql_fetch_array($exeConPruebaNT);
				$comeBackReal=$rowSum["cantEntrada"]+1;
				$comeActual=$noAparece;
				if($comeActual>1){
					$nmVec="veces";
				}else{
					$nmVec="vez";
				}
				$xi=0;
			}
			/*fIN BUSQUEDA*/
			$fechaReg=date('Y-m-d');
			$horaReg=date('G:i:s');
				if($a < $noItem){
					$add="INSERT INTO detalle_lotes (id_modelo,codeType,flowTag,numSerie,observaciones,id_lote,id_Senc,fecha_registro,hora_registro,id_commodity,cantEntrada) VALUES ('".$modelo."','".$codeType."','".$flowTag."','".$numSerie."','".$desc."','".$id_lote."','".$idSENC."','".$fechaReg."','".$horaReg."','".$idTipoComodity."','".$comeBackReal."')";
					//print($add)					;
					$una=mysql_query($add,$this->conectarBd());
					if(!$una){
						echo 'Error: ' . mysql_error();
						?>
						<script type="text/javascript">alert("El item NO ha sido guardado intente mas tarde");</script>
						<?
					}
					else{
					include("../../clases/claseDetalle.php");
					$objClase=new claseDetalle();
					$idUltimo=mysql_insert_id($this->conectarBd());
					$objClase->consulta($idUltimo,$idUsuario,"Agrega Item");
						if($noAparece==0){
							?><script type="text/javascript">alert("El item ha sido guardado Satisfactoriamente");consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Consulta');formAgrega('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','<?=$idUsuario;?>');</script><?
						}else{

							?><h3>El Item que ingres&oacute; ya ha sido procesado <?=$comeActual;?> <?=$nmVec?></h3><br>
							<div class="opcionesEnsamble2" onclick="clean2();consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Consulta');formAgrega('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','<?=$idUsuario;?>');" title="Siguiente">Continuar</div>
							<div style="width:98%;height:70%;clear:both;">
							<table class="tablaAntes">
								<tr>
									<th>#</th>
									<th>No. Serie</th>
									<th>Fecha Registro</th>
									<th>Hora Registro</th>
									<th>Detalles</th>
								</tr>
								<?
								while($rowRegSerie=mysql_fetch_array($exeConPruebaN)){
									//$nomDiv="Div".$rowRegSerie["id_item"];
									//$msgDiv="msgDetalles".$rowRegSerie["id_item"];
								?>
								<tr>
									<td><?=$xi;?></td>
									<td><?=$rowRegSerie["numSerie"]?></td>
									<td><?=$rowRegSerie["fecha_registro"]?></td>
									<td><?=$rowRegSerie["hora_registro"]?></td>
									<td><a href="#" onclick="generarVentana('Informaci&oacute;n','800','800','controladorEnsamble.php','action=muestraDetalles&idItem=<?=$rowRegSerie['id_item']?>');" title="Da click para ver más detalles">+</a></td>
								</tr>
								<!--<tr>
									<td colspan="5">
										<div id="<?=$nomDiv?>"style="width:98%;height:200px;font-size:10px;text-align:center;display:none;">
											<div id="barraTituloDetalles" style="">Detalles...<div id="btnCerrarVentanaDialogo"><a href="#" onclick="oculta('<?=$nomDiv?>')" title="Cerrar Detalles"><img src="../../img/close.gif" border="0" /></a></div></div>
											<div id="<?=$msgDiv;?>" class="msgVentanaDialogo"></div>
										</div>
									</td>
								</tr>-->
								<?$xi++;}?>
							</table>
						</div>
							<?
						}
					}
				}
				if($a>$noItem|| $a==$noItem){
					?><script type="text/javascript">alert("Ha sobrepasado los Items verifique los datos"); consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Consulta');</script>"<?
				}
		}// fin de agregar
		public function formModifica($id_lote,$id_proyecto,$idItem,$idUsuario){
			$conMov="SELECT * FROM lote where id_lote='".$id_lote."'";
			$exeCon=mysql_query($conMov,$this->conectarBd());
			$rowMovC=mysql_fetch_array($exeCon);
			$Item="SELECT * FROM detalle_lotes where id_lote=$id_lote and id_item=$idItem";
			//print($Item);
			$ItemC=mysql_query($Item,$this->conectarBd());
			$row=mysql_fetch_array($ItemC);
?>
			<form name="modificaDL" id="modificaLote"><table align="center">
				<input type="hidden" name="id_SEC" id="id_SEC" value="<?=$row['id_Senc']?>">
				<tr>
					<th colspan=2  align="center">Detalle de la referencia: <?=$rowMovC['num_po']?></th>
				</tr>
				<?
						$idSenc=$row['id_Senc'];
						$findSenc="Select * from CAT_SENC where id_SENC=$idSenc";
						$exeFindSenc=mysql_query($findSenc,$this->conectarBd());
						$rowSENC=mysql_fetch_array($exeFindSenc);
				?>
				<tr>	
					<th  align="left">Num parte</th>
					<td><input type="text"name="noParte" id="noParte" onclick="limpia('noSEC');"onkeyup="buskSEC(event);" value="<?=$rowSENC['NoParte']?>" /></td>
				</tr>
				<tr>	
					<th  align="left">Num SECN</th>
					
					<td><input type="text"name="noSEC" id="noSEC" readonly="" value="<?=$rowSENC['SECN'];?>"/></td>
				</tr>
				<tr>
					<th  align="left">Modelo</th>
					<td><input type="text" name="modelo" id="modelo" value="<?=$row['modelo']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); "/></td>		    
				</tr>
			<?if($id_proyecto==2){?>
				<tr>
					<th  align="left">Code Type</th>
					<td><input type="text" name="codeType" id="codeType" value="<?=$row['codeType']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9]/, ''); "/></td>		    
				</tr>
				<tr>
					<th  align="left">Flow Tag</th>
					<td><input type="text" name="flowTag" id="flowTag" value="<?=$row['flowTag']?>"/></td>
				</tr>
			<?}
			else {}?>
				<tr>
					<th  align="left">Num Serie</th>
					<td><input type="text" name="numSerie" id="numSerie" value="<?=$row['numSerie']?>"onkeyup="this.value = this.value.replace (/[^aA-zZ\^0-9 ]/, ''); "/></td>	    
				</tr>
				<tr>
					<th  align="left" style="width: 5px;">Fecha</th>
					<td><input type="text" name="date" id="date" value="<?=$row['fecha_registro']?>"/><input type="button" id="lanzador1" value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
								Calendar.setup({
								inputField     :    "date",      // id del campo de texto
								ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
								button         :    "lanzador1"   // el id del botón que lanzará el calendario
								});
						</script></td>    
				</tr>
				<tr>
					<th  align="left">Hora</th>
					<td><input type="text" name="hour" id="hour" value="<?=$row['hora_registro']?>" readonly/></td>
				</tr>
				<tr>
					<th align="left">Tipo de Comodity</th>
					<?
					$idCom=$row['id_commodity'];
					$conCom="SELECT * FROM CAT_commodity WHERE id_commodity=$idCom";
					$exeConCom=mysql_query($conCom,$this->conectarBd());
					$fetArrCom=mysql_fetch_array($exeConCom);
					?>
					<td>
						<select name="tipoComodity" id="tipoComodity">
							<option value="<?=$idCom?>"><?=$fetArrCom['desc_esp'];?></option>
							<?
							$com="Select * from CAT_commodity where id_commodity!= $idCom";
							$comExe=mysql_query($com,$this->conectarBd());
							while($fetchCom=mysql_fetch_array($comExe)){
								?>
								<option value="<?=$fetchCom['id_commodity']?>"><?=$fetchCom['desc_esp'];?></option>
								<?
							}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<th align="left">Observaciones</th>
					<td><textarea name="desc" id="desc" maxlength="100" value="descripcion" style="width: 225px;"></textarea></td>
				</tr>
			    
				<tr>
					<td colspan=2 align="center"><input type="button" name="envia" id="envia" value="GUARDAR" onclick="confirmar();modifica('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$idItem?>','<?=$idUsuario?>')"/><input type="button" id="cancelar" name="cancelar" onclick="cerrarVentana('divMensajeCaptura','transparenciaGeneral1');consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Modifica','<?=$idUsuario?>')" value="CANCELAR"/></td>
				</tr>
			</table></form><?
		}//fin formModifica
		
		public function modifica($modelo,$codeType,$flowTag,$numSerie,$fechaReg,$horaReg,$desc,$id_lote,$id_proyecto,$idItem,$idTipoComodity,$idUsuario,$idSENC){
			$muestraOriginal="SELECT * FROM detalle_lotes WHERE id_item='".$idItem."'";
			$DATE=date('Y-m-d');
			$HOUR=date('G:i:s');
			$exeOriginal=mysql_query($muestraOriginal,$this->conectarBd());
			$arrayOriginal=mysql_fetch_array($exeOriginal);
			$resp="INSERT INTO detalleLotes_cambios (fecha_cambio, hora_cambio, id_usuarioCambio,id_item, id_modelo, codeType, flowTag, numSerie, observaciones, id_Senc, fecha_registro, hora_registro, id_commodity)
			VALUES ('".$DATE."','".$HOUR."','".$idUsuario."','".$idItem."','".$arrayOriginal['id_modelo']."','".$arrayOriginal['codeType']."','".$arrayOriginal['flowTag']."','".$arrayOriginal['numSerie']."','".$arrayOriginal['observaciones']."','".$arrayOriginal['id_Senc']."','".$arrayOriginal['fecha_registro']."','".$arrayOriginal['hora_registro']."','".$arrayOriginal['id_commodity']."')";
			$mod="UPDATE detalle_lotes SET id_modelo='".$modelo."',codeType='".$codeType."',flowTag='".$flowTag."',numSerie='".$numSerie."',observaciones='".$desc."',fecha_registro='".$fechaReg."',id_commodity='".$idTipoComodity."',id_Senc='".$idSENC."' WHERE id_lote='".$id_lote."' and id_item='".$idItem."'";
			$una=mysql_query($mod,$this->conectarBd());
			if(!$una){
				echo 'Error: ' . mysql_error();
					?><script type="text/javascript">alert("El ITEM NO se modifico correctamente");</script><?
				}
				else{
					include("../../clases/claseDetalle.php");
					$objClase=new claseDetalle();
					$objClase->consulta($idItem,$idUsuario,"Modifica Item");
					$insertaOriginal=mysql_query($resp,$this->conectarBd());
					?><script type="text/javascript">alert("El Item ha sido modificado satisfactoriamente");consultaDetalleLote('<?=$id_lote;?>','<?=$id_proyecto?>','<?=$noItem?>','Consulta','<?=$idUsuario?>'); </script><?
				}
		}//fin modifica

		public function formSENC($noParte){
			?><br>
			<form name="SENC" id="SENC">
				<table align="center">
					<tr align="center">

						<th colspan=2 >Agrega Nuevo SENC</th>
					</tr>
					<tr align="left">
						<th>No. Parte:</th>
						<td><input type="text" name="nPar" id="nPar" style="width:150px;" value="<?=$noParte?>" readonly/></td>
					</tr>
					<tr align="left">
						<th>SENC:</th>
						<td><input type="text" name="SENC" id="NSENC" style="width:150px;" autofocus/></td>
					</tr>
					<tr align="left">
						<th>Plataforma:</th>
						<td><input type="text" name="plataF" id="plataF" style="width:150px;"/></td>
					</tr>
					<tr align="left">
						<th>Descripción:</th>
						<td><textarea name="descSe" id="descSe"></textarea></td>
					</tr>
					<tr align="left">
						<th>Proceso:</th>
						<td><textarea name="procSe" id="procSe"></textarea></td>
					</tr>
					<tr>
						<th colspan=2 align="right"><input type="button" id="canc" value="Cancelar" onclick="cerrarVentana('divAgrega','transparenciaOp');"/><input type="button" id="Guarda" value="Aceptar" onclick="guardaSENC();"</th>
					</tr>
				</table>
			</form><?
		}

		public function guardaSENC($noParte,$SENC,$plataF,$desSEN,$procSe){
			$insertSENC="INSERT INTO CAT_SENC (Plataforma,NoParte,SECN,descripcion, proceso) VALUE ('".$plataF."','".$noParte."','".$SENC."','".$desSEN."','".$procSe."')";
			$exeIns=mysql_query($insertSENC,$this->conectarBd());
				if(!$exeIns){
					?><script type="text/javascript">alert("El SENC NO se agrego correctamente");</script><?
				}
				else{
					$id_SENC=mysql_insert_id();
					?><script type="text/javascript">alert("El SENC se ha agregado satisfactoriamente"); cerrarVentana('divAgrega','transparenciaOp'); 
						inserta('<?=$id_SENC?>','<?=$SENC?>','<?=$noParte?>');
						cerrarVentana('divAgrega','transparenciaOp');
					</script><?
				}
			/*
			cerrarVentana('divAgrega','transparenciaOp');
			*/
		}
		public function listaMov($id_proyecto,$idUsuario){
			$conMovLotes="SELECT id_mov FROM  lote group by (id_mov)";
			$movUsados=array();
			$exeMovL=mysql_query($conMovLotes,$this->conectarBd());
			if($exeMovL==false){
				exit;
			}else{
				$numMovL=mysql_num_rows($exeMovL);
				if($numMovL!=0){
					while($rowML=mysql_fetch_array($exeMovL)){
						array_push($movUsados, $rowML['id_mov']);
					}
					$usadosMov=implode("','", $movUsados);
					$condicion=" AND id_mov NOT IN ('".$usadosMov."')";
				}else{
					$condicion="";
				}
			}
			$ConsMov="SELECT * FROM mov_almacen WHERE tipo_mov=2".$condicion." order by id_mov desc";
			//print($ConsMov);
			$exeConMov=mysql_query($ConsMov,$this->conecta2());
			if($exeConMov==false){
				print("No se pueden mostrar los movimientos");
			}else{
				$cuantosMov=mysql_num_rows($exeConMov);
				if($cuantosMov>0){
					?><br>
					<table border="0" align="center" style="width:98%;font-size:10px; border:1px solid #000;">					
					<tr>
						<td colspan="5" style="text-align: right;">
							<input type="button" name="next" id="next" value="SIGUIENTE" onclick="formLotes('<?=$id_proyecto?>','<?=$idUsuario;?>');"/>
							<input type="button" name="back" id="back" onclick="cerrarVentana('divMensajeCaptura','transparenciaGeneral1');" value="CANCELAR"/>
						</td>
					</tr>
					<tr>
						<th colspan="4">MOVIMIENTOS REALIZADOS</th>						
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>Referencia</td>
						<td>Cantidad</td>
						<td>Fecha</td>
						<td>Asociado</td>
					</tr>
<?
					$colorL="#FFF";
					while($rowM=mysql_fetch_array($exeConMov)){
						($colorL=="#FFF") ? $colorL="#EEE" : $colorL="#FFF";
						if($rowM["tipo_mov"]==2){
							$sqlConcepto="SELECT * FROM tipoalmacen WHERE id_almacen='".$rowM["asociado"]."'";
							$resConcepto=mysql_query($sqlConcepto,$this->conecta2());
							$rowConcepto=mysql_fetch_array($resConcepto);
							//se consulta el total por cantidad del movimiento
							$sqlNM="SELECT SUM(cantidad) AS totalItems FROM prodxmov WHERE nummov='".$rowM['id_mov']."'";
							$resNM=mysql_query($sqlNM,$this->conecta2());
							$rowNM=mysql_fetch_array($resNM);
						}
						if(strtoupper($rowConcepto["observ"])=="INGENIERIA IBM"){
							
						
?>						<tr style="background:<?=$colorL;?>">
							<td style="height: 15px;padding: 3px;text-align:center; width:10%"><input type="radio" name="movimientos" id="movimientos" value="<?=$rowM['id_mov'];?>"/></td>
							<td style="height: 15px;padding: 3px;text-align:justify; width:28%"><?=$rowM["id_mov"]." - ".strtoupper($rowM["referencia"]);?></td>
							<td style="height: 15px;padding: 3px;text-align:justify; width:28%"><?=strtoupper($rowNM["totalItems"]);?></td>
							<td style="height: 15px;padding: 3px;text-align:justify; width:28%"><?=strtoupper($rowM["fecha"]);?></td>
							<td style="height: 15px;padding: 3px;text-align:justify; width:28%"><?=strtoupper($rowConcepto["observ"]);?></td>
						</tr>
<?	
						}				
					}
					?>
						<tr>
							<td colspan="4"></td>
						</tr>
					</table><?
				}else{
					print("POR EL MOMENTO NO HAY MOVIMIENTOS");
				}
			}
		}
		public function muestraDetalles($idItem){
			$MuestraInfo="SELECT * FROM detalle_lotes INNER JOIN detalleDYR ON detalleDYR.id_item = detalleDYR.id_item INNER JOIN detalleCC ON detalle_lotes.id_item =detalleCC.id_item WHERE detalle_lotes.id_item='".$idItem."' GROUP BY (detalle_lotes.id_item)";
			//print($MuestraInfo);
			$exeMuestra=mysql_query($MuestraInfo,$this->conectarBd());
			if(mysql_num_rows($exeMuestra)==0){
				print("No se encuentra la informacion requerida, intente más tarde");
			}else{
			$rowMuestra=mysql_fetch_array($exeMuestra);
			?><fieldset style="border:6px groove #ccc; background:#E0DFDF; font-size:11px;">
					<legend style="font-weight:bold; color:#000;">DETALLES ITEM:</legend>
					<table border=0>
						<tr>
							<?
								$id_Senc=$rowMuestra['id_Senc'];
								$findSenc="Select * from CAT_SENC where id_SENC=$id_Senc";
								$exeFindSenc=mysql_query($findSenc,$this->conectarBd());
								$rowSENC=mysql_fetch_array($exeFindSenc);?>
							<th align="left">Num. Parte:</th>
							<td><?=$rowSENC['NoParte'];?></td>
						</tr>
						<tr>
							<th align="left">Num. Serie:</th>
							<td><?=$rowMuestra['numSerie'];?></td>
						</tr>
						<?
						$conPO="SELECT * FROM lote WHERE id_lote='".$rowMuestra['id_lote']."'";
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
							$idModelo=$rowMuestra['id_modelo'];
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
								<td><?=$rowMuestra['codeType'];?></td>
							</tr>
							<tr>
								<th align="left">Flow Tag</th>
								<td><?=$rowMuestra['flowTag'];?></td>
							</tr>
						<?}
						else{}?>
						<th align="left">Observaciones:</th>
						<td colspan=3><?=$rowMuestra['observaciones_asginacion'];?></td>
					</table>
				</fieldset>
				<br>
				<fieldset style="border:6px groove #ccc; background:#FFF; font-size:11px;">
					<legend style="font-weight:bold; color:#000;">DIAGNOSTICO Y REPARACIÓN ITEM:</legend><?
						$consCampos="SELECT * FROM CAT_tipoReparacion where id_tipoReparacion='".$rowMuestra['id_tipoReparacion']."'";
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
								$fab="SELECT * FROM CAT_fabricante WHERE id_fabricante='".$rowMuestra['id_fabricante']."'";
								$exeFab=mysql_query($fab,$this->conectarBd());
								$rowfoundFab=mysql_fetch_array($exeFab);
								?>
			 					<td><?=$rowfoundFab['nombre_fabricante'];?></td>
								<td>&nbsp;</td>
							</tr>
							<tr align="left">
								<th>Tipo de Reparacion:</th>
								<td><?=$ArrayExeCampos['tipo_reparacion'];?></td>
								<td>(<?=$ArrayExeCampos['descripcion'];?>)</td>
							</tr><?
							for($i=0;$i<$totalArrayCampos;$i++){
								$divideCampo=explode("-",$arrayCampos[$i]);
								if($divideCampo[1]==1){
										$contenedorArray[$i]="id_".$divideCampo[0];
										$valDatos=$rowMuestra[$contenedorArray[$i]];
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
										<td><?=$rowMuestra[$contenedorArray[$i]]?></td>
										<td><?=$unidad?></td>
									</tr>
									<?
								}
							
							}
						?></table><?
				//}?>
				</fieldset>
				<br>
				<fieldset style="border:6px groove #ccc; font-size:11px;">
					<?
					$chkList="SELECT * FROM detalleCC WHERE id_item='".$idItem."'";
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
						<legend style="font-weight:bold; color:#000;">ASEGURAMIENTO DE CALIDAD:</legend>
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
				</fielset>
				<?
					}
			}
		}//final de  
	}//fin de la clase
?>
