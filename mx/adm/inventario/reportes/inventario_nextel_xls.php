<?php 
	include ("../../php/conectarbase.php");
	$color="#D9FFB3";
	//print_r($_GET);
	$sql_recibida=str_replace('\\','',stripslashes($_GET["sql"]));

	if ($result0=mysql_db_query($sql_db,$sql_recibida))
	{
		$numeroRegistros=mysql_num_rows($result0);
		if ($numeroRegistros==0)
		{
			exit();
		} else {
			$fecha = date('Y-m-d H:i:s');
			
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=INVENTARIO_NEXTEL_$fecha.xls");
			header("Pragma: no-cache");
			header("Expires: 0");			
		}
	?>
		<br><table align="center" style="border:#000000 1px solid; font-size:12px" width="100%" cellspacing="0">
	
		<tr style="background-color:#333333; color:#FFFFFF; text-align:left; font-weight:bold; text-align:center;">
			<td height="20" colspan="11"><?=$numeroRegistros;?> Productos en Inventario Nextel 	
			</td>
		  </tr>
		<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
		  <td height="20">&nbsp;</td>
		  <td width="9%" rowspan="2" valign="bottom">Clave del Producto</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td width="6%" rowspan="2" valign="bottom">Control Almac&eacute;n</td>
		  <td colspan="2">General </td>
		  <td colspan="2">A. en Tr&aacute;nsito </td>
		  <td colspan="2">M. no Conforme </td>
		  </tr>
		<tr style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
		  <td width="2%" height="20">Id</td>
			<td width="41%">Descripci&oacute;n</td>
			<td width="19%">Especificaci&oacute;n</td>
			<td width="3%"><a href="#" title="Existencias en el Almacen General.">E</a></td>
			<td width="4%"><a href="#" title="Transferencias en el Almacen General.">T</a></td>
			<td width="3%"><a href="#" title="Existencias en el Almacen en Transito.">E</a></td>
			<td width="5%"><a href="#" title="Transferencias en el Almacen en Transito.">T</a></td>
			<td width="3%"><a href="#" title="Existencias en el Almacen de Material no Conforme.">E</a></td>
			<td width="5%"><a href="#" title="Transferencias en el Almacen de Material no Conforme.">T</a></td>
		  </tr>
		<?php 
			while($row=mysql_fetch_array($result0)){
		?>	
			<tr bgcolor="<? echo $color; ?>">
			  <td class="td1" height="20" align="center">&nbsp;<?=$row["id"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["id_prod"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["descripgral"]?></td>
				<td class="td1" align="left">&nbsp;<?=$row["especificacion"]?></td>
				<td class="td1" align="right"><?=$row["control_alm"]?>&nbsp;</td>
				<td class="td1" align="right"><?=$row["exist_1"]?></td>
				<td class="td1" align="right"><?=$row["trans_1"]?></td>
				<td class="td1" align="right"><?=$row["exist_43"]?></td>
				<td class="td1" align="right"><?=$row["trans_43"]?></td>
				<td class="td1" align="right"><?=$row["exist_44"]?></td>
				<td class="td1" align="right"><?=$row["trans_44"]?></td>
			  </tr>
		<?php 
			($color=="#D9FFB3")? $color="#ffffff" : $color="#D9FFB3";
			}
		?>	
		</table>
		<br />
		
	<?php			
	} else {
		echo "<br>Error: el Sistema ha fallado, consulte el Administrador del Sistema.";
	}	
?>
