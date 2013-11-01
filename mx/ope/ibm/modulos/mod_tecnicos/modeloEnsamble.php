<?
	/*
	 *modeloEnsamble:  Clase del modulo mod_tecnicos realiza las asignaciones y re-Asignaciones para cada uno de los Items,
	 ademas de poder dar de alta y/o baja a los tecnicos involucrados en el proyecto
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:29/Nov/2012
	 __________________________________________________________________________
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

		public function mostrarLotesProyecto($opt,$id_usuario,$idProyecto){/*Funcion que muestra los lotes que hay en el sistema*/
			$objCargaInicial=new verificaCargaInicial();
			$con="SELECT * FROM lote WHERE id_proyecto='".$idProyecto."' AND status='Recibido' ORDER BY(id_lote) DESC";
			$cons=mysql_query($con,$this->conectarBd());
			$name_pro=$objCargaInicial->dameNombreProyecto($idProyecto);
			if(mysql_num_rows($cons)==0){
				echo"No hay registros que mostrar";
			}else{
?>
				<h3 align="center">Linea <?=$name_pro;?></h3>
				<div id="titulo" style="background: #CCC; width: 100%; height:20px; font-size: 12px;text-align: center;font-weight: bold;"><?=strtoupper($opt);?> TÉCNICOS</div>
				
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
						$link="consultaDetalleLote('".$row['id_lote']."','".$idProyecto."','Consulta','".$id_usuario."');";
						$txt="De click para consultar la Asignacion del ITEM";
					}
					if($opt=="Asigna"){
						$link="consultaDetalleLote('".$row['id_lote']."','".$idProyecto."','Asigna','".$id_usuario."');";
						$txt="De click para modificar el lote";
					}
					if($opt=="Re-Asigna"){
						$link="consultaDetalleLote('".$row['id_lote']."','".$idProyecto."','Re-Asigna','".$id_usuario."');";
						$txt="De click para modificar el lote";
					}
