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
			<div style="height:auto; width:98%; background: #FFF; color:#000; text-align:justify;clear:both;font-size:12px;padding:10px;">

				<?
				$formatos= array(
					"IQF0750301_PARTES REPARADAS_REV.01_5",
					"IQF0750302_REPORTE DE SALIDA DE MONITORES REPARADOS_REV.01_1",
					"IQF0750305_FORMATO DE FACTURACION DE MONITORES REPARADOS_REV.01_0",
					"IQF0750308_PARTES IRREPARABLES_REV.01_0",
					"IQF0750309_GARANTIAS REPARADAS_REV.01_5",
					"IQF0750303_INGRESO DE EQUIPO A ALMACEN DE PRODUCTO TERMINADO_Rev.00_2",
					"IQF0750304_INVENTARIO DE MONITORES SCRAP_REV.01_0",
					"IQF0750306_INFORME DE DAÑOS Y SUCESOS_REV.00_3",
					"IQF0750307_CONTROL DE RECIBO COSMETICA_REV.01_4",
					"IQF0750311_REACOND COSMETICO HP SCITEX_REV.00_6",
  					"IQF0750316_FORMATO DE SALIDA HP SCITEX REV.00_7",
  					"IQF0750317_HOJA DE CAPTURA PARA PHOENIX_REV.00_4",
  					"IQF0750318_HP CHECK LIST FINAL_REV.00_8",
  					"IQF0750319_CODIGOS DE FALLAS REV.00_0",
  					"IQF0750320_REPORTE DE SALIDA DE MONITORES SCRAP PSG_REV.00_9",
  					"IQF0750321_HOJA DE ASIGNACION HP PSG R&B_REV.00_4",
  					"IQF0750322_CODIGOS DE REPARACION_REV.00_0");?>

				<table class="tablaForma">
					<?for($fo=0;$fo<count($formatos);$fo++){
						$arrN=explode("_",$formatos[$fo]);
						$noFormato=$arrN[0];
						$nameLink=$noFormato.$idLote;?>

					<tr>
						<td><a id="<?=$nameLink?>" href="#" onclick="formatoPDF('<?=$noFormato?>','<?=$idLote?>','<?=$idUsuario?>','<?=$idProyecto?>','<?=$formatos[$fo]?>')" title="Visualizar formato <?=$noFormato?>" class="stiloA"><?=strtoupper($formatos[$fo]);?></a></td>
					</tr>
					<?}?>
				</table>
			</div>
			<?
		}
		
			  
	        function insertardatos($date,$hora,$nom,$intrr,$numparte,$foto,$coment,$firma){
			$foto="../pag_guardar_imagen/uploads/".$foto;
			$sql="INSERT INTO detalle_IQFO750306 (fecha,hora,destinatario,introduccion,num_parte,imagenes,comentarios,elaboro) VALUES ('".$date."', '".$hora."', '".$nom."', '".$intrr."', '".$numparte."', '".$foto."', '".$coment."','".$firma."')";
                        //echo"$sql";
			$exeCon=mysql_query($sql,$this->conectarBd());
			if(!$exeCon){
?>
                       <script type="text/javascript">
			alert("Lo sentimos tu informacion no ha sido insertada");
		       </script>       
<?php
                        }else{
?>
                       <script type="text/javascript">
			alert("Informacion insertada correctamente");
		       </script>       

				<div id="uno" style="width:100%; height:100%">
	
			<table border = "" cellpading "0" cellspacing = "0" style=" margin: 8px 50px 10px 30px;">
				
			<tr>		
			   <td style="font-size: 9pt;"><b>FECHA:</b></td>
			   <td><input type ="text" name = "fecha" id = "fecha"  value="<?="$date";?>" size="50" style="width:200px;height:20px;"/>
			   <td><b>HORA</b> <input type="text" name="reloj" id="reloj"  value="<?="$hora";?>" size="10"></td>
			   <!--<input type="button" id="date"  value="..." />-->
			<!-- script que define y configura el calendario-->
			<script type="text/javascript">
			    Calendar.setup({
			    inputField     :    "fecha",      // id del campo de texto
			    ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
			    button         :    "date"   // el id del botón que lanzará el calendario
			    });
			</script>
			  </td>
			 </tr>
			</table>
			
			<table border = "" cellpading "0" cellspacing = "0" style=" margin: 5px 50px 10px 30px;">
			<tr>
			   <td style="font-size: 8pt;"><b>DIRIGIDO A:</b> </td>
			   <td><input type ="text" name = "nombre" id = "nombre" value="<?="$nom";?>" style="width:382px;height:25px;"/></td>
			 </tr>
			</table>
			<table border = "" cellpading "0" cellspacing = "0"  style=" margin: 5px 50px 10px 30px;">
			<tr>
			   <td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>INTRODUCCI&Oacute;N:</b></td>
			</tr>
			<tr>
			   <td><textarea name = "intro" id = "intro" cols="5" rows="3" style="width:630px;height:50px;"><?="$intrr";?></textarea></td>
			 </tr>
			</table>
			 <table border = "" cellpading "0" cellspacing = "0" style=" margin: 5px 50px 10px 30px;">
			 <tr>
			   <td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>CONTENIDO/PRODUCTOS Y/O N&Uacute;MEROS DE PARTE OBJETO DEL INFORME</b></td>
			</tr>
			 <tr>
			   <td><textarea name = "numpart" id = "numpart" cols="5" rows="3"   style="width:630px;height:50px;"><?="$numparte";?></textarea></td>
			 </tr>
			</table>
			<table border = "" cellpading = "0" cellspacing = "0" style=" margin: 5px 50px 10px 30px; width:630px;">
			 <tr>
			<td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt;"><b>FOTOGRAF&Iacute;AS O GR&Aacute;FICOS</b> (SI APLICA)
			   <!--<input type ="file"   accept="image/jpg" multiple="multiple" name = "uploadedfile" id = "uploadedfile" title="Elige un archivo para subir."/>--></td></tr>                   
			 <!--<tr><td><div id="foto_b_1" align="right" style="background-color:#EFFBFB; margin: 1px 70px 0px 2px; width:560px;height:170px;"><?="$foto";?></div></td>-->
			 <tr><td><?echo "<center><img src='uploads/$foto' width=150 height=165></center>";?></td>
			 </tr>
			</table>
			<table border = "" cellpading ="0" cellspacing = "0" style=" margin: 1px 50px 0px 30px;">
			<tr>
			   <td colspan="2" align="left" style="background-color:#F3F781; font-size: 8pt; margin: 1px 50px 0px 30px;"><b>COMENTARIOS:</b></td><br>
			</tr>
			<tr>
			   <td><textarea name ="coment" id = "coment" cols="5" rows="3" style="width:630px;height:60px;"><?="$coment";?></textarea></td>
			 </tr>
			 </tr>
			<table border = "" cellpading "0" cellspacing = "0" style="margin: 5px 5px 5px 270px;">
			<tr>
			   <td colspan="2" align="center" style="background-color:#F3F781; font-size: 8pt; margin: 8px 5px 10px 0px;"><b>ELABOR&Oacute;:</b>
	<?
			$nombre=$nomFormato."-1";
	?>
			   <!--<input type="button" value="GUARDAR"  onclick="valida()"  style="font-size: 7pt;"/> <input type="button" value="VER"  onclick="formatoPDF('<?=$nombre?>')" style="font-size: 7pt;"/>--></td>
			</tr>
			<tr>
			<td><input type ="text" name = "firma" id = "firma" align="center" value="<?="$firma";?>" style="width:170px;height:50px;"/></td>		
			</tr>
			
			</table
	
			
			 </div>
<?                        
		        }
		       
		}
		}
		
	