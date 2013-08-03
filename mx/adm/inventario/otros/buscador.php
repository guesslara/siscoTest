<?php
include("../../conf/conectarbase.php");
//print_r($_POST);

if($_POST["nds"]=="")
{
	echo "<br>&nbsp;Error: No se recibe No de Serie.";
	exit();
} else {
	$criterio=trim($_POST['nds']);
	$criterio=substr($criterio,0,17);
	$criterio=" catprod.id_prod like '".$criterio."%' AND lineas.linea=catprod.linea";
	//echo "<br>".
	$sql="SELECT catprod.id,catprod.id_prod,catprod.descripgral,catprod.especificacion,catprod.linea, lineas.linea "
		."FROM catprod,lineas WHERE $criterio "; 
		//exit();

	if(!$result=mysql_db_query($sql_inv,$sql))
	{
		echo 'Error SQL:Problemas al intentar conectarse a la Base de Datos';
		exit;
	}
	$ndr=mysql_num_rows($result);
	$row_color=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Busqueda</title>
</head>
<style type="text/css" media="screen"> 
BODY{
font-family:Verdana, Arial, Helvetica, sans-serif; font-size:11px;
}
.t{background-color:#333333; text-align:center; color:#FFFFFF; font-weight:bold;}
</style>
<script language="javascript">
function ficha(id2)
{
	//alert(id2);
	var w0=window.open("../almacen/fichaprod.php?idp="+id2,"","width=600,height=500,resizable=1,scrollbars=1");
}
</script>
<body>
<?php include("../menu/menu.php"); ?>
<br /><br />
<table align="center" border="0" cellpadding="0" cellspacing="0" width="800" style="border:#333333 2px solid; font-size:12px;">
<tr class="t">
  <th colspan="4" height="23">Cat&aacute;logo de Productos ( <?=$ndr?> Resultados)</th>
  </tr>
<tr style="background-color:#cccccc; text-align:center; color:#333333; font-weight:bold;">
  <th width="34">Id</th>
	<th width="254" height="23">Clave del Producto </th>
	<th width="292">Descripci&oacute;n</th>
	<th width="216">Especificaci&oacute;n</th>
  </tr>
<?php 

	while ($row1=mysql_fetch_array($result)) {
			$row_color += 1;
			if ($row_color % 2)
				$color = "#D9FFB3";
			else
				$color = "#FFFFFF";		
	
	//$sql_marca
	
	?>
	<tr bgcolor="<?=$color?>" onmouseover="this.style.background='#cccccc';" onmouseout="this.style.background='<? echo $color; ?>'" onclick="javascript:ficha('<?=$row1['id']?>');" style="cursor:pointer;">
	  <td align="center">&nbsp;<?php echo $row1['id']; ?></td>
	<td height="23" align="center"style="border-left:#CCCCCC 1px solid;">&nbsp;<?php echo $row1['id_prod']; ?>&nbsp;</td>
	<td style="border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid;">&nbsp;<?php echo $row1['descripgral']; ?>&nbsp;</td>
	<td>&nbsp;<?php echo $row1['especificacion']; ?>&nbsp;</td>
	</tr>
	<?php
	}
?>
</table>
<?php include("../f.php"); ?>
</body>
</html>
