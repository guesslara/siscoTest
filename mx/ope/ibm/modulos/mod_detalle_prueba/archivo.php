<?
	date_default_timezone_set("America/Mexico_City");
	$id_lote=$_GET['idLote'];
	$id_proyecto=$_GET['idProyecto'];
	$noItem=$_GET['noItem'];
	$idUsuario=$_GET['idUsuario'];
	$idMov=$_GET['idMov'];
	$nombreArchivo="DetalleLote#".$idMov."_".$nomPro."_".date("Y-m-d");
	header('Content-type: application/vnd.ms-excel'); 
	header("Content-Disposition: attachment; filename=$nombreArchivo.xls"); 
	header("Pragma: no-cache"); 
	header("Expires: 0");
	exportar($id_lote,$id_proyecto,$noItem,$idUsuario);

	function conectarBd(){
		require("../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db($db);
			return $link;
		}				
	}	  
	function exportar($id_lote,$id_proyecto,$noItem,$idUsuario){
	//cabeceraspara exportar a excel
		$noPro="SELECT * FROM proyecto WHERE id_proyecto=$id_proyecto";
		$exPro=mysql_query($noPro,conectarBd());
		$arrEx=mysql_fetch_array($exPro);
		$nomPro=$arrEx['nombre_proyecto'];
		$BusDa="SELECT * FROM detalle_lotes where id_lote='".$id_lote."'";
		$exeBus=mysql_query($BusDa,conectarBd());
		if(mysql_num_rows($exeBus)!=0){
		?>
			<table>
				<tr>
					<th>#</th>
					<th>Num. Parte</th>
					<th>SENC</th>
					<th>Modelo</th>
					<? if($id_proyecto==2){?>
						<th>Code Type</th>
						<th>Flow Tag</th>
					<?}?>
					<th>Num. Serie</th>
					<th>Fecha Registro</th>
					<th>Hora Registro</th>
					<th>T&eacutecnico Asignado</th>
					<th>Status</th>
					<th>Observaciones</th>
					
				</tr>
				<?
				$i=1;
				while($rowArr=mysql_fetch_array($exeBus)){
					?>
					<tr>
						<td><?=$i;?></td>
						<?$buNP="SELECT NoParte, SECN FROM CAT_SENC WHERE id_SENC='".$rowArr['id_Senc']."'";
						$exeBuNP=mysql_query($buNP,conectarBd());
						$rowSC=mysql_fetch_array($exeBuNP);?>
						<td><?=$rowSC['NoParte'];?></td>
						<td><?=$rowSC['SECN'];?></td>
						<td><?=$rowArr['modelo']?></td>
						<? if($id_proyecto==2){?>
							<th><?=$rowArr['codeType']?></td>
							<th><?=$rowArr['flowTag']?></td>
						<?}?>
						<td><?=$rowArr['numSerie']?></td>
						<td><?=$rowArr['fecha_registro']?></td>
						<td><?=$rowArr['hora_registro']?></td>
							<?
							$idTecnico=$rowArr['id_tecnico'];
							$conNT="SELECT * FROM userdbcontroloperaciones WHERE ID=$idTecnico";
							$exeConNT=mysql_query($conNT,conectarBd());
							$rowTEC=mysql_fetch_array($exeConNT);
							if($idTecnico==0){
								$idStyle="negrita";
								$tecnico="Aún no se ha asignado ningun técnico";
							}else{
								$idStyle="normal";
								$tecnico=$rowTEC['nombre']." ".$rowTEC['apaterno'];
							}
							?>
						<td id="<?=$idStyle;?>"><?=utf8_decode($tecnico);?></td>
							<?if($rowArr['status']=="Asignado"){
							$colorST="#09BD4E";}else{$colorST="#000";}?>
						<td style="color:<?=$colorST?>; font-weight: bold;"><?=$rowArr['status']?></td>
						<td><?=$rowArr['descripcion']?></td>
					</tr>
					<?
					$i++;
				}

				?>
			</table>
			<?}else{
				print("ESTE MOVIMIENTO NO TIENE REGISTROS POR EL MOMENTO");
			}
		}?>
			</body>
</html>