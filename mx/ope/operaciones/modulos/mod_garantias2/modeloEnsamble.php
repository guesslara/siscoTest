 <?
	/*
	 *modeloEnsamble:clase que realiza la inserción, modificación y consulta tanto de lotes como del detalle de los Items ingresados en cada uno de los lotes
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	
	session_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
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
				mysql_select_db("desarrollo_pruebas");
				return $link;
			}				
		}
		
		public function editarRegistro($id){
			
			$sqlE="SELECT * FROM garantias_autorizadas WHERE id_garantia='".$id."'";
			$resE=mysql_query($sqlE,$this->conectarBd());
			if(mysql_num_rows($resE)==0){
				echo "Error al editar el registro indicado"; exit;
			}
			$rowE=mysql_fetch_array($resE);
			$clase_obligaria="campo_obligatorio";
			date_default_timezone_set("America/Mexico_City");
			$hoy=date('Y-m-d');
			$dias=$this->FechaDif($rowE["fecha_asignacion"],$hoy);
			
			//$cadena="controladorEnsamble.php?action=actRe&id=".$id."&numre=".$rowE["num_reclamo"]."&infofa=".$rowE["info_falla"]."&producto=".$rowE["producto"]."&numcontrato=".$rowE["num_contrato"]."&nombre=".$rowE["nombre_cliente"]."&estatus=".$rowE["status"]."&accio=".$rowE["acciones"]."&diag=".$rowE["diagnostico"]."&status1=".$rowE["status1"]."&status2=".$rowE["status2"]."&accio2=".$rowE["acciones2"]."&acciofi=".$rowE["accion_final"]."&prespan=".$rowE["prestamos_pantallas"]."";
?>
			<style type="text/css">
				.tituloForm{height: 15px;padding: 5px;background: #000;color: #FFF;text-align: center;}
				.tituloFormD{height: 15px;padding: 5px;background: #F0F0F0;border: 1px solid #CCC;color: #000;text-align: center;}
				.filaTabla{border-bottom: 1px solid #CCC;}
			</style>
			
			<form id="formeditar" name="formeditar">
			<table border="0" cellpading="1" cellspacing="1" width="800" style="background: #FFF;">
				<tr>
					<td colspan="2" class="tituloForm">Edici&oacute;n de Registro de Incidencia</td>
				</tr>
				<tr>
					<td class="tituloFormD">N&uacute;mero de reclamo</td>
					<td><input type="text" name="num_reclamo" id="num_reclamo" value="<?=$rowE["num_reclamo"];?>" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Informaci&oacute;n de la Falla</td>
					<td><textarea name="info_falla" id="info_falla" cols="50" rows="4" class="<?=$clase_obligaria?>"><?=utf8_encode($rowE["info_falla"]);?></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Producto</td>
					<td><input type="text" name="producto" id="producto" value="<?=$rowE["producto"];?>" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha de Compra</td>
					<td>
						<input type="text" name="fecha_compra" id="fecha_compra" readonly  value="<?=$rowE["fecha_compra"];?>" class="<?=$clase_obligaria?>">
						<input type="button" id="lanzadorB1"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_compra",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB1"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha de Asignaci&oacute;n</td>
					<td>
						<input type="text" name="fecha_asignacion" id="fecha_asignacion" readonly  value="<?=$rowE["fecha_asignacion"];?>" class="<?=$clase_obligaria?>">
						<input type="button" id="lanzadorB2"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_asignacion",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB2"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha Compromiso</td>
					<td>
						<input type="text" name="fecha_compromiso" id="fecha_compromiso" readonly  value="<?=$rowE["fecha_compromiso"];?>">
						<input type="button" id="lanzadorB3"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_compromiso",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB3"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha de Entrega</td>
					<td>
						<input type="text" name="fecha_entrega" id="fecha_entrega" readonly  value="<?=$rowE["fecha_entrega"];?>">
						<input type="button" id="lanzadorB4"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_entrega",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB4"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>

				<tr>
					<td class="tituloFormD">Dias Transcurridos</td>
					<td><input type="text" name="dias_trans" id="dias_trans" value="<?=$dias?>" readonly="readonly"></td>
				</tr>
				<tr>
					<td class="tituloFormD">N&uacute;mero de contrato</td>
					<td><input type="text" name="num_contrato" id="num_contrato" value="<?=$rowE["num_contrato"];?>" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Nombre</td>
					<td><input type="text" name="nombre_cliente" id="nombre_cliente" value="<?=utf8_decode($rowE["nombre_cliente"]);?>" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Dias Abiertos</td>
					<td><input type="text" name="dias_ab" id="dias_ab"  value="<?=$dias?>"readonly="readonly"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Estatus</td>
					<td><input type="text" name="status" id="status" value="<?=$rowE["status"];?>" class="<?=$clase_obligaria?>"> </td>
				</tr
				<tr>
					<td class="tituloFormD">Numero de Serie</td>
					<td><input type="text" name="num_serie" id="num_serie" value="<?=$rowE["num_serie"];?>" class="<?=$clase_obligaria?>"> </td>
				</tr>
				<tr>
					<td class="tituloFormD">Acciones</td>
					<td><textarea name="acciones" id="acciones" cols="50" rows="4"><?=utf8_decode($rowE["acciones"]);?></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Diagnostico</td>
					<td><textarea name="diagnostico" id="diagnostico" cols="50" rows="4"><?=utf8_decode($rowE["diagnostico"]);?></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Estatus 1</td>
					<td><textarea name="status1" id="status1" cols="50" rows="4"><?=utf8_decode($rowE["status1"]);?></textarea></td>
				</tr>

				<tr>
					<td class="tituloFormD">Estatus 2</td>
					<td><textarea name="status2" id="status2" cols="50" rows="4"><?=utf8_decode($rowE["status2"]);?></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Acciones</td>
					<td><textarea name="acciones2" id="acciones2" cols="50" rows="4"><?=utf8_decode($rowE["acciones2"]);?></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Acci&oacute;n Final</td>
					<td><textarea name="accion_final" id="accion_final" cols="50" rows="4"><?=utf8_decode($rowE["accion_final"]);?></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Prestamos Pantallas</td>
					<td><textarea name="prestamos_pantallas" id="prestamos_pantallas" cols="50" rows="4"><?=utf8_decode($rowE["prestamos_pantallas"]);?></textarea></td>
				</tr>
                                <tr>
					<td class="tituloFormD">Observaciones</td>
					<td><textarea name="observaciones" id="observaciones" cols="50" rows="4"><?=utf8_decode($rowE["observaciones"]);?></textarea></td>
				</tr>

				<tr>
					<td colspan="2"><hr style="background: #CCC;"></td>					
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"><input type="button" value="Actualizar Registro"  onclick="actualizaRe('<?=$id?>');" style="height: 30px;padding: 5px;width: 150px;"></td>					
				</tr>				
			</table><p>&nbsp;</p>
			</form>
<?
		}
		
		
		
		public function actRe($campo_valor,$id){
			
			//print_r($cv); exit;
		$sql_camposY="";
		$sql_valoresY="";
		
		$separar_camposY=explode("@@@",trim($campo_valor));
		//print_r($separar_campos); exit;
		foreach ($separar_camposY as $campo){
			$separar_camposY2=explode("|||",trim($campo));
			//print_r($separar_campos2); exit;						
			$campoY=trim($separar_camposY2[0]);
			//print_r($campoX); exit;
			$valorY=trim($separar_camposY2[1]);			
			//print_r($valorX); exit;
			($sql_camposY=="")? $sql_camposY=$campoY : $sql_camposY.=",".$campoY;
			($sql_valoresY=="")? $sql_valoresY.="'".$valorY."'": $sql_valoresY.=",,'".$valorY."'";
		}
		//print_r($sql_camposY); exit;
		//print_r($sql_valoresY); exit;
		$pruba=explode(',',$sql_camposY);
		//print_r($pruba); exit;
		$pruba2=explode(',,',$sql_valoresY);
		//print_r($pruba2); exit;
		$cuenta=count($pruba);
		//echo $cuenta; exit;
		$b= array ();
		$i=1;
		//$a=0;
		for($j=1;$j<$cuenta;$j++){
		//$a=$i+$j;
		//echo $a; exit;
		//if($pruba[$a]==""){
			//unset($b[$i]);
		//}
		//else{
		$b[$i]=$pruba[$j]."=".$pruba2[$j];
		//}
		$i++;
		}
		//print_r($b); exit;	
		
		$dos=implode(",",$b);
		//print_r($dos); exit;
		//try{
		$sql_actualizar="UPDATE garantias_autorizadas SET $dos WHERE id_garantia=$id";
		//print_r($sql_actualizar); exit;
			if (mysql_query($sql_actualizar,$this->conectarBd())){
			echo "<font style='font-size:14px;'><br><b>&nbsp;Registro Actualizado Correctamente.</b></font>";
			} else {
			echo "<font style='font-size:14px;'><br>&nbsp;Error SQL <br><br><b>&nbsp;El Registro NO se Actualizo.</b></font>";
		
			
			}
		}
		
		public function nuevoRegistro(){			
			$clase_obligaria="campo_obligatorio"; 
?>
			<style type="text/css">
				.tituloForm{height: 15px;padding: 5px;background: #000;color: #FFF;text-align: center;}
				.tituloFormD{height: 15px;padding: 5px;background: #F0F0F0;border: 1px solid #CCC;color: #000;text-align: center;}
				.filaTabla{border-bottom: 1px solid #CCC;}
			</style>
			
			
			<form name="form_x" id="form_x">
			<table border="0" cellpading="1" cellspacing="1" width="800" style="background: #FFF;">
				<tr>
					<td colspan="2" class="tituloForm">Registro de Incidencia</td>
				</tr>
				<tr>
					<td class="tituloFormD">N&uacute;mero de reclamo</td>
					<td><input type="text" name="num_reclamo" id="num_reclamo" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Informaci&oacute;n de la Falla</td>
					<td><textarea name="info_falla" id="info_falla" cols="50" rows="4" class="<?=$clase_obligaria?>"></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Producto</td>
					<td><input type="text" name="producto" id="producto" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha de Compra</td>
					<td>
						<input type="text" name="fecha_compra" id="fecha_compra" readonly class="<?=$clase_obligaria?>" >
						<input type="button" id="lanzadorB1"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_compra",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB1"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha de Asignaci&oacute;n</td>
					<td>
						<input type="text" name="fecha_asignacion" id="fecha_asignacion" readonly    class="<?=$clase_obligaria?>" onchange="getDias();"  >
						<input type="button" id="lanzadorB2"  value="..."   /> <input type="button" id="calculo" name="calculo" value="calculas fecha compromiso" onclick="sumaDias();">
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_asignacion",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB2"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha Compromiso</td>
					<td>
						<input type="text" name="fecha_compromiso" id="fecha_compromiso" readonly>
						<input type="button" id="lanzadorB3"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_compromiso",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB3"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>
				<tr>
					<td class="tituloFormD">Fecha de Entrega</td>
					<td>
						<input type="text" name="fecha_entrega" id="fecha_entrega" readonly>
						<input type="button" id="lanzadorB4"  value="..." />
						<!-- script que define y configura el calendario-->
						<script type="text/javascript">
						    Calendar.setup({
							inputField     :    "fecha_entrega",      // id del campo de texto
							ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
							button         :    "lanzadorB4"   // el id del botón que lanzará el calendario
						    });
						</script>
					</td>
				</tr>

				<tr>
					<td class="tituloFormD">Dias Transcurridos</td>
					<td><input type="text" name="dias_trans" id="dias_trans" readonly="readonly"></td>
				</tr>
				<tr>
					<td class="tituloFormD">N&uacute;mero de contrato</td>
					<td><input type="text" name="num_contrato" id="num_contrato" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Nombre</td>
					<td><input type="text" name="nombre_cliente" id="nombre_cliente" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Dias Abiertos</td>
					<td><input type="text" name="dia_ab" id="dias_ab" readonly="readonly" ></td>
				</tr>
				<tr>
					<td class="tituloFormD">Estatus</td>
					<td><input type="text" name="status" id="status" class="<?=$clase_obligaria?>"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Numero de Serie</td>
					<td><input type="text" name="num_serie" id="num_serie" class="<?=$clase_obligaria?>" onkeyup="verifica_prod(evento)"></td>
				</tr>
				<tr>
					<td class="tituloFormD">Acciones</td>
					<td><textarea name="acciones" id="acciones" cols="50" rows="4" ></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Diagnostico</td>
					<td><textarea name="diagnostico" id="diagnostico" cols="50" rows="4" ></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Estatus 1</td>
					<td><textarea name="status1" id="status1" cols="50" rows="4" ></textarea></td>
				</tr>

				<tr>
					<td class="tituloFormD">Estatus 2</td>
					<td><textarea name="status2" id="status2" cols="50" rows="4" ></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Acciones</td>
					<td><textarea name="acciones2" id="acciones2" cols="50" rows="4" > </textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Acci&oacute;n Final</td>
					<td><textarea name="accion_final" id="accion_final" cols="50" rows="4" ></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Prestamos Pantallas</td>
					<td><textarea name="prestamos_pantallas" id="prestamos_pantallas" cols="50" rows="4" ></textarea></td>
				</tr>
				<tr>
					<td class="tituloFormD">Observaciones</td>
					<td><textarea name="observaciones" id="observaciones" cols="50" rows="4" ></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><hr style="background: #CCC;"></td>					
				</tr>
				<tr>
					<td colspan="2" style="text-align: right;"><input type="button" value="Guardar Registro"   onclick="insertaRe();" style="height: 30px;padding: 5px;width: 150px;"></td>					
				</tr>				
			</table><p>&nbsp;</p>
			</form>
			
<?
		}
		
		public function vertabla(){			
			$conComm="SELECT * FROM garantias_autorizadas";
			$exeConComm=mysql_query($conComm,$this->conectarBd());
			if(!$exeConComm){
                              echo "No se pueden mostrar los registros";
                        }else{
                              $cont=mysql_numrows($exeConComm);
                              if($cont==0){
				echo "No hay registros en la Base de Datos";
                              }else{
                
?>
			<style type="text/css">
				.estiloCelda{text-align: center;font-weight:bold;font-size: 12px;border: 1px solid #CCC;height: 20px;padding: 5px;}
				.estiloTr{background: #FFF;font-size: 10px;padding: 4px;}
				.estiloTr:hover{background: #E1E1E1;}
				.estiloTdResultados{border-bottom:1px solid #CCC;height: 20px;padding: 5px;}
			</style>
			<div id= "selec" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>
		        <form name = "showw" id= "showw">
								
			<table border="0" cellpadding="0" cellspacing="0" width="4000">
				<tr>				      
                                      <td class="estiloCelda" style="background:#000;color: #FFF;">Acciones</td>
				      <td class="estiloCelda" style="background: #FF8000;"># de Reclamo</td>
                                      <td class="estiloCelda" style="background: #FF8000;">Informacion de la Falla</td>
                                      <td class="estiloCelda" style="background: #FF8000;">Producto</td>
                                      <td class="estiloCelda" style="background: #FF8000;">Fecha de Compra</td>
                                      <td class="estiloCelda" style="background: #FF8000;">Fecha de Asignacion</td>
                                      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Fecha de Compromiso</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Fecha de Entrega</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Dias Transcurridos</td>
				      <td class="estiloCelda" style="background: #FF8000;"># de Contrato</td>
				      <td class="estiloCelda" style="background: #FF8000;">Nombre</td>
				      <td class="estiloCelda" style="background: #FF8000;">Dias Abiertos</td>
				      <td class="estiloCelda" style="background: #FF8000;">Estatus</td>
				      <td class="estiloCelda" style="background: #FF8000;">Acciones</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Diagnostico</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Estatus1</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Estatus2</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Acciones</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Accion Final</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Prestamos Pantallas</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;"># de Serie</td>
				      <td class="estiloCelda" style="background: #0000FF;color: #FFF;">Observaciones</td>
				</tr>
<?php
                        while ($si=mysql_fetch_array($exeConComm)){
				date_default_timezone_set("America/Mexico_City");
				$hoy=date('Y-m-d');
				$diasTabla=$this->FechaDif($si["fecha_asignacion"],$hoy);
				$color=$this->Semaforo($diasTabla);
				
?>
				<tr class="estiloTr">				    
                                    <td class="estiloTdResultados" style="text-align: center;"><a href="#" onclick="editarRegistro('<?=$si['id_garantia']?>')" style="color:blue;">Editar</a></td>
				    <td class="estiloTdResultados" style="text-align: center;"><?=$si['num_reclamo']?></td>
                                    <td class="estiloTdResultados" style="text-align: left;"><?=utf8_encode($si['info_falla']);?></td>
                                    <td class="estiloTdResultados" style="text-align: center;"><?=$si['producto']?></td>
                                    <td class="estiloTdResultados" style="text-align: center;"><?=$si['fecha_compra']?></td>
                                    <td class="estiloTdResultados" style="text-align: center;"><?=$si['fecha_asignacion']?></td>
                                    <td class="estiloTdResultados" style="text-align: center;"><?=$si['fecha_compromiso']?></td>
				    <td class="estiloTdResultados" style="text-align: center;"><?=$si['fecha_entrega']?></td>
				    <td class="estiloTdResultados" style="text-align: center; color: white; font-weight: bold; background: <?=$color?>"><?=$diasTabla?></td>
                                    <td class="estiloTdResultados" ><?=$si['num_contrato']?></td>
                                    <td class="estiloTdResultados" ><?=$si['nombre_cliente']?></td>
				    <td class="estiloTdResultados" style="text-align: center; color: white; font-weight: bold; background: <?=$color?>"><?=$diasTabla?></td>
                                    <td class="estiloTdResultados" ><?=$si['status']?></td>
                                    <td class="estiloTdResultados" ><?=utf8_decode($si['acciones']);?></td>
                                    <td class="estiloTdResultados" ><?=utf8_encode($si['diagnostico']);?></td>
				    <td class="estiloTdResultados" ><?=utf8_encode($si['status1']);?></td>
                                    <td class="estiloTdResultados" ><?=utf8_encode($si['status2']);?></td>
                                    <td class="estiloTdResultados" ><?=utf8_decode($si['acciones2']);?></td>
                                    <td class="estiloTdResultados" ><?=utf8_encode($si['accion_final']);?></td>
                                    <td class="estiloTdResultados" ><?=utf8_encode($si['prestamos_pantallas']);?></td>
				    <td class="estiloTdResultados" onkeyup="verifica_prod(evento)"><?=utf8_encode($si['num_serie']);?></td>
				    <td class="estiloTdResultados" ><?=utf8_encode($si['observaciones']);?></td>                                                                
                                </tr>
<?php
                        }
?>       				
			</table>
			</div>
			<div id= "pruebas" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>				        
<?php
		             }
			}
	        }
		
		public function insertaRe($cam_valo){
			
			//print_r($t);
		//exit;
		$sql_campos="";
		$sql_valores="";
		
		
		$separar_campos=explode("@@@",trim($cam_valo));
		//print_r($separar_campos);
		//exit;
		
		foreach ($separar_campos as $cam){
			$separar_campos2=explode("|||",trim($cam));
			//print_r($separar_campos);
			//exit;
			$campoX=trim($separar_campos2[0]);
			//print_r($campoX);
			//exit;
			$valorX=trim($separar_campos2[1]);
			//print_r($valorX);
			($sql_campos=="")? $sql_campos=$campoX : $sql_campos.=",".$campoX;
			($sql_valores=="")? $sql_valores.="'".$valorX."'": $sql_valores.=",'".$valorX."'";
		}
		//print_r($sql_campos); exit;
		$sql_insertar="INSERT INTO garantias_autorizadas ($sql_campos) VALUES ($sql_valores);"; 
		
		//print_r($sql_insertar); exit;
		$consulta=mysql_query($sql_insertar,$this->conectarBd());
		if ($consulta){
			echo "<br><b>&nbsp;Registro Insertado Correctamente.</b>";
			
			
			 
		} else {
			echo "<br>&nbsp; Error SQL (".mysql_error($link).")<br><br><b>&nbsp;El Registro NO se Inserto.</b>";
		}
		}
		
		function FechaDif($inicio, $fin){
		$inicio = strtotime($inicio);
		$fin = strtotime($fin);
		$diff = $fin - $inicio;
		return round($diff / 86400);
		}
		
		function Semaforo($diasTrans){
			$color="#989898";//color gris
			$color2="#0B3B17";//color  verde
			$color3="#D7DF01";//color amarillo
			$color4="#FF0000";//color rojo;
			if($diasTrans>=0 && $diasTrans<=9 ){
				return $color;
			}
			if($diasTrans>=10 && $diasTrans<=19){
				 return $color2;
				
			}
			if($diasTrans>=20 && $diasTrans<=29){
				 return $color3;
			}
			if($diasTrans>=30){
				return $color4;
				
			}
		}
		
	}//fin de la clase
?>