?>
					<div id="showLote" style="background: <?=$color;?>;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<table border=0>
							<tr>
								<th><?if($idProyecto==1){?>Pre-Alerta<?}else{?>Num. PO<?}?></th>
								<td><?=$row['num_po'];?></td>
							</tr>
							<tr>
								<th>No. ITEM</th>
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
		public function consultaDetalleLote($id_lote,$id_proyecto,$opt,$idUsuario){
			?>
			<div id="contenedorDetalleLote" style="background: #FFF;height: 80%;clear: both">
				<?
				if($opt=="Consulta"){
					$Reg_lote="SELECT * from detalle_lotes where id_lote=$id_lote";
					$inst="Consulte las asignaciones de los ITEMS";
				}
				if($opt=="Asigna"){
					$Reg_lote="SELECT * from detalle_lotes where id_lote=$id_lote AND id_tecnico=0";
					$inst="Seleccione un t&eacute;cnico para realizar la asignaci&oacute;n del ITEM";
				}
				if($opt=="Re-Asigna"){
					$Reg_lote="SELECT * from detalle_lotes where id_lote=$id_lote AND id_tecnico!=0";
					$inst="Seleccione un t&eacute;cnico para realizar la re-asignaci&oacute;n del ITEM";
				}
				$reg_loteCon=mysql_query($Reg_lote,$this->conectarBd());
				if(mysql_num_rows($reg_loteCon)==0){
					if($opt=="Asigna"||$opt=="Re-Asigna"){
						$consultaNueva="SELECT * from detalle_lotes where id_lote=$id_lote";
						$exeConsultaNueva=mysql_query($consultaNueva,$this->conectarBd());
						if(mysql_num_rows($exeConsultaNueva)==0){
							?><script type="text/javascript">alert("El Lote se encuentra vacio");</script><?
						}else{
							if($opt=="Asigna"){
								?><script type="text/javascript">alert("Los ITEMS han sido Asignados a un técnico\nVaya al apartado de Re-Asignar si desea modificarlos");</script><?
							}else{
								?><script type="text/javascript">alert("Los ITEMS aún NO han sido Asignados a un técnico\nVaya al apartado de Asignar");</script><?
							}
							
						}
					}else{
						?><script type="text/javascript">alert("El Lote se encuentra vacio");</script><?
					}
				}
				else{
					$conL="SELECT * FROM lote WHERE id_lote='".$id_lote."'";
					$exeConL=mysql_query($conL,$this->conectarBd());
					$rowL=mysql_fetch_array($exeConL);
					//$inst="nada";
	?>
					<div id="tituloDetalle" style="background: #DDD;width: 100%; height:20px; font-size: 12px;text-align: center;font-weight: bold;"><?=strtoupper($opt);?> DETALLE DE LA REFERENCIA <?=$rowL['num_po'];?></div>
					<div id="barraOpcionesEnsamble">
						<div class="opcionesEnsamble" onclick="clean2();consultaDetalleLote('<?=$id_lote?>','<?=$id_proyecto?>','Asigna','<?=$idUsuario?>');" title="Asignar">Asignar</div>
						<div class="opcionesEnsamble" onclick="clean2();consultaDetalleLote('<?=$id_lote?>','<?=$id_proyecto?>','Re-Asigna','<?=$idUsuario?>');" title="Re-Asignar">Re-Asignar</div>
					</div>
					<div id="Instrucciones" style="background: #e1e1e1;width: 100%; height:15px; font-size: 12px;text-align: justify;font-weight: bold;clear:both; color:#000;padding:5px;margin-top:10px;"><?=$inst;?></div>
				   <?
					while ($row=mysql_fetch_array($reg_loteCon)){
						if($color=="#FFFFFF"){
							$color="#EEE";
						}else{
							$color="#FFFFFF";
						}
						if($opt=="Consulta"||$opt=="Asigna"||$opt="Re-Asigna"){
							$link="";
							$txt="";
						}
	?>
					<div id="showdetalleLote"style="background: <?=$color;?>;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<table>
							<tr>
								<?
								$idSenc=$row['id_Senc'];
								$findSenc="Select * from CAT_SENC where id_SENC=$idSenc";
								$exeFindSenc=mysql_query($findSenc,$this->conectarBd());
								$rowSENC=mysql_fetch_array($exeFindSenc);
								?>
								<th>Numero de Parte:</th>
								<td><?=$rowSENC['NoParte']?></td>
							</tr>
							<tr>
								<th>SENC:</th>
								<td><?=$rowSENC['SECN'];?></td>
							</tr>
							<tr>
								<th>Modelo:</th>
								<?
								$idMod=$row['id_modelo'];
								$queMod="SELECT * FROM CAT_modelo WHERE id_modelo=$idMod";
								$exeQueMod=mysql_query($queMod,$this->conectarBd());
								$fetAMod=mysql_fetch_array($exeQueMod);
								?>
								<td><?=$fetAMod['modelo'];?></td>
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
								<th>Asignado a:</th>
								<?
								$idTecnico=$row['id_tecnico'];
								$conNT="SELECT * FROM userdbcontroloperaciones WHERE ID=$idTecnico";
								$exeConNT=mysql_query($conNT,$this->conectarBd());
								$rowTEC=mysql_fetch_array($exeConNT);
								if($opt=="Consulta"){
									if($idTecnico==0){
									$idStyle="sombrea";
									$tecnico="Aún no se ha asignado ningun técnico";
									}else{
									$idStyle="normal";
									$tecnico=$rowTEC['nombre']." ".$rowTEC['apaterno'];
									}
									?>
									<td id="<?=$idStyle;?>"><?=$tecnico;?></td>
								<?}
								if($opt=="Asigna"||$opt=="Re-Asigna"){
									?><td><select name="tecnico" id="tecnico" onchange = "guardalo(this,'<?=$id_lote?>','<?=$id_proyecto;?>','<?=$row['id_item'];?>','<?=$idUsuario;?>','<?=$opt;?>')">
									 <?if($opt=="Asigna"){?>
										<option value="">Selecciona Tecnico</option>
									<?}
									else{
										?><option value="<?=$idTecnico;?>"><?=$rowTEC['nombre']." ".$rowTEC['apaterno'];?></option><?
									}
									$queryTecnicos="Select * from userdbcontroloperaciones where grupo2=2 and activo=1";
									$playQueryTecnicos=mysql_query($queryTecnicos,$this->conectarBd());
									while($rowTecnicos=mysql_fetch_array($playQueryTecnicos)){
										$name=$rowTecnicos['nombre']." ".$rowTecnicos['apaterno'];
										?><option value="<?=$rowTecnicos['ID']?>"><?=$name;?></option><?
									}
									?></select></td><?
								}
								?>
							</tr>
							<tr>
								<th>Observaciones de Asignacion:</th>
								<td><?=$row['observaciones_asignacion']?></td>
							</tr>
						</table>
					</div>
<?
					}
					?>
			</div><?
			}
		}//fin de consulta
		public function guardaTec($id_tecnico,$id_proyecto,$idItem,$idLote,$idUsuario,$opt){
			$insertaTec="UPDATE detalle_lotes SET id_tecnico=$id_tecnico, status='Asignado' WHERE id_item=$idItem";
			$ejecutaUp=mysql_query($insertaTec,$this->conectarBd());
			 if(!$ejecutaUp){
				?><script type="text/javascript">clean2();alert("No se pudo asignar tecnico intente de nuevo");</script><?
			 }
			 else{
			 	include("../../clases/claseDetalle.php");
				$objClase=new claseDetalle();
				$proc=$opt." T&eacute;cnico (id=".$id_tecnico.") al Item" ;
				$objClase->consulta($idItem,$idUsuario,$proc);
				?><script type="text/javascript">clean2();consultaDetalleLote('<?=$idLote?>','<?=$id_proyecto;?>','<?=$opt?>','<?=$idUsuario?>'); title="Asignar" </script><?		
			 }
		}
		public function AB($usuario,$id_proyecto){
			$tec="Select * from userdbcontroloperaciones where grupo2=2";
			$ejecTec=mysql_query($tec,$this->conectarBd());
			?><br><br>
				<h3 align="center">Altas y Bajas de Tecnicos</h3>
			<br><table border=1 align="center">
				<tr align="center">
					<th colspan=5>Seleccione 1=Activado 0=Desactivado</th>
				</tr>
				<tr align="center">
					<th>#</th>
					<th>Usuario</th>
					<th>Nombre</th>
					<th>A. Paterno</th>
					<th>Activo</td>
				</tr><?
			$i=1;
			while($rowTec=mysql_fetch_array($ejecTec)){
				?>

				<tr align="center">
					<td><?=$i;?></td>
					<td><?=$rowTec['usuario'];?></td>
					<td><?=$rowTec['nombre'];?></td>
					<td><?=$rowTec['apaterno'];?></td>
					<td>
						<select name="status" id="status" onchange = "changeStatus(this,<?=$rowTec['ID'];?>,<?=$usuario;?>,<?=$id_proyecto?>)">
						<option value="<?=$rowTec['activo']?>"><?=$rowTec['activo']?></option>
						<option value="1">1</option>
						<option value="0">0</option>
						</select>
					</td>
				</tr>
				<?
				$i++;
			}
			?></table><?
		}
		public function status($status,$ID,$usuario,$id_proyecto){
			if($status==1){
				$st="Activo técnico (id=";
			}else{
				$st="Desactivo técnico (id=";
			}
			$act="UPDATE userdbcontroloperaciones SET activo=$status where ID=$ID";
			$act1=mysql_query($act,$this->conectarBd());
			 if(!$act1){
				echo"No se puede actualizar el status";
			 }
			 else{
			 	include("../../clases/claseDetalle.php");
				$objClase=new claseDetalle();
				$proc=utf8_decode($st).$ID.")";
				$objClase->consulta(0,$usuario,$proc);
				?><script type="text/javascript">clean2(); AB('<?=$usuario?>','<?=$id_proyecto?>'); </script><?
			 }
			
		}
		
	}//fin de la clase
?>
