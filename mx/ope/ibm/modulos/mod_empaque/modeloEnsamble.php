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
					$cDeL="SELECT * FROM detalle_lotes where id_lote='".$row['id_lote']."' AND (status='Empaque' OR status='CC' OR (status='Diagnosticado_NT' AND cantRechazos!=0) OR (status='Diagnosticado_Ao' AND cantRechazos!=0) OR(status='Diagnosticado_Co' AND cantRechazos!=0) OR (status='Diagnosticado_Ir' AND cantRechazos!=0)OR(status='Diagnosticado_Wk' AND cantRechazos!=0))";
					$exeCDel=mysql_query($cDeL,$this->conectarBd());
					$numEXeCDEL=mysql_num_rows($exeCDel);
					if($numEXeCDEL==0){
					}else{
?>
					<div id="showLote" style="background: <?=$color;?>;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<table border=0>
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
			}
		}//fin function mostrarLotesProyecto
		/****************************************DEtalle lote************************************************/
		public function consultaDetalleLote($id_lote,$id_proyecto,$noItem,$opt,$idUsuario){
			$conMov="SELECT * FROM lote where id_lote='".$id_lote."'";
			$exeCon=mysql_query($conMov,$this->conectarBd());
			$rowMovC=mysql_fetch_array($exeCon);
			?>
			<div id="contenedorDetalleLote" style="background: #FFF;height: 80%;">
				<?
				$Reg_lote="SELECT * from detalle_lotes where id_lote=$id_lote AND (status='Empaque' OR status='CC' OR (status='Diagnosticado_NT' AND cantRechazos!=0) OR (status='Diagnosticado_Ao' AND cantRechazos!=0) OR(status='Diagnosticado_Co' AND cantRechazos!=0) OR (status='Diagnosticado_Ir' AND cantRechazos!=0)OR(status='Diagnosticado_Wk' AND cantRechazos!=0))";
				$reg_loteCon=mysql_query($Reg_lote,$this->conectarBd());
				if(mysql_num_rows($reg_loteCon)==0){
				    echo "<br><br>POR EL MOMENTO LOS ITEMS SE ENCUENTRAN EN OTRO PROCESO";
				}
				else{
	?>
					<div id="tituloDetalle"><?=strtoupper($opt);?> DETALLE DE LA REFERENCIA: <?=$rowMovC['num_po'];?></div>
				   <?
					while ($row=mysql_fetch_array($reg_loteCon)){
						if($color=="#FFFFFF"){
							$color="#EEE";
						}else{
							$color="#FFFFFF";
						}
						$DatosCC="SELECT * FROM detalleCC WHERE id_item='".$row['id_item']."'";
						$exeDatosCC=mysql_query($DatosCC,$this->conectarBd());
						$cunRO=mysql_num_rows($exeDatosCC);
						$colorCC="#000";
						$colorF="#FFF";
						if($cunRO==0){
							$staCC="PENDIENTE";
						}else{
							$rowD=mysql_fetch_array($exeDatosCC);
							$staCC=$rowD['status_cc'];
						}
						if($staCC=='PASS'){
							$colorCC="#39C945";
							$colorF="#FFF";
						}if($staCC=='NO PASS'){
							$colorF="#FFF";
							$colorCC="#FC4040";
						}if($staCC=='PENDIENTE'){
							$colorF="#000";
							$colorCC="#ECE557";

						}
							$link="";
							$txt="";
	?>
					<div id="showdetalleLote" style="background: <?=$color;?>;position:relative;" onclick="<?=$link;?>" title="<?=$txt;?>">
						<div id="detalles" style="width:60%;height:128px; float:left; background:<?=$color;?>">
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
						<div id="statDiv" style="width:100px;height:25px;background:<?=$colorCC;?>;font-size:12px;font-weight:bold;float:right;margin:50px 50px 0px 0px;border:1px dotted #000;text-align:center;color:<?=$colorF?>"><p style="margin:5px 5px 0px 5px;"><?=$staCC;?></p></div>
					</div>
<?
					}
					?>
			</div><?
			}
		}//fin de consulta
	}