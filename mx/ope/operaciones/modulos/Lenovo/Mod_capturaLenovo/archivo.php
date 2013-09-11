<?
	date_default_timezone_set("America/Mexico_City");
	$lotes=$_GET['lotes'];
	$nombreArchivo="Lotes_".date("Y-m-d")."_".date("G:i:s");
	header('Content-type: application/vnd.ms-excel'); 
	header("Content-Disposition: attachment; filename=$nombreArchivo.xls"); 
	header("Pragma: no-cache"); 
	header("Expires: 0");
	exportar($lotes);

	function conectarBd(){
		require("../../../includes/config.inc.php");
		$link=mysql_connect($host,$usuario,$pass);
		if($link==false){
			echo "Error en la conexion a la base de datos";
		}else{
			mysql_select_db("2012_consulta_clientes_lenovo");
			return $link;
		}				
	}	  
	function exportar($lotes){
		$lote=explode(",",$lotes);
		$lotej=implode("','",$lote);
		$lotej=substr($lotej, 0, -2);
		$Consul="SELECT * FROM equipos WHERE lote IN ('".$lotej.");";
		$resC=mysql_query($Consul,conectarBd());
		?>
			<table>
				<tr>
					<th>#</th>
					<th>Lote</th>
					<th>Fecha de Recibo</th>
					<th>Producto</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Serie</th>
					<th>Fecha de Entrega</th>
					<th>Guia de Entrega</th>
					<th>Status Final</th>					
				</tr>
				<?
				while($rowDat=mysql_fetch_array($resC)){
					?>
					<tr>
						<td><?=$rowDat['id']?></td>
						<td><?=$rowDat['lote']?></td>
						<td><?=$rowDat['fecha_recibo']?></td>
						<td><?=$rowDat['producto']?></td>
						<td><?=$rowDat['marca']?></td>
						<td><?=$rowDat['modelo']?></td>
						<td><?=$rowDat['serie']?></td>
						<td><?=$rowDat['fecha_entrega']?></td>
						<td><?=$rowDat['guia_entrega']?></td>
						<td><?=$rowDat['status_final']?></td>
					</tr>
					<?
				}
				?>
			</table>
		<?
	}
?>
</body>
</html>