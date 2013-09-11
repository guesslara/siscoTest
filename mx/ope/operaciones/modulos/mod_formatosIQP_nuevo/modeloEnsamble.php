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
						$link="verFormatos('".$row['id_lote']."','".$idProyecto."','".$id_usuario."','".$row["num_po"]."');";
						$txt="De click para consultar los formatos de este Lote";
					}
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
		}//fin function mostrarLotesProyecto
		public function verFormatos($idLote,$idUsuario,$idProyecto,$numPo){
			$datoE=0;
			?>
			<div style="height:20px;width:98%;background:#e1e1e1;color:#000; text-align:center;clear:both;font-size:14px;">Formatos para lote: <?=$idLote?> con Referencia: <?=$numPo?></div>
			<div style="height:auto; width:98% background:#FFF; color:#000; text-align:justify;clear;both;font-size:12px;padding:10px;">

				<?
				$formatos= array(
					"IQF0750301_PARTES REPARADAS_REV.01_5",
					"IQF0750302_REPORTE DE SALIDA DE MONITORES REPARADOS_REV.01_1",
					"IQF0750308_PARTES IRREPARABLES_REV.01_0",
					"IQF0750309_GARANTIAS REPARADAS_REV.01_5",
					"IQF0750303_INGRESO DE EQUIPO A ALMACEN DE PRODUCTO TERMINADO_Rev.00_2",
					"IQF0750304_INVENTARIO DE MONITORES SCRAP_REV.01_0",
					"IQF0750306_INFORME DE DAÑOS Y SUCESOS_REV.00_3",
  					"IQF0750317_HOJA DE CAPTURA PARA PHOENIX_REV.00_4",
  					"IQF0750318_HP CHECK LIST FINAL_REV.00_8",
  					"IQF0750319_CODIGOS DE FALLAS REV.00_0",
  					"IQF0750320_REPORTE DE SALIDA DE MONITORES SCRAP PSG_REV.00_9",
  					"IQF0750321_HOJA DE ASIGNACION HP PSG R/B_REV.00_4",
  					"IQF0750322_CODIGOS DE REPARACION_REV.00_0");
?>

				<table class="tablaForma">
					<?for($fo=0;$fo<count($formatos);$fo++){
						$arrN=explode("_",$formatos[$fo]);
						$noFormato=$arrN[0];
						$nameLink=$noFormato.$idLote;?>

					<tr>
						<td><a id="<?=$nameLink?>" href="#" onclick="formatoPDF('<?=$noFormato?>','<?=$idLote?>','<?=$idUsuario?>','<?=$idProyecto?>','<?=$formatos[$fo]?>','<?=$datoE?>')" title="Visualizar formato <?=$noFormato?>" class="stiloA"><?=strtoupper($formatos[$fo]);?></a></td>
					</tr>
					<?}?>
				</table>
			</div>
			<?
		}
		public function muestraTec($idLote,$idUsuario,$idProyecto,$noFormato,$nombre,$datoE){
			$conTec="SELECT detalle_lotes.*, userdbcontroloperaciones.* FROM detalle_lotes INNER JOIN userdbcontroloperaciones ON userdbcontroloperaciones.ID= detalle_lotes.id_tecnico WHERE id_lote=$idLote group by (detalle_lotes.id_tecnico)";
			$exeTec=mysql_query($conTec,$this->conectarBd());
			$noTec=mysql_num_rows($exeTec);
			if($noTec==0){
				echo" NO SE ENCUENTRA NINGUN TECNICO";
			}else{
?>
				<select id="tecnicos" nombre="tecnicos" onchange="cerrarVentana('divMensajeCaptura','transparenciaGeneral1');formatoPDF('<?=$noFormato?>','<?=$idLote?>','<?=$idUsuario?>','<?=$idProyecto?>','<?=$nombre?>',this.options[this.selectedIndex].value)">
					<option value="0">Selecciona un t&eacute;cnico</option>
<?
					while($roT=mysql_fetch_array($exeTec)){
?>
						<option value="<?=$roT['ID']?>"><?=$roT['nombre']." ".$roT['apaterno']?></option>
<?
					}
?>
				</select>
<?
			}

		}
	}