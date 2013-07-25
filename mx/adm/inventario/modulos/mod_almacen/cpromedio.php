<?php 
session_start();
include("../php/conectarbase.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style type="text/css">
<!--
body{ margin:0px; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; padding:0px;}
a:link{ text-decoration:none;}
a:hover{ color:#ff0000;}
a:visited{text-decoration:none;}

#titulo{ text-align:center; font-weight:bold; margin:20px;}
.td1{ border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid; padding:1px;}
.td2{ border-bottom:#CCCCCC 1px solid; border-left:#CCCCCC 1px solid; border-right:#CCCCCC 1px solid; padding:1px;}

-->
</style>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript">

</script>

</head>

<body>
<div id="todo">
	<div align="center" style="text-decoration:none;">
	<a href="../aut_gestion_usuarios.php">Usuarios</a> | 
	<a href="../almacen/tipo_alm_listado.php">Almacenes</a> | 
	<a href="../almacen/conc_mov_listado.php">Conceptos de E/S</a> | 
	<a href="../almacen/cat_line_prod.php?op=3">Lineas de Producto</a> | 
	<a href="../almacen/cat_product1.php">Cat. Productos</a> | 
	<a href="../almacen/p_reorden.php">Punto de reorden</a> |		
	<a href="../almacen/kardex.php">Kardex</a> |
	<a href="../almacen/cpromedio.php">Costo Promedio</a> 		 
	</div>
	<div id="titulo">EN CONSTRUCCION ... Costo promedio.</div>
	<div id="contenido">
	
		<?
		
		?>
		<table width="800px" align="center" id="t1" cellspacing="0">
		<tr style="background-color:#333333; text-align:center; font-weight:bold; color:#FFFFFF;">
		  <td colspan="6">Costo Promedio </td>
		  </tr>
		<tr style="background-color:#cccccc; text-align:center; font-weight:bold; color:#000000;">
			<td>Clave Producto </td>
			<td>Descripci&oacute;n</td>
			<td>Especificaci&oacute;n</td>
			<td>&nbsp;</td><td>a</td><td>a</td>
		</tr>
		<tr>
			<td class="td1">a</td>
			<td class="td1">a</td>
			<td class="td1">a</td>
			<td class="td1">a</td>
			<td class="td1">a</td>
			<td class="td2">a</td>
		</tr>
	  </table>
	...
	</div>
	<div id="pie" style="font-size:10px; color:#333333; text-align:center;"><hr width="90%">&copy; IQ Electronics International SA de CV 2008</div>
</div>
</body>
</html>