<?
	session_start();
	
	class modeloBusqueda{

		private function conectarBd(){
			require("../../../../../includes/config.inc.php");
			$link=mysql_connect($host,$usuario,$pass);
			if($link==false){
				echo "Error en la conexion a la base de datos";
			}else{
				mysql_select_db($db);
				return $link;
			}				
		}

		public function guardarExistencia($valores,$idProducto){			
			$valores=explode(",",$valores);
			//se insertan los datos en los registros de la tabla
			//$sql="UPDATE catprod set exist_2='".$valores[0]."',exist_3='".$valores[1]."',exist_4='".$valores[2]."',exist_5='".$valores[3]."',exist_6='".$valores[4]."',exist_7='".$valores[5]."',exist_8='".$valores[6]."',exist_9='".$valores[7]."',exist_10='".$valores[8]."',exist_11='".$valores[9]."',exist_12='".$valores[10]."' WHERE id='".$idProducto."'";
			echo $sql="UPDATE catprod set exist_4='".$valores[0]."',exist_5='".$valores[1]."' WHERE id='".$idProducto."'";
			$res=mysql_query($sql,$this->conectarBd()); //se ejecuta la consulta en la base de datos			
			$sql0="SELECT id_prod FROM catprod WHERE id='".$idProducto."'";//se busca la clave del producto en la tabla catprod
			$res0=mysql_query($sql0,$this->conectarBd());
			$row0=mysql_fetch_array($res0);						
			$sql1="DELETE FROM prodxmov WHERE id_prod='".$idProducto."'";//se busca el id en la tabla de detalle de los movimientos y si existe se actualiza
			$res1=mysql_query($sql1,$this->conectarBd());								
			$sumaExistencias=array_sum($valores);		
			$sql3="INSERT INTO prodxmov (nummov,id_prod,cantidad,existen,clave,ubicacion) VALUES ('1','".$idProducto."','".$sumaExistencias."','".$sumaExistencias."','".$row0["id_prod"]."','S/E')";
			$res3=mysql_query($sql3,$this->conectarBd());
			if(mysql_affected_rows()>=1){
				echo "<br>Cambios realizados";
?>
				<script type="text/javascript"> $("#txtBusquedaProd").focus(); $("#txtBusquedaProd").select(); </script>
<?
			}else{
				echo "<br>Cambios NO realizados o no cambiaron los valores del producto seleccionado.";
			}			
		}
		
		public function mostrarFormularioCaptura($id){
			$sql="SELECT * FROM catprod WHERE id='".$id."'";
			$res=mysql_query($sql,$this->conectarBd());
			$row=mysql_fetch_array($res);
			echo "<div style='margin:5px;height:15px;padding:5px;'>Actualizar existencias.</div>";
?>
			<script type="text/javascript"> $("#exist_14").focus(); $("#exist_14").select();  </script>
			<input type="hidden" name="hdnIdProducto" id="hdnIdProducto" value="<?=$id;?>">
			<table border="0" cellpading="1" cellspacing="1" width="400" style="margin: 10px;font-size: 12px;">
				<!--<tr>
					<td width="250" style="height: 15px;padding:5px;">Equipo Nuevo</td>
					<td width="150"><input type="text" name="exist_2" id="exist_2" value="<?=$row["exist_2"];?>" onkeyup="siguienteCaja('exist_2','3',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Equipo Proceso</td>
					<td><input type="text" name="exist_3" id="exist_3" value="<?=$row["exist_3"];?>" onkeyup="siguienteCaja('exist_3','4',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Ingenier&iacute;a</td>
					<td><input type="text" name="exist_4" id="exist_4" value="<?=$row["exist_4"];?>" onkeyup="siguienteCaja('exist_4','5',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Equipo Terminado</td>
					<td><input type="text" name="exist_5" id="exist_5" value="<?=$row["exist_5"];?>" onkeyup="siguienteCaja('exist_5','6',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Equipo Convertido</td>
					<td><input type="text" name="exist_6" id="exist_6" value="<?=$row["exist_6"];?>" onkeyup="siguienteCaja('exist_6','7',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Equipo Cuarentena</td>
					<td><input type="text" name="exist_7" id="exist_7" value="<?=$row["exist_7"];?>" onkeyup="siguienteCaja('exist_7','8',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Equipo NO SAP</td>
					<td><input type="text" name="exist_8" id="exist_8" value="<?=$row["exist_8"];?>" onkeyup="siguienteCaja('exist_8','9',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Scrap</td>
					<td><input type="text" name="exist_9" id="exist_9" value="<?=$row["exist_9"];?>" onkeyup="siguienteCaja('exist_9','10',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Consumibles Nuevos</td>
					<td><input type="text" name="exist_10" id="exist_10" value="<?=$row["exist_10"];?>" onkeyup="siguienteCaja('exist_10','11',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Consumibles Tintas</td>
					<td><input type="text" name="exist_11" id="exist_11" value="<?=$row["exist_11"];?>" onkeyup="siguienteCaja('exist_11','12',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">Consumibles Ingenier&iacute;a</td>
					<td><input type="text" name="exist_12" id="exist_12" value="<?=$row["exist_12"];?>" onkeyup="siguienteCaja('exist_12','13',event)"></td>
				</tr>-->
				<tr>
					<td style="height: 15px;padding:5px;">3039</td>
					<td><input type="text" name="exist_14" id="exist_14" value="<?=$row["exist_14"];?>" onkeyup="siguienteCaja('exist_14','13',event)"></td>
				</tr>
				<tr>
					<td style="height: 15px;padding:5px;">3040</td>
					<td><input type="text" name="exist_13" id="exist_13" value="<?=$row["exist_13"];?>" onkeyup="siguienteCaja('exist_13','14',event)"></td>
				</tr>
				<tr>
					<td colspan="2" style="height: 15px;padding:5px;"><hr style="background: #666;"></td>					
				</tr>				
				<tr>
					<td colspan="2"><input type="button" id="btnActualizarExist" value="Actualizar" onclick="guardarActualizacion()"></td>					
				</tr>
			</table>
<?
		}
		
		public function busquedaProd($parametro){
			$sql="SELECT * FROM catprod WHERE descripgral LIKE '%".$parametro."%' OR especificacion LIKE '%".$parametro."%'";
			$res=mysql_query($sql,$this->conectarBd());
			if(mysql_num_rows($res)==0){
				echo "Sin Resultados"; exit();
			}else{
				//se recorren los registros en la base de datos
				echo "<br>Resultados encontrados: ".mysql_num_rows($res)."<br><br>";				
				while($row=mysql_fetch_array($res)){
?>					
					<div style='height:15px;padding:5px;border-bottom:1px solid #CCC;font-size:12px;width:350px;float:left;'>
					<? echo $row["descripgral"]." ".$row["especificacion"];?>
					</div>
					<div style='float:left;height:15px;padding:5px;width:200px;border-bottom:1px solid #CCC;font-size:12px;text-align:center;'><a href='#' onclick="capturarExistencias('<?=$row["id"];?>')">Capturar</a></div>
					<div style="clear: both;"></div>
<?
				}				
			}
		}
		
		public function mostrarFormulario(){
?>
			<table border="0" cellpadding="1" cellspacing="1" width="900" style="margin: 10px;">
				<tr>
					<td width="80">Buscar</td>
					<td width="170"><input type="text" name="txtBusquedaProd" id="txtBusquedaProd" onkeyup="buscarProductoProd(event)" style="font-size: 30px;"></td>
					<td width="250">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3"><div id="divBusqueda" style="height: 250px;overflow: auto;border: 1px solid #CCC;"></div></td>
				</tr>
				<tr>
					<td colspan="3"><div id="gridBusqueda" style="height: 400px;overflow: auto;border: 1px solid #CCC;"></div></td>
				</tr>
			</table><script type="text/javascript"> $("#txtBusquedaProd").focus(); </script>
<?
		}		
	}//fin de la clase
	
	
	//$objP=new modeloEnsamble();
	//$objP->prueba();
?>