<?php 
	include ("../../conf/conectarbase.php");
	header("Cache-Control: no-store, no-cache, must-revalidate");
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ficha de Producto</title>
<script type="text/javascript">
function cerrar(elEvento) {
var evento = elEvento || window.event;
var codigo = evento.charCode || evento.keyCode;
var caracter = String.fromCharCode(codigo);
//alert("Evento: "+evento+" Codigo: "+codigo+" Caracter: "+caracter);
if (codigo==27)
 	self.close();
}
document.onkeypress = cerrar;
</script>

<style type="text/css">
<!--
body {
	margin-top: 0px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;
}
.td3{ background-color:#CCCCCC; text-align:left; padding:1px; font-weight:bold;}
.td3a{ background-color:#ffffff; text-align:left; padding:1px; font-weight:normal;}
-->
</style>
</head>
<?
		$id=$_GET['idp'];
		$lista_campos=" `id`,`id_prod`, `descripgral`,`observa`, `especificacion`, `control_alm`, `ubicacion`, `uni_entrada`, `uni_salida`, `stock_min`, `stock_max`, `cpromedio`, `unidad`, `stock_min`, `linea`, `marca` ";	
		//echo "<br>".
		$sql="SELECT $lista_campos FROM catprod WHERE id= '$id'";
		$result=mysql_db_query($sql_inv,$sql);
		$row=mysql_fetch_array($result);
		$id_prod=$row["id_prod"];
		$cpromedio=$row["cpromedio"];		
/*$decimal = 3422.37847623; 
echo number_format($decimal,2,',','.'); // Mostrará 3.422,38*/		
		?>
<body>
<div class="t1" id="titulo" style=" font-size:14px; text-align:center; font-weight:normal; margin-top:10px; margin-bottom:10px;">
	Producto: <font color="#FF0000"><?=$id_prod."  - ".$row['descripgral'];?></font>
</div>

<table align="center" cellpadding="0" cellspacing="0" style="width:560px; border:#000000 1px solid; text-align:left; font-size:12px;">
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
  <td class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Costo Promedio </td>
  <td class="td3a">&nbsp;$ <?= number_format($cpromedio,4,'.',','); ?></td>
</tr>
<tr >
	<td width="145" class="td3" align="left" bgcolor="#CCCCCC">&nbsp;Unidad entrada  </td>
	<td width="156" class="td3a">&nbsp;
    <?= $row["uni_entrada"]; ?></td>	
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
	$sql_alm="SELECT id_almacen,almacen FROM tipoalmacen ORDER BY id_almacen";
	$result0=mysql_db_query($sql_inv,$sql_alm);
	while ($row0=mysql_fetch_array($result0))
	{ 
		$id_almacen=$row0["id_almacen"];
		$almacen=$row0["almacen"];
		
		$campo_almacen="a_".$id_almacen."_".$almacen;
		$campo_existencias="exist_".$id_almacen;	
		$campo_transferencias="trans_".$id_almacen;

		$sql_alm1="SELECT `$campo_existencias`,`$campo_transferencias` FROM catprod WHERE id='$id' AND `$campo_almacen`=1";
		$res1=mysql_db_query($sql_inv,$sql_alm1);
		while ($row1=mysql_fetch_array($res1))
		{ 	?>
			<tr bgcolor="<?=$color;?>">
				<td align="center"><?=$id_almacen; ?> </td>
				<td align="left"> <?=$almacen; ?></td>	
				<td align="right"><?=$row1[$campo_existencias];?></td>
				<td align="right"><?=$row1[$campo_transferencias];?>&nbsp;</td>
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
	<td align="right" bgcolor="#CCCCCC"><?=$totalt;?>&nbsp;</td>
</tr>
<tr style="font-weight:bold;">
	<td colspan="2" align="right">Total&nbsp;&nbsp;</td>
	<td>&nbsp;</td>
	<td align="right" bgcolor="#FFFF00"><?=$totale+$totalt;?>&nbsp;</td>
</tr>
</table>


</body>
</html>