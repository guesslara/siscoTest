<?php 
session_start();
//print_r($_SESSION);

include ("../../conf/conectarbase.php");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Content-Type: text/xml; charset=ISO-8859-1");


 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de Producto</title>
<style type="text/css">
<!--
body {
	margin-top: 0px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;
}
.td3{ background-color:#CCCCCC; text-align:left; padding:1px; font-weight:bold;}
.td3a{ background-color:#ffffff; text-align:left; padding:1px; font-weight:normal;}
-->
</style>
<style type="text/css" media="print">
.invisible { display:none;}
</style>
</head>
<?
		$id=$_GET['id'];
		$lista_campos=" `id`,`id_prod`, `descripgral`, `especificacion`, `control_alm`, `ubicacion`, `uni_entrada`, `uni_salida`, `stock_min`, `stock_max`, `cpromedio`, `unidad`, `stock_min`, `linea`, `marca`, `observa`, `status1` ";	
		$sql="SELECT $lista_campos FROM catprod WHERE id= '$id'";
		$result=mysql_query($sql,$link);
		$row=mysql_fetch_array($result);
		$id_prod=$row["id_prod"];
				$cpromedio=$row["cpromedio"];	
		?>
<body>
<div class="t1" id="titulo" style=" font-size:14px; text-align:center; font-weight:normal; margin-top:10px; margin-bottom:10px;">
	Producto: <font color="#FF0000"><?=$id_prod."  - ".$row['descripgral'];?></font>
	<input type="hidden" id="txt_idp" value="<?=$id?>" />
</div>

<div id="opciones" style="background-color:#EFEFEF; margin:5px 15px 5px 15px; padding:3px 3px 3px 3px;">
	<div id="opciones1" style="text-align:right;"><a href="javascript:ver_opciones();">Opciones</a></div>
	<div id="opciones2" style="display:none;">
		<a href="javascript:asociar('a');">Asociar a Almacenes</a>&nbsp;|&nbsp;
		<a href="javascript:asociar('c');">Asociar a Cliente</a>
	</div>
	<div id="opciones3" style="background-color:#EFEFEF; display:none;">&nbsp;</div>
</div>

<table align="center" cellpadding="0" cellspacing="0" style="width:560px; border:#000000 1px solid; text-align:left;">
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td colspan="4" style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;  padding:2px;">Datos del Producto   </td>
</tr>
<tr>
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Clave de Producto  </td>
	<td colspan="3" class="td3a">&nbsp;<?= $row["id_prod"]; ?></td>	
  </tr>
<tr align="center" >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Descripci&oacute;n </td>
	<td colspan="3" class="td3a" align="left">&nbsp;<?= $row["descripgral"]; ?></td>	
  </tr>
<tr>
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Especificaci&oacute;n </td>
	<td width="156" class="td3a">&nbsp;<?= $row["especificacion"]; ?></td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;L&iacute;nea de producto  </td>
	<td width="130" class="td3a">&nbsp;<?= $row["linea"]; ?></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Control de Almac&eacute;n </td>
	<td width="156" class="td3a">&nbsp;<?= $row["control_alm"]; ?></td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Ubicaci&oacute;n </td>
	<td width="130" class="td3a">&nbsp;<?= $row["ubicacion"]; ?></td>
</tr>
<tr >
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad</td>
  <td class="td3a">&nbsp;<?= $row["unidad"]; ?></td>
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Marca </td>
  <td class="td3a">&nbsp;<?=$row["marca"]?></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad entrada  </td>
	<td width="156" class="td3a">&nbsp;<?= $row["uni_entrada"]; ?></td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad salida </td>
	<td width="130" class="td3a">&nbsp;<?= $row["uni_salida"]; ?></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Stock M&iacute;nimo  </td>
	<td width="156" class="td3a">
	  &nbsp;<?= $row["stock_min"]; ?>	</td>	
	<td width="127" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Stock M&aacute;ximo </td>
	<td width="130" class="td3a">&nbsp;<?= $row["stock_max"]; ?></td>
</tr>
<tr>
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Status</td>
  <td colspan="3" class="td3a">&nbsp;<?php
	if ($_SESSION["usuario_login"]=="cirilo"||$_SESSION["usuario_login"]=="Admin")
	{
			if ($row["status1"]==2)
			{
				echo "<a href='javascript:modificar_status($id);' title='Para modificar el status, de clic AQUI.'>Obsoleto</a>";	
			} else if($row["status1"]==1) {
				echo "<a href='javascript:modificar_status($id);' title='Para modificar el status, de clic AQUI.'>Lento Movimiento</a>";
			} else {
				echo "<a href='javascript:modificar_status($id);' title='Para modificar el status, de clic AQUI.'>Uso Constante</a>";
			} 		
	} else { 
			if ($row["status1"]==2)
			{
				echo "Obsoleto";	
			} else if($row["status1"]==1) {
				echo "Lento Movimiento";
			} else {
				echo "Uso Constante";
			} 	
	}			
  
   
    ?>
	<div id="div_st_modificado" style="text-align:center; font-weight:bold; border:#000000 2px dotted; margin:2px; padding:2px; display:none;">
		<input type="hidden" name="hdn_idp1" id="hdn_idp1" value="<?=$id?>" size="5" readonly="1" />
		<select name="sel_status1" id="sel_status1">
			<option value="0">0 - Uso Constante</option>
			<option value="1">1 - Lento Movimiento</option>
			<option value="2">2 - Obsoleto</option>
		</select>
		<input type="button" onclick="modificar_status2()" value="Guardar Cambio" />
	</div></td>
</tr>
<tr>
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Observaciones</td>
	<td colspan="3" class="td3a">&nbsp;<?= $row["observa"]; ?>	  	</td>	
  </tr>
</table>

<br /><table align="center" cellpadding="0" cellspacing="0" style="width:560px; padding:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid;">
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td colspan="4" style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF; padding:1px;">Almacenes Asociados  </td>
</tr>
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td width="36"># </td>
	<td width="311">Almacen </td>	
	<td width="85">Existencias </td>
	<td width="108">Transferencias </td>
</tr>
<?php 
	//echo "<br>".
	$sql_alm="SELECT id_almacen,almacen FROM tipoalmacen ORDER BY id_almacen";
	$result0=mysql_query($sql_alm,$link);
	while ($row0=mysql_fetch_array($result0))
	{ 
		$id_almacen=$row0["id_almacen"];
		$almacen=$row0["almacen"];
		
		$campo_almacen="a_".$id_almacen."_".$almacen;
		$campo_existencias="exist_".$id_almacen;	
		$campo_transferencias="trans_".$id_almacen;
		
		//echo "<br><br> [$id_almacen] [$almacen] [$campo_almacen] [$campo_existencias] [$campo_transferencias]<br>"; 
		
		//echo "<br>".
		$sql_alm1="SELECT `$campo_existencias`,`$campo_transferencias` FROM catprod WHERE id='$id' AND `$campo_almacen`=1";
		$res1=mysql_query($sql_alm1,$link);
		while ($row1=mysql_fetch_array($res1))
		{ 	?>
			<tr bgcolor="<?=$color;?>">
				<td align="center" height="18"><?=$id_almacen; ?> </td>
				<td align="left"> <?=$almacen; ?></td>	
				<td align="right"><?=$row1[$campo_existencias];?></td>
				<td align="right"><?=$row1[$campo_transferencias];?></td>
			</tr>
			<?php
	 		$totale=$totale+$row1[$campo_existencias];
		 	$totalt=$totalt+$row1[$campo_transferencias];
			($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
		}
	} ?>
<tr style="font-weight:bold;">
	<td colspan="2" align="right">Subtotal&nbsp;&nbsp;</td>
	<td align="right" bgcolor="#CCCCCC"><?=$totale;?></td>
	<td align="right" bgcolor="#CCCCCC"><?=$totalt;?></td>
</tr>
<tr style="font-weight:bold;">
	<td colspan="2" align="right">Total&nbsp;&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right" bgcolor="#FFFF00"><?=$totale+$totalt;?></td>
</tr>
</table>

<br /><table align="center" cellspacing="0" cellpadding="0" style="width:560px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:#000000 1px solid;">
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold;">
	<td colspan="2" style=" background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF; padding:1px;">Clientes Asociados  </td>
</tr>
<tr align="center" style="background-color:#CCCCCC; text-align:center; font-weight:bold; text-align:center; color:#000000; padding:1px;">
	<td>#  </td>
	<td>Cliente</td>
</tr>
<?php 
	$sql2="SELECT id_clientes FROM catprod WHERE id='$id' ";
	//echo $sql;
	$result2=mysql_query($sql2,$link);
	while ($row2=mysql_fetch_array($result2)) {
		//print_r($row2);
		$id_clientes=$row2['id_clientes'];
		$idc=explode(',',$id_clientes);
		foreach ($idc as $ic){
			//echo "<br>$ic";
			$sql3="SELECT n_comercial FROM cat_clientes WHERE id_cliente=$ic";
			$res3=mysql_query($sql3,$link);
			$row3=mysql_fetch_array($res3)
			?>
			<tr align="center" bgcolor="<?=$color;?>" >
				<td width="23" height="18" align="center"><?=$ic?></td>
				<td width="324" height="18" align="left"><?=$row3["n_comercial"]?>  </td>	
			</tr>			
			<?php			
			($color=="#D9FFB3")? $color="#FFFFFF" : $color="#D9FFB3";
		}
	}
?>
</table>

<br />
<div style="text-align:center" class="invisible">
	<a href="javascript:ver_kardex('<?= $row["id"]; ?>');">Kardex</a>&nbsp;
	<a href="../mod_reportes/existencias_por_mes.php?idp=<?= $row["id"]; ?>">Comportamiento</a>&nbsp;	
	<?php if ($_SESSION["usuario_nivel"]==7) { ?>
		| <a href="javascript:modificar_producto('<?= $row["id"]; ?>');">Modificar</a>
	<?php } ?>	
</div>
</body>
</html>
