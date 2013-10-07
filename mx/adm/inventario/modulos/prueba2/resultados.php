<?php
  require_once('Connections/operacion.php'); 
$colname_Recordset1 = "-1";
if (isset($_POST['idbusc'])) {
  $colname_Recordset1 = (get_magic_quotes_gpc()) ? $_POST['idbusc'] : addslashes($_POST['idbusc']);
}
mysql_select_db($database_operacion, $operacion);
//echo $query_Recordset1 = sprintf("SELECT id, id_prod, descripgral, especificacion, linea, marca, control_alm, ubicacion, uni_entrada, uni_salida, stock_min, stock_max, observa, existencias, unidad, tipo, kit, cpromedio, activo, status1 FROM catprod WHERE id = %s ORDER BY id ASC", $colname_Recordset1);
echo $query_Recordset1 = "SELECT id, id_prod, descripgral, especificacion, linea, marca, control_alm, ubicacion, uni_entrada, uni_salida, stock_min, stock_max, observa, existencias, unidad, tipo, kit, cpromedio, activo, status1 FROM catprod WHERE descripgral LIKE '%".$colname_Recordset1."%' OR especificacion LIKE '%".$colname_Recordset1."%' ORDER BY id ASC";
$Recordset1 = mysql_query($query_Recordset1, $operacion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form method="POST" name="form1" action="resultados.php ">
  <table align="center">
  <tr valign="baseline">
      <td nowrap align="right">Busqueda por descripci&oacute;n general / especificaci&oacute;n:</td>
      <td><input type="text" name="idbusc" id="idbusc" value="" size="20">
	  <input type="submit" value="Buscar" ></td>
    </tr>
</table>
</form>

<form method="POST" action="<?php echo $editFormAction; ?>"  name="form2" >

  <?php do { ?>
<table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id:</td>
      <td><input type="text" name="id" value="<?php echo $row_Recordset1['id']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Id_prod:</td>
      <td><input type="text" name="id_prod" value="<?php echo $row_Recordset1['id_prod']; ?>"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Descripgral:</td>
      <td><input type="text" name="descripgral" value="<?php echo $row_Recordset1['descripgral']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Especificacion:</td>
      <td><input type="text" name="especificacion" value="<?php echo $row_Recordset1['especificacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Linea:</td>
      <td><input type="text" name="linea" value="<?php echo $row_Recordset1['linea']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Marca:</td>
      <td><input type="text" name="marca" value="<?php echo $row_Recordset1['marca']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Control_alm:</td>
      <td><input type="text" name="control_alm" value="<?php echo $row_Recordset1['control_alm']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Ubicacion:</td>
      <td><input type="text" name="ubicacion" value="<?php echo $row_Recordset1['ubicacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Uni_entrada:</td>
      <td><input type="text" name="uni_entrada" value="<?php echo $row_Recordset1['especificacion']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Uni_salida:</td>
      <td><input type="text" name="uni_salida" value="<?php echo $row_Recordset1['uni_entrada']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Stock_min:</td>
      <td><input type="text" name="stock_min" value="<?php echo $row_Recordset1['stock_min']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Stock_max:</td>
      <td><input type="text" name="stock_max" value="<?php echo $row_Recordset1['stock_max']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Observa:</td>
      <td><input type="text" name="observa" value="<?php echo $row_Recordset1['observa']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Existencias:</td>
      <td><input type="text" name="existencias" value="<?php echo $row_Recordset1['uni_entrada']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Unidad:</td>
      <td><input type="text" name="unidad" value="<?php echo $row_Recordset1['unidad']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Tipo:</td>
      <td><input type="text" name="tipo" value="<?php echo $row_Recordset1['tipo']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Status1:</td>
      <td><input type="text" name="status1" value="<?php echo $row_Recordset1['status1']; ?>" size="32"></td>
    </tr>
    <!--<tr valign="baseline">
      <td nowrap align="right">NoParte:</td>
      <td><input type="text" name="noParte" value="<?php echo $row_Recordset1['noParte']; ?>" size="32"></td>
    </tr>-->
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Guardar Modificacion"><!--<input type="submit" value="Actualizar registro">--></td>
    </tr>
    </table>
<div style="border: 1px dotted #000;"></div>
	      <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>


</form>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>

