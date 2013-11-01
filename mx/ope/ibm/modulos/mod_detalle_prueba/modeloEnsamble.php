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
		
		
		public function edittest(){
		$var1=array();
			$conComm="SELECT id_commodity FROM detalle_prueba_commodity GROUP BY id_commodity";
			$exeConComm=mysql_query($conComm,$this->conectarBd());
			while ($nullx=mysql_fetch_array ($exeConComm)){
				array_push($var1,$nullx["id_commodity"]);
			}
			$nullx2=implode("','",$var1);
			$querr="SELECT * FROM CAT_commodity WHERE id_commodity NOT IN ('".$nullx2."')";
			
			$exeConComm2=mysql_query($querr,$this->conectarBd());
			
?>
                        <div id="add" style="display:none; height:auto; margin-top:54px; margin-left:80px; width:40%; text-align:justify; clear: both;background:transparent; position: fixed;">
				<center><input type ="button" name="Guardar"value="Guardar" onClick="recuperaCC()">
			        <input type="button" name="Cancelar" value="Cancelar" onClick="clean2()"></center>
			</div>
		        <form name = "formcommod" id= "formcommod">
				<?="**El o los Commodities que se encuentran en el menú de selección no contienen pruebas.**<br>"?>
	                        <?="1.-A continuación Seleccione un Commodity dentro del menú para agregar pruebas al mismo.<br>"?>
				<?="2.-Una vez seleccionadas las pruebas, da click en el boton GUARDAR para guardarlas o CANCELAR en caso contrario."?>
			<table>
				<tr>
					<td colspan=2>
						<select name="idCommodity" id="idCommodity">
							<option value="">Seleccione un Commodity</option>
							<?while($rowComm=mysql_fetch_array($exeConComm2)){?>
							<option value="<?=$rowComm['id_commodity']?>"><?=$rowComm['desc_esp']?></option>
							<?}?>
						</select>
						
					</td>				
				</tr>
				
<?php                       
			$conpruebas="SELECT * FROM CAT_pruebas";
			$exeConpruebas=mysql_query($conpruebas,$this->conectarBd());
			while($rowprueba=mysql_fetch_array($exeConpruebas)){
			$nomChk="prueba".$rowprueba['id_prueba'];
?>			
				<tr>
					<td>
						 <input type ="checkbox"  id="<?=$nomChk?>" value = "<?=$rowprueba['id_prueba']?>" onclick="ActivarDivadd()"/>
					</td>
					<td>
						<?=utf8_encode($rowprueba['nombre']);?>
					</td>
				</tr>
			<?}		?>
			</table>
		        </form>
<?
		}
                public function insertar($commod,$contax){
			$arrayPruebas=explode(",",$contax);
			/*print_r($arrayPruebas);
			exit;*/
			for($i=0;$i<count($arrayPruebas);$i++){
				$var="INSERT INTO detalle_prueba_commodity (id_prueba,id_commodity) VALUES ('".$arrayPruebas[$i]."','".$commod."')";
				$rec=mysql_query($var,$this->conectarBd());
				if(!$rec){
                            
?>			     
					<script type="text/javascript">
						alert("Parametros de pruebas no insertado");
					</script>
	 <?php			       
				}else{
                            
?>			     
					<script type="text/javascript">
						alert("Parametros de pruebas insertados correctamente");
					</script>
<?php			       
				}
			}
			
		}
		
		public function vercommodity(){
			
			$conComm="SELECT * FROM CAT_commodity";
			$exeConComm=mysql_query($conComm,$this->conectarBd());
?>

			<div id= "selec" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>
		        <form name = "showw" id= "showw">
				<?="1.-Seleccione un commodity dentro de las opciones que le ofrece el menú para visualizar las pruebas que contiene.<br>"?>
			<table>
				<tr>
					<td colspan=1>
						<select name="Commo" id="Commo" onchange="verpruebas(this)">
							<option value="">Seleccione un Commodity</option>
							<?while($rowComm=mysql_fetch_array($exeConComm)){?>
							<option value="<?=$rowComm['id_commodity']?>"><?=$rowComm['desc_esp']?></option>
							<?}?>
						</select>
						
					</td>
				</tr>
                                
				
			</table>
			</div>
			<div id= "pruebas" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>


				
		        
<?php
		}
		
		public function verpruebas($recup){
			$var="SELECT * FROM CAT_pruebas INNER JOIN detalle_prueba_commodity ON CAT_pruebas.id_prueba = detalle_prueba_commodity.id_prueba WHERE id_commodity =".$recup;
			$exeConpruebas=mysql_query($var,$this->conectarBd());
			$cuantasPruebas=mysql_num_rows($exeConpruebas);
			
			if($cuantasPruebas==0){
?>
                                        <script type="text/javascript">
						alert("El commodity que has seleccionado no contiene pruebas");
					</script>
<?php					 
                        }else{
?>
                        <div id= "test" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>
                        <form name = "formshow" id= "formshow">
		        				
			<table>

<?php
                        $prueba=1;
			while($rowprueba=mysql_fetch_array($exeConpruebas)){
				$nomChk="prueba".$rowprueba['id_prueba'];
				
				
                                
                        
?>
	                        
				<tr>			
					<td colspan=1>
						<?=$prueba?>
					</td>
					
					<td>
						
						<?=utf8_encode($rowprueba['nombre']);?>
					</td>
				</tr>
				
<?
                         $prueba++;       
			}
?>			
			</table>
		        </form>
			</div>
<?php
			}
		}
		
		public function commoditypruebas(){
			
			$conComm="SELECT * FROM CAT_commodity INNER JOIN detalle_prueba_commodity ON CAT_commodity.id_commodity = detalle_prueba_commodity.id_commodity WHERE id_prueba is not null group by (detalle_prueba_commodity.id_commodity)";
			$exeConComm=mysql_query($conComm,$this->conectarBd());
?>
                        <div id="borrar" style="display:none; height:auto; margin-top:36px; margin-left:80px; width:40%; text-align:justify; clear: both;background:transparent; position: fixed;">
						<center><input type ="button" name="Borrar"value="Borrar"  title="Borrar pruebas seleccionadas" onClick="eliminar()">
						<input type="button" name="Cancelar" value="Cancelar" onClick="clean2()"></center>	
						</div>

			<div id= "selec" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>
			
		        <form name = "delete" id= "delete">
				<?="1.-Seleccione un Commodity dentro del menú de selección para mostrar las pruebas que contiene.<br>"?>
				<?="2.-Seleccione las pruebas que desee eliminar y de click en el botón BORRAR o CANCELAR en caso contrario."?>
			<table>
				<tr>
					<td colspan=4>
						<select name="idCommo" id="idCommo" onchange="mostrarpruebas(this)">
							<option value="">Seleccione un Commodity</option>
							<?while($rowComm=mysql_fetch_array($exeConComm)){?>
							<option value="<?=$rowComm['id_commodity']?>"><?=$rowComm['desc_esp']?></option>
							<?}?>
						</select>
						
					</td>
				</tr>
                                
				
			</table>
			</div>
			<div id= "pruebas" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>


				
		        
<?php
		}
		
		public function mostrarpruebas($recup){
			$var="SELECT * FROM CAT_pruebas INNER JOIN detalle_prueba_commodity ON CAT_pruebas.id_prueba = detalle_prueba_commodity.id_prueba WHERE id_commodity =".$recup;
			$exeConpruebas=mysql_query($var,$this->conectarBd());
			$cuantasPruebas=mysql_num_rows($exeConpruebas);
			
			if($cuantasPruebas==0){
?>
                                        <script type="text/javascript">
						alert("El commodity que has seleccionado no contiene pruebas");
					</script>
<?php					 
                        }else{
?>

                        <form name = "formdelet" id= "formdelet">
				
			<table>

<?php
			while($rowprueba=mysql_fetch_array($exeConpruebas)){
				$nomChk="prueba".$rowprueba['id_prueba'];
				
                                
                        
?>			
				<tr>
					<td>
						<input type ="checkbox"  id="<?=$nomChk?>" value = "<?=$rowprueba['id_prueba']?>" onclick="ActivarDivborrar()"/>
					</td>
					<td>
						<?=utf8_encode($rowprueba['id_prueba']);?>
					</td>
					<td>
						
						<?=utf8_encode($rowprueba['nombre']);?>
					</td>
				</tr>
				
<?
                                
			}
?>			
			</table>
			
		        </form>
<?php
			}
		}
			
		public function eliminar($sellec,$contac){			
			$arrayPruebas=explode(",",$contac);//convertimos a un array
			
			for($i=0;$i<count($arrayPruebas);$i++){
				"<br>".$varelimina="DELETE FROM `detalle_prueba_commodity` WHERE id_commodity =".$sellec." and id_prueba=".$arrayPruebas[$i]."";
				$delimina=@mysql_query($varelimina,$this->conectarBd()) or die(mysql_error());
				if(!$delimina){    
?>			     
					<script type="text/javascript">
						alert("No se borro ninguna prueba(s)");
					</script>
<?php			       
				}else{
                            
?>			     
					<script type="text/javascript">
						alert("Prueba(s) Borrada(s) correctamente");
						clean2();
						vercommodity();
					</script>
<?php			       
				}				
			}	
		}
		
		public function commodityfull(){
			
			$conComm="SELECT * FROM CAT_commodity INNER JOIN detalle_prueba_commodity ON CAT_commodity.id_commodity = detalle_prueba_commodity.id_commodity WHERE id_prueba is not null group by (detalle_prueba_commodity.id_commodity)";
			$exeConComm=mysql_query($conComm,$this->conectarBd());
?>
				        <div id="modify" style="display:none; height:5px; margin-top:53px; margin-left:80px; width:40%; text-align:justify;background:transparent; position: fixed;">
						<center><input type ="button" name="Guardar"value="Guardar"  title="Guardar pruebas seleccionadas" onClick="recuper()">
					        <input type="button" name="Cancelar" value="Cancelar" onClick="clean2()"></center>
					</div>
			<div id= "selec" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>
		        <form name = "save" id= "save">
				<?="1.-Seleccione un Commodity dentro del menú de selección para agregar pruebas.<br>"?>
				<?="2.-Se mostraran a continuación las pruebas que no contenga el Commodity seleccionado y que desee agregar.<br>"?>
	                        <?="3.-Seleccione las pruebas que desee agregar y de click en el botón GUARDAR o CANCELAR en caso contrario.<br>"?>

			<table>
				<tr>
					<td colspan=1>
						<select name="modifikr" id="modifikr" onchange="verpruebas2(this)">
							<option value="">Seleccione un Commodity</option>
							<?while($rowComm=mysql_fetch_array($exeConComm)){?>
							<option value="<?=$rowComm['id_commodity']?>"><?=$rowComm['desc_esp']?></option>
							<?}?>
						</select>
										
							
					</td>
				</tr>
                                
				
			</table>
			</div>
			<div id= "pruebas" style="height:auto; width:98%; text-align:justify; clear: both;background:#FFFFFF;"></div>			
		        
<?php
		}
		
		public function verpruebas2($recup){
			$resolver=array();
			$var="SELECT * FROM CAT_pruebas INNER JOIN detalle_prueba_commodity ON CAT_pruebas.id_prueba = detalle_prueba_commodity.id_prueba WHERE id_commodity =".$recup;
			$exeConpruebas=mysql_query($var,$this->conectarBd());
			while ($resolvr=mysql_fetch_array ($exeConpruebas)){
				array_push($resolver,$resolvr["id_prueba"]);
			}
			$resuelto=implode("','",$resolver);
			$querr="SELECT * FROM CAT_pruebas WHERE id_prueba NOT IN ('".$resuelto."')";
			$exeConComm2=mysql_query($querr,$this->conectarBd());
			while($rowprueba=mysql_fetch_array($exeConComm2)){
			$nomChk="test".$rowprueba['id_prueba'];
			
?>
                        
                        <form name = "savethm" id= "savethm">

			<table>

				<tr>
					<td colspan=2>
						<input type ="checkbox"  id="<?=$nomChk?>" value = "<?=$rowprueba['id_prueba']?>" onclick="ActivarDivmodify()"/>
					</td>
					
					<td>
						
						<?=utf8_encode($rowprueba['nombre']);?>
					</td>
				</tr>
<?       
			}
?>	
			
			</table>
		        </form>
			
<?php
		}
		
		public function insertar2($commod,$contax){
			$arrayPruebas=explode(",",$contax);
			/*print_r($arrayPruebas);
			exit;*/
			for($i=0;$i<count($arrayPruebas);$i++){
				$var="INSERT INTO detalle_prueba_commodity (id_prueba,id_commodity) VALUES ('".$arrayPruebas[$i]."','".$commod."')";
				$rec=mysql_query($var,$this->conectarBd());
				if(!$rec){
                            
?>			     
					<script type="text/javascript">
						alert("Parametros de pruebas no insertado");
					</script>
	 <?php			       
				}else{
                            
?>			     
					<script type="text/javascript">
						alert("Prueba(s) Adherida(s) exitosamente");
					</script>
<?php			       
				}
			}
			
		}
			
	}//fin de la clase
?>

