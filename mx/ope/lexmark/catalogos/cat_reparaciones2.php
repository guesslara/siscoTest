<?php 
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase.php");
	//print_r($_POST);
	$a=$_POST["action"];
	if ($a=="nuevo"){
		//Muestro formulario.
		?>
		<form name="frm1">
		<br /><table align="center" width="100%" style="font-weight:bold; font-size:10px;">
			<tr>
			  <td width="775">C&oacute;digo:</td>
			  <td width="184"><label>
			    <input type="text" name="textfield" id="textfield" />
			  </label></td>
		  </tr>
			<tr>
			  <td>Reparaci&oacute;n:</td>
			  <td><label>
			    <input type="text" name="textfield2" id="textfield2" />
			  </label></td>
		  </tr>
			<tr>
			  <td>Aplica a los Productos: </td>
			  <td><label>
			    <input type="text" name="textfield3" id="textfield3" onClick="elegir_productos()" onFocus="elegir_productos()" readonly="1" />
			  </label></td>
		  </tr>
			<tr>
			  <td>Observaciones:</td>
			  <td><input type="text" name="textfield4" id="textfield4" /></td>
		  </tr>
			<tr>
			  <td colspan="2" id="mensajeX" style="text-align:justify; font-size:10px; color:#FF0000;">&nbsp;</td>
		  </tr>
			
		</table>
		</form>	
		<?php
	
	}
	if ($a=="elegir_productos"){
		//echo "<br>BD [$sql_inv] SQL=".
		$sql1="SELECT id,id_prod,descripgral,especificacion FROM catprod ORDER BY id";
		if ($resultado1=mysql_db_query($sql_inv,$sql1)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		?>
		<form name="frm2">
		<br /><table align="center" width="739" style="font-weight:bold; font-size:12px;">
			<tr>
			  <td colspan="5" align="center">La Reparaci&oacute;n  aplica a los productos seleccionados. </td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>Id</td>
			  <td>Clave del Producto </td>
			  <td>Descripci&oacute;n</td>
			  <td>Especificaci&oacute;n</td>
		  </tr>
			<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
			<tr style="font-weight:normal;">
			  <td width="37"><input type="checkbox" value="<?=$registro1["id"]?>" /></td>
			  <td width="26"><?=$registro1["id"]?></td>
			  <td width="118"><?=$registro1["id_prod"]?></td>
			  <td width="381"><?=$registro1["descripgral"]?></td>
			  <td width="153"><?=$registro1["especificacion"]?></td>
		  </tr>
		  	<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>
		<br /><div align="center"><input type="button" value="Aceptar" onClick="coloca_productos()" /></div><br />
		</form>
		<?php
	}  
	if ($a=="elegir_productos2"){
		$idd=$_POST["idd"];
		//echo "<br>BD [$sql_inv] SQL=".
		$sql1="SELECT id,id_prod,descripgral,especificacion FROM catprod ORDER BY id";
		if ($resultado1=mysql_db_query($sql_inv,$sql1)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		?>
		<form name="frm2">
		<br /><table align="center" width="739" style="font-weight:bold; font-size:12px;">
			<tr>
			  <td colspan="5" align="center">La Reparaci&oacute;n
			    <input type="hidden" id="txt_idd" value="<?=$idd?>" />  aplica a los productos seleccionados. </td></tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>Id</td>
			  <td>Clave del Producto </td>
			  <td>Descripci&oacute;n</td>
			  <td>Especificaci&oacute;n</td>
		  </tr>
			<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
			<tr style="font-weight:normal;">
			  <td width="37"><input type="checkbox" value="<?=$registro1["id"]?>" /></td>
			  <td width="26"><?=$registro1["id"]?></td>
			  <td width="118"><?=$registro1["id_prod"]?></td>
			  <td width="381"><?=$registro1["descripgral"]?></td>
			  <td width="153"><?=$registro1["especificacion"]?></td>
		  </tr>
		  	<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>
		<br /><div align="center"><input type="button" value="Aceptar" onClick="coloca_productos2(<?=$idd?>)" /></div><br />
		</form>
		<?php
	}  


	if ($a=="guardar"){
		//echo "<br>BD [$sql_inv] SQL=".
		$sql1="INSERT INTO cat_reparaciones(id,cod_rep,descripcion,tipos_productos,obs) 
			VALUES (NULL,'".$_POST["c"]."','".$_POST["d"]."','".$_POST["p"]."','".$_POST["o"]."')";
		
		if ($resultado1=mysql_db_query($sql_ing,$sql1)){
			echo "<div align=center>La Reparaci&oacute;n se guardo correctamente.</div>";
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		
	}	
	if ($a=="listar"){	
		//echo "<br>BD [$sql_ing] SQL=".
		$sql1="SELECT * FROM cat_reparaciones ORDER BY id";
		if ($resultado1=mysql_db_query($sql_ing,$sql1)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la BAse de Datos no se ejecuto.</div>";
			exit();
		}		
		?>
		<table width="853" align="center" class="tabla1" cellpadding="2" cellspacing="0">
		<tr>
		  <td colspan="6" class="titulo_tabla1">Cat&aacute;logo de Reparaciones (<?=$ndr1?> Resultados) </td>
		  </tr>
		<tr>
		  <td width="31" class="campos_tabla1">Id</td>
		  <td width="48" class="campos_tabla1">C&oacute;digo</td>
		  <td width="476" class="campos_tabla1">Descripci&oacute;n</td>
		  <td width="164" class="campos_tabla1">Aplica a Productos </td>
		  <td width="47" class="campos_tabla1">Obs</td>
		  <td width="47" class="campos_tabla1">Mod</td>
		  </tr>
		<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
		<tr bgcolor="<?=$col?>">
		  <td align="center">&nbsp;<?=$registro1["id"]?></td>
		  <td class="tda_tabla1">&nbsp;<?=$registro1["cod_rep"]?></td>
		  <td>&nbsp;<?=$registro1["descripcion"]?></td>
			<td class="tda_tabla1" align="center">&nbsp;<a href="#" title="<?=$registro1["tipos_productos"]?>">Ver</a></td>
			<td><?=$registro1["obs"]?></td>
			<td class="tdi_tabla1"><a href="javascript:agregar_tipos_productos('<?=$registro1["id"]?>');" title="Modificar los Productos a los que aplica este Diagnostico.">Modificar</a></td>
		  </tr>
		<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>	
	<?php	
	}
	if ($a=="modificar"){
		$idd=$_POST["idd"];
		$ps=$_POST["ps"];
		//echo "<br>BD [$sql_inv] SQL=".
		$sql1="UPDATE cat_reparaciones SET tipos_productos='$ps' WHERE id=$idd";
		if ($resultado1=mysql_db_query($sql_ing,$sql1)){
			echo "<div align=center>La Reparaci&oacute;n se guardo correctamente.</div>";?>
				<script language="javascript"> $("#all").show(); </script>
			<?php
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
	}	
?>