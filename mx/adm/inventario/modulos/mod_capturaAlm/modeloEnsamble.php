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

		public function busquedaProd($parametro){
			echo "<br>".$sql="SELECT * FROM catprod WHERE descripgral LIKE '%".$parametro."%' OR especificacion LIKE '%".$parametro."%'";
			$res=mysql_query($sql,$this->conectarBd());
			if(mysql_num_rows($res)==0){
				echo "Sin Resultados"; exit();
			}else{
				//se recorren los registros en la base de datos
				echo "<br>Resultados encontrados: ".mysql_num_rows($res)."<br><br>";				
				while($row=mysql_fetch_array($res)){
					echo "<div style='height:15px;padding:5px;border-bottom:1px solid #CCC;font-size:12px;width:500px;float:left;'>";
					echo $row["descripgral"]." ".$row["especificacion"];
					echo "</div>";
					echo "<div style='float:left;width:200px;text-align:center;'><a href='#'>Capturar</a></div>";
				}				
			}
		}
		
		public function mostrarFormulario(){
?>
			<table border="1" cellpadding="1" cellspacing="1" width="900" style="margin: 10px;">
				<tr>
					<td width="80">Buscar</td>
					<td width="170"><input type="text" name="txtBusquedaProd" id="txtBusquedaProd" onkeyup="buscarProductoProd(event)" style="font-size: 30px;"></td>
					<td width="250">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3"><div id="divBusqueda" style="height: 200px;overflow: auto;border: 1px solid #CCC;"></div></td>
				</tr>
				<tr>
					<td colspan="3"><div id="gridBusqueda" style="height: 200px;overflow: auto;border: 1px solid #CCC;"></div></td>
				</tr>
			</table><script type="text/javascript"> $("#txtBusquedaProd").focus(); </script>
<?
		}		
	}//fin de la clase
	
	
	//$objP=new modeloEnsamble();
	//$objP->prueba();
?>