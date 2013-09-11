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
			?>
			<div style="height:20px;width:98%;background:#e1e1e1;color:#000; text-align:center;clear:both;font-size:14px;">Formatos para lote: <?=$idLote?> con Referencia: <?=$numPo?></div>
			<div style="height:auto; width:98% background:#FFF; color:#000; text-align:justify;clear;both;font-size:12px;padding:10px;">

				<?
				$formatos= array(
					"IQF0750301_PARTES_REPARADAS_REV_01",
					"IQF0750302_REPORTE_DE_SALIDA_DE_MONITORES_REPARADOS_REV_01",
					"IQF0750305_FORMATO_DE_FACTURACION_DE_MONITORES_REPARADOS_REV_01",
					"IQF0750308_PARTES_IRREPARABLES_REV_01",
					"IQF0750309_GARANTIAS_REPARADAS_REV_01",
					"IQFO750303_Ingreso_de_Equipo_a_Almacen_de_Producto_Terminado_Rev_00",
					"IQFO750304_INVENTARIO_DE_MONITORES_SCRAP_REV_01",
					"IQFO750306 Informe de Danos o Sucesos Version 00",
					"IQFO750307_CONTROL_DE_RECIBO_COSMETICA_ REV_01",
					"IQFO750311_REACOND_COSMETICO_HP_SCITEX_REV_00",
  					"IQFO750316 Formato de Salida HP SCITEX Version 00",
  					"IQFO750317_HOJA_DE_CAPTURA_PARA_PHOENIX_REV_00",
  					"IQFO750318_HP_CHECK_LIST_FINAL_REV_00",
  					"IQFO750319_CODIGOS_DE_FALLAS_REV_00",
  					"IQFO750320_REPORTE_DE_SALIDA_DE_MONITORES_SCRAP_PSG_REV_00",
  					"IQFO750321_HOJA_DE_ASIGNACION_HP_PSG_R&B_REV_00",
  					"IQFO750322_CODIGOS_ DE_ REPARACION_REV_00");?>

				<table class="tablaForma">
					<?for($fo=0;$fo<count($formatos);$fo++){
						$arrN=explode("_",$formatos[$fo]);
						$noFormato=$arrN[0];
						$nameLink=$noFormato.$idLote;?>

					<tr>
						<td><a id="<?=$nameLink?>" href="#" onclick="formatoPDF('<?=$noFormato?>','<?=$idLote?>','<?=$idUsuario?>','<?=$idProyecto?>')" title="Visualizar formato <?=$noFormato?>" class="stiloA"><?=strtoupper($formatos[$fo]);?></a></td>
					</tr>
					<?}?>
				</table>
			</div>
			<?
		}
	}