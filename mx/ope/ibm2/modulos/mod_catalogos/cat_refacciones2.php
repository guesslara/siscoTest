<?php 
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: text/xml; charset=ISO-8859-1");
	include ("../../conf/conectarbase2.php");
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
			  <td>Refacci&oacute;n:</td>
			  <td><label>
			    <input type="text" name="textfield2" id="textfield2" />
			  </label></td>
		  </tr>
			<tr>
			  <td>Aplica a los Productos: </td>
			  <td><label>
			    <input type="text" name="textfield3" id="textfield3" onclick="elegir_productos(3)" onfocus="elegir_productos(3)" readonly="1" />
			  </label></td>
		  </tr>
			<tr>
			  <td>Id producto </td>
			  <td><input type="text" name="textfield4" id="textfield4" onclick="elegir_productos(4)" onfocus="elegir_productos(4)" readonly="1" /></td>
		  </tr>
			<tr>
			  <td>Cantidad</td>
			  <td><input type="text" name="textfield5" id="textfield5" value="1" style="text-align:right;"/></td>
		  </tr>
			<tr>
			  <td>Observaciones:</td>
			  <td><input type="text" name="textfield6" id="textfield6" /></td>
		  </tr>
			<tr>
			  <td colspan="2" id="mensajeX" style="text-align:justify; font-size:10px; color:#FF0000;">&nbsp;</td>
		  </tr>
			
		</table>
		</form>	
		<?php
	
	}
	if ($a=="elegir_productos"){
		$n=$_POST["n"];
		//echo "<br>BD [$sql_inv] SQL=".
		$sql1="SELECT id,noParte,descripgral,familia FROM catprod ORDER BY id";
		if ($resultado1=mysql_query($sql1,$link)){
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		?>
		<form name="frm2">
		<br /><table align="center" width="739" style="font-weight:bold; font-size:12px;">
			<tr>
			  <td colspan="5" align="center">
			  <?php if ($n==3){  ?>
			  El Refacci&oacute;n aplica a los productos seleccionados.<input type="hidden" id="txt_numeroX" value="<?=$n?>" /> 
			  <?php } else { ?>
			  Cat&aacute;logo de productos.<input type="hidden" id="txt_numeroX" value="<?=$n?>" /> 
			  <?php } ?>
			  </td>
		  </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>Id</td>
			  <td>No. Parte </td>
			  <td>Descripci&oacute;n</td>
			  <td>Familia</td>
		  </tr>
			<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
			<tr style="font-weight:normal;">
			  <td width="37"><input type="checkbox" value="<?=$registro1["id"]?>" /></td>
			  <td width="26"><?=$registro1["id"]?></td>
			  <td width="118"><?=$registro1["noParte"]?></td>
			  <td width="381"><?=$registro1["descripgral"]?></td>
			  <td width="153"><?=$registro1["familia"]?></td>
		  </tr>
		  	<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>
		<br /><div align="center"><input type="button" value="Aceptar" onclick="coloca_productos()" /></div><br />
		</form>
		<?php
	}  
	if ($a=="elegir_productos2"){
		$idd=$_POST["idd"];
		 $diagno="SELECT descripcion FROM cat_refacciones WHERE id_ref=$idd ";
		if ($diagnostico=mysql_query($diagno,$link)){
		                    
			$ndr1=mysql_num_rows($diagnostico);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		 $col="#FFFFFF";	while($registro1=mysql_fetch_array($diagnostico)){
		?>
		
		<form id="formbusc">
				<h3 align="center">Busqueda de Producto por:</h3>
		<div align="center" id="div_datos1">
			No. de Parte: <input type="text" name="busc" id="busc" size="10" />
			<input type="button" value="Buscar" onclick="buscar()" /><br>
			Se Agregar&aacute; la Refacci&oacute;n #: <input type="text" name="num" id="num" value="<?php echo $idd ; ?>" size="1" readonly="1" />
			<input type="text" name="num" id="num" value="<?php echo $registro1["descripcion"] ; ?>" size="20" readonly="1" />
		</div>
		
		</form>
		<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($diagnostico); ?>
		<?php
	}  


	if ($a=="guardar"){
		//echo "<br>BD [$sql_inv] SQL=".
		$sql1="INSERT INTO cat_refacciones(id_ref,cod_ref,descripcion,productos,id_producto,cantidad,obs) 
			VALUES (NULL,'".$_POST["a"]."','".$_POST["b"]."','".$_POST["c"]."','".$_POST["d"]."','".$_POST["e"]."','".$_POST["f"]."')";
		
		if ($resultado1=mysql_query($sql1,$link)){
			
			?>
			<script type="text/javascript">
			alert("La refaccion se guardo correctamente.");
			</script><?php
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		
	}
	if ($a=="listar"){	
		//echo "<br>BD [$sql_ing] SQL=".
		$sql1="SELECT * FROM cat_refacciones ORDER BY id_ref";
		if ($resultado1=mysql_query($sql1,$link)){
			//echo "<div align=center>OK</div>";
			$ndr1=mysql_num_rows($resultado1);
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}		
		?>
		<div style=" margin:30px 3px 4px 250px; width: 70%; border-radius: 10px;-moz-box-shadow: 3px 3px 4px #111; -webkit-box-shadow: 3px 3px 4px #111; box-shadow: 3px 3px 4px #111; -ms-filter: 'progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color=#111111)'; filter: progid:DXImageTransform.Microsoft.Shadow(Strength=4, Direction=135, Color='#111111');">
		<table width="957" align="center" class="tabla1" cellpadding="2" cellspacing="0">
		<tr>
		  <td colspan="8" class="titulo_tabla1">Cat&aacute;logo de Refacciones (<?=$ndr1?> Resultados) </td>
		  </tr>
		<tr>
		  <td width="31" class="campos_tabla1">Id</td>
		  <td width="48" class="campos_tabla1">C&oacute;digo</td>
		  <td width="476" class="campos_tabla1">Descripci&oacute;n</td>
		  <td width="164" class="campos_tabla1">Aplica a Productos </td>
		  <td width="47" class="campos_tabla1">Id Producto </td>
		  <td width="47" class="campos_tabla1">Cantidad</td>
		  <td width="47" class="campos_tabla1">Obs</td>
		  <td width="47" class="campos_tabla1">Mod</td>
		  </tr>
		<?php $col="#FFFFFF";	while($registro1=mysql_fetch_array($resultado1)){?>
		<tr bgcolor="<?=$col?>" onmouseover='this.style.background="#819FF7"' onmouseout='this.style.background="white"'>
		  <td>&nbsp;<?=$registro1["id_ref"]?></td>
		  <td class="tda_tabla1">&nbsp;<?=$registro1["cod_ref"]?></td>
		  <td>&nbsp;<?=$registro1["descripcion"]?></td>
			<td class="tda_tabla1">&nbsp;<?=$registro1["productos"]?></td>
			<td>&nbsp;<?=$registro1["id_producto"]?></td>
			<td class="tda_tabla1">&nbsp;<?=$registro1["cantidad"]?></td>
			<td><?=$registro1["obs"]?></td>
			<td class="tdi_tabla1"><a href="javascript:agregar_tipos_productos('<?=$registro1["id_ref"]?>');" title="Modificar los Productos a los que aplica esta Refaccion.">Modificar</a></td>
		  </tr>
		<?php ($col=="#FFFFFF")? $col="#EFEFEF" : $col="#FFFFFF"; }	mysql_free_result($resultado1); ?>  
		</table>
		</div>
	<?php	
	}
	if ($a=="modificar"){
		$idd=$_POST["idd"];
		$ps=$_POST["ps"];
		$sql1="UPDATE cat_refacciones SET productos='$ps' WHERE id_ref=$idd";
		
		if ($resultado1=mysql_query($sql1,$link)){
			echo "<div align=center>La refaccion se guardo correctamente.</div>";?>
				<script language="javascript"> $("#all").show(); </script>
			<?php
		} else {
			echo "<div align=center>Error SQL. La consulta a la Base de Datos no se ejecuto.</div>";
			exit();
		}
		
	}	
?>