<?php 
	$fecha = date('Y-m-d');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=MOVIMIENTOS_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	include ("../../conf/conectarbase.php");
	if ($_GET["action"]=="ejecutar") {
		$v1=$_GET["v1"];		$v4=$_GET["v4"];		$v6=$_GET["v6"];
		$v2=$_GET["v2"];		$v5=$_GET["v5"];		$v7=$_GET["v7"];
		$v3=$_GET["v3"];		$v8=$_GET["v8"];		$v9=$_GET["v9"];		$v10=trim($_GET["v10"]);
		
		$v10_split=split(',',$v10);
		if (($ndc3=count($v10_split))>1){
			$sql_asociado=" AND ( mov_almacen.asociado=".$v10_split[0];
			for ($i3=1;$i3<$ndc3;$i3++){ 
				(is_numeric(trim($v10_split[$i3])))? $sql_asociado.=" OR mov_almacen.asociado=".trim($v10_split[$i3]) : $sql_asociado.=""; 
			}
			$sql_asociado.=" )";	
		} else {
			(is_numeric(trim($v10)))? $sql_asociado=" AND mov_almacen.asociado=".trim($v10) : $sql_asociado="";
		}
		
		
		
		//(is_numeric($v10))? $sql_asociado="AND mov_almacen.asociado=$v10 " : $sql_asociado=""; 
		
		$tipo_movs=split(',',$v2);
		if (($ndc1=count($tipo_movs))>1){
			$sql_con=" (mov_almacen.tipo_mov=".$tipo_movs[0];
			for ($i=1;$i<$ndc1;$i++)
			{
				$sql_con.="	OR mov_almacen.tipo_mov=".$tipo_movs[$i];	
			}
			$sql_con.=")";
		} else {
			$sql_con="mov_almacen.tipo_mov=$v2";
		}	
		$alms=split(',',$v6);
		if (($ndc2=count($alms))>1){
			$sql_con2=" (mov_almacen.almacen=".$alms[0];
			for ($i2=1;$i2<$ndc2;$i2++)
			{
				$sql_con2.=" OR mov_almacen.almacen=".$alms[$i2];	
			}
			$sql_con2.=")";
		} else {
			$sql_con2="mov_almacen.almacen=$v6";
		}	
		$sql8="
SELECT mov_almacen.id_mov, mov_almacen.fecha, mov_almacen.tipo_mov, mov_almacen.asociado, concepmov.concepto, concepmov.asociado as asociado0, tipoalmacen.almacen as nalmacen, mov_almacen.almacen, prodxmov.id, prodxmov.id_prod, prodxmov.clave, prodxmov.cantidad, prodxmov.cu, prodxmov.cantidad*prodxmov.cu as subtotal
FROM mov_almacen, prodxmov, concepmov, tipoalmacen
WHERE mov_almacen.id_mov = prodxmov.nummov AND concepmov.id_concep=mov_almacen.tipo_mov AND tipoalmacen.id_almacen=mov_almacen.almacen
AND mov_almacen.fecha BETWEEN '$v3' AND '$v4'
AND $sql_con
AND $sql_con2 $sql_asociado ORDER BY $v8 $v9
";
		if ($result8=mysql_db_query($sql_inv,$sql8))
		{
			$ndr8=mysql_num_rows($result8);
			?>
		<table width="auto" align="center" cellspacing="0" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">
			<tr style="font-weight:bold; text-align:center; color:#000000;">
			  <td colspan="12" height="20" > <?=$ndr8?> Resultados</td>
			</tr>
			<tr style="text-align:center; font-weight:bold; color:#000000;">
			  <td width="44"># </td>
			  <td width="95" height="20">Fecha</td>
			  <td width="63">Id Mov</td>
			  <td width="197">Tipo de Mov </td>
			  <td width="145">Almac&eacute;n</td>
			  <td width="97">Asociado</td>
			  <td width="97">Id Producto </td>
			  <td width="83">Clave P. </td>
			  <td width="69">Cantidad</td>
			  <td width="69">C.U.</td>
			  <td width="69">Subtotal $ </td>
			</tr>
			<?php while($row8=mysql_fetch_array($result8)){ ?>
			<tr>
			  <td height="20" align="center"><?=$row8["id"]?></td>
			  <td class="tda"><?=$row8["fecha"]?></td>
			  <td align="center"><?=$row8["id_mov"]?></td>
			  <td class="tda"><?=$row8["tipo_mov"].".".$row8["concepto"]?></td>
			  <td><?=$row8["almacen"].".".$row8["nalmacen"]?></td>
			  <td class="tdai"><?=$row8["asociado0"]." ".$row8["asociado"]?></td>
			  <td class="tda"><?=$row8["id_prod"]?></td>
			  <td><?=$row8["clave"]?></td>
			  <td class="tda" align="right"><?=$row8["cantidad"]; ?></td>
			  <td align="right"><?=$row8["cu"]?></td>
			  <td class="tdai" align="right"><?=$row8["subtotal"]?></td>
		    </tr>
			<?php ($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3"; } ?>
		</table>				
		<?
		}

	}
?>
