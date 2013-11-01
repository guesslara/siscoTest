<?
	/*
	 *modeloEnsamble:clase que realiza la inserción, modificación y consulta tanto de lotes como del detalle de los Items ingresados en cada uno de los lotes
	 *Autor: Rocio Manuel Aguilar
	 *Fecha:20/Nov/2012
	*/
	session_start();
	include("../../../clases/funcionesComunes.php");
	include("../../../clases/cargaInicial.php");
	date_default_timezone_set("America/Mexico_City");
	class modelo{
		private function conectarBd(){
			require("../../../includes/config.inc.php");
			$link=mysql_connect($host,$usuario,$pass);
			if($link==false){
				echo "Error en la conexion a la base de datos";
			}else{
				mysql_select_db("2012_consulta_clientes_lenovo");
				return $link;
			}				
		}
		public function guardarDatos($idElemento,$valores){
			//setlocale(LC_CTYPE, 'es');
			$val = explode(",",$valores);$bandera=true;$mnsj="";
			for($i=0;$i<count($val);$i++){
				$val[$i]=strtoupper($val[$i]);
			}
			if($this->datecheck($val[1])===false){
				$bandera=false;
				$mnsj=$mnsj."La fecha de Recibo esta mal ";
			}else{
			}
			if($this->datecheck($val[6])===false){
				$bandera=false;
				$mnsj=$mnsj."La fecha de Entrega esta mal ";
			}else{
			}
			if($bandera==true){
				$sqlInsEquipo="INSERT INTO equipos(lote, fecha_recibo, producto, marca, modelo, serie, fecha_entrega, guia_entrega, status_final)
				VALUES ('".$val[0]."','".$val[1]."','".$val[2]."','".$val[3]."','".$val[4]."','".$val[5]."','".$val[6]."','".$val[7]."','".$val[8]."')";
				$InsEquipo=mysql_query($sqlInsEquipo,$this->conectarBd()) or die (mysql_error());
				$this->mensajesCaja($idElemento,"EXITO¡¡¡","green","#FFF");
			}else{
				$this->mensajesCaja($idElemento,"ERROR!!!","red","");
				echo"$mnsj ¡¡¡";
			}
		}
		public function mensajesCaja($idElemento,$msgCaja,$color,$fuente){
			echo "<script type='text/javascript'>document.getElementById('".$idElemento."').value='".$msgCaja."'; </script>";
			echo "<script type='text/javascript'>document.getElementById('".$idElemento."').style.background='".$color."'; </script>";
			echo "<script type='text/javascript'>document.getElementById('".$idElemento."').style.color='".$fuente."'; </script>";
		}
		public function datecheck($input,$format=""){
			
			$separator_type= array("/","-",".");
			
			foreach ($separator_type as $separator){
				$find= stripos($input,$separator);
				if($find<>false){
					$separator_used = $separator;
				}
			}
			if($separator_used==""){
				return false;
			}
			$input_array= explode($separator_used,$input);
			if ($format=="mdy"){
				return checkdate($input_array[0],$input_array[1],$input_array[2]);
			}elseif ($format=="ymd"){
				return checkdate($input_array[1],$input_array[2],$input_array[0]);
			}else{
				return checkdate($input_array[1],$input_array[0],$input_array[2]);
			}
			$input_array=array();
		}
		public function manDatos($dato){
			return preg_match('[a-zA-z]', $dato);
		}	
		public function exportar(){
			$sqlResFolio="SELECT lote FROM equipos GROUP BY lote";
			$resFolio=mysql_query($sqlResFolio,$this->conectarBd());
		?>
		<form id="frmlotes" name="frmlotes">
			<table>
				<?while($rowFolio=mysql_fetch_array($resFolio)){?>
					<tr>
						<td align="center">
							<input type="checkbox" name="lote" value="<?=$rowFolio['lote']?>">
						</td>
						<td>Lote <?=$rowFolio['lote']?></td>
					</tr>
<?
				}
?>										
			</table>
		</form>
		<?
		}
		public function verFoliosResumen(){
			$sqlResFolio="SELECT * FROM equipos ORDER BY id";
			$resFolio=mysql_query($sqlResFolio,$this->conectarBd());
			if(mysql_num_rows($resFolio)==0){
				echo "( 0 ) registros encontrados.";
			}else{
?>
				<table border="0" cellpadding="0" cellspacing="0" width="900" style="font-size: 12px;">
					<tr>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">#</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Lote</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Fecha de Recibo</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Producto</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Marca</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Modelo</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Serie</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Fecha Entrega</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Guia de Entrega</td>
						<td style="background: #000;color: #FFF;height: 20px;padding: 5px;text-align: center;">Status Final</td>			      
					</tr>
<?
					while($rowFolio=mysql_fetch_array($resFolio)){
						//echo $rowFolio["status_final"];
						if($rowFolio["status_final"]=="ENTREGADO"){
							$color="green"; $fondo="#7DC24B";
						}else if($rowFolio["status_final"]=="SCRAP"){
							$color="white"; $fondo="#FE2E2E";
						}else if(utf8_encode($rowFolio["status_final"])=="Reparación"){
							$color=""; $fondo="#F7D358";
						}else if(utf8_encode($rowFolio["status_final"])=="MIX & MATCH" || utf8_encode($rowFolio["status_final"])=="MX & MATCH"){
							$color=""; $fondo="#CEECF5";
						}
?>
					<tr class="resultadosTabla">
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["id"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["lote"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["fecha_recibo"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["producto"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["marca"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["modelo"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["serie"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["fecha_entrega"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;"><?=$rowFolio["guia_entrega"];?></td>
						<td style="background:<?=$fondo;?>;border-bottom: 1px solid #CCC;border-right: 1px solid #CCC;height: 15px;padding: 5px;text-align: center;font-weight: bold;color: <?=$color;?>"><?=utf8_encode($rowFolio["status_final"]);?></td>			      
					</tr>
<?
					}
?>
				</table>
<?
			}
		}
	}//fin de la clase
	
?>
